<?php

namespace App\Http\Livewire\Movie;

use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Favs extends Component
{
    public function render()
    {
        return view('livewire.movie.favs', [
            'arrMovies' => Auth::user()->movies()->get()
        ])
        ->layout('layouts.app', ['header'=> __('Movie')]);
    }

    public function removeMovieFav($movie_id){
        DB::transaction(function () use ($movie_id){
            try {
                if ($movie = Movie::find($movie_id)){
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
