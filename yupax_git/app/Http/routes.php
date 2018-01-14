<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */ 
/*
 * ********* ADMIN PORTAL
 */
Route::filter("check-login-admin-portal", function() {
    if (!Session::has("login_admin_portal")) {
        return redirect("/portal/login"); 
    }
});
Route::get('/portal/login', '\App\Http\AdminPortal\Controllers\AuthController@getLogin');
Route::post('/portal/login', '\App\Http\AdminPortal\Controllers\AuthController@postLogin');
Route::get('/portal/logout', '\App\Http\AdminPortal\Controllers\AuthController@getLogout');
Route::group(array('prefix' => 'portal', 'before' => 'check-login-admin-portal'), function() {
    // Dashboard
    Route::get('/', '\App\Http\AdminPortal\Controllers\DashboardController@getIndex');
    // Merchant
    Route::get('/merchant/list', '\App\Http\AdminPortal\Controllers\MerchantController@getList');
    Route::post('/merchant/list', '\App\Http\AdminPortal\Controllers\MerchantController@postList');
    Route::get('/merchant/deleteSearch', '\App\Http\AdminPortal\Controllers\MerchantController@getDeleteSearch');
    Route::get('/merchant/add', '\App\Http\AdminPortal\Controllers\MerchantController@getAdd');
    Route::get('/merchant/getLatLong', '\App\Http\AdminPortal\Controllers\MerchantController@getLatLong');
    Route::post('/merchant/add', '\App\Http\AdminPortal\Controllers\MerchantController@postAdd');
});
/*
 * ********* ADMIN MERCHANT
 */
Route::filter("check-login-admin-merchant", function() {
    if (!Session::has("login_admin_merchant")) {
        return redirect("/merchant/login"); 
    }
});
Route::get('/merchant/login', '\App\Http\AdminMerchant\Controllers\AuthController@getLogin');
Route::post('/merchant/login', '\App\Http\AdminMerchant\Controllers\AuthController@postLogin');
Route::get('/merchant/logout', '\App\Http\AdminMerchant\Controllers\AuthController@getLogout');
Route::group(array('prefix' => 'merchant', 'before' => 'check-login-admin-merchant'), function() {
    // Test
    Route::get('/test', '\App\Http\AdminMerchant\Controllers\TestController@testMail');
    Route::get('/readFile', '\App\Http\AdminMerchant\Controllers\TestController@readFile');
    Route::get('/testMail', '\App\Http\AdminMerchant\Controllers\TestController@testMail');
    // Dashboard
    Route::get('/', '\App\Http\AdminMerchant\Controllers\DashboardController@getIndex');
    // Config
    Route::get('/config/level-user-fast', '\App\Http\AdminMerchant\Controllers\ConfigController@getConfigLevelUserFast');
    Route::post('/config/level-user-fast', '\App\Http\AdminMerchant\Controllers\ConfigController@postConfigLevelUserFast');
    // File
    Route::get('/file/list', '\App\Http\AdminMerchant\Controllers\FileController@getList');
    Route::post('/file/list', '\App\Http\AdminMerchant\Controllers\FileController@postList');
    Route::get('/file/clear-search', '\App\Http\AdminMerchant\Controllers\FileController@getClearSearch');
    Route::get('/file/add', '\App\Http\AdminMerchant\Controllers\FileController@getAdd');
    Route::post('/file/add-confirm', '\App\Http\AdminMerchant\Controllers\FileController@postAddConfirm');
    Route::get('/file/detail/{hashcode}', '\App\Http\AdminMerchant\Controllers\FileController@getDetail');
    // User
    Route::get('/user/list', '\App\Http\AdminMerchant\Controllers\UserController@getList');
    Route::post('/user/list', '\App\Http\AdminMerchant\Controllers\UserController@postList');
    Route::get('/user/import-csv', '\App\Http\AdminMerchant\Controllers\UserController@getImportCsv');
    Route::post('/user/import-csv-confirm', '\App\Http\AdminMerchant\Controllers\UserController@postImportCsvConfirm');
    Route::get('/user/import-csv-finish', '\App\Http\AdminMerchant\Controllers\UserController@postImportCsvFinish');
    // Store
    Route::get('/store/list', '\App\Http\AdminMerchant\Controllers\StoreController@getList');
    Route::post('/store/list', '\App\Http\AdminMerchant\Controllers\StoreController@postList');
    Route::get('/store/clear-search', '\App\Http\AdminMerchant\Controllers\StoreController@getClearSearch');
    Route::get('/store/add', '\App\Http\AdminMerchant\Controllers\StoreController@getAdd');
    Route::post('/store/add-confirm', '\App\Http\AdminMerchant\Controllers\StoreController@postAddConfirm');
    Route::get('/store/add-finish', '\App\Http\AdminMerchant\Controllers\StoreController@postAddFinish');
    Route::get('/store/detail/{hashcode}', '\App\Http\AdminMerchant\Controllers\StoreController@getDetail');
    Route::get('/store/edit/{hashcode}', '\App\Http\AdminMerchant\Controllers\StoreController@getEdit');
    Route::post('/store/edit-confirm', '\App\Http\AdminMerchant\Controllers\StoreController@postEditConfirm');
    Route::get('/store/edit-finish', '\App\Http\AdminMerchant\Controllers\StoreController@postEditFinish');
    // Store - Branch
    Route::get('/store/branch/add/{storeHashcode}', '\App\Http\AdminMerchant\Controllers\StoreController@getBranchAdd');
    Route::post('/store/branch/add-confirm', '\App\Http\AdminMerchant\Controllers\StoreController@postAddBranchConfirm');
    Route::get('/store/branch/add-finish', '\App\Http\AdminMerchant\Controllers\StoreController@postAddBranchFinish');
    Route::get('/store/branch/edit/{hashcode}', '\App\Http\AdminMerchant\Controllers\StoreController@getBranchEdit');
    Route::post('/store/branch/edit-confirm', '\App\Http\AdminMerchant\Controllers\StoreController@postEditBranchConfirm');
    Route::get('/store/branch/edit-finish', '\App\Http\AdminMerchant\Controllers\StoreController@postEditBranchFinish');
    // Promotion
    Route::get('/promotion/list', '\App\Http\AdminMerchant\Controllers\PromotionController@getList');
    Route::post('/promotion/list', '\App\Http\AdminMerchant\Controllers\PromotionController@postList');
    Route::get('/promotion/clear-search', '\App\Http\AdminMerchant\Controllers\PromotionController@getClearSearch');
    Route::get('/promotion/add', '\App\Http\AdminMerchant\Controllers\PromotionController@getAdd');
    Route::post('/promotion/add-confirm', '\App\Http\AdminMerchant\Controllers\PromotionController@postAddConfirm');
    Route::get('/promotion/add-finish', '\App\Http\AdminMerchant\Controllers\PromotionController@postAddFinish');
    // News
    Route::get('/news/list', '\App\Http\AdminMerchant\Controllers\NewsController@getList');
    Route::post('/news/list', '\App\Http\AdminMerchant\Controllers\NewsController@postList');
    Route::get('/news/clear-search', '\App\Http\AdminMerchant\Controllers\NewsController@getClearSearch');
    Route::get('/news/add', '\App\Http\AdminMerchant\Controllers\NewsController@getAdd');
    Route::post('/news/add-confirm', '\App\Http\AdminMerchant\Controllers\NewsController@postAddConfirm');
    Route::get('/news/add-finish', '\App\Http\AdminMerchant\Controllers\NewsController@postAddFinish');
    Route::get('/news/detail/{hashcode}', '\App\Http\AdminMerchant\Controllers\NewsController@getDetail');
    Route::get('/news/edit/{hashcode}', '\App\Http\AdminMerchant\Controllers\NewsController@getEdit');
    Route::post('/news/edit-confirm', '\App\Http\AdminMerchant\Controllers\NewsController@postEditConfirm');
    Route::get('/news/edit-finish', '\App\Http\AdminMerchant\Controllers\NewsController@postEditFinish');
    // Statistical
    Route::get('/statistical', '\App\Http\AdminMerchant\Controllers\StatisticalController@statistical');
    Route::post('/statistical', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatistical');
    Route::get('/statistical/clear-search', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatistical');

    // Report
    Route::get('/report', '\App\Http\AdminMerchant\Controllers\ReportController@report')->name('report.index');
    Route::get('/report-group', '\App\Http\AdminMerchant\Controllers\ReportController@reportGroup')->name('report.reportGroup');

    // --- revenue
    Route::get('/statistical/revenue', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalRevenue');
    Route::post('/statistical/revenue', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalRevenue');
    Route::get('/statistical/clear-search-revenue', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalRevenue');
    // --- revpash
    Route::get('/statistical/revpash', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalRevpash');
    Route::post('/statistical/revpash', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalRevpash');
    Route::get('/statistical/clear-search-revpash', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalRevpash');
    // --- revtab
    Route::get('/statistical/revtab', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalRevtab');
    Route::post('/statistical/revtab', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalRevtab');
    Route::get('/statistical/clear-search-revtab', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalRevtab');
    // --- revbill
    Route::get('/statistical/revbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalRevbill');
    Route::post('/statistical/revbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalRevbill');
    Route::get('/statistical/clear-search-revbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalRevbill');
    // --- revpam
    Route::get('/statistical/revpam', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalRevpam');
    Route::post('/statistical/revpam', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalRevpam');
    Route::get('/statistical/clear-search-revpam', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalRevpam');
    // --- guests
    Route::get('/statistical/guests', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalGuests');
    Route::post('/statistical/guests', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalGuests');
    Route::get('/statistical/clear-search-guests', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalGuests');
    // --- guestbill
    Route::get('/statistical/guestbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalGuestbill');
    Route::post('/statistical/guestbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalGuestbill');
    Route::get('/statistical/clear-search-guestbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalGuestbill');
    // --- timeturn
    Route::get('/statistical/timeturn', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalTimeturn');
    Route::post('/statistical/timeturn', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalTimeturn');
    Route::get('/statistical/clear-search-timeturn', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalTimeturn');
    // --- meal
    Route::get('/statistical/meal', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalMeal');
    Route::post('/statistical/meal', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalMeal');
    Route::get('/statistical/clear-search-meal', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalMeal');
    // --- complaintbill
    Route::get('/statistical/complaintbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalComplaintbill');
    Route::post('/statistical/complaintbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalComplaintbill');
    Route::get('/statistical/clear-search-complaintbill', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalComplaintbill');
    // --- unavailabilityitem
    Route::get('/statistical/unavailabilityitem', '\App\Http\AdminMerchant\Controllers\StatisticalController@statisticalUnavailabilityitem');
    Route::post('/statistical/unavailabilityitem', '\App\Http\AdminMerchant\Controllers\StatisticalController@postStatisticalUnavailabilityitem');
    Route::get('/statistical/clear-search-unavailabilityitem', '\App\Http\AdminMerchant\Controllers\StatisticalController@clearSearchStatisticalUnavailabilityitem');
    
    // Answer Question
    Route::get('/answer-question/list', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getList');
    Route::post('/answer-question/list', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postList');
    Route::get('/answer-question/clear-search', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getClearSearch');
    Route::get('/answer-question/add', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getAdd');
    Route::post('/answer-question/add-confirm', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postAddConfirm');
    Route::get('/answer-question/add-finish', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postAddFinish');
    Route::get('/answer-question/answer-view', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getAnswerView');
    Route::get('/answer-question/detail/{hashcode}', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getDetail');
    Route::get('/answer-question/edit/{hashcode}', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getEdit');
    Route::post('/answer-question/edit-confirm', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postEditConfirm');
    Route::get('/answer-question/edit-finish', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postEditFinish');
    // --- Answer - Question
    Route::get('/answer/question/add/{hashcode}', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getQuestionAdd');
    Route::post('/answer/question/add-confirm', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postQuestionAddConfirm');
    Route::get('/answer/question/add-finish', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postQuestionAddFinish');
    Route::get('/answer/question/edit/{hashcode}', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getQuestionEdit');
    Route::post('/answer/question/edit-confirm', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postQuestionEditConfirm');
    Route::get('/answer/question/edit-finish', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postQuestionEditFinish');
    // --- User - Question
    Route::get('/answer-question/user/list', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getUserQuestionList');
    Route::post('/answer-question/user/list', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postUserQuestionList');
    Route::get('/answer-question/user/clear-search', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@getUserQuestionClearSearch');
    // Config
    Route::get('/config', '\App\Http\AdminMerchant\Controllers\ConfigController@getConfig');
    Route::post('/config-confirm', '\App\Http\AdminMerchant\Controllers\ConfigController@postConfigConfirm');
    Route::get('/config-finish', '\App\Http\AdminMerchant\Controllers\ConfigController@postConfigFinish');
    // Analysis User
    // ---- 
    Route::get('/analysis-user/rfm/config', '\App\Http\AdminMerchant\Controllers\AnalysisUserController@getRfmConfig');
    Route::post('/analysis-user/rfm/config-confirm', '\App\Http\AdminMerchant\Controllers\AnalysisUserController@postRfmConfigConfirm');
    Route::get('/analysis-user/rfm/config-finish', '\App\Http\AdminMerchant\Controllers\AnalysisUserController@postRfmConfigFinish');
});
Route::post('stripe/merchant/postMinMaxValue', '\App\Http\AdminMerchant\Controllers\ConfigController@postMinMaxValue');
Route::post('stripe/merchant/postDataRatingLevel', '\App\Http\AdminMerchant\Controllers\ConfigController@postDataRatingLevel');
Route::post('stripe/merchant/file/delete', '\App\Http\AdminMerchant\Controllers\FileController@postDelete');
Route::post('stripe/merchant/store/branch/delete', '\App\Http\AdminMerchant\Controllers\StoreController@postStoreBranchDelete');
Route::post('stripe/merchant/store/delete', '\App\Http\AdminMerchant\Controllers\StoreController@postStoreDelete');
Route::post('stripe/merchant/answer/question/delete', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postQuestionDelete');
Route::post('stripe/merchant/answer-question/delete', '\App\Http\AdminMerchant\Controllers\AnswerQuestionController@postAnswerDelete');
/*
 * FrontEnd
 */
Route::get('/', '\App\Http\FrontEnd\Controllers\IndexController@getIndex');
Route::get('/activeCode', '\App\Http\FrontEnd\Controllers\IndexController@getActiveCode');

Route::get('/getLatLong', '\App\Http\Controllers\Controller@getLatLong');

/*
 * Api
 */
Route::post('stripe/api/auth', '\App\Http\Api\Controllers\ApiController@postAuth');
Route::post('stripe/api/auth-merchant', '\App\Http\Api\Controllers\ApiController@postAuthMerchant');
Route::post('stripe/api/unauth', '\App\Http\Api\Controllers\ApiController@postUnauth');
Route::post('stripe/api/service', '\App\Http\Api\Controllers\ApiController@postService');



