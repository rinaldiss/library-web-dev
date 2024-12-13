@extends('layouts.admin')

@section('title', 'Ubah Peraturan')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Ubah Berkas Hukum</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.regulation.update', Crypt::encrypt($regulation->id)) }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $regulation->title) }}">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="regulation_serial_number">No. Urut Peraturan</label>
                        <input type="number" class="form-control @error('regulation_serial_number') is-invalid @enderror" id="regulation_serial_number" name="regulation_serial_number" value="{{ old('regulation_serial_number', $regulation->regulation_serial_number) }}">
                        @error('regulation_serial_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="regulation_type">Tipe Peraturan</label>
                        <input type="text" class="form-control @error('regulation_type') is-invalid @enderror" id="regulation_type" name="regulation_type" value="{{ old('regulation_type', $regulation->regulation_type) }}">
                        @error('regulation_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="number_and_year_of_regulation">Nomor dan Tahun Peraturan</label>
                        <input type="text" class="form-control @error('number_and_year_of_regulation') is-invalid @enderror" id="number_and_year_of_regulation" name="number_and_year_of_regulation" value="{{ old('number_and_year_of_regulation', $regulation->number_and_year_of_regulation) }}">
                        @error('number_and_year_of_regulation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="author">Pengarang</label>
                        <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author', $regulation->author) }}">
                        @error('author')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="publisher">Penerbit</label>
                        <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" value="{{ old('publisher', $regulation->publisher)}}">
                        @error('publisher')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="place_of_publication">Tempat Terbit</label>
                        <input type="text" class="form-control @error('place_of_publication') is-invalid @enderror" id="place_of_publication" name="place_of_publication" value="{{ old('place_of_publication', $regulation->place_of_publication) }}">
                        @error('place_of_publication')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="year_of_publication">Tahun Terbit</label>
                        <input type="text" class="form-control @error('year_of_publication') is-invalid @enderror" id="year_of_publication" name="year_of_publication" value="{{ old('year_of_publication', $regulation->year_of_publication) }}">
                        @error('year_of_publication')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="classification">No. Klasifika</label>
                        <input type="text" class="form-control @error('classification') is-invalid @enderror" id="classification" name="classification" value="{{ old('classification', $regulation->classification) }}">
                        @error('classification')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="place_of_origin">Berasal dari</label>
                        <input type="text" class="form-control @error('place_of_origin') is-invalid @enderror" id="place_of_origin" name="place_of_origin" value="{{ old('place_of_origin', $regulation->place_of_origin) }}">
                        @error('place_of_origin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="note">Keterangan</label>
                        <textarea type="text" class="form-control @error('note') is-invalid @enderror" id="note" name="note">{{ old('note', $regulation->note) }}</textarea>
                        @error('note')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="stock">Stok</label>
                        <input type="text" class="form-control" name="stock" value="{{ old('stock', $regulation->stock ?? '') }}">
                        @error('stock')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dokumen">Dokumen</label>
                        <input type="file" class="form-control" name="dokumen" value="{{ old('dokumen') }}">
                        @error('dokumen')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <a href="{{ route('admin.regulation') }}" class="btn btn-secondary btn-icon-split">
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
    <script>
        $("#year_of_publication").datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            autoclose: true
        });
    </script>
@endpush