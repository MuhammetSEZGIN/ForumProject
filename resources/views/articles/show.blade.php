<x-layout>
    <x-slot name="navbar">
        <x-navbar></x-navbar>
    </x-slot>
    <x-slot name="body">
       <h2>{{$article->title}}</h2>
        <div>{{$article->content}}</div>
        <h1>Yorumlar</h1>
        <x-comment-form :messages='$article'  ></x-comment-form>
    </x-slot>

</x-layout>


