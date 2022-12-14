
@extends('layouts.app')
@section('content')

<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card p-3 mb-4">
        <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h5>Profile Information</h5>
                <p>Update your account's profile information and email address.</p>
                <div class="form-group focused col-md-5 mb-3">
                    <label class="form-control-label mb-1" for="name">Name</label>
                    <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name', Auth::user()->name) }}">
                </div>
                <div class="form-group focused col-md-5 mb-3">
                    <label class="form-control-label mb-1" for="last_name">Email</label>
                    <input type="email" id="email" class="form-control" name="email" placeholder="Email" value="{{ old('email', Auth::user()->email) }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card p-3">
        <div class="card-body">
            <form action="{{ route('password.update') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">

                <h5>Update Password</h5>
                <p>Ensure your account is using a long and random password for security.</p>
                <div class="form-group focused col-md-5 mb-3">
                    <label class="form-control-label" for="current_password">Current password</label>
                    <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Current password">
                </div>
                <div class="form-group focused col-md-5 mb-3">
                    <label class="form-control-label" for="new_password">New password</label>
                    <input type="password" id="new_password" class="form-control" name="new_password" placeholder="New password">
                </div>
                <div class="form-group focused col-md-5 mb-3">
                    <label class="form-control-label" for="confirm_password">Confirm password</label>
                    <input type="password" id="confirm_password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                </div>
                <div>
                    <button type="submit" class="btn btn-dark">Save</button>
                </div>
            </form>
        </div>
    </div>

</div>

@include('modal.certificate')
<script>
    $(document).ready(function(){
        $('#previewImage').hide();
            setTimeout(() => {
            $('.alert').fadeOut('slow');
        }, 3000);
    })
</script>
@endsection