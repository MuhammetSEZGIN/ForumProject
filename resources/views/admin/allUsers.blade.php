<x-layouts.admin-layout>
    <div class="container w-50 mt-5">
        <div class="mt-5 m-lg-5 w-20 d-flex justify-content-end">
        <form action="{{ route('allUsers') }}" method="GET" >
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Kullanıcı adı veya e-posta ara" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Ara</button>
            </div>
        </form>
        </div>
        <table class="table text-center">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>E Mail</th>
                <th>Role</th>
                <th>Created At</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)

                <tr>

                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <form action="{{route("userDelete",$user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-modal-button class="btn btn-danger btn-sm">
                                <x-slot name="modalTitleText">Sil</x-slot>
                                <x-slot name="modalButtonText">Sil</x-slot>
                                <x-slot name="modalBodyText">Yorumu silmek ister misiniz?</x-slot>
                            </x-modal-button>
                        </form>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <div>
            {{ $users->links() }}
        </div>
    </div>

</x-layouts.admin-layout>
