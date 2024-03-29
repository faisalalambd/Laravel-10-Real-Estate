<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RedirectIfAuthenticated;

use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\Backend\AmenitiesController;
use App\Http\Controllers\Backend\PropertyController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ContactUsController;
use App\Http\Controllers\Backend\OurServicesController;
use App\Http\Controllers\Backend\OurPartnersController;
use App\Http\Controllers\Backend\AboutUsController;

use App\Http\Controllers\Agent\AgentPropertyController;

use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\CompareController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// User Frontend All Route
Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // User All Routes
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/profile', 'UserProfile')->name('user.profile');
        Route::post('/user/profile/store', 'UserProfileStore')->name('user.profile.store');
        Route::get('/user/logout', 'UserLogout')->name('user.logout');
        Route::get('/user/change/password', 'UserChangePassword')->name('user.change.password');
        Route::post('/user/password/update', 'UserPasswordUpdate')->name('user.password.update');
        Route::get('/user/schedule/request', 'UserScheduleRequest')->name('user.schedule.request');
    });

    // User Wishlist All Route
    Route::controller(WishlistController::class)->group(function () {
        Route::get('/user/wishlist', 'UserWishlist')->name('user.wishlist');
        Route::get('/get-wishlist-property', 'GetWishlistProperty');
        Route::get('/wishlist-remove/{id}', 'WishlistRemove');
    });

    // User Compare All Route
    Route::controller(CompareController::class)->group(function () {
        Route::get('/user/compare', 'UserCompare')->name('user.compare');
        Route::get('/get-compare-property', 'GetCompareProperty');
        Route::get('/compare-remove/{id}', 'CompareRemove');
    });
});

require __DIR__ . '/auth.php';

// Admin Group Middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Admin All Routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'AdminDashboard')->name('admin.dashboard');
        Route::get('/admin/logout', 'AdminLogout')->name('admin.logout');
        Route::get('/admin/profile', 'AdminProfile')->name('admin.profile');
        Route::post('/admin/profile/store', 'AdminProfileStore')->name('admin.profile.store');
        Route::get('/admin/change/password', 'AdminChangePassword')->name('admin.change.password');
        Route::post('/admin/update/password', 'AdminUpdatePassword')->name('admin.update.password');

        // Agent All Route from admin
        Route::get('/all/agent', 'AllAgent')->name('all.agent');
        Route::get('/add/agent', 'AddAgent')->name('add.agent');
        Route::post('/store/agent', 'StoreAgent')->name('store.agent');
        Route::get('/edit/agent/{id}', 'EditAgent')->name('edit.agent');
        Route::post('/update/agent', 'UpdateAgent')->name('update.agent');
        Route::get('/delete/agent/{id}', 'DeleteAgent')->name('delete.agent');
        Route::get('/changeStatus', 'changeStatus');
    });

    // Property Type All Routes
    Route::controller(PropertyTypeController::class)->group(function () {
        Route::get('/all/propertyType', 'AllPropertyType')->name('all.propertyType');
        Route::get('/add/propertyType', 'AddPropertyType')->name('add.propertyType');
        Route::post('/store/propertyType', 'StorePropertyType')->name('store.propertyType');
        Route::get('/edit/propertyType/{id}', 'EditPropertyType')->name('edit.propertyType');
        Route::post('/update/propertyType', 'UpdatePropertyType')->name('update.propertyType');
        Route::get('/delete/propertyType/{id}', 'DeletePropertyType')->name('delete.propertyType');
    });

    // Amenities All Routes
    Route::controller(AmenitiesController::class)->group(function () {
        Route::get('/all/amenities', 'AllAmenities')->name('all.amenities');
        Route::get('/add/amenity', 'AddAmenity')->name('add.amenity');
        Route::post('/store/amenity', 'StoreAmenity')->name('store.amenity');
        Route::get('/edit/amenity/{id}', 'EditAmenity')->name('edit.amenity');
        Route::post('/update/amenity', 'UpdateAmenity')->name('update.amenity');
        Route::get('/delete/amenity/{id}', 'DeleteAmenity')->name('delete.amenity');
    });

    // Property All Routes
    Route::controller(PropertyController::class)->group(function () {
        Route::get('/all/property', 'AllProperty')->name('all.property');
        Route::get('/add/property', 'AddProperty')->name('add.property');
        Route::post('/store/property', 'StoreProperty')->name('store.property');
        Route::get('/edit/property/{id}', 'EditProperty')->name('edit.property');
        Route::post('/update/property', 'UpdateProperty')->name('update.property');
        Route::post('/update/property/thumbnail', 'UpdatePropertyThumbnail')->name('update.property.thumbnail');
        Route::post('/update/property/multiImage', 'UpdatePropertyMultiImage')->name('update.property.multiImage');
        Route::get('/delete/property/multiImage/{id}', 'DeletePropertyMultiImage')->name('delete.property.multiImage');
        Route::post('/store/property/multiImage', 'StorePropertyMultiImage')->name('store.property.multiImage');
        Route::post('/update/property/facilities', 'UpdatePropertyFacilities')->name('update.property.facilities');
        Route::get('/delete/property/{id}', 'DeleteProperty')->name('delete.property');
        Route::get('/details/property/{id}', 'DetailsProperty')->name('details.property');
        Route::post('/inactive/property', 'InactiveProperty')->name('inactive.property');
        Route::post('/active/property', 'ActiveProperty')->name('active.property');
        Route::get('/admin/package/history', 'AdminPackageHistory')->name('admin.package.history');
        Route::get('/package/invoice/{id}', 'PackageInvoice')->name('package.invoice');

        // Admin Property Message
        Route::get('/admin/property/message/', 'AdminPropertyMessage')->name('admin.property.message');
        Route::get('/admin/message/details/{id}', 'AdminMessageDetails')->name('admin.message.details');
    });

    // State All Routes
    Route::controller(StateController::class)->group(function () {
        Route::get('/all/state', 'AllState')->name('all.state');
        Route::get('/add/state', 'AddState')->name('add.state');
        Route::post('/store/state', 'StoreState')->name('store.state');
        Route::get('/edit/state/{id}', 'EditState')->name('edit.state');
        Route::post('/update/state', 'UpdateState')->name('update.state');
        Route::get('/delete/state/{id}', 'DeleteState')->name('delete.state');
    });

    // Testimonials All Routes
    Route::controller(TestimonialController::class)->group(function () {
        Route::get('/all/testimonial', 'AllTestimonial')->name('all.testimonial');
        Route::get('/add/testimonial', 'AddTestimonial')->name('add.testimonial');
        Route::post('/store/testimonial', 'StoreTestimonial')->name('store.testimonial');
        Route::get('/edit/testimonial/{id}', 'EditTestimonial')->name('edit.testimonial');
        Route::post('/update/testimonial', 'UpdateTestimonial')->name('update.testimonial');
        Route::get('/delete/testimonial/{id}', 'DeleteTestimonial')->name('delete.testimonial');
    });

    // Blog Controller All Routes
    Route::controller(BlogController::class)->group(function () {
        // Blog Category All Routes
        Route::get('/all/blog/category', 'AllBlogCategory')->name('all.blog.category');
        Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');
        Route::get('/edit/blog/category/{id}', 'EditBlogCategory');
        Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');

        // Blog Post All Routes
        Route::get('/all/blog/post', 'AllBlogPost')->name('all.blog.post');
        Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post');

        // Blog Comment All Routes
        Route::get('/admin/blog/comment', 'AdminBlogComment')->name('admin.blog.comment');
        Route::get('/admin/blog/comment/reply/{id}', 'AdminBlogCommentReply')->name('admin.blog.comment.reply');
        Route::post('/reply/blog/message', 'ReplyBlogMessage')->name('reply.blog.message');
    });

    // Setting All Routes
    Route::controller(SettingController::class)->group(function () {
        // SMTP Setting All Routes
        Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');
        Route::post('/update/smtp/setting', 'UpdateSmtpSetting')->name('update.smtp.setting');

        // Site Setting All Routes
        Route::get('/site/setting', 'SiteSetting')->name('site.setting');
        Route::post('/update/site/setting', 'UpdateSiteSetting')->name('update.site.setting');
    });

    // Contact Us Message All Routes
    Route::controller(ContactUsController::class)->group(function () {
        Route::get('/contact/us/message', 'ContactUsMessage')->name('contact.us.message');
        Route::get('/delete/contact/us/message/{id}', 'DeleteContactUsMessage')->name('delete.contact.us.message');
    });

    // Our Services All Routes
    Route::controller(OurServicesController::class)->group(function () {
        Route::get('/all/our/services', 'AllOurServices')->name('all.our.services');
        Route::get('/add/our/service', 'AddOurService')->name('add.our.service');
        Route::post('/store/our/service', 'StoreOurService')->name('store.our.service');
        Route::get('/edit/our/service/{id}', 'EditOurService')->name('edit.our.service');
        Route::post('/update/our/service', 'UpdateOurService')->name('update.our.service');
        Route::get('/delete/our/service/{id}', 'DeleteOurService')->name('delete.our.service');
    });

    // Our Partners All Routes
    Route::controller(OurPartnersController::class)->group(function () {
        Route::get('/all/our/partners', 'AllOurPartners')->name('all.our.partners');
        Route::get('/add/our/partner', 'AddOurPartner')->name('add.our.partner');
        Route::post('/store/our/partner', 'StoreOurPartner')->name('store.our.partner');
        Route::get('/edit/our/partner/{id}', 'EditOurPartner')->name('edit.our.partner');
        Route::post('/update/our/partner', 'UpdateOurPartner')->name('update.our.partner');
        Route::get('/delete/our/partner/{id}', 'DeleteOurPartner')->name('delete.our.partner');
    });

    // About Us All Routes
    Route::controller(AboutUsController::class)->group(function () {
        Route::get('/all/about/us', 'AllAboutUs')->name('all.about.us');
        Route::get('/edit/about/us/{id}', 'EditAboutUs')->name('edit.about.us');
        Route::post('/update/about/us', 'UpdateAboutUs')->name('update.about.us');
    });
}); // End Admin Group Middleware

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])
    ->name('admin.login')
    ->middleware(RedirectIfAuthenticated::class);

// Agent Group Middleware
Route::middleware(['auth', 'role:agent'])->group(function () {
    // Agent All Routes
    Route::controller(AgentController::class)->group(function () {
        Route::get('/agent/dashboard', 'AgentDashboard')->name('agent.dashboard');
        Route::get('/agent/logout', 'AgentLogout')->name('agent.logout');
        Route::get('/agent/profile', 'AgentProfile')->name('agent.profile');
        Route::post('/agent/profile/store', 'AgentProfileStore')->name('agent.profile.store');
        Route::get('/agent/change/password', 'AgentChangePassword')->name('agent.change.password');
        Route::post('/agent/update/password', 'AgentUpdatePassword')->name('agent.update.password');
    });

    // Agent Property All Routes
    Route::controller(AgentPropertyController::class)->group(function () {
        Route::get('/agent/all/property', 'AgentAllProperty')->name('agent.all.property');
        Route::get('/agent/add/property', 'AgentAddProperty')->name('agent.add.property');
        Route::post('/agent/store/property', 'AgentStoreProperty')->name('agent.store.property');
        Route::get('/agent/edit/property/{id}', 'AgentEditProperty')->name('agent.edit.property');
        Route::post('/agent/update/property', 'AgentUpdateProperty')->name('agent.update.property');
        Route::post('/agent/update/property/thumbnail', 'AgentUpdatePropertyThumbnail')->name('agent.update.property.thumbnail');
        Route::post('/agent/update/property/multiImage', 'AgentUpdatePropertyMultiImage')->name('agent.update.property.multiImage');
        Route::get('/agent/delete/property/multiImage/{id}', 'AgentDeletePropertyMultiImage')->name('agent.delete.property.multiImage');
        Route::post('/agent/store/property/multiImage', 'AgentStorePropertyMultiImage')->name('agent.store.property.multiImage');
        Route::post('/agent/update/property/facilities', 'AgentUpdatePropertyFacilities')->name('agent.update.property.facilities');
        Route::get('/agent/details/property/{id}', 'AgentDetailsProperty')->name('agent.details.property');
        Route::get('/agent/delete/property/{id}', 'AgentDeleteProperty')->name('agent.delete.property');

        // Agent Buy Package Route from admin
        Route::get('/buy/package', 'BuyPackage')->name('buy.package');
        Route::get('/buy/business/plan', 'BuyBusinessPlan')->name('buy.business.plan');
        Route::post('/store/business/plan', 'StoreBusinessPlan')->name('store.business.plan');
        Route::get('/buy/professional/plan', 'BuyProfessionalPlan')->name('buy.professional.plan');
        Route::post('/store/professional/plan', 'StoreProfessionalPlan')->name('store.professional.plan');
        Route::get('/package/history', 'PackageHistory')->name('package.history');
        Route::get('/agent/package/invoice/{id}', 'AgentPackageInvoice')->name('agent.package.invoice');

        // Agent Property Message
        Route::get('/agent/property/message/', 'AgentPropertyMessage')->name('agent.property.message');
        Route::get('/agent/message/details/{id}', 'AgentMessageDetails')->name('agent.message.details');

        // Schedule Request Route
        Route::get('/agent/schedule/request/', 'AgentScheduleRequest')->name('agent.schedule.request');
        Route::get('/agent/details/schedule/{id}', 'AgentDetailsSchedule')->name('agent.details.schedule');
        Route::post('/agent/update/schedule/', 'AgentUpdateSchedule')->name('agent.update.schedule');
    });
}); // End Agent Group Middleware

Route::get('/agent/login', [AgentController::class, 'AgentLogin'])
    ->name('agent.login')
    ->middleware(RedirectIfAuthenticated::class);

// Frontend All Routes
Route::controller(IndexController::class)->group(function () {
    // Frontend Property Details All Route
    Route::get('/property/details/{id}/{slug}', 'PropertyDetails');

    // Send Message from Property Details Page
    Route::post('/property/message', 'PropertyMessage')->name('property.message');

    // Agent Details Page
    Route::get('/agent/details/{id}', 'AgentDetails')->name('agent.details');

    // Send Message from Agent Details Page
    Route::post('/agent/details/message', 'AgentDetailsMessage')->name('agent.details.message');

    // Get All Rent Property
    Route::get('/rent/property', 'RentProperty')->name('rent.property');

    // Get All Buy Property
    Route::get('/buy/property', 'BuyProperty')->name('buy.property');

    // Get All Property Type Data
    Route::get('/property/type/{id}', 'PropertyType')->name('property.type');

    // Get State Details Data
    Route::get('/state/details/{id}', 'StateDetails')->name('state.details');

    // Home Page Buy Search Option
    Route::post('/buy/property/search', 'BuyPropertySearch')->name('buy.property.search');

    // Home Page Rent Search Option
    Route::post('/rent/property/search', 'RentPropertySearch')->name('rent.property.search');

    // All Property Search Option
    Route::post('/all/property/search', 'AllPropertySearch')->name('all.property.search');

    // Schedule Message Request
    Route::post('/store/tour/schedule', 'StoreTourSchedule')->name('store.tour.schedule');

    // Contact Us
    Route::get('/contact-us', 'ContactUs')->name('contact.us');
    Route::post('/store/contact/us/message', 'StoreContactUsMessage')->name('store.contact.us');

    // Property Types
    Route::get('/property/types', 'PropertyTypes')->name('property.types');

    // Our Services
    Route::get('/our/services', 'OurServices')->name('our.services');

    // About Us
    Route::get('/about-us', 'AboutUs')->name('about.us');

    // Properties
    Route::get('/properties', 'Properties')->name('properties');

    // Agents
    Route::get('/agents', 'Agents')->name('agents');

    // Agent Search
    Route::get('/search/agents', 'SearchAgents')->name('search.agents');

    // Blog Search
    Route::get('/search/blog', 'SearchBlog')->name('search.blog');
}); // End Frontend All Routes

// Frontend Blog All Routes
Route::controller(BlogController::class)->group(function () {
    Route::get('/blog/details/{slug}', 'BlogDetails');
    Route::get('/blog/category/list/{id}', 'BlogCategoryList');
    Route::get('/blog', 'BlogList')->name('blog.list');
    Route::post('/store/blog/comment', 'StoreBlogComment')->name('store.blog.comment');
});

// Frontend Agent Register
Route::post('/agent/register', [AgentController::class, 'AgentRegister'])->name('agent.register');

// Frontend Wishlist Add
Route::post('/add-to-wishList/{property_id}', [WishlistController::class, 'AddToWishList']);

// Frontend Compare Add
Route::post('/add-to-compare/{property_id}', [CompareController::class, 'AddToCompare']);
