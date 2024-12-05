@extends('layouts.admin')

@section('title', 'Tambah Pengembalian')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Tambah Pengembalian</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.reversion.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Pilih Data Peminjam</label>
                        <select name="loan_id" onchange="return showDetail()" id="loan_id" class="form-control @error('loan_id') is-invalid @enderror">
                            <option value="">--Pilih Data Peminjaman--</option>
                            @foreach ($loan as $item)
                                <option value="{{ $item->id }}">{{ $item->visitor->name }} - {{ $item->visitor->nip }}</option>
                            @endforeach
                        </select>
                        @error('loan_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Tanggal Pengembalian</label>
                        <input type="datetime-local" onchange="return showDetail()" value="{{ date('Y-m-d H:i') }}" name="returned_at" class="form-control  @error('returned_at') is-invalid @enderror">
                        @error('returned_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Jenis Peminjaman</label>
                        <input type="text" class="form-control" readonly name="type">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control" readonly name="title">                        
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="title">Pengarang</label>
                        <input type="text" class="form-control" readonly name="author">                        
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Waktu Pinjam</label>
                        <input type="datetime-local" readonly value="" name="loan_at" class="form-control  @error('loan_at') is-invalid @enderror">
                        @error('loan_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Jumlah Denda Keterlambatan</label>
                        <input type="text" value="0" readonly name="amount_penalty" class="form-control  @error('amount_penalty') is-invalid @enderror">
                        @error('amount_penalty')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <a href="{{ route('admin.loan') }}" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span class="text">Batal</span>
                    </a>
                </div>
                <div class="col-md-7">
                    <button type="submit" class="btn btn-primary btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Simpan</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/customize.js')}}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script>
        $("#year_of_publication").datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose: true
        });
        function showDetail(){
            let id = $("#loan_id").find(":selected").val();
            if (id != "") {
                $.ajax({
                    url:"{{ route('admin.reversion.create') }}",
                    data:{id:id,returned_at:$("input[name='returned_at']").val()},
                    success:(res) => {
                        if (res.success) {
                            for (const key in res.data) {
                                $(`input[name='${key}']`).val(res.data[key])
                            }
                        }
                    }
                })
            }
        }
        $(document).ready(function(){
        })
    </script>
    @error('failed')
        <script>
            toastr.error("{{ $message }}");
        </script>
    @enderror
@endpush