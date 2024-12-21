@extends('layouts.admin')

@section('title', 'Detail Peraturan')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Detail Berkas Hukum</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->title }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Urut Peraturan</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->regulation_serial_number }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tipe Peraturan</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->regulation_type }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nomor dan Tahun Peraturan</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->number_and_year_of_regulation }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->author }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->publisher }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tempat Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->place_of_publication }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->year_of_publication }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Berasal dari</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->place_of_origin }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea type="text" class="form-control" disabled>{{ $regulation->note }}</textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="text" class="form-control" disabled value="{{ old('stock', $regulation->stock ?? '') }}">                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Rak</label>
                    <input type="text" class="form-control" disabled value="{{ $regulation->classification }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Dokumen</label>
                    <br>
                    <a href="{{ asset('storage/' . $regulation->dokumen) }}" class="btn btn-primary btn-sm float-end" download>Download</a>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.regulation') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>
@endsection