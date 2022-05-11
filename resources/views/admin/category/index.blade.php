@extends('layouts.backend.app')
@section('title', 'Category')

@section('content')
    <div class="content-header">

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
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control rounded-0" id="title">
                                </div>
                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" class="form-control rounded-0" id="slug">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control rounded-0" rows="5" id="description"></textarea>
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
                <form action="" method="" autocomplete="off">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="edit_id">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control rounded-0" id="edit_title" name="edit_title">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control rounded-0" id="edit_description" name="edit_description" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm rounded-0" data-dismiss="modal">Close</button>
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
                    name: 'description'
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
                    Swal.fire({
                        title: 'Oops...!',
                        text: 'Something went wrong!',
                        icon: 'error',
                        timer: '1500'
                    })
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

    </script>

@endsection
