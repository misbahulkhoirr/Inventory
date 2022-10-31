@extends('layouts.panel')
@push('css')
<style>
        .pass_show {
            position: relative
        }

        .pass_show .ptxt {
            position: absolute;
            top: 50%;
            right: 10px;
            z-index: 1;
            color: #f36c01;
            margin-top: -10px;
            cursor: pointer;
            transition: .3s ease all;
        }

        .pass_show .ptxt:hover {
            color: #333333;
        }
    </style>
@endpush
@section('content')
<section class="pcoded-main-container">
    <div class="pcoded-content">

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Change Password</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i
                                        class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{route('viewProfile.index')}}">Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        <h5>Change Password</h5>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    @elseif ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ $message }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    @endif


                    <div class="container mt-3">
                        <div class="row justify-content-center">


                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('changePasswordDB') }}">
                                            @csrf


                                            <div class="row mb-3">
                                                <label for="current_password"
                                                    class="col-md-2 col-form-label text-md-end">{{ __('Current Password') }}</label>

                                                <div class="col-md-6 pass_show">
                                                    <input id="current_password" type="password"
                                                        class="form-control @error('current_password') is-invalid @enderror"
                                                        name="current_password"
                                                        value="{{ $current_password ?? old('current_password') }}"
                                                        required autocomplete="current_password"
                                                        placeholder="Masukkan kata sandi saat ini"
                                                        data-toggle="current_password" autofocus>

                                                    @error('current_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="new_password"
                                                    class="col-md-2 col-form-label text-md-end">{{ __('New Password') }}</label>

                                                <div class="col-md-6 pass_show">
                                                    <input id="new_password" type="password"
                                                        class="form-control @error('new_password') is-invalid @enderror"
                                                        name="password" required autocomplete="new-password"
                                                        placeholder="Masukkan kata sandi baru" data-toggle="password">

                                                    @error('new_password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="new-password-confirm"
                                                    class="col-md-2 col-form-label text-md-end">{{ __('Re-Type New Password') }}</label>

                                                <div class="col-md-6 pass_show">
                                                    <input id="new-password-confirm" type="password"
                                                        class="form-control" name="password_confirmation" required
                                                        autocomplete="new-password-confirm"
                                                        placeholder="Ulangi kata sandi baru"
                                                        data-toggle="password_confirmation">
                                                </div>
                                            </div>

                                            <div class="row mb-0">
                                                <div class="col-md-6 offset-md-2">
                                                    <button type="submit" class="btn btn-primary" id="formSubmit">
                                                        {{ __('Update Password') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        $('.pass_show').append('<span class="ptxt">Show</span>');
    });
    $(document).on('click', '.pass_show .ptxt', function () {
        $(this).text($(this).text() == "Show" ? "Hide" : "Show");
        $(this).prev().attr('type', function (index, attr) {
            return attr == 'password' ? 'text' : 'password';
        });
    });
</script>
@endpush