<x-layout>
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
                <th scope="col">Yarum Tarihi</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @if(count($comments)!==0)

            @foreach($comments as $comment)

            <tr>
                <td>{{$comment->article->title}}</td>
                <td>{{$comment->user->name}}</td>
                <td>{{$comment->content}}</td>
                <td>{{$comment->created_at}}</td>
                @if($comment->isApproved==true)
                    <td class="d-flex gap-3">Onaylandı
                @else
                <td class="d-flex gap-1">
                    <form action="{{route("approveComment",$comment->commentID)}}" method="POST">
                       @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm" type="submit">Onayla</button>
                    </form>
                @endif
                    <form action="{{route("deleteComment",$comment->commentID)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Sil</button>
                    </form>
                </td>
            </tr>

            @endforeach
            @else
                <tr>
                    <td colspan="5" ><p class="text-center">Yorum Bulunmamakta</p></td>
                </tr>

            @endif

            </tbody>
        </table>
    </x-slot>
</x-layout>
