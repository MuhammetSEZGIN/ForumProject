<x-layouts.admin-layout >

    <div class="container w-100 mt-5" style="overflow-x: auto;">
        <div class="mt-5 m-lg-5 w-20 d-flex justify-content-end">
            <form action="{{ route('userActionLogs') }}" method="GET">
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
                <th>Ip</th>
                <th>User Agent</th>
                <th>Post Data</th>
                <th>Action</th>
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
                    <td>{{ $log->ip }}</td>
                    <td>{{ $log->userAgent }}</td>
                    <td>{{ $log->postData }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->created_at }}</td>

                </tr>

            @endforeach

            </tbody>
        </table>
        <div>
            {{ $userLogs->links() }}
        </div>
        <div class="mt-5 m-lg-5 w-20 d-flex justify-content-end">
            <form action="{{ route('userActionLogsDeleteAll') }}" method="POST">
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
