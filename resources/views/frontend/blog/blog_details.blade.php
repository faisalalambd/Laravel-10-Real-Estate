@extends('frontend.frontend_dashboard')
@section('main')

@section('title')
    {{ $blog_details->post_title }}
@endsection


<!--Page Title-->
<section class="page-title-two bg-color-1 centred">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
        </div>
        <div class="pattern-2" style="background-image: url({{ asset('frontend/assets/images/shape/shape-9.png') }});">
        </div>
    </div>
    <div class="auto-container">
        <div class="content-box clearfix">
            <h1>{{ $blog_details->post_title }}</h1>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>{{ $blog_details->post_title }}</li>
            </ul>
        </div>
    </div>
</section>
<!--End Page Title-->


<!-- sidebar-page-container -->
<section class="sidebar-page-container blog-details sec-pad-2">

    <div class="auto-container">

        <div class="row clearfix">

            <div class="col-lg-8 col-md-12 col-sm-12 content-side">

                <div class="blog-details-content">

                    <div class="news-block-one">

                        <div class="inner-box">

                            <div class="image-box">

                                <figure class="image">
                                    <img src="{{ asset($blog_details->post_image) }}" alt="">
                                </figure>

                                <span class="category">New</span>

                            </div>


                            <div class="lower-content">

                                <h3>{{ $blog_details->post_title }}</h3>


                                <ul class="post-info clearfix">

                                    <li class="author-box">

                                        <figure class="author-thumb">
                                            <img src="{{ !empty($blog_details->user->photo) ? url('upload/admin_images/' . $blog_details->user->photo) : url('upload/no_image.jpg') }}"
                                                alt="">
                                        </figure>

                                        <h5><a href="">{{ $blog_details['user']['name'] }}</a></h5>
                                    </li>

                                    <li>{{ $blog_details->created_at->format('M d, Y') }}</li>

                                </ul>


                                <div class="text">
                                    <p>{!! $blog_details->long_description !!}</p>
                                </div>


                                <div class="post-tags">

                                    <ul class="tags-list clearfix">
                                        <li>
                                            <h5>Tags:</h5>
                                        </li>
                                        @foreach ($post_tags_all as $post_tag)
                                            <li><a href="">{{ ucwords($post_tag) }}</a></li>
                                        @endforeach
                                    </ul>

                                </div>

                            </div>

                        </div>

                    </div>


                    @php
                        $blogComment = App\Models\BlogComment::where('blog_post_id', $blog_details->id)
                            ->where('parent_id', null)
                            ->limit(5)
                            ->get();
                    @endphp

                    <div class="comments-area">

                        <div class="group-title">
                            <h4>3 Comments</h4>
                        </div>


                        <div class="comment-box">

                            @foreach ($blogComment as $comment)
                                <div class="comment">

                                    <figure class="thumb-box">
                                        <img src="{{ !empty($comment->user->photo) ? url('upload/user_images/' . $comment->user->photo) : url('upload/no_image.jpg') }}"
                                            alt="">
                                    </figure>

                                    <div class="comment-inner">

                                        <div class="comment-info clearfix">
                                            <h5>{{ $comment->user->name }}</h5>
                                            <span>{{ $comment->created_at->format('M d, Y') }}</span>
                                        </div>

                                        <div class="text">
                                            <h6>{{ $comment->subject }}</h6>
                                            <p>{{ $comment->message }}</p>
                                            <a href="blog-details.html"><i class="fas fa-share"></i>Reply</a>
                                        </div>
                                    </div>
                                </div>


                                @php
                                    $blogCommentReply = App\Models\BlogComment::where('parent_id', $comment->id)->get();
                                @endphp

                                @foreach ($blogCommentReply as $reply)
                                    <div class="comment replay-comment">

                                        <figure class="thumb-box">
                                            <img src="{{ url('upload/admin.png') }}" alt="">
                                        </figure>

                                        <div class="comment-inner">

                                            <div class="comment-info clearfix">
                                                <h5>{{ $reply->subject }}</h5>
                                                <span>{{ $reply->created_at->format('M d, Y') }}</span>
                                            </div>

                                            <div class="text">
                                                <p>{{ $reply->message }}</p>
                                                <a href="blog-details.html"><i class="fas fa-share"></i>Reply</a>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach
                            @endforeach

                        </div>

                    </div>


                    <div class="comments-form-area">

                        <div class="group-title">
                            <h4>Leave a Comment</h4>
                        </div>

                        @auth

                            <form action="{{ route('store.blog.comment') }}" method="post"
                                class="comment-form default-form">

                                @csrf

                                <input type="hidden" name="blog_post_id" value="{{ $blog_details->id }}">

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <input type="text" name="subject" placeholder="Subject" required="">
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <textarea name="message" placeholder="Your message"></textarea>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn btn-one">Submit Now</button>
                                    </div>

                                </div>

                            </form>
                        @else
                            <p>
                                <b>
                                    For Add Comment You need to login first <a href="{{ route('login') }}"> Login Here </a>
                                </b>
                            </p>
                        @endauth

                    </div>

                </div>

            </div>


            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">

                <div class="blog-sidebar">

                    <div class="sidebar-widget search-widget">
                        <div class="widget-title">
                            <h4>Search</h4>
                        </div>
                        <div class="search-inner">
                            <form action="blog-1.html" method="post">
                                <div class="form-group">
                                    <input type="search" name="search_field" placeholder="Search" required="">
                                    <button type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <div class="sidebar-widget social-widget">
                        <div class="widget-title">
                            <h4>Follow Us On</h4>
                        </div>
                        <ul class="social-links clearfix">
                            <li><a href="blog-1.html"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="blog-1.html"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="blog-1.html"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="blog-1.html"><i class="fab fa-linkedin-in"></i></a></li>
                            <li><a href="blog-1.html"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>


                    <div class="sidebar-widget category-widget">

                        <div class="widget-title">
                            <h4>Category</h4>
                        </div>

                        <div class="widget-content">

                            <ul class="category-list clearfix">
                                @foreach ($blogCategory as $category)
                                    @php
                                        $blog_post = App\Models\BlogPost::where('blog_category_id', $category->id)->get();
                                    @endphp

                                    <li>
                                        <a href="{{ url('blog/category/list/' . $category->id) }}">
                                            {{ $category->category_name }}
                                            <span>({{ count($blog_post) }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                    </div>


                    <div class="sidebar-widget post-widget">

                        <div class="widget-title">
                            <h4>Recent Posts</h4>
                        </div>


                        <div class="post-inner">

                            @foreach ($blogPost as $post)
                                <div class="post">

                                    <figure class="post-thumb">
                                        <a href="{{ url('blog/details/' . $post->post_slug) }}">
                                            <img src="{{ asset($post->post_image) }}" alt="">
                                        </a>
                                    </figure>

                                    <h5>
                                        <a href="{{ url('blog/details/' . $post->post_slug) }}">
                                            {{ $post->post_title }}
                                        </a>
                                    </h5>

                                    <span class="post-date">{{ $post->created_at->format('M d, Y') }}</span>

                                </div>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- sidebar-page-container -->


@endsection
