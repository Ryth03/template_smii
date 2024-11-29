<?php

use App\Http\Controllers\Auth\LockScreenController;
use App\Http\Controllers\Auth\UnlockableController;
use App\Http\Controllers\COA\AnalyticalDataController;
use App\Http\Controllers\COA\CustomerController;
use App\Http\Controllers\COA\ProductAnalystController;
use App\Http\Controllers\COA\ProductController as COAProductController;
use App\Http\Controllers\COA\TemplateController;
use App\Http\Controllers\COA\TestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DOC\CategoryController;
use App\Http\Controllers\DOC\DocumentController;
use App\Http\Controllers\DOC\EventController;
use App\Http\Controllers\DOC\FileController;
use App\Http\Controllers\DOC\ReminderController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PCR\InitiatorController;
use App\Http\Controllers\PCR\NatureOfChangeController;
use App\Http\Controllers\PCR\PCCController;
use App\Http\Controllers\PCR\PCRController;
use App\Http\Controllers\PCR\ProductController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QAD\AccountController;
use App\Http\Controllers\QAD\ApproverController;
use App\Http\Controllers\QAD\CostCenterController;
use App\Http\Controllers\QAD\CustomerInvoiceController;
use App\Http\Controllers\QAD\EmployeeController;
use App\Http\Controllers\QAD\InventoryController;
use App\Http\Controllers\QAD\ItemController;
use App\Http\Controllers\QAD\ProductionController;
use App\Http\Controllers\QAD\PurchaseOrderDetailController;
use App\Http\Controllers\QAD\PurchaseOrderMasterController;
use App\Http\Controllers\QAD\RequisitionApprovalDetailController;
use App\Http\Controllers\QAD\RequisitionMasterController;
use App\Http\Controllers\QAD\SalesController;
use App\Http\Controllers\QAD\SubAccountController;
use App\Http\Controllers\QAD\SupplierController;
use App\Http\Controllers\Role\PermissionController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WSA\RQMController;
use App\Models\PCR\InitiatorApproval;
use App\Models\QAD\RequisitionMaster;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;
use App\Http\Controllers\HSE\HSEController;
use App\Http\Controllers\HSE\HSEFormController;
use App\Http\Controllers\HSE\HSELocationController;
use App\Http\Controllers\HSE\HSEApproverLevelController;
use App\Http\Controllers\HSE\JobEvaluationController;



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
    SEOMeta::setTitle('Intra SMII - Dashboard');
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/help', function(){
        return view('hse.guest.tutorial');
    })->name('tutorial.hse');

    // Admin HSE
    Route::get('/dashboard-review', [HSEController::class, 'reviewTable'])->name('review.table');
    Route::get('/dashboard-approval', [HSEController::class, 'approvalTable'])->name('approval.table');
    Route::get('/viewAll-table', [HSEController::class, 'viewAllTable'])->name('viewAll.table');
    Route::get('/dashboard-security', [HSEController::class, 'viewSecurityTable'])->name('securityPost.table');
    Route::get('/job-evaluation', [JobEvaluationController::class, 'viewJobEvaluation'])->name('jobEvaluation.table');
    Route::get('/job-evaluation-report', [JobEvaluationController::class, 'viewJobEvaluationReport'])->name('jobEvaluationReport.table');
    
    Route::POST('/job-evaluate-report-form', [JobEvaluationController::class, 'evaluateJobReport'])->name('jobEvaluateReport.form');
    Route::POST('/job-evaluate-form', [JobEvaluationController::class, 'evaluateJob'])->name('jobEvaluate.form');
    Route::POST('/job-evaluate', [JobEvaluationController::class, 'evaluate'])->name('evaluate');
    Route::POST('/review', [HSEController::class, 'reviewForm'])->name('review.form');
    Route::POST('/approve', [HSEController::class, 'approvalForm'])->name('approval.form');
    Route::get('/approve', function () {
        return view('hse.admin.form.approveForm');
    });

    // USER HSE
    Route::get('/hse', [HSEFormController::class, 'viewNewForm'])->name('permit.form');
    Route::post('/extend-form-hse', [HSEFormController::class, 'viewExtendForm'])->name('extend.form');
    Route::get('/dashboard-hse',  [HSEFormController::class, 'viewList'])->name('hse.dashboard');
    Route::post('/insert-form-hse', [HSEFormController::class, 'insertNewForm'])->name('hse.form.insert');
    Route::post('/insert-extend-form-hse', [HSEFormController::class, 'insertExtendForm'])->name('hse.form.extend');
    Route::post('/view-form-hse', [HSEFormController::class, 'viewDraftForm'])->name('view.form.hse');
    Route::post('/submit-form-hse', [HSEFormController::class, 'insertForm'])->name('submit.form.hse');
    Route::post('/update-form-hse', [HSEController::class, 'updateForm'])->name('update.form.hse');
    Route::delete('/delete-form-hse', [HSEFormController::class, 'deleteForm'])->name('delete.form.hse');
    Route::post('/approve-form-hse', [HSEController::class, 'approveForm'])->name('approve.form.hse');

    Route::get('/location', [HSELocationController::class, 'viewLocation'])->name('location.hse');
    Route::put('/location/{locationId}/edit', [HSELocationController::class, 'locationUpdate'])->name('location.update');
    Route::delete('/location/{locationId}/delete', [HSELocationController::class, 'locationDelete'])->name('location.destroy');
    Route::post('/location/store', [HSELocationController::class, 'locationStore'])->name('location.store');
    
    Route::get('/approver', [HSEApproverLevelController::class, 'index'])->name('approver.view.hse');
    Route::put('/approver/{approverId}', [HSEApproverLevelController::class, 'update'])->name('approver.update.hse');

    Route::post('/report', [HSEController::class, 'printReport'])->name('report.hse');

    /* Dashboard */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-finance', [DashboardController::class, 'index-finance'])->name('dashboard-finance');
    Route::get('/api/requisitions/{year}', [DashboardController::class, 'getRequisitionsByYear'])->name('dashboard.requisitions.byYear');
    Route::get('/dashboard-sales', [DashboardController::class, 'index-sales'])->name('dashboard-sales');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile', [UserController::class, 'updateProfile'])->name('profile.updates');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*Locked */
    Route::get('locked', [LockScreenController::class, 'show'])
        ->name('locked');

    Route::post('locked', [LockScreenController::class, 'store']);

    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/markAllAsRead', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/clear', [NotificationController::class, 'clearAll'])->name('notifications.clear');

    Route::get('/notifications/count', function () {
        return response()->json(['count' => auth()->user()->unreadNotifications->count()]);
    })->name('notifications.count');


});



Route::group(['middleware' => ['role:super-admin|admin|hse']], function () {

    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    Route::resource('users', UserController::class);
    Route::delete('users/{userId}/delete', [UserController::class, 'destroy']);

    Route::get('departments', [DepartmentController::class, 'index'])->name('department.index');
    Route::post('departments', [DepartmentController::class, 'store'])->name('department.store');
    Route::delete('departments/{department:department_slug}/delete', [DepartmentController::class, 'destroy'])->name('department.destroy');
    Route::put('departments/{department:department_slug}/update', [DepartmentController::class, 'update'])->name('department.update');

    Route::get('positions', [PositionController::class, 'index'])->name('position.index');
    Route::delete('positions/{position:position_slug}/delete', [PositionController::class, 'destroy'])->name('positions.destroy');
    Route::put('positions/{position:position_slug}/update', [PositionController::class, 'update'])->name('positions.update');
    Route::post('positions', [PositionController::class, 'store'])->name('position.store');

    Route::get('levels', [LevelController::class, 'index'])->name('level.index');
    Route::put('levels/{level:level_slug}/update', [LevelController::class, 'update'])->name('level.update');
    Route::post('levels', [LevelController::class, 'store'])->name('level.store');
    Route::delete('levels/{level:level_slug}/delete', [LevelController::class, 'destroy'])->name('level.destroy');
});









require __DIR__ . '/auth.php';
