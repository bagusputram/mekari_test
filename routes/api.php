    <?php

use Illuminate\Http\Request;

use Hashids\Hashids;

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

Route::bind('id', function ( $id ) {
    $hashids = new Hashids('', 20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');
    return $hashids->decode($id);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {
    //    Route::resource('task', 'TasksController');

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_api_routes
});

Route::group(['middleware' => 'timeout','auth:api'], function() {
    //Api for Fetch Session Timeout Data
    Route::get('setting/session-timeout/{id}', 'Api\SessionTimeoutController@getSessionTimeoutData')->name('api.setting.session-timeout');

    //Api for Fetch Gender Data
    Route::get('setting/gender/{id}', 'Api\GenderController@getGenderById')->name('api.setting.gender');

    //Api for Fetch User Data
    Route::get('user-management/{id}', 'Api\UserManagementController@getUserById')->name('api.user-management');

    //Api to Fetch Citizenship Data
    Route::get('setting/citizenship/{id}', 'Api\CitizenshipController@getCitizenshipById')->name('api.setting.citizenship');

    //Api to Fetch Citizenship Data
    Route::get('setting/company-type/{id}', 'Api\CompanyTypeController@getCompanyTypeById')->name('api.setting.company-type');

    //Api to Fetch Citizenship Data
    Route::get('company-information/company/{id}', 'Api\CompanyController@getCompanyById')->name('api.setting.company');

    //Api to Fetch User Role Data
    Route::get('setting/user-role/{id}', 'Api\UserRoleController@getUserRoleById')->name('api.setting.user-role');

    //Api to Fetch Menu Sidebar Data
    Route::get('setting/menu/{id}', 'Api\MenuController@getMenuById')->name('api.setting.menu');

    //Api to Fetch Language Data
    Route::get('setting/language/{id}', 'Api\LanguageController@getLanguageById')->name('api.setting.language');

    //Api to Fetch Application Theme Color Data
    Route::get('setting/application-theme-color/{id}', 'Api\ApplicationThemeColorController@getApplicationThemeColorById')->name('api.setting.application-theme-color');

    //Api to Fetch Route Type Data
    Route::get('setting/route-type/{id}', 'Api\RouteTypeController@getRouteTypeById')->name('api.setting.route-type');

    //Api to Fetch Menu Type Data
    Route::get('setting/menu-type/{id}', 'Api\MenuTypeController@getMenuTypeById')->name('api.setting.menu-type');

    //Api to Fetch Route Controller Type Data
    Route::get('setting/route-controller-type/{id}', 'Api\RouteControllerTypeController@getRouteControllerTypeById')->name('api.setting.route-controller-type');

    //Api to Fetch Route list Data
    Route::get('setting/route-list/{id}', 'Api\RouteListController@getRouteListById')->name('api.setting.route-list');

    //Api to Fetch Province Data
    Route::get('setting/province/{id}', 'Api\ProvinceController@getProvinceById')->name('api.setting.province');

    //Api to Fetch City Data
    Route::get('setting/city/{id}', 'Api\CityController@getCityById')->name('api.setting.city');
    Route::get('setting/city/{province_id}/filter-province', 'Api\CityController@getCityDataByProvince')->name('api.setting.city.filter.byprovince');

    //Api to Fetch District Data
    Route::get('setting/district/{id}', 'Api\DistrictController@getDistrictById')->name('api.setting.district');
    Route::get('setting/district/alldata/{trash}', 'Api\DistrictController@getDistrictData')->name('api.setting.district.all');
    Route::get('setting/district/{city_id}/filter-city', 'Api\DistrictController@getDistrictDataByCity')->name('api.setting.district.filter.bycity');

    //Api to Fetch District Data
    Route::any('setting/subdistrict/alldata/{trash}', 'Api\SubdistrictController@getSubdistrictData')->name('api.setting.subdistrict.all');
    Route::get('setting/subdistrict/singledata/{id}', 'Api\SubdistrictController@getSubdistrictById')->name('api.setting.subdistrict');
    Route::get('setting/subdistrict/{district_id}/filter-district', 'Api\SubdistrictController@getSubdistrictDataByDistrict')->name('api.setting.subdistrict.filter.bydistrict');

    //Api to Fetch Task Data
    Route::any('to-do-list/alldata/{trash}', 'Api\ToDoListController@getToDoListData')->name('api.to-do-list.all');
    Route::get('to-do-list/singledata/{id}', 'Api\ToDoListController@getToDoListById')->name('api.to-do-list.id');

});

Route::group(['middleware' => 'web'], function() {
    Route::get('find-taxonomy', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        Log::info($keyword);
        $taxonomy = DB::table('eperformance_taxonomy')->where('taxonomy_name','like','%'.$keyword.'%')
                    ->select('taxonomy_name')
                    ->get();
        return json_encode($taxonomy);
    })->name('api.taxonomy');
});

// get api token key
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Api\AuthController@login');    
  
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
    });
});