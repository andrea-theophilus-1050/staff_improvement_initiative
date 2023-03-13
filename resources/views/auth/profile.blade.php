@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Change password</h4>

                    <form class="forms-sample" method="POST" action="{{ route('auth.change.password') }}">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                @foreach ($errors->all() as $error)
                                    <strong>Error!</strong> {{ $error }}<br />
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif(session('firstAccess'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>NOTE!</strong> {{ session('firstAccess') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputPassword1">Current Password</label>
                            <input type="password" class="form-control" name="currentPassword"
                                placeholder="Current Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">New Password</label>
                            <input type="password" class="form-control" name="newPassword" placeholder="New Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword1">Confirm New Password</label>
                            <input type="password" class="form-control" name="confirmPassword"
                                placeholder="Confirm New Password">
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Change Password</button>
                        <button class="btn btn-secondary" type="reset">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Account information</h4>
                    <form class="forms-sample" method="POST" action="{{ route('auth.change.profile') }}" enctype="multipart/form-data">
                        @csrf
                        @if (session('successProfile'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('successProfile') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif(session('errorProfile'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('errorProfile') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputUsername1">Full name</label>
                            <input type="text" class="form-control" placeholder="Fullname" name="fullname"
                                value="{{ $user->fullName }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" placeholder="Email" name="email"
                                value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Role name</label>
                            <input type="text" class="form-control" value="{{ $user->role->role_name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Department name</label>
                            <input type="text" class="form-control" value="{{ $user->department->dept_name }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Avatar</label>
                            <input class="form-control" type="file" name="avatar" id="avatar"
                                onchange="previewImage(avatar, preview_avatar)" accept="image/*">
                            <img src="" id="preview_avatar" alt="" width="40%"
                                style="margin-top: 10px">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                        <button class="btn btn-secondary" type="reset">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // NOTE: Preview image before upload (id_card_front, id_card_back)
        function previewImage(input, preview) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(preview).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
