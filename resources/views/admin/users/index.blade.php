@extends('layouts.backend.app')
@section('title', 'User')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
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
                        <div class="card-header">
                            <h4 class="card-title">List User</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-head-fixed text-nowrap" id="user_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="edit_user">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" autocomplete="off">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control rounded-0" id="edit_uname" name="edit_uname">
                        </div>
                        <div class="form-group">
                            <label>Display Name</label>
                            <input type="text" class="form-control rounded-0" id="edit_dname" name="edit_dname">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control rounded-0" id="edit_email" name="edit_email">
                        </div>
                        <div class="form-group clearfix">
                            <label>Role</label>
                            <select class="form-control rounded-0" id="edit_role" name="edit_role">
                                <option value="">Choose Role</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection