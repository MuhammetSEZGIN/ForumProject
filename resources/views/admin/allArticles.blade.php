<x-layouts.admin-layout>
    <div class="container w-50 mt-5">
        <div class="mt-5 m-lg-5 w-20 d-flex justify-content-end">
            <form action="{{ route('allArticles') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Makale adı veya yazar ara"
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Ara</button>
                </div>
            </form>
        </div>
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
            @foreach($articles as $article)

                <tr>

                    <td><a href="{{ route('showArticle', ['id' => $article->articleID]) }}">{{$article->title}}</a></td>
                    <td>{{$article->user->name}}</td>
                    <td>{{$article->created_at}}</td>

                    <td class="d-flex gap-1">

                        <form action="{{route("deleteArticleAdmin",['id'=>$article->articleID])}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-modal-button class="btn btn-danger btn-sm">
                                <x-slot name="modalTitleText">Sil</x-slot>
                                <x-slot name="modalButtonText">Sil</x-slot>
                                <x-slot name="modalBodyText">Makaleyi silmek istediğinize emin misiniz?</x-slot>
                            </x-modal-button>
                        </form>
                        <form action="{{route('exportArticleToExcel', ['id'=>$article->articleID])}}" method="POST">
                            @csrf
                            <button class="btn btn-primary btn-sm" type="submit">Excel'e Çıkart</button>
                        </form>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <div>
            {{ $articles->links() }}
        </div>
    </div>

</x-layouts.admin-layout>
