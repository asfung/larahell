<!DOCTYPE html>
<html>
<head>
    <title>Laporan Siswa</title>
</head>
<body>
    <h1>Laporan Data Siswa</h1>
    <table border="1">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Telepon</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $s)
                <tr>
                    <td>{{ $s->nisn }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>{{ $s->tempat_lahir }}</td>
                    <td>{{ $s->tanggal_lahir }}</td>
                    <td>{{ $s->alamat }}</td>
                    <td>{{ $s->telepon }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
