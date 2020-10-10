<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Movie;

class SearchMovies extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.search-movies', [
            'arrMovies' => Http::get(env('OMDB_API_URL'), [
                'apikey' => env('OMDB_API_KEY'),
                's' => $this->search
            ])->json()
        ]);
    }

    public function addMovieFav($movie_id){
        DB::transaction(function () use ($movie_id){
            try {
                if ($movie = Movie::where('imdbID', $movie_id)->first()){
                    $movie->users()->syncWithoutDetaching(Auth::user());
                }else{
                    $apiMovie = Http::get(env('OMDB_API_URL'), [
                        'apikey' => env('OMDB_API_KEY'),
                        'i' => $movie_id
                    ])->json();

                    $movie = new Movie();
                    $movie->imdbID = $apiMovie['imdbID'];
                    $movie->title = $apiMovie['Title'];
                    $movie->image = $apiMovie['Poster'];
                    $movie->type = $apiMovie['Type'];
                    $movie->genre = $apiMovie['Genre'];
                    $movie->description = $apiMovie['Plot'];
                    $movie->rating = $apiMovie['imdbRating'];
                    $movie->released = Carbon::parse($apiMovie['Released'])->toDateString();
                    $movie->save();
                    $movie->users()->syncWithoutDetaching(Auth::user());
                }


                session()->flash('message', [
                    'description' => "Agregado a favoritos {$movie->title}",
                    'type' => 'Success'
                ]);

            }catch (\Exception $exception){
                DB::rollBack();
                session()->flash('message', [
                    'description' => "Ocurrio un error inesperado, contacte al administrador",
                    'type' => 'Error'
                ]);
            }
        });
    }

    public function removeMovieFav($movie_id){
        DB::transaction(function () use ($movie_id){
            try {
                if ($movie = Auth::user()->movies()
                    ->where('imdbID', $movie_id)
                    ->first()){
                    $movie->users()->detach(Auth::user());

                    session()->flash('message', [
                        'description' => "Se ha eliminado {$movie->title} de favoritos",
                        'type' => 'Success'
                    ]);

                }else{
                    session()->flash('message', [
                        'description' => "Pelicula inexistente",
                        'type' => 'Error'
                    ]);
                }
            }catch (\Exception $exception){
                DB::rollBack();
                session()->flash('message', [
                    'description' => "Ocurrio un error inesperado, contacte al administrador",
                    'type' => 'Error'
                ]);
            }
        });

    }
}
