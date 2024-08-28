<?php


use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::get('/generate-qrcode', [App\Http\Controllers\QRCodeController::class, 'generateQRCode']);
Route::get('/download-qrcode', [App\Http\Controllers\QRCodeController::class, 'downloadQRCode'])->name('download-qrcode');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('guest.index');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('guest.login');
Route::get('/register', [App\Http\Controllers\Auth\LoginController::class, 'register'])->name('guest.register');
Route::post('/store', [App\Http\Controllers\Auth\LoginController::class, 'store'])->name('guest.store');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('guest.logout');

Route::prefix('/')->name('home.')->group(function(){
    Route::resources([
        'bookings' =>App\Http\Controllers\Home\BookingController::class,
        'booked' =>App\Http\Controllers\Home\BookedController::class,
        'history' =>App\Http\Controllers\Home\BookedHistoryController::class,
        'announcement' =>App\Http\Controllers\Home\AnnouncementController::class,
        'gallery' =>App\Http\Controllers\Home\GalleryController::class,
        'schedules' =>App\Http\Controllers\Home\SchedulesController::class,
        'location' =>App\Http\Controllers\Home\LocationController::class,
        'rating' =>App\Http\Controllers\Home\RatingsController::class,
        'gcash' =>App\Http\Controllers\Home\GcashController::class,
        'message' =>App\Http\Controllers\Home\MessageController::class,
        'contact' =>App\Http\Controllers\Home\ContactController::class,
    ]);
    Route::post('/rating.done', [App\Http\Controllers\Home\RatingsController::class,'done'])->name('rating.done');
    Route::patch('/bookings.done/{book}', [App\Http\Controllers\Home\BookingController::class, 'done'])->name('bookings.done');
    Route::get('/bookings.list', [App\Http\Controllers\Home\BookingController::class, 'list'])->name('bookings.list');
    Route::get('/rating.list', [App\Http\Controllers\Home\RatingsController::class, 'list'])->name('rating.list');
    Route::get('/message/inbox/{message}', [App\Http\Controllers\Home\MessageController::class, 'inbox'])->name('message.inbox');
});

Route::middleware(['PreventBackHistory','auth','isAdmin'])->prefix('admin')->name('admin.')->group(function(){
    Route::resources([
        'dashboard' =>App\Http\Controllers\Admin\DashboardController::class,
        'bookings' =>App\Http\Controllers\Admin\BookingController::class,
        'bookingslogs' =>App\Http\Controllers\Admin\BookingLogsController::class,
        'bookreport' =>App\Http\Controllers\Admin\BookReportController::class,
        'users' =>App\Http\Controllers\Admin\UsersController::class,
        'rating' =>App\Http\Controllers\Admin\RatingStarController::class,
        'message' =>App\Http\Controllers\Admin\MessageController::class,
        'availity' =>App\Http\Controllers\Admin\SortAvailityController::class,
        'announcement' =>App\Http\Controllers\Admin\AnnouncementController::class,
        'employee' =>App\Http\Controllers\Admin\EmployeeController::class,
        'foods' =>App\Http\Controllers\Admin\FoodController::class,
        'concern' =>App\Http\Controllers\Admin\ConcernController::class,
        'room' =>App\Http\Controllers\Admin\RoomController::class,
        'income' =>App\Http\Controllers\Admin\IncomeController::class,
        'warning' =>App\Http\Controllers\Admin\WarningHistoryController::class,
        'timer' =>App\Http\Controllers\Admin\TimerController::class,
    ]);
    Route::patch('/timer/timein/{book}', [App\Http\Controllers\Admin\TimerController::class, 'timein'])->name('timer.timein');
    Route::patch('/timer/timeout/{book}', [App\Http\Controllers\Admin\TimerController::class, 'timeout'])->name('timer.timeout');
    Route::post('/timer/out/', [App\Http\Controllers\Admin\TimerController::class, 'out'])->name('timer.out');
    Route::post('/timer/release/', [App\Http\Controllers\Admin\TimerController::class, 'release'])->name('timer.release');

    Route::patch('/bookings.paid/{book}', [App\Http\Controllers\Admin\BookingController::class, 'paid'])->name('bookings.paid');
    Route::patch('/bookings.partial/{book}', [App\Http\Controllers\Admin\BookingController::class, 'partial'])->name('bookings.partial');
    Route::patch('/bookings.partialupdate/{book}', [App\Http\Controllers\Admin\BookingController::class, 'partialupdate'])->name('bookings.partialupdate');

    Route::post('/bookings.warning', [App\Http\Controllers\Admin\BookingController::class, 'warning'])->name('bookings.warning');
    Route::post('/bookings.delete', [App\Http\Controllers\Admin\BookingController::class, 'delete'])->name('bookings.delete');

    Route::get('/employee/history/{employee}', [App\Http\Controllers\Admin\EmployeeController::class, 'history'])->name('employee.history');
    Route::get('/employee/paid/{employee}', [App\Http\Controllers\Admin\EmployeeController::class, 'paid'])->name('employee.paid');

    Route::get('/food/list/', [App\Http\Controllers\Admin\FoodController::class, 'list'])->name('foods.list');
    Route::get('/rooms/list/', [App\Http\Controllers\Admin\RoomController::class, 'list'])->name('room.list');
    Route::get('/employeee/list/', [App\Http\Controllers\Admin\EmployeeController::class, 'list'])->name('employee.list');
    Route::get('/announcements/list/', [App\Http\Controllers\Admin\AnnouncementController::class, 'list'])->name('announcement.list');
    Route::patch('/users/unban/{user}', [App\Http\Controllers\Admin\UsersController::class, 'unban'])->name('users.unban');


    Route::get('/incomes/chart/', [App\Http\Controllers\Admin\IncomeController::class, 'chart'])->name('income.chart');
});


Route::middleware(['PreventBackHistory','auth','isEmployee'])->prefix('employee')->name('employee.')->group(function(){
    Route::resources([
        'dashboard' =>App\Http\Controllers\Employee\DashboardController::class,
        'history' =>App\Http\Controllers\Employee\HistoryController::class,
        'timer' =>App\Http\Controllers\Employee\TimerController::class,
    ]);
});
