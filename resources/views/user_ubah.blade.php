<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ubah Data User</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="{{ route('/user') }}">Kembali</a>
    <br>
    <form method="post" action="{{ route('/user/ubah_simpan', $data->user_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Username</label><br>
        <input type="text" name='username' value="{{ $data->username }}">
        <br><br>
        <label>Nama</label><br>
        <input type="text" name='nama' value="{{ $data->nama }}">
        <br><br>
        <label>Level ID</label><br>
        <input type="number" name='level_id' value="{{ $data->level_id }}">
        <br><br>
        <input type="submit" name='btn btn-success' value="Ubah">
    </form>
</body>
</html>