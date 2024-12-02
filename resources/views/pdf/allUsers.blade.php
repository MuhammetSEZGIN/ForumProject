<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
<div style=" display: flex; align-items: center; justify-content: center">
    <table style="display: flex;">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>E Mail</th>
            <th>Role</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name }}</td>
                <td>{{ $user->created_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


</body>
<style>
    table, th, td {
        border: 1px solid;
    }
</style>
</html>
