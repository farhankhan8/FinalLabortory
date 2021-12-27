<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get("/testsms1",[Controllers\HomeController::class,'test_sms'])->name('test_sms');

//Auth::routes();
Auth::routes([
    "register" => false
]);
Route::get('registerinlab', [Controllers\Auth\RegisterController::class,'showRegistrationForm'])->name('register');
Route::post('registerinlab', [Controllers\Auth\RegisterController::class,'register']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/select', [Controllers\HomeController::class, 'postShow'])->name('select');
    Route::POST('/postData', [Controllers\HomeController::class, 'postData'])->name('postData');
});


//these route belongs to AvailAbleTest
Route::group(['middleware' => ['auth','inventory']], function () {

    Route::get('available-tests', [Controllers\AvailableTestController::class,'index'])->name('available-tests');
    Route::get('available-test-create',[Controllers\AvailableTestController::class,'create'])->name('available-test-create');
    Route::POST('availale-tests-store',[Controllers\AvailableTestController::class,'store'])->name('availale-tests-store');
    Route::get('availabel-tests-show/{id}',[Controllers\AvailableTestController::class,'show'])->name('availabel-tests-show');
    Route::get('availabel-tests-edit/{id}', [Controllers\AvailableTestController::class,'edit'])->name('availabel-tests-edit');
    Route::put('availabel-tests-update/{id}', [Controllers\AvailableTestController::class,'update'])->name('availabel-tests-update');
    Route::DELETE('avaiable-test-delete/{id}',[Controllers\AvailableTestController::class,'destroy'])->name('avaiable-test-delete');
});
// these route belongs to TestPerformeed

Route::group(['middleware' => ['auth']], function () {

    Route::get('test-performed-edit/{id}', [Controllers\TestsPerformedController::class,'edit'])->name('test-performed-edit')->middleware('inventory');
    Route::get('test-performed-show/{id}',[Controllers\TestsPerformedController::class,'show'])->name('test-performed-show');
    Route::get('test-performed-table/{id}',[Controllers\TestsPerformedController::class,'showDataOfTestPerformedTable'])->name('test-performed-table');

    Route::get('tests-performed',[Controllers\TestsPerformedController::class,'index'])->name('tests-performed');
    Route::get('test-performed-back',[Controllers\TestsPerformedController::class,'index'])->name('test-performed-back');

    Route::get('create',[Controllers\TestsPerformedController::class,'create'])->name('create');
    Route::post('test-performed',[Controllers\TestsPerformedController::class,'store'])->name('test-performed');   
    Route::put('performed-test-update/{id}', [Controllers\TestsPerformedController::class,'update'])->name('performed-test-update');
    Route::DELETE('performed-test-delete/{id}',[Controllers\TestsPerformedController::class,'destroy'])->name('performed-test-delete');
});
// Route::get('changeStatus', 'TestsPerformedController@changeStatus');

// these route belongs to PatientController

Route::group(['middleware' => ['auth']], function () {

    Route::get('patient-list', [Controllers\PatientController::class,'index'])->name('patient-list');
    Route::get('patient-create',[Controllers\PatientController::class,'create'])->name('patient-create');
    Route::post('patient-store',[Controllers\PatientController::class,'store'])->name('patient-store');
    Route::post('patient-view-multiple-report',[Controllers\PatientController::class,'view_multiple_report'])->name('patient-view-multiple-report');
    Route::get('patient-show/{id}',[Controllers\PatientController::class,'show'])->name('patient-show');
    Route::get('patient-edit/{id}', [Controllers\PatientController::class,'edit'])->name('patient-edit');
    Route::put('patient-update/{id}', [Controllers\PatientController::class,'update'])->name('patient-update');
    Route::DELETE('patient-delete/{id}',[Controllers\PatientController::class,'destroy'])->name('patient-delete');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('patient-category', [Controllers\PatientCategoryController::class,'index'])->name('patient-category');
    Route::get('patient-category-create',[Controllers\PatientCategoryController::class,'create'])->name('patient-category-create');
    Route::post('patient-category-store',[Controllers\PatientCategoryController::class,'store'])->name('patient-category-store');
    Route::get('patient-category-show/{id}',[Controllers\PatientCategoryController::class,'show'])->name('patient-category-show');
    Route::get('patient-category-edit/{id}', [Controllers\PatientCategoryController::class,'edit'])->name('patient-category-edit');
    Route::put('patient-category-update/{id}',[Controllers\PatientCategoryController::class,'update'])->name('patient-category-update');
    Route::DELETE('patient-category-delete/{id}',[Controllers\PatientCategoryController::class,'destroy'])->name('patient-category-delete');
});

// these are the route for CatagoryController
Route::group(['middleware' => ['auth']], function () {
    Route::get('catagory-list', [Controllers\TestCatagoryController::class,'index'])->name('catagory-list');
    Route::get('category', [Controllers\TestCatagoryController::class,'index'])->name('category');

    Route::get('catagory-create',[Controllers\TestCatagoryController::class,'create'])->name('catagory-create');
    Route::post('catagory-store',[Controllers\TestCatagoryController::class,'store'])->name('catagory-store');
    Route::get('catagory-show/{id}',[Controllers\TestCatagoryController::class,'show'])->name('catagory-show');
    Route::get('catagory-edit/{id}', [Controllers\TestCatagoryController::class,'edit'])->name('catagory-edit');
    Route::put('catagory-update/{id}', [Controllers\TestCatagoryController::class,'update'])->name('catagory-update');
    Route::DELETE('catagory-delete/{id}',[Controllers\TestCatagoryController::class,'destroy'])->name('catagory-delete');
});

// these are routes for Inventory section
Route::group(['middleware' => ['auth','inventory']], function () {

    Route::get('inventory-list', [Controllers\InventoryController::class,'index'])->name('inventory-list');
    Route::get('inventory-create',[Controllers\InventoryController::class,'create'])->name('inventory-create');
    Route::post('inventory-store',[Controllers\InventoryController::class,'store'])->name('inventory-store');
    Route::get('inventory-show/{id}',[Controllers\InventoryController::class,'show'])->name('inventory-show');
    Route::get('inventory-edit/{id}', [Controllers\InventoryController::class,'edit'])->name('inventory-edit');
    Route::put('inventory-update/{id}', [Controllers\InventoryController::class,'update'])->name('inventory-update');
    Route::DELETE('inventory-delete/{id}',[Controllers\InventoryController::class,'destroy'])->name('inventory-delete');
});
// these are route for sales

Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('sales', [Controllers\SalesController::class,'index'])->name('sales');
});

// Route::get("create", [Controllers\PostController::class, "create"]);
// Route::get('posts', [Controllers\PostController::class, "index"]);
// Route::post('store', [Controllers\PostController::class, "store"]);