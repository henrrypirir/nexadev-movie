<div class="container my-12 mx-auto px-4 md:px-12">
    <div class="flex flex-wrap -mx-1 lg:-mx-4">
        @foreach($arrMovies as $movie)
            @php
                $img = ($movie->image !== 'N/A') ? $movie->image : "https://coraops.com/wp-content/themes/uplift/images/default-thumb.png"
            @endphp
            <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">
                <article class="overflow-hidden rounded-lg shadow-lg">
                    <img alt="{{ $movie->title }}" class="block h-auto w-full" src="{{ $img }}" style="height: 400px; object-fit: cover">

                    <div class="flex items-center justify-between flex-wrap">
                        <header class="leading-tight p-2 md:p-4">
                            <h1 class="text-lg">
                                {{ $movie->title }}
                            </h1>
                            <p class="text-grey-darker text-sm">
                                <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($movie->released)->year }}
                            </p>
                        </header>
                        <div class="p-2 md:p-4">
                            <button wire:click="removeMovieFav('{{ $movie->id }}')" class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>

                    <footer class="flex items-center flex-wrap leading-none p-2 md:p-4">
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $movie->type }}</span>
                        @php
                            $arrGenre = explode(', ', $movie->genre);
                        @endphp
                        @foreach($arrGenre as $genre)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#{{ $genre }}</span>
                        @endforeach
                    </footer>

                </article>
            </div>
        @endforeach
    </div>
    @if (session()->has('message'))
        <div id="alert">
            <script>
                Swal.fire({
                    text: "{{ session('message.description') }}",
                    icon: "{{ strtolower(session('message.type')) }}"
                }).then(() => {
                    document.getElementById('alert').innerHTML = "";
                });
            </script>
        </div>
    @endif
</div>
