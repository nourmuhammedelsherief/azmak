<?php

use Illuminate\Support\Facades\Route;

use \Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

// restaurant uses
use \App\Http\Controllers\RestaurantController\BranchController;
use \App\Http\Controllers\RestaurantController\RestaurantController as UserRestaurant;
use \App\Http\Controllers\RestaurantController\Restaurant\LoginController as ResLogin;
use \App\Http\Controllers\RestaurantController\Restaurant\ForgotPasswordController as ResForgetPassword;
use \App\Http\Controllers\RestaurantController\Restaurant\ResetPasswordController as ResResetPassword;
use \App\Http\Controllers\RestaurantController\HomeController as ResHome;
use \App\Http\Controllers\RestaurantController\TableController;
use \App\Http\Controllers\RestaurantController\MenuCategoryController;
use \App\Http\Controllers\RestaurantController\ModifierController;
use \App\Http\Controllers\RestaurantController\OptionController;
use \App\Http\Controllers\RestaurantController\EmployeeController;
use \App\Http\Controllers\RestaurantController\ProductController;
use \App\Http\Controllers\RestaurantController\ProductOptionController;
use \App\Http\Controllers\RestaurantController\SocialController;
use \App\Http\Controllers\RestaurantController\DeliveryController;
use \App\Http\Controllers\RestaurantController\SensitivityController;
use \App\Http\Controllers\RestaurantController\OfferController;
use \App\Http\Controllers\RestaurantController\SliderController;
use \App\Http\Controllers\RestaurantController\SubCategoryController;
use \App\Http\Controllers\RestaurantController\PosterController;
use \App\Http\Controllers\RestaurantController\ResBranchesController;
use \App\Http\Controllers\RestaurantController\ProductSizeController;
use \App\Http\Controllers\RestaurantController\ProductPhotoController;
use \App\Http\Controllers\RestaurantController\RestaurantSettingController;
use \App\Http\Controllers\RestaurantController\OrderSettingDaysController;
use \App\Http\Controllers\RestaurantController\IntegrationController;
use \App\Http\Controllers\RestaurantController\RestaurantOrderSellerCodeController;
use \App\Http\Controllers\RestaurantController\OrderFoodicsDaysController;
use App\Http\Controllers\RestaurantController\PeriodController;
use App\Http\Controllers\RestaurantController\RestaurantEmployeeController;
use App\Http\Controllers\RestaurantController\RestaurantRateUsController;
use App\Http\Controllers\RestaurantController\RestaurantOrderSettingRangeController;


use App\Http\Controllers\RestaurantController\AdsController;
use App\Http\Controllers\RestaurantController\BackupController;
use App\Http\Controllers\RestaurantController\BankController as RestaurantControllerBankController;
use App\Http\Controllers\RestaurantController\RestaurantContactUsController;
use App\Http\Controllers\RestaurantController\RestaurantContactUsLinkController;
use App\Http\Controllers\RestaurantController\RestaurantOrderSellerCodeWhatsappController;
use App\Http\Controllers\RestaurantController\ServiceProviderController as RestaurantControllerServiceProviderController;
use App\Http\Controllers\RestaurantController\ServiceStoreController;
use App\Http\Controllers\RestaurantController\SmsController;
use App\Http\Controllers\RestaurantController\TermsConditionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;


////////////////////////////////////////////////////////////    site controllers //////////
use App\Http\Controllers\WebsiteController\HomeController as AZHome;
use App\Http\Controllers\WebsiteController\ContactUsController;
use App\Http\Controllers\WebsiteController\UserController;
use App\Http\Controllers\WebsiteController\CartController;

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



Route::get('locale/{locale}', function (Request $request , $locale) {
    session()->put('locale', $locale);
    App::setLocale($locale);
    return redirect()->back();
})->name('language');
Route::get('restaurant/locale/{locale}', function (Request $request, $locale) {
    session()->put('lang_restaurant', $locale);
    App::setLocale($locale);
    return redirect()->back();
})->name('restaurant.language');


/**
 *  Start @user routes
 */

Route::get('/restaurants/{res_name}' , [AZHome::class , 'index']);
Route::match(['get', 'post'],'/restaurants/branch/{branch_name?}' , [AZHome::class , 'home'])->name('homeBranch');
Route::get('/restaurants/{res}/{branch_name}/{cat?}' , [AZHome::class , 'homeBranch'])->name('homeBranchIndex');
Route::get('/restaurantAZ/{res_name}/terms&conditions/{branch?}' , [AZHome::class , 'terms'])->name('restaurantTerms');
Route::get('/restaurantAZ/{res_name}/about_us/{branch?}' , [AZHome::class , 'about'])->name('restaurantAboutAzmak');
Route::get('/restaurant_contact_us/{res_name}/{branch?}' , [ContactUsController::class , 'index'])->name('restaurantVisitorContactUs');
Route::post('/restaurant_contact_us/{res_name}/send' , [ContactUsController::class , 'contact_us'])->name('restaurantVisitorContactUsSend');
Route::get('/restaurantsAZ/products/{id}' , [AZHome::class , 'product_details'])->name('product_details');
Route::get('/share/restaurantsAZ/products/{id}' , [AZHome::class , 'share_product'])->name('product_details_share');

// user routes
Route::get('user/restaurants/{res}/join_us/{branch?}' , [UserController::class , 'join_us'])->name('AZUserRegister');
Route::post('user/restaurants/{res}/join_us/{branch?}' , [UserController::class , 'register'])->name('AZUserRegisterSubmit');

Route::get('user/restaurants/{res}/login/{branch?}' , [UserController::class , 'show_login'])->name('AZUserLogin');
Route::post('user/restaurants/{res}/login/{branch?}' , [UserController::class , 'login'])->name('AZUserLoginSubmit');

Route::group(['middleware' => 'auth:web'], function () {
    Route::post('logout', [UserController::class, 'logout'])->name('azUser.logout');
    Route::get('user/restaurants/{res}/profile/{branch?}' , [UserController::class , 'profile'])->name('AZUserProfile');
    Route::post('user/restaurants/{res}/profile/{branch?}' , [UserController::class , 'edit_profile'])->name('AZUserProfileUpdate');
    Route::post('user/restaurants/add_to_cart' , [CartController::class , 'add_to_cart'])->name('addToAZCart');

});

/**
 *  End @user routes
 */


/**
 * Start @restaurant Routes
 */

Route::match(['get', 'post'], 'restaurants-registration/{code}', [ResHome::class, 'sellerRegisters'])->name('restaurant.seller.register');
Route::match(['post'], 'restaurants-registration/{code}/verification-code/{id}', [ResHome::class, 'sellerVerificationPhone'])->name('restaurant.seller.register.verification');
Route::match(['get', 'post'], 'restaurants-registration/{code}/payment/{id}', [ResHome::class, 'sellerRestaurantPayment'])->name('restaurant.seller.register.payment');

Route::get('/restaurants-registration/{id1?}/{id2?}', [ResHome::class, 'sellerCodeRestaurantMyFatoora'])->name('restaurant.seller.register.myfatoora');

Route::prefix('restaurant')->group(function () {

    Route::get('check-email-or-phone', [ResHome::class, 'checkEmailAndPhone'])->name('restaurant.check');
    Route::get('register/step1', [ResHome::class, 'show_register'])->name('restaurant.step1Register');
    Route::get('register-gold/step1', [ResHome::class, 'show_register'])->name('restaurant.step1Registergold');
    Route::post('store/step1', [ResHome::class, 'submit_step1'])->name('restaurant.submit_step1');
    Route::match(['get', 'post'], 'resend_code/{id}', [ResHome::class, 'resend_code'])->name('restaurant.resend_code');
    Route::get('phone_verification/{id}', [ResHome::class, 'phone_verification'])->name('restaurant.phone_verification');
    Route::post('phone_verification/{id}', [ResHome::class, 'code_verification'])->name('restaurant.code_verification');
    Route::get('register/step2/{id}', [ResHome::class, 'storeStep2'])->name('restaurant.step2Register');
    Route::post('store/step2/{id}', [ResHome::class, 'submitStep2'])->name('restaurant.submitStep2');
    Route::get('password/forget', [ResHome::class, 'forget_password'])->name('restaurant.password.phone');
    Route::post('password/forget/submit', [ResHome::class, 'forget_password_submit'])->name('forget_password_submit');
    Route::get('password/verification/{res}', [ResHome::class, 'password_verification'])->name('forget_password_verification');
    Route::post('password/verification/{res}/submit', [ResHome::class, 'password_verification_post'])->name('password_verification_post');
    Route::get('password/reset/{res}', [ResHome::class, 'reset_password'])->name('password_reset_restaurant');
    Route::post('password/reset/{res}', [ResHome::class, 'reset_password_post'])->name('password_reset_restaurant_post');
    Route::get('login', [ResLogin::class, 'showLoginForm'])->name('restaurant.login');
    Route::post('login', [ResLogin::class, 'login'])->name('restaurant.login.submit');
    Route::get('password/reset', [ResForgetPassword::class, 'showLinkRequestForm'])->name('restaurant.password.request');
    Route::post('password/email', [ResForgetPassword::class, 'sendResetLinkEmail'])->name('restaurant.password.email');
    Route::get('password/reset/{token}', [ResResetPassword::class, 'showResetForm'])->name('restaurant.password.reset');
    Route::post('password/reset', [ResResetPassword::class, 'reset'])->name('restaurant.password.update');
    Route::post('logout', [ResLogin::class, 'logout'])->name('restaurant.logout');

    Route::post('{id}/rate_us', [FeedbackController::class, 'rateUs'])->name('restaurant.rateUs');
    Route::post('not_allowed_ads', [AdsController::class, 'notWatchAgain'])->name('ads.not_allowed');
    Route::group(['middleware' => 'auth:restaurant'], function () {
        Route::get('/home', [ResHome::class, 'index'])->name('restaurant.home');



        // whatsapp_branches
        Route::resource('/whatsapp_branches', WhatsappBranchController::class, []);
        Route::get('/whatsapp_branches/delete/{id}', [WhatsappBranchController::class, 'destroy']);

        Route::match(['get', 'post'], '/banks-settings', [RestaurantControllerBankController::class, 'settings'])->name('restaurant.banks.setting');
        Route::resource('/banks', RestaurantControllerBankController::class, ['as' => 'restaurant']);
        Route::get('/banks/delete/{id}', [RestaurantControllerBankController::class, 'destroy']);

        // party-branches

        Route::resource('/party-branch', PartyBranchController::class, ['as' => 'restaurant']);
        Route::get('/party-branch/delete/{id}', [PartyBranchController::class, 'destroy']);
        // party
        Route::match(['get', 'post'], '/party/payment-settings', [PartyController::class, 'servicesIndex'])->name('restaurant.party.setting.payment');
        Route::match(['get', 'post'], '/party/payment-cash', [PartyController::class, 'cashSettings'])->name('restaurant.party.setting.cash');
        Route::match(['get', 'post'], '/party/settings', [PartyController::class, 'getSettings'])->name('restaurant.party.settings');
        Route::resource('/party', PartyController::class, ['as' => 'restaurant']);
        Route::get('/party/delete/{id}', [PartyController::class, 'destroy']);

        Route::get('party-order/confirm/{id}/{code}', [PartyController::class, 'confirmOrder']);
        Route::get('party-order/{order}/bank-confirm', [PartyOrderController::class, 'acceptBankOrder'])->name('restaurant.party.bank-confirm');
        Route::post('party-order/cancel/{id}', [PartyController::class, 'cancelOrder'])->name('restaurant.party.cancel');
        Route::resource('/party-order', PartyOrderController::class, ['as' => 'restaurant'])->only(['index']);


        // rate us routes
        Route::resource('restaurant_rate_us' , RestaurantRateUsController::class , []);
        Route::get('restaurant_rate_us/delete/{id}' ,   [RestaurantRateUsController::class,'destroy']);
        Route::get('restaurant_our_rates' ,   [RestaurantRateUsController::class,'our_rates'])->name('restaurant_our_rates');
        Route::get('restaurant_our_rates/delete/{id}' ,   [RestaurantRateUsController::class,'delete_our_rate']);
        Route::get('show_restaurant_rate/{id}' ,   [RestaurantRateUsController::class,'show_restaurant_rate'])->name('show_restaurant_rate');



        Route::resource('/related_code', HeaderFooterController::class, ['as' => 'restaurant']);
        Route::get('/related_code/delete/{id}', [HeaderFooterController::class, 'destroy']);

        Route::resource('ads', AdsController::class, ['as' => 'restaurant'])->only(['create', 'store', 'edit', 'update']);
        Route::get('ads/delete/{id}', [AdsController::class, 'delete'])->name('restaurant.ads.delete');
        Route::get('ads', [AdsController::class, 'mainIndex'])->name('restaurant.ads.index');

        // link_contact_us
        Route::resource('link_contact_us', RestaurantContactUsLinkController::class, ['as' => 'restaurant'])->only(['create', 'store', 'edit', 'update', 'index']);
        Route::get('link_contact_us/delete/{id}', [RestaurantContactUsLinkController::class, 'delete'])->name('restaurant.link_contact_us.delete');
        Route::get('link_contact_us/change_status/{id}', [RestaurantContactUsLinkController::class, 'changeStatus'])->name('restaurant.link_contact_us.changeStatus');
        Route::get('link_contact_us/{id}', [RestaurantContactUsLinkController::class, 'show'])->name('restaurant.link_contact_us.show');


        // contact_us
        Route::resource('contact_us', RestaurantContactUsController::class, ['as' => 'restaurant'])->only(['create', 'store', 'edit', 'update', 'index']);
        Route::get('contact_us/delete/{id}', [RestaurantContactUsController::class, 'delete'])->name('restaurant.contact_us.delete');
        Route::match(['get', 'post'], 'contact_us/settings', [RestaurantContactUsController::class, 'setting'])->name('restaurant.contact_us.setting');
        Route::match(['get', 'post'], 'contact_us/barcode', [RestaurantContactUsController::class, 'setting'])->name('restaurant.contact_us.barcode');


    });

    Route::group(['middleware' => ['web']], function () {
        Route::controller(UserRestaurant::class)->group(function () {
            Route::get('/profile', 'my_profile')->name('RestaurantProfile');
            Route::get('/barcode', 'barcode')->name('RestaurantBarcode');
            Route::get('/pdf-barcode', 'barcodePDF')->name('RestaurantBarcodePDF');
            Route::get('/urgent-barcode', 'urgentBarcode')->name('RestauranturgentBarcode');
            Route::post('/profileEdit/{id?}', 'my_profile_edit')->name('RestaurantUpdateProfile');
            Route::post('/updateBarcode/{id?}', 'updateBarcode')->name('RestaurantUpdateBarcode');
            Route::match(['get', 'post'], '/my-information/{id?}', 'updateMyInformation')->name('RestaurantUpdateInformation');
            Route::get('/subscription/{id}/{admin?}', 'renew_subscription')->name('renewSubscription');
            Route::get('/subscription/{id}/renew/{admin?}', 'store_subscription')->name('renewSubscriptionPost');
            Route::post('/subscription/{id}/bank/{admin?}', 'renewSubscriptionBank')->name('renewSubscriptionBank');
            Route::get('/check-status/{id1?}/{id2?}/{admin?}', 'check_status')->name('checkRestaurantStatus');
            Route::get('/check-service-status/{id1?}/{id2?}', 'check_service_status')->name('checkServiceStatus');
            Route::post('/profileChangePass/{id?}', 'change_pass_update')->name('RestaurantChangePassword');
            Route::post('/RestaurantChangeExternal/{id?}', 'RestaurantChangeExternal')->name('RestaurantChangeExternal');
            Route::get('/information', 'information')->name('information');
            Route::post('/information', 'store_information')->name('store_information');
            Route::post('/RestaurantChangeColors/{id}', 'RestaurantChangeColors')->name('RestaurantChangeColors');
            Route::post('/RestaurantChangeBioColors/{id}', 'RestaurantChangeBioColors')->name('RestaurantChangeBioColors');

            Route::get('/reset_to_main/{id}', 'Reset_to_main')->name('Reset_to_main');
            Route::get('/Reset_to_bio_main/{id}', 'Reset_to_bio_main')->name('Reset_to_bio_main');

            Route::get('/myfatoora_token', 'myfatoora_token')->name('myfatoora_token');
            Route::post('/myfatoora_token', 'update_myfatoora_token')->name('myfatoora_token.update');
            Route::get('/my_restaurant_users', 'my_restaurant_users')->name('my_restaurant_users');



            // restaurant colors
        });
        //branches routes
        Route::resource('/branches', BranchController::class, []);
        Route::get('/branches/delete/{id}', [BranchController::class, 'destroy']);
        Route::get('/branches/get_branch_payment/{id}', [BranchController::class, 'get_branch_payment'])->name('get_branch_payment');
        Route::post('/branches/get_branch_payment/{id}', [BranchController::class, 'store_branch_payment'])->name('store_branch_payment');
        Route::get('/branches/subscription/{id}/{country}/{subscription}', [BranchController::class, 'renewSubscriptionBankGet'])->name('renewSubscriptionBankGet');
        Route::post('/branches/subscription/{id}', [BranchController::class, 'renewSubscriptionBank'])->name('renewBranchSubscriptionBank');
        Route::get('/branches/{id}/barcode', [BranchController::class, 'barcode'])->name('branchBarcode');
        Route::get('/branches/{id}/print-menu', [BranchController::class, 'printMenu'])->name('branchPrintMenu');
        Route::get('/foodics/branches', [BranchController::class, 'foodics_branches'])->name('foodics_branches');
        Route::match(['get', 'post'], '/foodics/branches/{id}/edit', [BranchController::class, 'foodicsBranchEdit'])->name('foodics_branches.edit');
        Route::get('/foodics/branch/{id}/{active}', [BranchController::class, 'active_foodics_branch'])->name('active_foodics_branch');
        Route::get('/foodics/discounts/{id}', [BranchController::class, 'discounts'])->name('foodics_discounts');
        Route::get('/branches/showBranchCart/{branch_id}/{state}', [BranchController::class, 'showBranchCart'])->name('showBranchCart');
        Route::get('/branches/stopBranchMenu/{branch_id}/{state}', [BranchController::class, 'stopBranchMenu'])->name('stopBranchMenu');

        Route::get('/copy_menu/branch', [BranchController::class, 'copy_menu'])->name('copyBranchMenu');
        Route::post('/copy_menu/branch', [BranchController::class, 'copy_menu_post'])->name('copyBranchMenuPost');
        Route::get('/print_invoice/{id}', [BranchController::class, 'print_invoice'])->name('print_invoice');

        Route::group(['middleware' => 'auth:restaurant'], function () {
            // Table Routes
            Route::resource('/tables', TableController::class, []);
            Route::get('/service_tables/create/{id}', [TableController::class, 'create_service_table'])->name('createServiceTable');
            Route::get('/foodics/tables/{id}',  [TableController::class, 'foodics_tables'])->name('FoodicsOrderTable');
            // Foodics table order
            Route::get('/foodics/orders',  [TableController::class, 'tableOrder'])->name('FoodicsTableOrder');
            Route::get('/foodics/foodics-info',  [TableController::class, 'getFoodicsDetails'])->name('FoodicsTableInfo');
            Route::get('/foodics/create-foodics-order',  [TableController::class, 'createFoodicsOrder'])->name('CreateFoodicsOrder');
            Route::get('/order/details',  [TableController::class, 'orderDetails'])->name('orderDetails');
            Route::get('/tables/delete/{id}', [TableController::class, 'destroy']);
            Route::get('/tables/barcode/{id}/show', [TableController::class, 'show_barcode'])->name('showTableBarcode');
            Route::get('/whatsApp/tables/{id}',  [TableController::class, 'service_tables'])->name('WhatsAppTable');
            Route::get('/easymenu/tables/{id}',  [TableController::class, 'service_tables'])->name('EasyMenuTable');


            // Foodics Order
            Route::get('/foodics-orders',  [RestaurantControllerOrderController::class, 'foodicsOrder'])->name('FoodicsOrder');
            Route::get('/foodics-orders/foodics-info',  [RestaurantControllerOrderController::class, 'getFoodicsDetails'])->name('FoodicsOrderInfo');
            Route::get('/foodics-orders/create-foodics-order',  [RestaurantControllerOrderController::class, 'createFoodicsOrder'])->name('CreateFoodicsOrder');
            Route::get('foodics-orders/order/details',  [RestaurantControllerOrderController::class, 'orderDetails'])->name('foodicsOrderDetails');

            // Restaurant Employee Routes
            Route::resource('/restaurant_employees', RestaurantEmployeeController::class, []);
            Route::get('/restaurant_employees/delete/{id}', [RestaurantEmployeeController::class, 'destroy']);


            // MenuCategory Routes
            Route::resource('/menu_categories', MenuCategoryController::class, []);
            Route::get('/branch/menu_categories/{id}', [MenuCategoryController::class, 'branch_categories'])->name('BranchMenuCategory');

            Route::get('/menu_categories/delete/{id}', [MenuCategoryController::class, 'destroy']);
            Route::get('/menu_categories/deleteCategoryPhoto/{id}', [MenuCategoryController::class, 'deleteCategoryPhoto'])->name('deleteCategoryPhoto');

            Route::get('/menu_categories/active/{id}/{active}', [MenuCategoryController::class, 'activate'])->name('activeMenuCategory');
            Route::get('/menu_categories/arrange/{id}', [MenuCategoryController::class, 'arrange'])->name('arrangeMenuCategory');
            Route::post('/menu_categories/arrange/{id}', [MenuCategoryController::class, 'arrange_submit'])->name('arrangeSubmitMenuCategory');
            Route::get('/menu_categories/copy/{id}', [MenuCategoryController::class, 'copy_category'])->name('copyMenuCategory');
            Route::post('/menu_categories/copy', [MenuCategoryController::class, 'copy_category_post'])->name('copyMenuCategoryPost');
            // Modifiers Routes
            Route::resource('/modifiers', ModifierController::class, []);
            Route::get('/modifiers/delete/{id}', [ModifierController::class, 'destroy']);
            Route::get('/modifiers/active/{id}/{is_ready}', [ModifierController::class, 'active'])->name('activeModifier');
            // Options Routes
            Route::resource('/additions', OptionController::class, []);
            Route::get('/additions/delete/{id}', [OptionController::class, 'destroy']);
            Route::get('/additions/active/{id}/{is_active}', [OptionController::class, 'active'])->name('activeOption');
            // socials Routes
            Route::resource('/socials', SocialController::class, []);
            Route::get('/socials/delete/{id}', [SocialController::class, 'destroy']);

            // Restaurant Order Seller Codes Routes
            Route::resource('/order_seller_codes', RestaurantOrderSellerCodeController::class, []);
            Route::get('/order_seller_codes/delete/{id}', [RestaurantOrderSellerCodeController::class, 'destroy']);

            Route::resource('whatsapp/order_seller_codes', RestaurantOrderSellerCodeWhatsappController::class, [])->names([
                'index'   => 'restaurant.whatsapp.order_seller_codes.index',
                'create'  => 'restaurant.whatsapp.order_seller_codes.create',
                'store'   => 'restaurant.whatsapp.order_seller_codes.store',
                'show'    => 'restaurant.whatsapp.order_seller_codes.show',
                'edit'    => 'restaurant.whatsapp.order_seller_codes.edit',
                'update'  => 'restaurant.whatsapp.order_seller_codes.update',
                'destroy' => 'restaurant.whatsapp.order_seller_codes.destroy',
            ]);;
            Route::get('whatsapp/order_seller_codes/delete/{id}', [RestaurantOrderSellerCodeWhatsappController::class, 'destroy']);

            // employees Routes
            Route::resource('/employees', EmployeeController::class, []);
            Route::get('/employees/delete/{id}', [EmployeeController::class, 'destroy']);

            // deliveries Routes
            Route::resource('/deliveries', DeliveryController::class, []);
            Route::get('/deliveries/delete/{id}', [DeliveryController::class, 'destroy']);

            // sensitivities Routes
            Route::resource('/sensitivities', SensitivityController::class, []);
            Route::get('/sensitivities/delete/{id}', [SensitivityController::class, 'destroy']);

            // sliders Routes
            Route::post('/sliders/slider-title', [SliderController::class, 'storeSliderTitle'])->name('sliders.title');
            Route::resource('/sliders', SliderController::class, []);
            Route::get('/sliders/delete/{id}', [SliderController::class, 'destroy']);
            Route::post('/sliders/upload-video', [SliderController::class, 'uploadVideo'])->name('sliders.uploadVideo');
            Route::get('/sliders/stopSlider/{id}/{status}', [SliderController::class, 'stopSlider'])->name('stopSlider');


            // res_branches Routes
            Route::resource('/res_branches', ResBranchesController::class, []);
            Route::get('/res_branches/delete/{id}', [ResBranchesController::class, 'destroy']);

            // sub_categories Routes
            Route::controller(SubCategoryController::class)->group(function () {
                Route::get('/sub_categories/{id}', 'index')->name('sub_categories.index');
                Route::get('/sub_categories/create/{id}', 'create')->name('sub_categories.create');
                Route::post('/sub_categories/store/{id}', 'store')->name('sub_categories.store');
                Route::get('/sub_categories/edit/{id}', 'edit')->name('sub_categories.edit');
                Route::post('/sub_categories/update/{id}', 'update')->name('sub_categories.update');
                Route::get('/sub_categories/delete/{id}', [SubCategoryController::class, 'destroy']);
            });

            // home_icons

            Route::resource('home_icons', IconController::class, ['as' => 'restaurant']);
            Route::get('/home_icons/{icon}/active/{status}', [IconController::class, 'changeStatus'])->name('restaurant.home_icons.change_status');
            Route::get('/home_icons/{icon}/contact-active/{status}', [IconController::class, 'changeContactStatus'])->name('restaurant.home_icons.change_contact_status');
            Route::get('/home_icons/delete/{id}', [IconController::class, 'destroy']);
            // posters Routes
            Route::resource('/posters', PosterController::class, []);
            Route::get('/posters/delete/{id}', [PosterController::class, 'destroy']);

            // sms_methods
            Route::match(['get', 'post'], '/sms/settings', [SmsController::class, 'settings'])->name('restaurant.sms.settings');
            Route::match(['get', 'post'], '/sms/send', [SmsController::class, 'sendSms'])->name('restaurant.sms.sendSms');
            Route::match(['get'], '/sms/history', [SmsController::class, 'index'])->name('restaurant.sms.index');
            Route::match(['get'], '/sms/show/phone', [SmsController::class, 'showDetails'])->name('restaurant.sms.phone');
            Route::match(['get'], '/sms/delete/{id}', [SmsController::class, 'delete'])->name('restaurant.sms.delete');


            // Offer Routes
            Route::resource('/offers', OfferController::class, []);
            Route::get('/offers/delete/{id}', [OfferController::class, 'destroy']);
            Route::get('/offers/photo/{id}/remove', [OfferController::class, 'remove_photo'])->name('imageOfferRemove');

            Route::post('/sub_menu_category/update-image', [SubCategoryController::class, 'uploadImage'])->name('restaurant.sub_menu_category.update_image');
            Route::post('/menu_category/update-image', [MenuCategoryController::class, 'uploadImage'])->name('restaurant.menu_category.update_image');
            Route::post('/profile/update-image', [UserRestaurant::class, 'uploadImage'])->name('restaurant.profile.update_image');
            Route::post('/ads/update-image', [AdsController::class, 'uploadImage'])->name('restaurant.ads.update_image');
            Route::post('/ads/upload-video', [AdsController::class, 'uploadVideo'])->name('ads.uploadVideo');
            Route::post('/offer/update-image', [OfferController::class, 'uploadImage'])->name('restaurant.offer.update_image');
            // products Routes
            Route::resource('/products', ProductController::class, []);
            Route::get('/branch/products/{id}',  [ProductController::class, 'branch_products'])->name('BranchProducts');
            Route::get('/get/branch_menu_categories/{id}',  [ProductController::class, 'branch_menu_categories'])->name('branch_menu_categories');
            Route::get('/get_menu_sub_categories/{id}',  [ProductController::class, 'get_menu_sub_categories'])->name('get_menu_sub_categories');

            Route::post('/products/update-image', [ProductController::class, 'updateProductImage'])->name('restaurant.product.update_image');
            Route::get('/products/arrange/{id}', [ProductController::class, 'arrange'])->name('arrangeProduct');
            Route::post('/products/arrange/{id}', [ProductController::class, 'arrange_submit'])->name('arrangeSubmitProduct');
            Route::get('/products/copy/{id}', [ProductController::class, 'copy_product'])->name('copyProduct');
            Route::post('/products/copy/{id}', [ProductController::class, 'copy_product_submit'])->name('submitCopyProduct');

            Route::get('/products/delete/{id}', [ProductController::class, 'destroy']);
            Route::get('/products/deleteProductPhoto/{id}', [ProductController::class, 'deleteProductPhoto'])->name('deleteProductPhoto');
            Route::get('/products/active/{id}/{active}', [ProductController::class, 'active'])->name('activeProduct');
            Route::get('/products/available/{id}/{available}', [ProductController::class, 'available'])->name('availableProduct');
            Route::post('/products/upload-video', [ProductController::class, 'uploadVideo'])->name('products.uploadVideo');


            // products options routes
            Route::controller(ProductOptionController::class)->group(function () {
                Route::get('/product_options/{id}', 'index')->name('productOption');
                Route::get('/product_options/{id}/create', 'create')->name('createProductOption');
                Route::post('/product_options/{id}/store', 'store')->name('storeProductOption');
                Route::get('/product_options/{id}/edit', 'edit')->name('editProductOption');
                Route::post('/product_options/{id}/update', 'update')->name('updateProductOption');
                Route::get('/product_options/delete/{id}', 'destroy')->name('deleteProductOption');
                Route::delete('/product_options/{product}/delete-all', 'deleteAll')->name('deleteAllProductOption');
            });

            // products sizes routes
            Route::controller(ProductSizeController::class)->group(function () {
                Route::get('/product_sizes/{id}', 'index')->name('productSize');
                Route::get('/product_sizes/{id}/active/{status}', 'changeStatus')->name('productSize.changeStatus');
                Route::get('/product_sizes/{id}/create', 'create')->name('createProductSize');
                Route::post('/product_sizes/{id}/store', 'store')->name('storeProductSize');
                Route::get('/product_sizes/{id}/edit', 'edit')->name('editProductSize');
                Route::post('/product_sizes/{id}/update', 'update')->name('updateProductSize');
                Route::get('/product_sizes/delete/{id}', 'destroy')->name('deleteProductSize');
            });



            Route::get('/history/{id}', [SettingController::class, 'show_restaurant_history'])->name('show_restaurant_history');

            // terms and conditions routes
            Route::get('/terms/conditions', [TermsConditionController::class, 'index'])->name('restaurant.terms_conditions.index');
            Route::post('/terms/conditions/{id}', [TermsConditionController::class, 'update'])->name('restaurant.terms_conditions.update');

            // about azmak routes
            Route::get('/azmak_about', [TermsConditionController::class, 'azmak_about'])->name('restaurant.azmak_about.index');
            Route::post('/azmak_about/{id}', [TermsConditionController::class, 'azmak_about_update'])->name('restaurant.azmak_about.update');

            // about azmak routes
            Route::get('/az_contacts', [TermsConditionController::class, 'az_contacts'])->name('restaurant.az_contacts.index');
            Route::get('/az_contacts/delete/{id}', [TermsConditionController::class, 'delete_az_contact'])->name('restaurant.delete_az_contact');


            // restaurant period Routes
            Route::controller(PeriodController::class)->group(function () {
                Route::get('/periods/{id}', 'index')->name('BranchPeriod');
                Route::get('/periods/{id}/create', 'create')->name('createBranchPeriod');
                Route::post('/periods/{id}/store', 'store')->name('storeBranchPeriod');
                Route::get('/periods/{id}/edit', 'edit')->name('editBranchPeriod');
                Route::post('/periods/{id}/update', 'update')->name('updateBranchPeriod');
                Route::get('/periods/delete/{id}', 'destroy')->name('deleteBranchPeriod');
            });

        });
    });
});
/**
 * End @restaurant Routes
 */
