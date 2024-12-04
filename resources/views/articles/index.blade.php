<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
        <h2>{{$header}}</h2>
        <hr>
        @foreach($articles as $article)
            <h2>{{$article->title}}</h2>
            <div class="d-flex justify-content-end">
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
