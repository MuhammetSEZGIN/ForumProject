<x-layouts.admin-layout>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>User Logs</h1>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Makale Numarası</th>
                        <th>Rapor Numarası</th>
                        <th>Kullanıcı Numarası</th>
                        <th>Rapor Nedeni</th>
                        <th>Zaman</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $reportedComment)
                        <tr>
                            <td>{{ $reportedComment->id }}</td>
                            <td>{{ $reportedComment->articleID }}</td>
                            <td>{{ $reportedComment->userID }}</td>
                            <td>{{ $reportedComment->reason }}</td>
                            <td>{{ $reportedComment->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin-layout>
