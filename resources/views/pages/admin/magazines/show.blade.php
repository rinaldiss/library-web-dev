@extends('layouts.admin')

@section('title', 'Detail Majalah')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Detail Majalah</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->title }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Urut Majalah</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->magazine_serial_number }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nomor</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->number }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Volume</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->volume }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Kala Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->times_published }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ISSN</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->issn }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->author }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->publisher }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tempat Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->place_of_publication }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->year_of_publication }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Klasifika</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->classification }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Berasal dari</label>
                    <input type="text" class="form-control" disabled value="{{ $magazine->place_of_origin }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea type="text" class="form-control" disabled>{{ $magazine->note }}</textarea>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.magazine') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>
@endsection