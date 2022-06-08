@extends('layouts.backend.app')
@section('title', 'Category')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add New Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" autocomplete="off" id="add_category">
                                @csrf
                                <div class="form-group required">
                                    <label>Name</label>
                                    <input type="text" class="form-control rounded-0" id="title">
                                    <p class="help-block">The name is how it appears on your site.</p>
                                    <span id="title_message"></span>
                                </div>
                                <div class="form-group">
                                    <label>Slug (URL)</label>
                                    <input type="text" class="form-control rounded-0" id="slug">
                                    <p class="help-block">Will be automatically generated from your name, if left empty.</p>
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control rounded-0" rows="5" id="description"></textarea>
                                    <p class="help-block">The description is not prominent by default.</p>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm rounded-0">Add New Category</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">List Category</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-head-fixed text-nowrap" id="category_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
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

    <div class="modal fade" id="edit_category">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" autocomplete="off">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control rounded-0" id="edit_title" name="edit_title">
                            <p class="help-block">The name is how it appears on your site.</p>
                            <span id="title_message"></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control rounded-0" id="edit_description" rows="5" name="edit_description"></textarea>
                            <p class="help-block">The description is not prominent by default.</p>
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

@section('script')

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // get category
        var table = $('#category_table').DataTable({
            responsive: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('admin.category.index') }}",
                type: 'GET'
            },
            columns: [
                {
                    data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'slug',
                    data: 'slug'
                },
                {
					data: 'description',
					name: 'description',
					render: function(data, type, full, meta) {
						if (data == null) {
							return "<span>&#8212;</span>";
						} else {
							return data;
						}		
					},
				},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        })

        // add category
        $('form#add_category').on('submit', function(e) {
            e.preventDefault();
            var title = $('#title').val();
            var description = $('#description').val();
            $.ajax({
                url: "{{ url('admin/category') }}",
                type: "POST",
                data: {
                    title: title,
                    description: description
                },
                success: function(data) {
                    //console.log(data)
                    table.ajax.reload();
                    $('form#add_category')[0].reset();
                    Swal.fire({
                        title: 'Success!',
                        text: 'Your data has been inserted!',
                        icon: 'success',
                        timer: '1500'
                    })
                },
                error: function(err) {
                    //console.log(err)
                    if (err.status == 422) {
                        //console.log(err.responseJSON)
                        $('#title').addClass('is-invalid')

                        $.each(err.responseJSON.errors, function (i, error) {
                            var el = $(document).find('[id="' + i + '"]')
                            el.after($('<span class="error invalid-feedback"><strong>' + error[0] + '</strong></span>'))
                        })
                    }
                }
            })
        })

        // delete category
        function deleteData(id) {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('admin/category') }}" + '/' + id,
                        type: 'POST',
                        data: {
                                '_method': 'DELETE',
                                '_token': csrf_token
                            },
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire({
                                title: 'Success!',
                                text: 'Your data has been deleted!',
                                icon: 'success',
                                timer: '1500'
                            })
                        },
                        error: function(err) {
                            Swal.fire({
                                title: 'Oops...!',
                                text: 'Something went wrong!',
                                icon: 'error',
                                timer: '1500'
                            })
                        }
                    })
                }
            })
        }

        // edit category
        function editData(id) {
            $('#edit_category form')[0].reset();
            $('input[name=_method]').val('PATCH');
            $.ajax({
                url: "{{ url('admin/category') }}" + "/" + id + "/edit",
                type: 'GET',
                success: function(data) {
                    $('#edit_category').modal('show');
                    $('#edit_id').val(data.id);
                    $('#edit_title').val(data.title);
                    $('#edit_description').val(data.description);
                }
            })        
        }

        // update category
        $(function() {
            $('#edit_category form').on('submit', function(e) {
                if (!e.isDefaultPrevented()) {
                    var id = $('#edit_id').val();
                    $.ajax({
                        url: "{{ url('admin/category') }}" + '/' + id,
                        type: "POST",
                        data: $('#edit_category form').serialize(),
                        success: function(data) {
                            console.log(data)
                            $('#edit_category').modal('hide');
                            table.ajax.reload();
                            swal.fire({
                                icon: 'success',
                                title: 'Success...',
                                text: 'Data has been add!',
                                timer: 1500
                            });
                        },
                        error: function(data) {
                            console.log(data)
                            swal.fire({
                                title: 'Oops...',
                                text: "Something went wrong!",
                                type: "error"
                            })
                        }
                    });
                }
                return false;
            });
        });

    </script>

@endsection
