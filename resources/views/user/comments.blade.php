<x-layouts.layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">
        <table class="table text-center">
            <thead>
            <tr>
                <th scope="col">Makale Başlık</th>
                <th scope="col">Yorum Sahibi</th>
                <th scope="col">Yorum</th>
                <th scope="col">Yorum Tarihi</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @if(count($comments) !== 0)
                @foreach($comments as $comment)
                    <tr>
                        <td><a href="{{ route('showArticle', ['id' => $comment->article->articleID]) }}">{{ $comment->article->title }}</a></td>
                        <td>{{ $comment->user->name }}</td>
                        <td>{{ $comment->content }}</td>
                        <td>{{ $comment->created_at }}</td>
                        @if($comment->isApproved)
                            <td class="d-flex gap-3">Onaylandı
                        @else
                            <td class="d-flex gap-1">
                                <form action="{{ route('approveComment', $comment->commentID) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success btn-sm" type="submit">Onayla</button>
                                </form>
                                @endif
                                <!-- Sil Butonu -->
                                <form action="{{ route('deleteComment', $comment->commentID) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-modal-button class="btn btn-danger btn-sm" id="{{$comment->commentID}}">
                                        <x-slot name="modalTitleText">Sil</x-slot>
                                        <x-slot name="modalButtonText">Sil</x-slot>
                                        <x-slot name="modalBodyText">Yorumu silmek ister misiniz?</x-slot>
                                    </x-modal-button>
                                </form>
                            </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5"><p class="text-center">Yorum Bulunmamakta</p></td>
                </tr>
            @endif
            </tbody>
        </table>
    </x-slot>
</x-layouts.layout>
