    <?php

use Illuminate\Support\Facades\Auth;
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
    // dd(Auth::user());
    if (!Auth::user()) {
        return view('auth.login');
    } else {
        return redirect(route('home'));
    }
});

Auth::routes();

Route::group(
    ['middleware' => 'auth'],
    function () {

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // USERS
        Route::get('/employee', [App\Http\Controllers\UsersController::class, 'index'])->name('employee');
        Route::get('/employee/api/datatable', [App\Http\Controllers\UsersController::class, 'apiUsers'])->name('employes_api');
        Route::get('/employee/api/show', [App\Http\Controllers\UsersController::class, 'show'])->name('showemployee_api');
        Route::get('/employee/api/departments', [App\Http\Controllers\UsersController::class, 'showDepartment'])->name('showDepartment_api');
        Route::get('/employee/api/jobTitles/{id}', [App\Http\Controllers\UsersController::class, 'showJobTittle'])->name('showJobTittle_api');

        Route::post('/employee/store', [App\Http\Controllers\UsersController::class, 'store'])->name('employee_store');
        Route::post('/employee/update', [App\Http\Controllers\UsersController::class, 'update'])->name('employee_update');
        Route::post('/employee/destroy', [App\Http\Controllers\UsersController::class, 'destroy'])->name('employee_destroy');
        Route::post('/employee/activate', [App\Http\Controllers\UsersController::class, 'activate'])->name('employee_Activate');
        Route::post('/employee/deactivate', [App\Http\Controllers\UsersController::class, 'deactivate'])->name('employee_Deactivate');


        //CHAR PERSETAGE MATCH ( PART OF PENUGASAN TECHNICAL TEST)
        Route::get('/charmatch/ajax', [App\Http\Controllers\CharacterPersentageController::class, 'index'])->name('characterpersentage');
        Route::post('/charmatch/ajax', [App\Http\Controllers\CharacterPersentageController::class, 'calculateMatch'])->name('characterpersentage');

        //SHOW HIERARCHY TREE
        Route::get('/departments/hierarchy', [App\Http\Controllers\DepartmentController::class, 'showHierarchyTree'])->name('showHierarchyTree');


        // REIMBURSMENT
        Route::get('/reimbursements', [App\Http\Controllers\reimbursementsController::class, 'index'])->name('reimbursements');
        Route::get('/reimbursements/all', [App\Http\Controllers\reimbursementsController::class, 'indexAll'])->name('reimbursements_all');
        Route::get('/reimbursements/create', [App\Http\Controllers\reimbursementsController::class, 'create'])->name('reimbursements_create');
        Route::get('/reimbursements/show/{id}', [App\Http\Controllers\reimbursementsController::class, 'show'])->name('reimbursements_show');
        Route::get('/reimbursements/edit/{id}', [App\Http\Controllers\reimbursementsController::class, 'edit'])->name('reimbursements_edit');
        Route::get('/reimbursements/api', [App\Http\Controllers\reimbursementsController::class, 'api'])->name('reimbursements_api');
        Route::get('/reimbursements/apiByID/{id}', [App\Http\Controllers\reimbursementsController::class, 'apiByID'])->name('reimbursements_apiByID');
        Route::get('/reimbursements/api/all', [App\Http\Controllers\reimbursementsController::class, 'apiAllreimbursements'])->name('reimbursementsAll_api');
        Route::post('/reimbursements/store', [App\Http\Controllers\reimbursementsController::class, 'post'])->name('reimbursements_store');
        Route::post('/reimbursements/update', [App\Http\Controllers\reimbursementsController::class, 'update'])->name('reimbursements_update');
        Route::post('/reimbursements/delete', [App\Http\Controllers\reimbursementsController::class, 'destroy'])->name('reimbursements_delete');
        Route::post('/reimbursements/approval', [App\Http\Controllers\reimbursementsController::class, 'approval'])->name('reimbursements_approval');
        Route::post('/reimbursements/approved', [App\Http\Controllers\reimbursementsController::class, 'approved'])->name('reimbursements_approved');
        Route::post('/reimbursements/rejected', [App\Http\Controllers\reimbursementsController::class, 'rejected'])->name('reimbursements_rejected');
        Route::post('/reimbursements/cancelled', [App\Http\Controllers\reimbursementsController::class, 'cancelled'])->name('reimbursements_cancelled');
        Route::get('/reimbursements/downloadFile/{id}', [App\Http\Controllers\reimbursementsController::class, 'downloadFile'])->name('reimbursements_downloadFile');

        // Permit for Leave
        Route::get('/leave', [App\Http\Controllers\LeaveController::class, 'index'])->name('leave');
        Route::get('/leave/all', [App\Http\Controllers\LeaveController::class, 'indexAll'])->name('leave_all');
        Route::get('/leave/create', [App\Http\Controllers\LeaveController::class, 'create'])->name('leave_create');
        Route::get('/leave/show/{id}', [App\Http\Controllers\LeaveController::class, 'show'])->name('leave_show');
        Route::get('/leave/edit/{id}', [App\Http\Controllers\LeaveController::class, 'edit'])->name('leave_edit');
        Route::get('/leave/api', [App\Http\Controllers\LeaveController::class, 'api'])->name('leave_api');
        Route::get('/leave/api/all', [App\Http\Controllers\LeaveController::class, 'apiAllLeaves'])->name('leaveAll_api');
        Route::post('/leave/store', [App\Http\Controllers\LeaveController::class, 'post'])->name('leave_store');
        Route::post('/leave/update', [App\Http\Controllers\LeaveController::class, 'update'])->name('leave_update');
        Route::post('/leave/delete', [App\Http\Controllers\LeaveController::class, 'destroy'])->name('leave_delete');
        Route::post('/leave/approval', [App\Http\Controllers\LeaveController::class, 'approval'])->name('leave_approval');
        Route::post('/leave/approved', [App\Http\Controllers\LeaveController::class, 'approved'])->name('leave_approved');
        Route::post('/leave/rejected', [App\Http\Controllers\LeaveController::class, 'rejected'])->name('leave_rejected');
        Route::post('/leave/cancelled', [App\Http\Controllers\LeaveController::class, 'cancelled'])->name('leave_cancelled');
        Route::get('/leave/downloadFile/{id}', [App\Http\Controllers\LeaveController::class, 'downloadFile'])->name('leave_downloadFile');

        // API
        Route::get('/api/v1/master/cities', [App\Http\Controllers\UsersController::class, 'apiCities'])->name('api_cities');
    }
);
