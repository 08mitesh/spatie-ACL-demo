@extends('layouts.admin')

@section('title')
Password
@endsection

@section('content')
<section class="content">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Password</h4>
                    </div>
                    <div class="card-body">
                        <div>
                            <div>
                                <form class="form-horizontal" method="POST" action="{{ route('user.updatePassword') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Password</label>
                                                <input type="text" name="newPassword"  id="newPassword" class="form-control @error('newPassword') is-invalid @enderror" value="{{ auth()->user()->newPassword }}" required placeholder="Password">
                                                @error('newPassword')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="name">Confirm Password</label>
                                                <input type="text" name="newPassword_confirmation"  id="newPassword_confirmation" class="form-control @error('newPassword_confirmation') is-invalid @enderror" value="{{ auth()->user()->newPassword_confirmation }}" required placeholder="Confirm Password">
                                                @error('newPassword_confirmation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group button">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit"></i> Update </button>
                                                {{--  <a role="button" href="admin/index.html" class="bizwheel-btn theme-2">Login</a>  --}}
                                            </div>
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
</section>
@endsection
