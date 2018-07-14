<?php

use App\Message;
use App\Repositories\MessagesRepository;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/messagerie/users', 'Api\MessagesController@index');
    Route::get('/messagerie/user/{user}', 'Api\MessagesController@show');
    Route::post('/messagerie/user/{user}', 'Api\MessagesController@sendMessage');
});
/*Route::middleware('auth:api')->get('/messages', function (Request $request){
    $repo = new MessagesRepository(new User(), new Message());
    return $repo->getMessages(1,2)->get();
});*/
