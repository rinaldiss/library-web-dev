@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-xl-6 col-lg-8 col-md-8">
        <div class="card border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">SIMPERPUS</h1>
                            </div>
                            <form class="user" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input id="email" type="email" name="email" class="form-control form-control-user" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                </div>
                                <button id="submit-button" type="button" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                                <p class="text-danger text-center mt-3">
                                    <span id="empty">
                                        @if (Session::has('error'))
                                            {{ Session::get('error') }}
                                        @endif
                                    </span>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $('#password, #email').on('keyup', function() {
            if ($('#password').val().length > 0 && $('#email').val().length > 0) {
                $('#submit-button').prop('type', 'submit');
            } else {
                $('#submit-button').prop('type', 'button');
            }
            $('#empty').hide();
        });

        $('#submit-button').on('click', function() {
            if($('#password').val().length > 0 && $('#email').val().length > 0) {
                $('#empty').hide();
            } else if ($('#email').val().length === 0 && $('#password').val().length === 0) {
                $('#empty').text('Silakan isi email dan password Anda!');
                $('#empty').show();
            } else if ($('#email').val().length === 0) {
                $('#empty').text('Silakan isi email Anda!');
                $('#empty').show();
            } else if ($('#password').val().length === 0) {
                $('#empty').text('Silakan isi password Anda!');
                $('#empty').show();
            }
        });
    });
</script>
@endpush