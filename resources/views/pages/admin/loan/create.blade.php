@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Tambah Peminjaman</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.loan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="title">Peminjam</label>
                        <select name="member_id" id="member" class="form-control @error('member_id') is-invalid @enderror">
                            <option value="">--Pilih Peminjam--</option>
                            @foreach ($member as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="title">Jenis Peminjaman</label>
                        <select name="type" id="type" onchange="return showDataPinjam()" class="form-control @error('type') is-invalid @enderror">
                            <option {{ (old("type") == "book") ? "selected" : "" }} value="book">Buku</option>
                            <option {{ (old("type") == "magazine") ? "selected" : "" }} value="magazine">Majalah</option>
                            <option {{ (old("type") == "regulation") ? "selected" : "" }} value="regulation">Peraturan</option>
                        </select>
                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-none" id="buku">
                    <div class="form-group">
                        <label for="title">Buku</label>
                        <select name="book_id" class="form-control @error('book_id') is-invalid @enderror">
                            <option value="">--Pilih Buku--</option>
                            @foreach ($book as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-none" id="majalah">
                    <div class="form-group">
                        <label for="title">Majalah</label>
                        <select name="magazine_id" class="form-control @error('magazine_id') is-invalid @enderror">
                            <option value="">--Pilih Majalah--</option>
                            @foreach ($magazine as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('magazine_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-none" id="peraturan">
                    <div class="form-group">
                        <label for="title">Peraturan</label>
                        <select name="regulation_id" class="form-control @error('regulation_id') is-invalid @enderror">
                            <option value="">--Pilih Peraturan--</option>
                            @foreach ($regulation as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('regulation_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Waktu Pinjam</label>
                        <input type="datetime-local" value="{{ date('Y-m-d H:i') }}" name="loan_at" class="form-control  @error('loan_at') is-invalid @enderror">
                        @error('loan_at')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="title">Lama Pinjam (Hari)</label>
                        <input type="text" value="1" name="lama_pinjam" class="form-control  @error('lama_pinjam') is-invalid @enderror">
                        @error('lama_pinjam')
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
        function showDataPinjam(){
            type = $("#type").find(":selected").val()
            if (type === "book") {
                $("#buku").removeClass("d-none")
                $("#majalah").addClass("d-none")
                $("#peraturan").addClass("d-none")
            }else if (type === "magazine") {
                $("#majalah").removeClass("d-none")
                $("#buku").addClass("d-none")
                $("#peraturan").addClass("d-none")
            }else if (type === "regulation") {
                $("#peraturan").removeClass("d-none")
                $("#buku").addClass("d-none")
                $("#majalah").addClass("d-none")
            }
        }
        $(document).ready(function(){
            showDataPinjam();
        })
    </script>
    @error('failed')
        <script>
            toastr.error("{{ $message }}");
        </script>
    @enderror
@endpush