@extends('layouts.admin')

@section('title', 'Peraturan')

@push('style')
    <link href="{{ asset('vendor/datatables/datatables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Pengembalian Buku</h1>
    <a href="{{ route('admin.regulation.export') }}" class="btn btn-sm btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-download"></i>
        </span>
        <span class="text">Export</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('admin.reversion.create') }}" class="btn btn-sm btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered nowrap" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="25">No</th>
                        <th>Peminjam</th>
                        <th>No HP</th>
                        <th>Jenis</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/datatables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    
    @if(session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
    @if(session('error'))
        <script>
            toastr.error("{{ session('error') }}");
        </script>
    @endif
    
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.reversion') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'peminjam', name: 'peminjam' },
                    { data: 'phone', name: 'phone' },
                    { data: 'type', name: 'type' },
                    { data: 'judul', name: 'judul' },
                    { data: 'pengarang', name: 'pengarang' },
                    { data: 'returned_at', name: 'returned_at' },
                    { data: 'penalty', name: 'penalty' },
                    { 
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false 
                    }
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

            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Harap periksa kembali. Data yang sudah dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#888888',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.loan.delete') }}/"+id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Data Anda telah dihapus.',
                                    'success'
                                );
                                $('#dataTable').DataTable().ajax.reload();
                            },
                            error: function(response) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
