@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-dark">Dashboard</h1>
</div>

<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card shadow">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col-sm-8">
                        <div class="text-dark mb-1">
                            Selamat datang
                        </div>
                        <div class="text-dark">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{ route('logout' )}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-dark btn-block">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                            Berkas Hukum
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $regulations }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-gavel fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                            Majalah
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $magazines }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                            Buku
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $books }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection