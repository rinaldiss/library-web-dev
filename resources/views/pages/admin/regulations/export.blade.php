<table>
    <thead>
        <tr>
            <th>Judul</th>
            <th>No. Urut Peraturan</th>
            <th>Tipe Peraturan</th>
            <th>Nomor dan Tahun Peraturan</th>
            <th>Tempat dan Nomor Peraturan</th>
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
                <td>{{ $data->regulation_serial_number }}</td>
                <td>{{ $data->regulation_type }}</td>
                <td>{{ $data->number_and_year_of_regulation }}</td>
                <td>{{ $data->place_and_number_of_regulation }}</td>
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