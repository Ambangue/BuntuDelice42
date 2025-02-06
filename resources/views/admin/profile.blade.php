@extends('layouts.app')
@section('title', 'Admin Profile | Buntu Delice ')
@section('profile_nav', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-12">
                    @if(session()->has('alert'))
            <div class="alert alert-{{ session()->get('alert.type') }}">
                {{ session()->get('alert.message') }}
            </div>
        @endif
                <div class="">
  <div class="card">
    <div class="card-body login-card-body">
        <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{url('images/profile_images',$admin->image)}}" alt="User profile picture">
        </div>
        <h3 class="profile-username text-center">{{$admin->name}}</h3>
        <p class="text-muted text-center">{{$admin->email}}</p>
      <form action="{{route('admin.profile_update')}}" method="post">
          @csrf
          <div class="input-group mb-3">
          <input type="password" name="current_password" class="form-control" placeholder="Current Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if($errors->has('current_password'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('current_password') }}</strong>
            </span>
        @endif
        </div>
        <div class="input-group mb-3">
          <input type="password" name="new_password" class="form-control" placeholder="New password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if($errors->has('new_password'))
            <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('new_password') }}</strong>
            </span>
        @endif
        </div>
        <div class="input-group mb-3">
          <input type="password" name="pwdnew_confirm" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
            </div>
        </div></div>
    </section>
@endsection
