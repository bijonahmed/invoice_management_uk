<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\UserController;
/*
   Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
     return $request->user();
   });
*/
Route::group(['prefix' => 'public'], function () {
  Route::get('/getVideoLists', [App\Http\Controllers\API\PublicController::class, 'getVideoLists']);
  Route::get('/deleteStatus/{id}', [App\Http\Controllers\API\PublicController::class, 'updateDeleteStatus']);
});
Route::middleware('auth:sanctum')->group(function () {
  Route::group(['prefix' => 'category'], function () {
    Route::get('/allCustomers', [App\Http\Controllers\API\CategoryController::class, 'allCustomers']);
    Route::get('/allCustomerslist', [App\Http\Controllers\API\CategoryController::class, 'allCustomerslist']);
    Route::get('/allCustomerMoney', [App\Http\Controllers\API\CategoryController::class, 'allCustomerMoney']);
    Route::get('/allCustomerOthers', [App\Http\Controllers\API\CategoryController::class, 'allCustomerOthers']);

    Route::get('/getCustomerData', [App\Http\Controllers\API\CategoryController::class, 'getCustomerData']);
    Route::get('/getSupplierData', [App\Http\Controllers\API\CategoryController::class, 'getSupplierData']);
    Route::get('/getDueAmountlist', [App\Http\Controllers\API\CategoryController::class, 'getDueAmountlist']);
    Route::get('/getPaymentAmountlist', [App\Http\Controllers\API\CategoryController::class, 'getPaymentAmountlist']);
    Route::get('/getCategoryList', [App\Http\Controllers\API\CategoryController::class, 'getCategoryList']);
    Route::get('/gamesCategory', [App\Http\Controllers\API\CategoryController::class, 'gamesCategory']);
    Route::get('/allsuppliders', [App\Http\Controllers\API\CategoryController::class, 'allsuppliders']);
    Route::get('/moneySuppliders', [App\Http\Controllers\API\CategoryController::class, 'moneySuppliders']);
    Route::post('/saveCustomer', [App\Http\Controllers\API\CategoryController::class, 'saveCustomer']);
    Route::post('/saveSupplier', [App\Http\Controllers\API\CategoryController::class, 'saveSupplier']);
    Route::post('/saveDueAmt', [App\Http\Controllers\API\CategoryController::class, 'saveDueAmt']);
    Route::post('/savePayment', [App\Http\Controllers\API\CategoryController::class, 'savePayment']);
    Route::post('/saveInvoiceMoney', [App\Http\Controllers\API\CategoryController::class, 'saveInvoiceMoney']);
    Route::post('/saveInvoiceOthers', [App\Http\Controllers\API\CategoryController::class, 'saveInvoiceOthers']);
    Route::post('/saveInvoice', [App\Http\Controllers\API\CategoryController::class, 'saveInvoice']);
    Route::post('/saveInvoiceReturn', [App\Http\Controllers\API\CategoryController::class, 'saveInvoiceReturn']);
    Route::post('/saveCategory', [App\Http\Controllers\API\CategoryController::class, 'saveCategory']);
    Route::post('/checkInSubCateName', [App\Http\Controllers\API\CategoryController::class, 'checkInSubCateName']);
    Route::post('/checkSubCateName', [App\Http\Controllers\API\CategoryController::class, 'checkSubCateName']);
    Route::post('/chkCategoryId', [App\Http\Controllers\API\CategoryController::class, 'chkCategoryId']);
    Route::post('/chkSupplierAmt', [App\Http\Controllers\API\CategoryController::class, 'chkSupplierAmt']);
    Route::post('/chkSupplierWiseDueAmt', [App\Http\Controllers\API\CategoryController::class, 'chkSupplierWiseDueAmt']);
    Route::post('/checkhastagName', [App\Http\Controllers\API\CategoryController::class, 'checkhastagName']);
    Route::post('/checkCateName', [App\Http\Controllers\API\CategoryController::class, 'checkCateName']);
    Route::get('/editInSubCategoryId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editInSubCategoryId']);
    Route::get('/editCategoryId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editCategoryId']);
    Route::get('/editInvoiceMoneyId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editInvoiceMoneyId']);
    Route::get('/editInvoiceOthersInvId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editInvoiceOthresId']);
    Route::get('/editInvoiceTravelId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editInvoiceTravelId']);
    Route::get('/editCustomerId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editCustomerId']);
    Route::get('/editSupplierId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editSupplierId']);
    Route::get('/editDueAmtId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editDueAmtId']);
    Route::get('/editPaidAmtId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editPaidAmtId']);
    Route::get('/getInvoiceData/{id}', [App\Http\Controllers\API\CategoryController::class, 'getInvoiceData']);
    Route::get('/getInvoiceMoneyData/{id}', [App\Http\Controllers\API\CategoryController::class, 'getInvoiceMoneyData']);

    Route::get('/getInvoiceOthersData/{id}', [App\Http\Controllers\API\CategoryController::class, 'getInvoiceOthersData']);

    Route::get('/getInvoiceDataChk/{id}', [App\Http\Controllers\API\CategoryController::class, 'getInvoiceDataChk']);
    Route::get('/getInvoiceslist', [App\Http\Controllers\API\CategoryController::class, 'getInvoiceslist']);
    Route::get('/getInvoicesReturnForTravellist', [App\Http\Controllers\API\CategoryController::class, 'invoicesReturnForTravellist']);
    Route::get('/getInvoicesmoneylist', [App\Http\Controllers\API\CategoryController::class, 'getInvoicesmoneylist']);

    Route::get('/getInvoicesOtherslist', [App\Http\Controllers\API\CategoryController::class, 'getInvoicesOtherslist']);



    Route::get('/editHashTagId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editHashTagId']);
    Route::get('/editSubCategoryId/{id}', [App\Http\Controllers\API\CategoryController::class, 'editSubCategoryId']);
    Route::post('/saveSubCategory', [App\Http\Controllers\API\CategoryController::class, 'saveSubCategory']);
    Route::post('/addAds', [App\Http\Controllers\API\CategoryController::class, 'addAds']);
    Route::post('/inSaveSubCategory', [App\Http\Controllers\API\CategoryController::class, 'inSaveSubCategory']);
    Route::post('/removeSubCategory', [App\Http\Controllers\API\CategoryController::class, 'removeSubCategory']);
    Route::post('/removeCategory', [App\Http\Controllers\API\CategoryController::class, 'removeCategory']);
    Route::post('/removeAds', [App\Http\Controllers\API\CategoryController::class, 'removeAds']);
    Route::post('/removeHashTag', [App\Http\Controllers\API\CategoryController::class, 'removeHashTag']);
    Route::get('/getCategoryData', [App\Http\Controllers\API\CategoryController::class, 'getCategoryData']);
    Route::get('/getInvoice_data', [App\Http\Controllers\API\CategoryController::class, 'getInvoice_data']);
    Route::get('/getAdsData', [App\Http\Controllers\API\CategoryController::class, 'getAdsData']);
    Route::get('/getHasTagData', [App\Http\Controllers\API\CategoryController::class, 'getHasTagData']);
    Route::get('/getSubCategoryData', [App\Http\Controllers\API\CategoryController::class, 'getSubCategoryData']);
    Route::post('/removeInSubCategory', [App\Http\Controllers\API\CategoryController::class, 'removeInSubCategory']);
    Route::get('/getInSubCategoryData', [App\Http\Controllers\API\CategoryController::class, 'getInSubCategoryData']);
  });
  Route::group(['prefix' => 'gifts'], function () {
    Route::get('/giftsList', [App\Http\Controllers\API\GitftController::class, 'giftsList']);
    Route::post('/saveGifts', [App\Http\Controllers\API\GitftController::class, 'saveGifts']);
    Route::post('/removeGifts', [App\Http\Controllers\API\GitftController::class, 'removeGifts']);
    Route::get('/editGiftId/{id}', [App\Http\Controllers\API\GitftController::class, 'editGiftId']);
  });
  Route::group(['prefix' => 'deposit'], function () {
    Route::get('/getDepositList', [App\Http\Controllers\API\DepositController::class, 'depositList']);
    Route::post('/cancelDeposit', [App\Http\Controllers\API\DepositController::class, 'cancelDeposit']);
    Route::post('/approvedDeposit', [App\Http\Controllers\API\DepositController::class, 'approvedDeposit']);
  });
  Route::group(['prefix' => 'trade'], function () {
    Route::get('/tradinghistory', [App\Http\Controllers\API\TradingController::class, 'tradinghistory']);
    Route::get('/cryptohistory', [App\Http\Controllers\API\TradingController::class, 'cryptohistory']);
    Route::get('/mininghistory', [App\Http\Controllers\API\TradingController::class, 'mininghistory']);
    Route::post('/traderow', [App\Http\Controllers\API\TradingController::class, 'traderow']);
    Route::post('/miningRow', [App\Http\Controllers\API\TradingController::class, 'miningRow']);
    Route::post('/checkCryprtoRow', [App\Http\Controllers\API\TradingController::class, 'checkCryprtoRow']);
    Route::post('/updateCrypto', [App\Http\Controllers\API\TradingController::class, 'updateCrypto']);
    Route::post('/updateTrade', [App\Http\Controllers\API\TradingController::class, 'updateTrade']);
    Route::post('/updateMining', [App\Http\Controllers\API\TradingController::class, 'updateMining']);
    // Route::post('/approvedDeposit', [App\Http\Controllers\API\DepositController::class, 'approvedDeposit']);
  });
  Route::group(['prefix' => 'withdrawal'], function () {
    Route::get('/getWithdrawalList', [App\Http\Controllers\API\WithdrawalController::class, 'withdrawalList']);
    Route::post('/cancel', [App\Http\Controllers\API\WithdrawalController::class, 'cancel']);
    Route::post('/approved', [App\Http\Controllers\API\WithdrawalController::class, 'approved']);
  });
  Route::group(['prefix' => 'member'], function () {
    Route::post('/insertkyc', [App\Http\Controllers\API\UserController::class, 'insertkyc']);
    Route::get('/getMemberData', [App\Http\Controllers\API\UserController::class, 'getMemberData']);
    Route::get('/getallUsersList', [App\Http\Controllers\API\UserController::class, 'AllUsersList']);
    Route::get('/getKycData', [App\Http\Controllers\API\UserController::class, 'getKycData']);
    Route::post('/searchIPfinder', [App\Http\Controllers\API\UserController::class, 'searchIPfinder']);
    Route::post('/approvedKyc', [App\Http\Controllers\API\UserController::class, 'approvedKyc']);
  });
  Route::group(['prefix' => 'user'], function () {
    Route::post('/getfiles', [App\Http\Controllers\API\UserController::class, 'getFiles']);
    Route::get('/getLiveStreming', [App\Http\Controllers\API\UserController::class, 'getLiveStreming']);
    Route::post('/getScheduleList', [App\Http\Controllers\API\UserController::class, 'getScheduleList']);
    Route::get('/getTimeFormat', [App\Http\Controllers\API\UserController::class, 'getTimeFormat']);
    Route::get('/getUserData', [App\Http\Controllers\API\UserController::class, 'getUsersData']);
    Route::post('/addUser', [App\Http\Controllers\API\UserController::class, 'addUser']);
    Route::post('/updateUser', [App\Http\Controllers\API\UserController::class, 'updateUser']);
    Route::get('/getHosterList', [App\Http\Controllers\API\UserController::class, 'getHosterList']);
    Route::get('/getActiveHostList', [App\Http\Controllers\API\UserController::class, 'getActiveHostList']);
    Route::get('/role_check/{id}', [App\Http\Controllers\API\UserController::class, 'roleCheck']);
    Route::get('/customerRow/{id}', [App\Http\Controllers\API\UserController::class, 'customerRow']);
    Route::get('/editUserId/{id}', [App\Http\Controllers\API\UserController::class, 'editUserId']);
    Route::get('/editAdsId/{id}', [App\Http\Controllers\API\UserController::class, 'editAdsId']);
    Route::get('/checkUserDetails/{id}', [App\Http\Controllers\API\UserController::class, 'checkUserDetails']);
    Route::get('/getRoleList', [App\Http\Controllers\API\UserController::class, 'getRoleList']);
    Route::get('/getUsersList', [App\Http\Controllers\API\UserController::class, 'getUsersList']);
    Route::post('/saveRole', [App\Http\Controllers\API\UserController::class, 'saveRole']);
    Route::get('/getcountryList', [App\Http\Controllers\API\ProfileController::class, 'getcountryList']);
    Route::get('/getCompanySetting', [App\Http\Controllers\API\ProfileController::class, 'getCompanySetting']);
    Route::post('/updateprofile', [App\Http\Controllers\API\ProfileController::class, 'updateprofile']);
    Route::post('/removeUser', [App\Http\Controllers\API\ProfileController::class, 'removeUser']);
    Route::post('/checkEmail', [App\Http\Controllers\API\ProfileController::class, 'checkEmail']);
    Route::post('/checkPhone', [App\Http\Controllers\API\ProfileController::class, 'checkPhone']);
    Route::post('/updateCompanySetting', [App\Http\Controllers\API\ProfileController::class, 'updateCompanySetting']);
    Route::post('/updatePassword', [App\Http\Controllers\API\ProfileController::class, 'updatePassword']);
    Route::post('/updateUserPassword', [App\Http\Controllers\API\ProfileController::class, 'updateUserPassword']);
    Route::get('/getLogActivity', [App\Http\Controllers\API\UserController::class, 'getLogActivity']);
  });
  Route::group(['prefix' => 'post'], function () {
    Route::post('/postInsert', [App\Http\Controllers\API\PostController::class, 'postInsert']);
    Route::post('/livepostInsert', [App\Http\Controllers\API\PostController::class, 'livepostInsert']);
    Route::post('/gamesPostInsert', [App\Http\Controllers\API\PostController::class, 'gamesPostInsert']);
    Route::post('/postUpdate', [App\Http\Controllers\API\PostController::class, 'postUpdate']);
    Route::post('/postUpdateLive', [App\Http\Controllers\API\PostController::class, 'postUpdateLive']);
    Route::get('/getPostList', [App\Http\Controllers\API\PostController::class, 'getPostList']);
    Route::get('/getLivePostList', [App\Http\Controllers\API\PostController::class, 'getLivePostList']);
    Route::get('/getGallaryList', [App\Http\Controllers\API\PostController::class, 'getGallaryList']);
    Route::get('/limitPost', [App\Http\Controllers\API\PostController::class, 'limitPost']);
    Route::get('/getTotalCount', [App\Http\Controllers\API\PostController::class, 'getTotalCount']);
    Route::post('/removePost', [App\Http\Controllers\API\PostController::class, 'removePost']);
    Route::get('/tradehistory', [App\Http\Controllers\API\PostController::class, 'tradehistory']);
    Route::post('/categoryRemove', [App\Http\Controllers\API\PostController::class, 'categoryRemove']);
    Route::post('/htagRemove', [App\Http\Controllers\API\PostController::class, 'htagRemove']);
    Route::get('/editPostId/{id}', [App\Http\Controllers\API\PostController::class, 'editPostId']);
    Route::get('/editGallaryId/{id}', [App\Http\Controllers\API\PostController::class, 'editGallaryId']);
    Route::get('/findMultipleThumnail/{id}', [App\Http\Controllers\API\PostController::class, 'findMultipleThumnail']);
    Route::post('/dueReport', [App\Http\Controllers\API\PostController::class, 'dueReport']);
    Route::post('/dueReportMoney', [App\Http\Controllers\API\PostController::class, 'dueReportMoney']);
    Route::post('/profitReport', [App\Http\Controllers\API\PostController::class, 'profitReport']);

    Route::post('/profitReportMoney', [App\Http\Controllers\API\PostController::class, 'profitReportMoney']);
    Route::post('/profitReportOthers', [App\Http\Controllers\API\PostController::class, 'profitReportOthers']);
    Route::post('/deReportOthers', [App\Http\Controllers\API\PostController::class, 'deReportOthers']);

    
    Route::post('/deleteThumbnail', [App\Http\Controllers\API\PostController::class, 'deleteThumbnail']);
    Route::post('/featchVideoHtag', [App\Http\Controllers\API\PostController::class, 'featchVideoHtag']);
    Route::get('/selectedCategoryList/{id}', [App\Http\Controllers\API\PostController::class, 'selectedCategoryList']);
    Route::get('/selectedHTagList/{id}', [App\Http\Controllers\API\PostController::class, 'selectedHTagList']);
    Route::post('/gallaryInsert', [App\Http\Controllers\API\PostController::class, 'gallaryInsert']);
  });
  //token/tokenPackages
  Route::group(['prefix' => 'bank'], function () {
    Route::post('/bankInsert', [App\Http\Controllers\API\BankController::class, 'bankInsert']);
    Route::get('/bank-list', [App\Http\Controllers\API\BankController::class, 'tokenPackagesList']);
    Route::post('/removeToken', [App\Http\Controllers\API\BankController::class, 'removeToken']);
    Route::get('/editBank/{id}', [App\Http\Controllers\API\BankController::class, 'editBank']);
  });
});
Route::controller(AuthController::class)->group(function () {
  Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);
  Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
  Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});