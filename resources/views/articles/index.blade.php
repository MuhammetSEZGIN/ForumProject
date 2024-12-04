<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
        <h2>{{$header}}</h2>
        <hr>
        @foreach($articles as $article)

            <div class="d-flex justify-content-between mt-0">
                <h3>{{$article->title}}</h3>
                <p><small>{{$article->created_at}}</small></p>
            </div>
            <p>{!! \Illuminate\Support\Str::limit($article->content, 200) !!} ...
                <a href="{{ route('showArticle', ['id' => $article->articleID]) }}">Show Article</a>
            </p>
            <hr>
        @endforeach
        <div>
            {{ $articles->links() }}
        </div>
    </x-slot>
</x-layouts.layout>
