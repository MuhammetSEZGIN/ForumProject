<x-layouts.admin-layout>
    <div class="container w-100 mt-5" style="overflow-x: auto;">
        <div class="mt-5 m-lg-5 w-20 d-flex justify-content-end">
            <form action="{{ route('userLogs') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tablo Bilgilerini Ara"
                           value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Ara</button>
                </div>
            </form>
        </div>
        <table class="table text-lg-start">
            <thead>
            <tr>
                <th>User</th>
                <th>User Agent</th>
                <th>Activity</th>
                <th>Post Data</th>
                <th>Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($userLogs as $log)

                <tr>

                    @if($log->user->name != null)
                        <td>{{ $log->user->name}}</td>
                    @else
                        <td>Anonim</td>
                    @endif
                    <td>{{ $log->userAgent }}</td>
                    <td>{{ $log->url }}</td>
                    <td>{{ $log->postData }}</td>
                    <td>{{ $log->created_at }}</td>
                    <td>
                        <form action="{{ route('userLogsDelete', $log->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-modal-button class="btn btn-danger btn-sm" id="{{$log->id}}">
                                <x-slot name="modalTitleText">Sil</x-slot>
                                <x-slot name="modalButtonText">Sil</x-slot>
                                <x-slot name="modalBodyText">Logu silmek ister misiniz?</x-slot>
                            </x-modal-button>
                        </form>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <div>
            {{ $userLogs->links() }}
        </div>
        <div class="mt-5 m-lg-5 w-20 d-flex justify-content-end">
            <form action="{{ route('userLogsDeleteAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <x-modal-button class="btn btn-danger btn-sm" id="default">
                    <x-slot name="modalTitleText">Sil</x-slot>
                    <x-slot name="modalButtonText">Hepsini Sil</x-slot>
                    <x-slot name="modalBodyText">Hepsini silmek ister misiniz?</x-slot>
                </x-modal-button>
            </form>

        </div>
    </div>
</x-layouts.admin-layout>
