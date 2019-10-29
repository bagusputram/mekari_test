<?php

use Hashids\Hashids;

use App\Models\Setting\RouteList;

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
Auth::routes(['register' => false]);

Auth::routes();

/*
 * Bind hash decoder to routes
 *
 * @return string
 */
Route::bind('id', function ( $id ) {
    $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    return $hashids->decode($id);
});

Route::get('/', function () {
    return redirect('/dashboard');
});

// Route To Dashboard Index
Route::get('/dashboard', 'HomeController@index')->name('home');


Route::group(['middleware' => 'timeout','auth'], function () {    
    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

    $route_lists    = RouteList::all();

    foreach ($route_lists as $route_list) {
        $method         = $route_list->RouteType->name;
        $link           = $route_list->route_link;
        $controller     = (strpos($route_list->route_controller_name, '@') !== false) ? $route_list->route_controller_name : $route_list->route_controller_name . '@' . $route_list->MenuType->name;
        $name           = $route_list->route_menu_name;
        Route::match($method, $link, $controller)->name($name);
    }    
});


/* Route untuk Mas Tyo Isi Dibawah Sini Mas Tyo
    Stylingnya Route::any('{/nama}','{nama_controller}@{nama_function})->name('{nama_route_untuk_dipanggil_tanpa_link}');
*/

