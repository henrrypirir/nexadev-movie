<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

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
}
