<x-layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">Makale Başlık</th>
                <th scope="col">Yazar</th>
                <th scope="col">Yayın Tarihi</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @if(count($articles)!==0)

                @foreach($articles as $article)

                    <tr>
                        <td>{{$article->title}}</td>
                        <td>{{$article->user->name}}</td>
                        <td>{{$article->created_at}}</td>

                        <td class="d-flex gap-1">
                            <form action="{{route('article.edit.show',['id'=>$article->articleID])}}" method="GET">
                                <button class="btn btn-primary btn-sm" type="submit">Düzenle</button>
                            </form>
                            <form action="{{route("deleteArticle",['id'=>$article->articleID])}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">Sil</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            @else
                <tr>
                    <td colspan="5"><p class="text-center">Makale Bulunmamakta</p></td>
                </tr>
            @endif

            </tbody>
        </table>
    </x-slot>
</x-layout>