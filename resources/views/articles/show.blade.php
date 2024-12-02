<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">

        <h2>{{$article->title}}</h2>
        <div class="d-flex justify-content-between">
            <p><small>{{$article->user->name}}</small></p>
            <p><small>{{$article->created_at}}</small></p>
        </div>

        <hr>
        <div>{!! $article->content !!}</div>
        <x-comment-form :messages='$article'  ></x-comment-form>
    </x-slot>
</x-layouts.layout>


