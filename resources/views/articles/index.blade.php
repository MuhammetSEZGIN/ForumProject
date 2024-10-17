<x-layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
        <h1>{{$header}}</h1>
        @foreach($articles as $article)
            <h2>{{$article->title}}</h2>
            <p>{{\Illuminate\Support\Str::limit($article->content,300)}}
                <a href="{{route("article",$article->articleID)}}">Devamını Oku</a>
            </p>

        @endforeach
        <div>
            {{$articles->links()}}
        </div>
    </x-slot>

</x-layout>

