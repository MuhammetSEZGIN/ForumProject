<x-layout>
    <x-slot name="navbar">
        <x-navbar/>
    </x-slot>
    <x-slot name="body">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Makale Başlık</th>
                <th scope="col">Yorum Sahibi</th>
                <th scope="col">Yorum</th>
                <th scope="col">Yarum Tarihi</th>
                <th scope="col">--</th>
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
                    <td>Onaylandı</td>
                @else
                <td><form action="{{route("approveComment",$comment->commentID)}}" method="POST">
                       @csrf
                        @method('PATCH')
                        <input type="submit" value="Onayla">
                    </form></td>
                @endif
                <td><form action="{{route("deleteComment",$comment->commentID)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Sil">
                    </form></td>
            </tr>

            @endforeach
            @else
                <tr >
                    <td colspan="5" ><p class="text-center">Yorum Bulunmamakta</p></td>
                </tr>

            @endif

            </tbody>
        </table>
    </x-slot>
</x-layout>
