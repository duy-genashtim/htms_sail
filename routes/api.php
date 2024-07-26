<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\GraphMailerController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'user'], function () {
    // Route::get('profile', [AuthController::class, 'getCurrentUser']); // Get all employees
});
Route::group(['prefix' => 'departments'], function () {
    Route::get('/', [DepartmentController::class, 'index']);
    Route::post('/', [DepartmentController::class, 'store']); 
    Route::get('/{id}', [DepartmentController::class, 'show']);
    Route::post('/{id}/employees', [DepartmentController::class, 'addEmployees']); 
    Route::patch('/{id}/toggle-main', [DepartmentController::class, 'toggleMainDepartment']);
});

Route::group(['prefix' => 'employee'], function () {
    Route::get('/', [EmployeeController::class, 'index']); // Get all employees
    Route::get('/{id}', [EmployeeController::class, 'show']); // Get specific employee by ID
    Route::post('/', [EmployeeController::class, 'store']); // Create a new employee
    Route::middleware('web')->put('/{id}', [EmployeeController::class, 'update']); // Update an employee
   // Route::delete('/{id}', [EmployeeController::class, 'destroy']); // Delete an employee
   Route::get('/{id}/department', [EmployeeController::class, 'getEmployeesByDepartment']); // Get specific employee by ID
   Route::post('/{id}/emergency-contact', [EmployeeController::class, 'storeEmergencyContact']);
   Route::get('/{id}/emergency-contact', [EmployeeController::class, 'getEmergencyContact']);
   Route::delete('/emergency-contact/{id}', [EmployeeController::class, 'deleteEmergencyContact']);

});
Route::group(['prefix' => 'graph'], function () {
    Route::get('get-avatar/{email}', [GraphMailerController::class, 'getAvatarImage'])->name('getAvatarImage');
    Route::middleware('web')->get('test', [GraphMailerController::class, 'test'])->name('test');

});
