@extends('layouts.landing-page')

@section('title', 'Menu Utama')

@push('style')
    <link rel="stylesheet" href="{{ asset('css/pencarian.css')}}"/>
@endpush

@section('content')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="h1 text-primary mb-5">Menu Utama</div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <a href="{{ route('search') }}" class="text-decoration-none">
                            <div class="featured-block">
                                <div class="card shadow bg-primary h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                                    Pencarian Buku Induk
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-search fa-2x text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                
                    <div class="col-xl-4 col-md-6 mb-4">
                        <a href="{{ route('visitors') }}" class="text-decoration-none">
                            <div class="featured-block">
                                <div class="card shadow bg-primary h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                                    Daftar Kunjungan
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-walking fa-2x text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection 