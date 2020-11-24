<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/plans', 'PlanController@index')->name('plan.index');
    Route::get('/plan/{plan}', 'PlanController@show')->name('plan.show');
    Route::post('/subscription', 'subscriptionController@create')->name('subscription.create');

    //Routes for create Plan
    Route::get('create/plan', 'subscriptionController@createPlan')->name('create.plan');
    Route::post('store/plan', 'subscriptionController@storePlan')->name('store.plan');
//});*/
Route::get('checkout','CheckoutController@checkout');
Route::post('checkout','CheckoutController@afterpayment')->name('checkout.credit-card');
