@extends('layouts.admin')

@section('title', 'Detail Buku')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Detail Buku</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" class="form-control" disabled value="{{ $book->title }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Urut Buku</label>
                    <input type="text" class="form-control" disabled value="{{ $book->book_serial_number }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Edisi</label>
                    <input type="text" class="form-control" disabled value="{{ $book->edition }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Volume</label>
                    <input type="text" class="form-control" disabled value="{{ $book->volume }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Cetakan</label>
                    <input type="text" class="form-control" disabled value="{{ $book->printed }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>ISBN</label>
                    <input type="text" class="form-control" disabled value="{{ $book->isbn }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Pengarang</label>
                    <input type="text" class="form-control" disabled value="{{ $book->author }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" class="form-control" disabled value="{{ $book->publisher }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tempat Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $book->place_of_publication }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="text" class="form-control" disabled value="{{ $book->year_of_publication }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>No. Klasifika</label>
                    <input type="text" class="form-control" disabled value="{{ $book->classification }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Berasal dari</label>
                    <input type="text" class="form-control" disabled value="{{ $book->place_of_origin }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea type="text" class="form-control" disabled>{{ $book->note }}</textarea>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="text" class="form-control" disabled value="{{ old('stock', $book->stock ?? '') }}">                   
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Dokumen</label>
                    <br>
                    <a href="{{ asset('storage/' . $book->dokumen) }}" class="btn btn-primary btn-sm float-end" download>Download</a>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.book') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>
@endsection