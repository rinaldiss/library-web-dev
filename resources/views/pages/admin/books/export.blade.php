<table>
    <thead>
        <tr>
            <th>Judul</th>
            <th>No. Urut Buku</th>
            <th>Edisi</th>
            <th>Volume</th>
            <th>Cetakan</th>
            <th>ISBN</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tempat Terbit</th>
            <th>Tahun Terbit</th>
            <th>No. Klasifika</th>
            <th>Berasal dari</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $data)
            <tr>
                <td>{{ $data->title }}</td>
                <td>{{ $data->book_serial_number }}</td>
                <td>{{ $data->edition }}</td>
                <td>{{ $data->volume }}</td>
                <td>{{ $data->printed }}</td>
                <td>{{ $data->isbn }}</td>
                <td>{{ $data->author }}</td>
                <td>{{ $data->publisher }}</td>
                <td>{{ $data->place_of_publication }}</td>
                <td>{{ $data->year_of_publication }}</td>
                <td>{{ $data->classification }}</td>
                <td>{{ $data->place_of_origin }}</td>
                <td>{{ $data->note }}</td>
            </tr>
        @endforeach
    </tbody>
</table>