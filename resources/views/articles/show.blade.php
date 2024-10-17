<x-layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
       <h2>{{$article->title}}</h2>
        <p>{{$article->content}}</p>
        <h1>Yorumlar</h1>
        <x-comment-form :messages='$article'  ></x-comment-form>
    </x-slot>

</x-layout>


