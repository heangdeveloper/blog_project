@extends('layouts.backend.app')
@section('title', 'Add User')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add New User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <form method="POST" action="{{ route('admin.user.store') }}" enctype="multipart/form-data" autocomplete="off">
                                        @csrf
                                        <div class="form-group required">
                                            <label>Username</label>
                                            <input type="text" class="form-control rounded-0" name="username">
                                        </div>
                                        <div class="form-group required">
                                            <label>Display Name</label>
                                            <input type="text" class="form-control rounded-0" name="name">
                                        </div>
                                        <div class="form-group required">
                                            <label>Email</label>
                                            <input type="email" class="form-control rounded-0" name="email">
                                        </div>
                                        <div class="form-group required">
                                            <label>Password</label>
                                            <input type="password" class="form-control rounded-0" name="password">
                                        </div>
                                        <div class="form-group">
                                            <label>Role</label>
                                            <select class="form-control rounded-0" name="role">
                                                @foreach ($role as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group required">
                                            <label>Profile Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="profile_photo_path">
                                                <label class="custom-file-label rounded-0">Choose Image file</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm rounded-0">Add New User</button>
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

@section('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>
@endsection