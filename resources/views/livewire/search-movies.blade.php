<div>
    <div class="flex mb-4">
        <div class="w-1/3 h-12"></div>
        <div class="w-1/3 h-12">
            <input wire:model="search" type="text" placeholder="Buscar peliculas..." class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker leading-tight focus:outline-none focus:shadow-outline" aria-label="Full name">
        </div>
        <div class="w-1/3 h-12"></div>
    </div>

    @if(isset($arrMovies['Search']))
        <div class="container my-12 mx-auto px-4 md:px-12">
            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                @foreach($arrMovies['Search'] as $movie)
                    @php
                        $img = ($movie['Poster'] !== 'N/A') ? $movie['Poster'] : "https://coraops.com/wp-content/themes/uplift/images/default-thumb.png"
                    @endphp
                    <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
                            <article class="overflow-hidden rounded-lg shadow-lg">
                                <img alt="{{ $movie['Title'] }}" class="block h-auto w-full" src="{{ $img }}" style="height: 400px; object-fit: cover">

                                <header class="leading-tight p-2 md:p-4">
                                    <h1 class="text-lg">
                                        {{ $movie['Title'] }}
                                    </h1>
                                    <p class="text-grey-darker text-sm">
                                        <i class="far fa-clock"></i> {{ $movie['Year'] }}
                                    </p>
                                </header>

                                <footer class="flex items-center justify-between leading-none p-2 md:p-4">
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $movie['Type'] }}</span>
                                    <a class="no-underline text-grey-darker hover:text-red-dark" href="#">
                                        <span class="hidden">Like</span>
                                        <i class="far fa-heart"></i>
                                    </a>
                                </footer>

                            </article>
                        </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
