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
                    
                }
            })
        })

    </script>

@endsection
