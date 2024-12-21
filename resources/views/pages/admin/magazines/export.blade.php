<table>
    <thead>
        <tr>
            <th>Judul</th>
            <th>No. Urut Majalah</th>
            <th>Nomor</th>
            <th>Volume</th>
            <th>Kata Terbit</th>
            <th>ISSN</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tempat Terbit</th>
            <th>Tahun Terbit</th>
            <th>No. Rak</th>
            <th>Berasal dari</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datas as $data)
            <tr>
                <td>{{ $data->title }}</td>
                <td>{{ $data->magazine_serial_number }}</td>
                <td>{{ $data->number }}</td>
                <td>{{ $data->volume }}</td>
                <td>{{ $data->times_published }}</td>
                <td>{{ $data->issn }}</td>
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