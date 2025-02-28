    <?php

use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\Employee\EmployeeHomeController;
    use App\Http\Controllers\LogController;
    use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDetailController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AssigneeController;
use App\Http\Controllers\ReservationItemsController;
use App\Http\Controllers\CategoryEventController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayPeriodController;
use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category.index');
Route::get('/admin/category/{id}', [CategoryController::class, 'show'])->name('admin.category.show');
Route::post('/admin/category', [CategoryController::class, 'store'])->name('admin.category.store');
Route::put('/admin/category/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
Route::delete('/admin/category/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
Route::get('/admin/list', [CategoryController::class, 'list'])->name('admin.category.list');

//Admin Inventory
Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('admin.inventory.index');
Route::get('/admin/inventory/{id}', [InventoryController::class, 'show'])->name('admin.inventory.show');
Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('admin.inventory.store');
Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
Route::get('/admin/item/list', [InventoryController::class, 'allInventory'])->name('admin.inventory.list');

//Logs
Route::get('/admin/logs', [LogController::class, 'index'])->name('admin.log.index');

//admin employee
Route::get('/admin/employee', [EmployeeController::class, 'index'])->name('admin.employee.index');
Route::get('/admin/employee/{id}', [EmployeeController::class, 'show'])->name('admin.employee.show');
Route::post('/admin/employee', [EmployeeController::class, 'store'])->name('admin.employee.store');
Route::put('/admin/employee/{id}', [EmployeeController::class, 'update'])->name('admin.employee.update');
Route::delete('/admin/employee/{id}', [EmployeeController::class, 'destroy'])->name('admin.employee.destroy');

//admin employee detail
Route::post('/admin/employee-detail', [EmployeeDetailController::class, 'store'])->name('admin.employee_detail.store');
Route::get('/admin/employee-detail/{id}', [EmployeeDetailController::class, 'show'])->name('admin.employee_detail.show');
Route::put('/admin/employee-detail/{id}', [EmployeeDetailController::class, 'update'])->name('admin.employee_detail.update');
Route::delete('/admin/employee-detail/{id}', [EmployeeDetailController::class, 'destroy'])->name('admin.employee_detail.destroy');


//admin client
Route::get('/admin/client', [ClientController::class, 'index'])->name('admin.client.index');
Route::get('/admin/client/{id}', [ClientController::class, 'show'])->name('admin.client.show');
Route::post('/admin/client', [ClientController::class, 'store'])->name('admin.client.store');
Route::put('/admin/client/{id}', [ClientController::class, 'update'])->name('admin.client.update');
Route::delete('/admin/client/{id}', [ClientController::class, 'destroy'])->name('admin.client.destroy');

//admin service
Route::get('/admin/service', [ServiceController::class, 'index'])->name('admin.service.index');
Route::post('/admin/service', [ServiceController::class, 'store'])->name('admin.service.store');
Route::get('/admin/service/{service}', [ServiceController::class, 'show'])->name('admin.service.show');
Route::put('/admin/service/{service}', [ServiceController::class, 'update'])->name('admin.service.update');
Route::delete('/admin/service/{service}', [ServiceController::class, 'destroy'])->name('admin.service.destroy');


//Reservation
Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('admin.reservations.index');

Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');





//payment
Route::get('/payment/index', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/checkout', [PaymentController::class, 'store'])->name('payment.checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

//profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/upload-image', [ProfileController::class, 'uploadProfileImage'])->name('profile.uploadImage');
Route::post('/profile/reset-image', [ProfileController::class, 'resetProfileImage'])->name('profile.resetImage');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//admin reservation allocation
Route::get('/admin/reservation-items', [ReservationItemsController::class, 'index'])->name('admin.reservationitems.index');
Route::get('/admin/reservation-items/single/{id}', [ReservationItemsController::class, 'showSingle'])->name('admin.reservationitems.single');
Route::get('/admin/reservation-items/{id}', [ReservationController::class, 'show'])->name('admin.reservationitems.show');
Route::post('/admin/reservation-items/store', [ReservationItemsController::class, 'store'])->name('admin.reservationitems.store');
Route::get('/admin/reservation-items/{id}/edit', [ReservationController::class, 'edit'])->name('admin.reservationitems.edit');
Route::put('/admin/reservation-items/{id}', [ReservationController::class, 'update'])->name('admin.reservationitems.update');

//reservation input
Route::post('admin/reservation-items/{id}/addInventory', [ReservationItemsController::class, 'addInventory'])->name('admin.reservationItems.addInventory');
Route::post('admin/reservation-items/{id}/editInventory', [ReservationItemsController::class, 'editInventory'])->name('admin.reservationItems.editInventory');
Route::post('admin/reservation-items/{id}/deleteInventory', [ReservationItemsController::class, 'deleteInventory'])->name('admin.reservationItems.deleteInventory');

//assignee for reservation
Route::get('/admin/assignee', [AssigneeController::class, 'index'])->name('admin.assignee.index');
Route::post('/admin/assignee', [AssigneeController::class, 'store'])->name('admin.assignee.store');
Route::get('/admin/assignee/{id}', [AssigneeController::class, 'show'])->name('admin.assignee.show');
Route::put('/admin/assignee/{id}', [AssigneeController::class, 'update'])->name('admin.assignee.update');
Route::delete('/admin/assignee/{id}', [AssigneeController::class, 'destroy'])->name('admin.assignee.destroy');

// admin category events
Route::prefix('admin/category-events')->group(function () {
    Route::get('/', [CategoryEventController::class, 'index'])->name('admin.categoryevents.index'); // List all category events
    Route::post('/', [CategoryEventController::class, 'store'])->name('admin.categoryevents.store'); // Create a new category event
    Route::get('/{id}', [CategoryEventController::class, 'show'])->name('admin.categoryevents.show'); // Show a specific category event
    Route::put('/{id}', [CategoryEventController::class, 'update'])->name('admin.categoryevents.update'); // Update an existing category event
    Route::delete('/{id}', [CategoryEventController::class, 'destroy'])->name('admin.categoryevents.destroy'); // Delete a category event
});



//admin payroll
Route::get('/admin/payroll', [PayrollController::class, 'index'])->name('admin.payroll.index');
Route::get('/admin/payroll/create', [PayrollController::class, 'create'])->name('admin.payroll.create');
Route::post('/admin/payroll', [PayrollController::class, 'store'])->name('admin.payroll.store');
Route::put('/admin/payroll/{id}', [PayrollController::class, 'update'])->name('admin.payroll.update');
Route::delete('/admin/payroll/{id}', [PayrollController::class, 'destroy'])->name('admin.payroll.destroy');
Route::get('/admin/payroll/{id}/edit', [PayrollController::class, 'edit'])->name('admin.payroll.edit');
Route::put('/admin/payroll/{id}', [PayrollController::class, 'update'])->name('admin.payroll.update');

//admin attendance
Route::get('/admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
Route::get('/admin/attendance/create', [AttendanceController::class, 'create'])->name('admin.attendance.create');
Route::post('/admin/attendance', [AttendanceController::class, 'store'])->name('admin.attendance.store');
Route::get('/admin/attendance/{id}', [AttendanceController::class, 'show'])->name('admin.attendance.show');
Route::get('/admin/attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('admin.attendance.edit');
Route::put('/admin/attendance/{id}', [AttendanceController::class, 'update'])->name('admin.attendance.update');
Route::delete('/admin/attendance/{id}', [AttendanceController::class, 'destroy'])->name('admin.attendance.destroy');

Route::get('/admin/reservation/attendance/{reservationId}', [AttendanceController::class, 'reservationAttendance'])
    ->name('admin.reservation.attendance');



//Staff Routes
Route::get('/staff/home', [EmployeeHomeController::class, 'index'])->name('staff.home');



