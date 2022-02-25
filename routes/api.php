<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\UserApiController;

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
// Get for Fetch User
Route::get('/users/{id?}',[UserApiController::class, 'ShowUser']);
// Post for Add User
Route::post('/add_user',[UserApiController::class, 'AddUser']);
// Post for Add Multi User
Route::post('/add_multi_user',[UserApiController::class, 'MultiUser']);

// put for update User details
Route::put('/update_user_details/{id}',[UserApiController::class, 'UpdateUser']);

// patch for update single record
Route::patch('/update_single_record/{id}',[UserApiController::class, 'UpdateSingleRecord']);

// Delete for  single record
Route::delete('/delete_single_record/{id}',[UserApiController::class, 'DeleteSingleRecord']);

// Delete for  single record with Json
Route::delete('/delete_single_record_withjson',[UserApiController::class, 'DeleteSingleRecordWithJson']);

// Delete for  Multiple User
Route::delete('/delete_multiple_user/{ids}',[UserApiController::class, 'DeleteMultipleUser']);

// Delete for  Multiple record with Json
Route::delete('/delete_multiple_record_withjson',[UserApiController::class, 'DeleteMultipleRecordWithJson']);

// Register Api Using Passport

Route::post('/register_user_using_passport',[UserApiController::class,'RegisterUserUsingPassport']);

// Login Api Using Passport

Route::post('/login_user_using_passport',[UserApiController::class,'LoginUserUsingPassport']);
