<?php
use App\Http\Controllers\Api\ProgramsController;
use App\Http\Controllers\Api\RegisteredStudentsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\StudentsController;
use App\Http\Controllers\Api\SubclassController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\CatagoryController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\AboutusController;
use App\Http\Controllers\Api\MainTitleController;
use App\Http\Controllers\Api\WhyController;
use App\Http\Controllers\Api\ContactusController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BlogsController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\InvoiceController;
use App\Mail\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('', function(){
    return 'weee';

});

//Order
Route::get('Order', [OrderController::class, 'index'])->name('RegisteredStudent.index');
Route::get('OrderStatus', [OrderController::class, 'index1'])->name('RegisteredStudent.index');
Route::get('search/{program}', [OrderController::class, 'search']);
Route::get('Order/{program}', [OrderController::class, 'show']);
Route::post('Order', [OrderController::class, 'store']);
Route::put('/Order/{program}', [OrderController::class, 'update']);
Route::delete('/Order/{program}', [OrderController::class, 'destroy']);


//Product

Route::get('Product', [ProductController::class, 'index'])->name('RegisteredStudent.index');
Route::get('search/{program}', [ProductController::class, 'search']);
Route::get('Product/{program}', [ProductController::class, 'show']);
Route::post('Product', [ProductController::class, 'store']);
Route::put('/Product/{program}', [ProductController::class, 'update']);
Route::delete('/Product/{program}', [ProductController::class, 'destroy']);



//RegisteredStudent

Route::get('RegisteredStudents', [RegisteredStudentsController::class, 'index'])->name('RegisteredStudent.index');
Route::get('searchById/{program}', [RegisteredStudentsController::class, 'searchById']);
Route::get('searchByName/{program}', [RegisteredStudentsController::class, 'searchByName']);
Route::get('RegisteredStudents/{program}', [RegisteredStudentsController::class, 'show']);
Route::get('NumReg', [RegisteredStudentsController::class, 'index2']);
Route::post('RegisteredStudents', [RegisteredStudentsController::class, 'store']);
Route::put('/RegisteredStudents/{program}', [RegisteredStudentsController::class, 'update']);
Route::put('/verify/{program}', [RegisteredStudentsController::class, 'verify']);
Route::put('/verify2/{program}', [RegisteredStudentsController::class, 'verify2']);
Route::delete('/RegisteredStudents/{program}', [RegisteredStudentsController::class, 'destroy']);
Route::get('/PendingPayment', [RegisteredStudentsController::class, 'Unpaid']);


//Gallerys

Route::get('Gallerys', [GalleryController::class, 'index']);
Route::get('Gallerys/{program}', [GalleryController::class, 'show']);
Route::post('Gallerys', [GalleryController::class, 'store']);
Route::put('Gallerys/{program}', [GalleryController::class, 'update']);
Route::delete('Gallerys/{program}', [GalleryController::class, 'destroy']);


//Blogs

Route::get('Blogs', [BlogsController::class, 'index'])->name('Blogs.index');
Route::get('Blogs/{program}', [BlogsController::class, 'show'])->name('Blogs.show');
Route::post('Blogs', [BlogsController::class, 'store']);
Route::put('/Blogs/{program}', [BlogsController::class, 'update']);
Route::delete('/Blogs/{program}', [BlogsController::class, 'destroy']);


//Events

Route::get('Events', [EventsController::class, 'index'])->name('Events.index');
Route::get('Events/{program}', [EventsController::class, 'show'])->name('Events.show');
Route::post('Events', [EventsController::class, 'store']);
Route::put('Events/{program}', [EventsController::class, 'update']);
Route::delete('/Events/{program}', [EventsController::class, 'destroy']);


//Messages

Route::get('Messages', [MessageController::class, 'index'])->name('Messages.index');
Route::get('Messages/{program}', [MessageController::class, 'show'])->name('Messages.show');
Route::post('Messages', [MessageController::class, 'store']);
Route::put('/Messages/{program}', [MessageController::class, 'update']);
Route::delete('/Messages/{program}', [MessageController::class, 'destroy']);

//Services

Route::get('Services', [ServicesController::class, 'index'])->name('Services.index');
Route::get('Services/{program}', [ServicesController::class, 'show'])->name('Services.show');
Route::post('Services', [ServicesController::class, 'store']);
Route::put('/Services/{program}', [ServicesController::class, 'update']);
Route::delete('/Services/{program}', [ServicesController::class, 'destroy']);


//Staff

Route::get('Staff', [StaffController::class, 'index'])->name('Staff.index');
Route::get('Staff/{program}', [StaffController::class, 'show'])->name('Staff.show');
Route::post('Staff', [StaffController::class, 'store']);
Route::put('/Staff/{program}', [StaffController::class, 'update']);
Route::delete('/Staff/{program}', [StaffController::class, 'destroy']);


//Students

Route::get('Students', [StudentsController::class, 'index'])->name('Students.index');
Route::get('Students/{program}', [StudentsController::class, 'show'])->name('Students.show');
Route::get('showbyid/{program}', [StudentsController::class, 'showbyid'])->name('Students.show');
Route::get('showbyname/{program}', [StudentsController::class, 'showbyname'])->name('Students.show');
Route::post('Students', [StudentsController::class, 'store']);
Route::put('/Students/{program}', [StudentsController::class, 'update']);
Route::delete('/Students/{program}', [StudentsController::class, 'destroy']);


//Programs

Route::get('programs', [ProgramsController::class, 'index'])->name('programs.index');
Route::get('programs/{program}', [ProgramsController::class, 'show'])->name('programs.show');
Route::post('programs', [ProgramsController::class, 'store']);
Route::put('/programs/{program}', [ProgramsController::class, 'update']);
Route::delete('/programs/{program}', [ProgramsController::class, 'destroy']);

//Subclass

Route::get('Subclass', [SubclassController::class, 'index'])->name('Subclass.index');
Route::get('Subclass/{program}', [SubclassController::class, 'show'])->name('Subclass.show');
Route::post('Subclass', [SubclassController::class, 'store']);
Route::put('/Subclass/{program}', [SubclassController::class, 'update']);
Route::delete('/Subclass/{program}', [SubclassController::class, 'destroy']);

//Catagory

Route::get('Catagory', [CatagoryController::class, 'index'])->name('Catagory.index');
Route::get('Catagory/{program}', [CatagoryController::class, 'show'])->name('Catagory.show');
Route::post('Catagory', [CatagoryController::class, 'store']);
Route::put('/Catagory/{program}', [CatagoryController::class, 'update']);
Route::delete('/Catagory/{program}', [CatagoryController::class, 'destroy']);

//Testimonial

Route::get('Testimonial', [TestimonialController::class, 'index'])->name('Testimonial.index');
Route::get('Testimonial/{program}', [TestimonialController::class, 'show'])->name('Testimonial.show');
Route::post('Testimonial', [TestimonialController::class, 'store']);
Route::put('/Testimonial/{program}', [TestimonialController::class, 'update']);
Route::delete('/Testimonial/{program}', [TestimonialController::class, 'destroy']);
//AboutUs

Route::get('aboutus', [AboutusController::class, 'index'])->name('Aboutus.index');
Route::put('/aboutus/1', [AboutusController::class, 'update']);

//MainTitle

Route::get('mainTitle', [MainTitleController::class, 'index'])->name('MainTitle.index');
Route::put('/mainTitle/1', [MainTitleController::class, 'update']);

//Partners

Route::get('Partner', [PartnerController::class, 'index'])->name('Why.index');
Route::post('Partner', [PartnerController::class, 'store']);
Route::delete('/partner/1', [PartnerController::class, 'destroy']);
//Whys

Route::get('why', [WhyController::class, 'index'])->name('Why.index');
Route::put('/why/1', [WhyController::class, 'update']);

//Contactus

Route::get('contactus', [ContactusController::class, 'index'])->name('Contactus.index');
Route::put('/contactus/1', [ContactusController::class, 'update']);

//User

Route::post('/auth/register', [UserController::class, 'createUser']);
Route::post('/auth/login', [UserController::class, 'loginUser']);

//Payment

Route::post('checkout', [PaymentController::class, 'createCheckoutSession']);

//Invoices

Route::get('/invoices', [InvoiceController::class, 'index']);
Route::post('/invoices', [InvoiceController::class, 'store']);
Route::get('/invoices/{id}', [InvoiceController::class, 'show']);
Route::put('/invoices/{id}', [InvoiceController::class, 'update']);
Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy']);