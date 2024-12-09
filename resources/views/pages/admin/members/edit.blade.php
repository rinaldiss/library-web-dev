@extends('layouts.admin')

@section('title', 'Ubah Anggota')

@push('style')
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"/>
@endpush

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Ubah Anggota</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('admin.member.update', Crypt::encrypt($member->id)) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $member->name ?? '') }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $member->phone ?? '') }}">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="title">Status</label>
                        <select name="is_verified" class="form-control @error('is_verified') is-invalid @enderror">
                            <option value="1" {{ ($member->is_verified == true) ? "selected" : "" }}>Active</option>
                            <option value="0" {{ ($member->is_verified == false) ? "selected" : "" }}>Non Active</option>
                        </select>
                        @error('is_verified')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <a href="{{ route('admin.book') }}" class="btn btn-secondary btn-icon-split">
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