@extends('layouts.auth')

@section('title', 'Daftar Kunjungan')

@push('style')
    <link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-9">
        <div class="card border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Daftar Kunjungan</h1>
                            </div>
                            <form class="user" action="{{ route('visitors.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input id="name" type="text" name="name" class="form-control form-control-user @error('name') is-invalid @enderror" placeholder="Nama">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="nip" type="text" name="nip" class="form-control form-control-user @error('nip') is-invalid @enderror" placeholder="NIP">
                                    @error('nip')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-user">
                                        Submit
                                    </button>
                                </div>
                                <p class="text-danger text-center mt-3">
                                    <span id="empty">
                                        @if (Session::has('error'))
                                            {{ Session::get('error') }}
                                        @endif
                                    </span>
                                </p>
                            </form>
                            <a href="{{ route('home') }}" class="btn btn-sm btn-secondary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                <span class="text">Kembali</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    
@if(session('success'))
    <script>
        toastr.success("{{ session('success') }}");
    </script>
@endif
@endpush