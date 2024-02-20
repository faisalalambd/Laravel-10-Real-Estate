@extends('admin.admin_dashboard')
@section('admin')

@section('admin_title')
    All Blog Comment
@endsection


<div class="page-content">

    <nav class="page-breadcrumb">

        <div class="row">

            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#!">Table</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Blog Comment</li>
                </ol>
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
                                    <th>Blog Post Title</th>
                                    <th>User Name</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($blog_comment as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item['blogPost']['post_title'] }}</td>
                                        <td>{{ $item['user']['name'] }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>
                                            <a href="{{ route('admin.blog.comment.reply', $item->id) }}"
                                                class="btn btn-outline-light" title="Reply">
                                                Reply
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


@endsection
