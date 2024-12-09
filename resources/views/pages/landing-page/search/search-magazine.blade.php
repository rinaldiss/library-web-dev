@extends('layouts.auth')

@section('title')
Pencarian Majalah
@endsection

@push('style')
    <link href="{{ asset('vendor/datatables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-12">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <a href="{{ route('search') }}" class="btn btn-sm btn-secondary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                <span class="text">Kembali</span>
                            </a>
                            <div class="text-center">
                                <h1 class="h2 text-gray-900 mb-4">Pencarian Majalah</h1>
                            </div>
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped table-bordered nowrap" id="dataTableSearch" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th width="25">No</th>
                                                    <th>Judul</th>
                                                    <th>Pengarang</th>
                                                    <th>Penerbit</th>
                                                    <th>Tahun Terbit</th>
                                                    <th>Stock</th>
                                                    <th>Dokumen</th>
                                                    <th width="30">Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/datatables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#dataTableSearch').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('search.magazine') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'title', name: 'title' },
                    { data: 'author', name: 'author' },
                    { data: 'publisher', name: 'publisher' },
                    { data: 'year_of_publication', name: 'year_of_publication' },
                    { data: 'stock', name: 'stock' },
                    { data: 'dokumen', name: 'dokumen' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                language: {
                    sEmptyTable: "Tidak ada data",
                    sProcessing: "Sedang memproses...",
                    sLengthMenu: "Tampilkan _MENU_ data",
                    sZeroRecords: "Tidak ditemukan data yang sesuai",
                    sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    sInfoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    sInfoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                    sInfoPostFix: "",
                    sSearch: "Cari:",
                    sUrl: "",
                    oPaginate: {
                        sFirst: "Pertama",
                        sPrevious: "<",
                        sNext: ">",
                        sLast: "Terakhir"
                    }
                }
            });
        });
    </script>
@endpush