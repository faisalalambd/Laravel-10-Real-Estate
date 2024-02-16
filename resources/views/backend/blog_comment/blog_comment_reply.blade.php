@extends('admin.admin_dashboard')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    
    <div class="page-content">

        <div class="row">

            <div class="col-md-12 grid-margin stretch-card">

                <div class="card">

                    <div class="card-body">

                        <h6 class="card-title">Blog Comment</h6>

                        <div class="table-responsive pt-3">

                            <table class="table table-bordered">

                                <tbody>

                                    <tr>
                                        <th>User Name</th>
                                        <td><code>{{ $blog_comment['user']['name'] }}</code></td>
                                    </tr>

                                    <tr>
                                        <th>Blog Post Title</th>
                                        <td><code>{{ $blog_comment['blogPost']['post_title'] }}</code></td>
                                    </tr>

                                    <tr>
                                        <th>Subject</th>
                                        <td><code>{{ $blog_comment->subject }}</code></td>
                                    </tr>

                                    <tr>
                                        <th>Message</th>
                                        <td><code>{{ $blog_comment->message }}</code></td>
                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                    <hr>

                    <div class="card-body">

                        <h6 class="card-title mb-4">Blog Comment Reply</h6>

                        <form id="myForm" method="POST" action="{{ route('reply.blog.message') }}" class="forms-sample">
                            @csrf

                            <input type="hidden" name="id" value="{{ $blog_comment->id }}">
                            <input type="hidden" name="user_id" value="{{ $blog_comment->user_id }}">
                            <input type="hidden" name="blog_post_id" value="{{ $blog_comment->blog_post_id }}">

                            <div class="form-group mb-3">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="3"></textarea>
                            </div>

                            <button type="submit" class="btn btn-outline-primary me-2">Reply Comment</button>

                        </form>

                    </div>

                </div>

            </div>

        </div>


    </div>
@endsection
