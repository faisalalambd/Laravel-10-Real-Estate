<?php

namespace App\Http\Controllers\Backend;

use App\Models\BlogPost;
use App\Models\BlogComment;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    // #################### Blog Category All Functions ####################
    public function AllBlogCategory()
    {
        $blog_category = BlogCategory::latest()->get();
        return view('backend.blogCategory.all_blog_category', compact('blog_category'));
    } // End Method

    public function StoreBlogCategory(Request $request)
    {
        BlogCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        $notification = [
            'message' => 'Blog Category Created Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.blog.category')->with($notification);
    } // End Method

    public function EditBlogCategory($id)
    {
        $blog_categories = BlogCategory::findOrFail($id);
        return response()->json($blog_categories);
    } // End Method

    public function UpdateBlogCategory(Request $request)
    {
        $blog_category_id = $request->blog_category_id;

        BlogCategory::findOrFail($blog_category_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        $notification = [
            'message' => 'Blog Category Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.blog.category')->with($notification);
    } // End Method

    public function DeleteBlogCategory($id)
    {
        BlogCategory::findOrFail($id)->delete();

        $notification = [
            'message' => 'Blog Category Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    // #################### Blog Post All Functions ####################
    public function AllBlogPost()
    {
        $blog_post = BlogPost::latest()->get();
        return view('backend.blogPost.all_blog_post', compact('blog_post'));
    } // End Method

    public function AddBlogPost()
    {
        $blog_category = BlogCategory::latest()->get();

        return view('backend.blogPost.add_blog_post', compact('blog_category'));
    } // End Method

    public function StoreBlogPost(Request $request)
    {
        $blog_post_image = $request->file('post_image');

        $manager = new ImageManager(new Driver());
        $name_gen = hexdec(uniqid()) . '.' . $blog_post_image->getClientOriginalExtension();
        $image = $manager->read($blog_post_image);
        $image->resize(770, 520);
        $image->toJpeg(80)->save(base_path('public/upload/blog_post/' . $name_gen));
        $save_url = 'upload/blog_post/' . $name_gen;

        BlogPost::insert([
            'blog_category_id' => $request->blog_category_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'post_tags' => $request->post_tags,
            'post_image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Blog Post Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.blog.post')->with($notification);
    } // End Method

    public function EditBlogPost($id)
    {
        $blog_category = BlogCategory::latest()->get();

        $blog_post = BlogPost::findOrFail($id);

        return view('backend.blogPost.edit_blog_post', compact('blog_post', 'blog_category'));
    } // End Method

    public function UpdateBlogPost(Request $request)
    {
        $blog_post_id = $request->id;

        $blog_post_image = $request->file('post_image');

        if ($blog_post_image) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $blog_post_image->getClientOriginalExtension();
            $image = $manager->read($blog_post_image);
            $image->resize(770, 520);
            $image->toJpeg(80)->save(base_path('public/upload/blog_post/' . $name_gen));
            $save_url = 'upload/blog_post/' . $name_gen;

            // Delete existing image if it exists
            $existing_image = BlogPost::findOrFail($blog_post_id);
            if ($existing_image->post_image) {
                if (file_exists(public_path($existing_image->post_image))) {
                    unlink(public_path($existing_image->post_image));
                }
            }

            BlogPost::findOrFail($blog_post_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'post_tags' => $request->post_tags,
                'post_image' => $save_url,
                'created_at' => Carbon::now(),
            ]);

            $notification = [
                'message' => 'Blog Post Updated with Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.blog.post')->with($notification);
        } else {
            BlogPost::findOrFail($blog_post_id)->update([
                'blog_category_id' => $request->blog_category_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ', '-', $request->post_title)),
                'short_description' => $request->short_description,
                'long_description' => $request->long_description,
                'post_tags' => $request->post_tags,
                'created_at' => Carbon::now(),
            ]);

            $notification = [
                'message' => 'Blog Post Updated without Image Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('all.blog.post')->with($notification);
        }
    } // End Method

    public function DeleteBlogPost($id)
    {
        $blog_post = BlogPost::findOrFail($id);

        $blog_post_image = $blog_post->post_image;
        unlink($blog_post_image);

        BlogPost::findOrFail($id)->delete();

        $notification = [
            'message' => 'Blog Post Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    // #################### Blog Details Frontend ####################

    public function BlogDetails($slug)
    {
        $blog_details = BlogPost::where('post_slug', $slug)->first();

        $post_tags = $blog_details->post_tags;
        $post_tags_all = explode(',', $post_tags);

        $blogCategory = BlogCategory::latest()->get();
        $blogPost = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_details', compact('blog_details', 'post_tags_all', 'blogCategory', 'blogPost'));
    } // End Method

    public function BlogCategoryList($id)
    {
        $blog = BlogPost::where('blog_category_id', $id)->paginate(6);

        $breadcrumb_category = BlogCategory::where('id', $id)->first();

        $blogCategory = BlogCategory::latest()->get();
        $blogPost = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_category_list', compact('blog', 'breadcrumb_category', 'blogCategory', 'blogPost'));
    } // End Method

    // #################### Blog List Frontend Header ####################

    public function BlogList()
    {
        $blog = BlogPost::latest()->paginate(6);

        $blogCategory = BlogCategory::latest()->get();
        $blogPost = BlogPost::latest()->limit(3)->get();

        return view('frontend.blog.blog_list', compact('blog', 'blogCategory', 'blogPost'));
    } // End Method

    // #################### Blog Comment Frontend ####################

    public function StoreBlogComment(Request $request)
    {
        $post_id = $request->blog_post_id;

        BlogComment::insert([
            'user_id' => Auth::user()->id,
            'blog_post_id' => $post_id,
            'parent_id' => null,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Blog Comment Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    } // End Method

    // #################### Blog Comment Backend ####################

    public function AdminBlogComment()
    {
        $blog_comment = BlogComment::where('parent_id', null)->latest()->get();

        return view('backend.blog_comment.all_blog_comment', compact('blog_comment'));
    } // End Method

    public function AdminBlogCommentReply($id)
    {
        $blog_comment = BlogComment::where('id', $id)->first();

        return view('backend.blog_comment.blog_comment_reply', compact('blog_comment'));
    } // End Method

    public function ReplyBlogMessage(Request $request)
    {
        $id = $request->id;
        $user_id = $request->user_id;
        $blog_post_id = $request->blog_post_id;

        BlogComment::insert([
            'user_id' => $user_id,
            'blog_post_id' => $blog_post_id,
            'parent_id' => $id,
            'subject' => $request->subject,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Blog Comment Reply Inserted Successfully',
            'alert-type' => 'success',
        ];

        // return redirect()->back()->with($notification);
        return redirect()->route('admin.blog.comment')->with($notification);
    } // End Method
}
