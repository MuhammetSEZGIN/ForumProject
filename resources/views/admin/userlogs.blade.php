<x-layouts.admin-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Logs</h1>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>User</th>
                            <th>User Agent</th>
                            <th>Activity</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userlogs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>

                            <td>{{ $log->userAgent }}</td>
                            @if($log->user->name != null)
                            <td>{{ $log->user->name}}</td>
                            @else
                                <td>Anonim</td>
                            @endif
                                <td>{{ $log->url }}</td>
                            <td>{{ $log->postData }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
