<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReorderController;
use App\Http\Controllers\Admin\CategoryController;

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

Route::admineticAuth();

// Resourcefull Routes
Route::group(['prefix' => config('adminetic.prefix', 'admin'), 'middleware' => config('adminetic.middleware')], function () {
    // Restful Routes
    Route::resource('category', CategoryController::class);

    // Single Routes
    Route::get('category-children-reorder/{category}', [ReorderController::class, 'categoryChildrenReorder'])->name('categoryChildrenReorder');
});
