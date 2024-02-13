@extends('admin.admin_dashboard')
@section('admin')
    <div class="page-content">

        <nav class="page-breadcrumb">

            <div class="row">

                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#!">Table</a></li>
                        <li class="breadcrumb-item active" aria-current="page">All Blog Category</li>
                    </ol>
                </div>

                <div class="col-md-6" style="text-align: right;">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal"
                        data-bs-target="#addBlogCategoryModal">
                        Add Blog Category
                    </button>
                </div>

            </div>

        </nav>

        <div class="row">

            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">

                    <div class="card-body">

                        <div class="table-responsive">

                            <table id="dataTableExample" class="table">

                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Blog Category Name</th>
                                        <th>Blog Category Slug</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($blog_category as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->category_name }}</td>
                                            <td>{{ $item->category_slug }}</td>
                                            <td>

                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-outline-warning"
                                                    data-bs-toggle="modal" data-bs-target="#editBlogCategoryModal"
                                                    title="Edit" id="{{ $item->id }}" onclick="blogCategoryEdit(this.id)">
                                                    <i data-feather="edit"></i>
                                                </button>

                                                <a href="{{ route('delete.blog.category', $item->id) }}"
                                                    class="btn btn-outline-danger" id="delete" title="Delete">
                                                    <i data-feather="trash-2"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Add Blog Category Modal -->
    <div class="modal fade" id="addBlogCategoryModal" tabindex="-1" aria-labelledby="addBlogCategoryModalLabel"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="addBlogCategoryModalLabel">Add Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>


                <form id="myForm" method="POST" action="{{ route('store.blog.category') }}" class="forms-sample">
                    @csrf

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label class="form-label">Blog Category</label>
                            <input type="text" name="category_name" class="form-control">
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary me-2">Save changes</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Edit Blog Category Modal -->
    <div class="modal fade" id="editBlogCategoryModal" tabindex="-1" aria-labelledby="editBlogCategoryModalLabel"
        aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editBlogCategoryModalLabel">Edit Blog Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>


                <form id="myForm" method="POST" action="{{ route('update.blog.category') }}" class="forms-sample">

                    @csrf

                    <input type="hidden" name="blog_category_id" id="blog_category_id">

                    <div class="modal-body">

                        <div class="form-group mb-3">
                            <label class="form-label">Blog Category</label>
                            <input type="text" name="category_name" class="form-control" id="blog_category_name">
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="submit" class="btn btn-outline-primary me-2">Update changes</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        function blogCategoryEdit(id) {
            $.ajax({
                type: 'GET',
                url: '/edit/blog/category/' + id,
                dataType: 'json',
                success: function(data) {
                    // console.log(data)
                    $('#blog_category_name').val(data.category_name);
                    $('#blog_category_id').val(data.id);
                }
            })
        }
    </script>
@endsection
