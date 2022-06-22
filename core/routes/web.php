<?php

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


Route::get('/ipnbtc', 'PaymentController@ipnBchain')->name('ipn.bchain');
Route::post('/ipnpaypal', 'PaymentController@ipnpaypal')->name('ipn.paypal');
Route::post('/ipnperfect', 'PaymentController@ipnperfect')->name('ipn.perfect');
Route::post('/ipnstripe', 'PaymentController@ipnstripe')->name('ipn.stripe');
Route::post('/ipnskrill', 'PaymentController@skrillIPN')->name('ipn.skrill');
Route::post('/ipnflutter', 'PaymentController@flutterIPN')->name('ipn.flutter');
Route::post('/ipnvogue', 'PaymentController@vogueIPN')->name('ipn.vogue');
Route::post('/ipnpaystack', 'PaymentController@paystackIPN')->name('ipn.paystack');
Route::post('/ipncoinpaybtc', 'PaymentController@ipnCoinPayBtc')->name('ipn.coinPay.btc');
Route::post('/ext_transfer', 'UserController@submitpay')->name('submit.pay');

// Front end routes
Route::get('/home', 'FrontendController@index')->name('home');
Route::get('/', 'AdminLoginController@index')->name('admin-unit.loginForm');
Route::get('/faq', 'FrontendController@faq')->name('faq');
Route::get('/about', 'FrontendController@about')->name('about');
Route::get('/blog', 'FrontendController@blog')->name('blog');
Route::get('/terms', 'FrontendController@terms')->name('terms');
Route::get('/privacy', 'FrontendController@privacy')->name('privacy');
Route::get('/page/{id}', 'FrontendController@page');
Route::get('/single/{id}/{slug}', 'FrontendController@article');
Route::get('/cat/{id}/{slug}', 'FrontendController@category');
Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact', ['uses' => 'FrontendController@contactSubmit', 'as' => 'contact-submit']);
Route::post('/about', 'FrontendController@subscribe')->name('subscribe');
Route::post('/py_scheme', 'FrontendController@py_scheme')->name('py_scheme');

// User routes
Auth::routes();

Route::post('/login', 'LoginController@submitlogin')->name('submitlogin');
Route::get('/login', 'LoginController@login')->name('login');
Route::get('/counter', 'Counter@login')->name('counter');
Route::post('/2fa', 'LoginController@submitfa')->name('submitfa');
Route::get('/2fa', 'LoginController@faverify')->name('2fa');
Route::post('/register', 'RegisterController@submitregister')->name('submitregister');
Route::get('/register', 'RegisterController@register')->name('register');
Route::get('/forget', 'UserController@forget')->name('forget');
Route::get('/r_pass', 'UserController@r_pass')->name('r_pass');
Route::group(['prefix' => 'user', ], function () {
    Route::get('authorization', 'UserController@authCheck')->name('user.authorization');   
    Route::post('verification', 'UserController@sendVcode')->name('user.send-vcode');
    Route::post('smsVerify', 'UserController@smsVerify')->name('user.sms-verify');
    Route::post('verify-email', 'UserController@sendEmailVcode')->name('user.send-emailVcode');
    Route::post('postEmailVerify', 'UserController@postEmailVerify')->name('user.email-verify'); 
        Route::group(['middleware'=>'isActive'], function() {
            Route::middleware(['CheckStatus'])->group(function () {
                Route::get('dashboard', 'UserController@dashboard')->name('user.dashboard');
                Route::get('plans', 'UserController@plans')->name('user.plans');
                Route::post('calculate', 'UserController@calculate');
                Route::post('buy', 'UserController@buy');
                Route::post('withdraw-update', 'UserController@withdrawupdate');
                Route::get('profile', 'UserController@profile')->name('user.profile');
                Route::post('kyc', 'UserController@kyc');
                Route::post('account', 'UserController@account');
                Route::post('avatar', 'UserController@avatar');
                Route::get('statement', 'UserController@statement')->name('user.statement');
                Route::get('merchant', 'UserController@merchant')->name('user.merchant');
                Route::get('sender_log', 'UserController@senderlog')->name('user.senderlog');
                Route::get('add-merchant', 'UserController@addmerchant')->name('user.add-merchant');
                Route::get('merchant-documentation', 'UserController@merchant_documentation')->name('user.merchant-documentation');
                Route::post('add-merchant', 'UserController@submitmerchant')->name('submit.merchant');
                Route::get('transfer_process/{id}/{token}', 'UserController@transferprocess')->name('transfer.process');
                Route::get('edit-merchant/{id}', 'UserController@Editmerchant')->name('edit.merchant');
                Route::get('log-merchant/{id}', 'UserController@Logmerchant')->name('log.merchant');
                Route::get('cancel_merchant/{id}', 'UserController@Cancelmerchant')->name('cancel.merchant');
                Route::get('submit_merchant/{id}', 'UserController@Paymerchant')->name('pay.merchant');
                Route::post('editmerchant', 'UserController@updatemerchant')->name('update.merchant');
                Route::get('ticket', 'UserController@ticket')->name('user.ticket');
                Route::post('submit-ticket', 'UserController@submitticket')->name('submit-ticket');
                Route::get('ticket/delete/{id}', 'UserController@Destroyticket')->name('ticket.delete');
                Route::get('reply-ticket/{id}', 'UserController@Replyticket')->name('ticket.reply');
                Route::post('reply-ticket', 'UserController@submitreply');
                Route::get('own_bank', 'UserController@ownbank')->name('user.ownbank');
                Route::post('own_bank', 'UserController@submitownbank')->name('submit.ownbank');
                Route::post('other_bank', 'UserController@submitotherbank')->name('submit.otherbank');
                Route::get('other_bank', 'UserController@otherbank')->name('user.otherbank');
                Route::post('local_preview', 'UserController@submitlocalpreview')->name('submit.localpreview');
                Route::get('local_preview', 'UserController@localpreview')->name('user.localpreview');
                Route::get('fund', 'UserController@fund')->name('user.fund');
                Route::get('preview', 'UserController@depositpreview')->name('user.preview');
                Route::post('fund', 'UserController@fundsubmit')->name('fund.submit');
                Route::get('bank_transfer', 'UserController@bank_transfer')->name('user.bank_transfer');
                Route::post('bank_transfer', 'UserController@bank_transfersubmit')->name('bank_transfersubmit');
                Route::get('withdraw', 'UserController@withdraw')->name('user.withdraw');
                Route::post('withdraw', 'UserController@withdrawsubmit')->name('withdraw.submit');
                Route::get('save', 'UserController@save')->name('user.save');
                Route::post('save', 'UserController@submitsave')->name('submitsave');
                Route::get('branch', 'UserController@branch')->name('user.branch');
                Route::get('password', 'UserController@changePassword')->name('user.password');
                Route::post('password', 'UserController@submitPassword')->name('change.password');
                Route::get('pin', 'UserController@changePin')->name('user.pin');
                Route::post('pin', 'UserController@submitPin')->name('change.pin');
                Route::get('loan', 'UserController@loan')->name('user.loan');
                Route::get('loan-detail/{id}', 'UserController@loanDetail')->name('user.loan-detail');
                Route::post('loansubmit', 'UserController@loansubmit');
                Route::post('bankupdate', 'UserController@bankupdate');
                Route::post('payloan/{id}', 'UserController@payloan')->name('user.payloan');
                Route::get('upgrade', 'UserController@upgrade')->name('user.upgrade');
                Route::get('read', 'UserController@read')->name('user.read');
                Route::post('deposit-confirm', 'PaymentController@depositConfirm')->name('deposit.confirm');
                Route::get('buy_asset', 'UserController@buyasset')->name('user.buyasset');
                Route::post('buy_asset', 'UserController@submitbuyasset')->name('submit.buyasset');                
                Route::get('sell_asset', 'UserController@sellasset')->name('user.sellasset');
                Route::post('sell_asset', 'UserController@submitsellasset')->name('submit.sellasset');               
                Route::get('exchange_asset', 'UserController@exchangeasset')->name('user.exchangeasset');
                Route::post('exchange_asset', 'UserController@submitexchangeasset')->name('submit.exchangeasset');                    
                Route::get('transfer_asset', 'UserController@transferasset')->name('user.transferasset');
                Route::post('transfer_asset', 'UserController@submittransferasset')->name('submit.transferasset');                
                Route::get('check_asset', 'UserController@checkasset')->name('user.checkasset');
                Route::post('check_asset', 'UserController@submitcheckasset')->name('submit.checkasset');
                Route::post('2fa', 'UserController@submit2fa')->name('change.2fa');
            });
        });
    Route::get('logout', 'UserController@logout')->name('user.logout');
});

Route::get('user-password/reset', 'User\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
Route::post('user-password/email', 'User\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
Route::get('user-password/reset/{token}', 'User\ResetPasswordController@showResetForm')->name('user.password.reset');
Route::post('user-password/reset', 'User\ResetPasswordController@reset');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminLoginController@index')->name('admin.loginForm');
    Route::post('/', 'AdminLoginController@authenticate')->name('admin.login');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('/admin-unit', 'AdminController@admin_unit')->name('admin.admin_unit');
    Route::post('/add-admin', 'AdminController@AddAdmin')->name('admin.add.admin_unit');
    Route::post('/edit-admin/{id}', 'AdminController@EditAdmin')->name('admin.edit.admin_unit');
    Route::get('/delete-admin/{id}', 'AdminController@DeleteAdmin')->name('admin.delete.admin_unit');
    Route::get('/logout', 'AdminController@logout')->name('admin.logout');
    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    //Blog controller
    Route::post('/createcategory', 'PostController@CreateCategory');
    Route::post('/updatecategory', 'PostController@UpdateCategory');
    Route::get('/post-category', 'PostController@category')->name('admin.cat');
    Route::get('/unblog/{id}', 'PostController@unblog')->name('blog.unpublish');
    Route::get('/pblog/{id}', 'PostController@pblog')->name('blog.publish');
    Route::get('blog', 'PostController@index')->name('admin.blog');
    Route::get('blog/create', 'PostController@create')->name('blog.create');
    Route::post('blog/create', 'PostController@store')->name('blog.store');
    Route::get('blog/delete/{id}', 'PostController@destroy')->name('blog.delete');
    Route::get('category/delete/{id}', 'PostController@delcategory')->name('blog.delcategory');
    Route::get('blog/edit/{id}', 'PostController@edit')->name('blog.edit');
    Route::post('blog-update', 'PostController@updatePost')->name('blog.update');

    //Web controller
    Route::post('social-links/update', 'WebController@UpdateSocial')->name('social-links.update');
    Route::get('social-links', 'WebController@sociallinks')->name('social-links'); 

    Route::post('about-us/update', 'WebController@UpdateAbout')->name('about-us.update');
    Route::get('about-us', 'WebController@aboutus')->name('about-us'); 

    Route::post('privacy-policy/update', 'WebController@UpdatePrivacy')->name('privacy-policy.update');
    Route::get('privacy-policy', 'WebController@privacypolicy')->name('privacy-policy');

    Route::post('terms/update', 'WebController@UpdateTerms')->name('terms.update');
    Route::get('terms', 'WebController@terms')->name('admin.terms'); 

    Route::post('/createfaq', 'WebController@CreateFaq');   
    Route::post('faq/update', 'WebController@UpdateFaq')->name('faq.update');
    Route::get('faq/delete/{id}', 'WebController@DestroyFaq')->name('faq.delete');
    Route::get('faq', 'WebController@faq')->name('admin.faq');   
    
    Route::post('/createservice', 'WebController@CreateService');   
    Route::post('service/update', 'WebController@UpdateService')->name('service.update');
    Route::get('service/edit/{id}', 'WebController@EditService')->name('brand.edit');
    Route::get('service/delete/{id}', 'WebController@DestroyService')->name('service.delete');
    Route::get('service', 'WebController@services')->name('admin.service'); 
    
    Route::post('/createpage', 'WebController@CreatePage');   
    Route::post('page/update', 'WebController@UpdatePage')->name('page.update');
    Route::get('page/delete/{id}', 'WebController@DestroyPage')->name('page.delete');
    Route::get('page', 'WebController@page')->name('admin.page'); 
    Route::get('/unpage/{id}', 'WebController@unpage')->name('page.unpublish');
    Route::get('/ppage/{id}', 'WebController@ppage')->name('page.publish');    
    
    Route::post('/createreview', 'WebController@CreateReview');   
    Route::post('review/update', 'WebController@UpdateReview')->name('review.update');
    Route::get('review/edit/{id}', 'WebController@EditReview')->name('review.edit');
    Route::get('review/delete/{id}', 'WebController@DestroyReview')->name('review.delete');
    Route::get('review', 'WebController@review')->name('admin.review'); 
    Route::get('/unreview/{id}', 'WebController@unreview')->name('review.unpublish');
    Route::get('/preview/{id}', 'WebController@preview')->name('review.publish');    
    
    Route::post('/createbrand', 'WebController@CreateBrand');   
    Route::post('brand/update', 'WebController@UpdateBrand')->name('brand.update');
    Route::get('brand/edit/{id}', 'WebController@EditBrand')->name('brand.edit');
    Route::get('brand/delete/{id}', 'WebController@DestroyBrand')->name('brand.delete');
    Route::get('brand', 'WebController@brand')->name('admin.brand'); 
    Route::get('/unbrand/{id}', 'WebController@unbrand')->name('brand.unpublish');
    Route::get('/pbrand/{id}', 'WebController@pbrand')->name('brand.publish');
    
    Route::post('createbranch', 'WebController@CreateBranch');   
    Route::post('branch/update', 'WebController@UpdateBranch')->name('branch.update');
    Route::get('branch/delete/{id}', 'WebController@DestroyBranch')->name('branch.delete');
    Route::get('branch', 'WebController@branch')->name('admin.branch');

    Route::get('currency', 'WebController@currency')->name('admin.currency');
    Route::get('pcurrency/{id}', 'WebController@pcurrency')->name('blog.publish'); 
    
    Route::get('logo', 'WebController@logo')->name('admin.logo');
    Route::post('updatelogo', 'WebController@UpdateLogo');
    Route::post('updatefavicon', 'WebController@UpdateFavicon');

    Route::get('home-page', 'WebController@homepage')->name('homepage');   
    Route::post('home-page/update', 'WebController@Updatehomepage')->name('homepage.update');
    Route::post('section1/update', 'WebController@section1');
    Route::post('section2/update', 'WebController@section2');
    Route::post('section3/update', 'WebController@section3');
    Route::post('section4/update', 'WebController@section4');
    Route::post('section8/update', 'WebController@section8');
    Route::post('section9/update', 'WebController@section9');

    //Unit Controller
    Route::get('area-management', 'AdminController@AreaManagement')->name('admin.area.management');
    Route::post('add-unit', 'AdminController@AddUnit')->name('admin.add.unit');
    Route::post('edit-unit', 'AdminController@EditUnit')->name('admin.edit.unit');
    Route::get('unit-delete/{id}', 'AdminController@DeleteUnit')->name('admin.delete.unit');
    
    //Usaha Management
    Route::get('jenis-management', 'AdminController@JenisManagement')->name('admin.usaha.jenis');
    Route::post('edit-jenis', 'AdminController@EditJenis')->name('admin.edit.jenis');
    Route::get('jenis-delete/{id}', 'AdminController@DeleteJenis')->name('admin.delete.jenis');
    Route::get('usaha-management', 'AdminController@UsahaManagement')->name('admin.usaha.management');
    Route::post('add-usaha', 'AdminController@AddUsaha')->name('admin.add.usaha');
    Route::post('edit-usaha', 'AdminController@EditUsaha')->name('admin.edit.usaha');
    Route::get('usaha-delete/{id}', 'AdminController@DeleteUsaha')->name('admin.delete.usaha');

    //Wilayah Management
    Route::post('get-kota', 'AdminController@GetKota')->name('admin.get.kota');
    Route::get('kota', 'AdminController@GetKota')->name('admin.kota');

    //Withdrawal controller
    Route::get('withdraw-log', 'WithdrawController@withdrawlog')->name('admin.withdraw.log');
    Route::get('withdraw-method', 'WithdrawController@withdrawmethod')->name('admin.withdraw.method');
    Route::post('withdraw-method', 'WithdrawController@store')->name('admin.withdraw.store');
    Route::get('withdraw-method/delete/{id}', 'WithdrawController@DestroyMethod')->name('withdrawmethod.delete');
    Route::get('withdraw-approved', 'WithdrawController@withdrawapproved')->name('admin.withdraw.approved');
    Route::get('withdraw-declined', 'WithdrawController@withdrawdeclined')->name('admin.withdraw.declined');
    Route::get('withdraw-unpaid', 'WithdrawController@withdrawunpaid')->name('admin.withdraw.unpaid');
    Route::get('withdraw/delete/{id}', 'WithdrawController@DestroyWithdrawal')->name('withdraw.delete');
    Route::get('approvewithdraw/{id}', 'WithdrawController@approve')->name('withdraw.approve');
    Route::get('declinewithdraw/{id}', 'WithdrawController@decline')->name('withdraw.declined');  
    Route::get('approvewithdrawm/{id}', 'WithdrawController@approvem')->name('withdraw.approvem');
    Route::get('/declinewithdrawm/{id}', 'WithdrawController@declinem')->name('withdraw.declinedm');  
    
    //Deposit controller
    Route::get('bank-transfer', 'DepositController@banktransfer')->name('admin.banktransfer');
    Route::get('bank_transfer/delete/{id}', 'DepositController@DestroyTransfer')->name('transfer.delete');
    Route::post('bankdetails', 'DepositController@bankdetails');
    Route::get('deposit-log', 'DepositController@depositlog')->name('admin.deposit.log');
    Route::get('deposit-method', 'DepositController@depositmethod')->name('admin.deposit.method');
    Route::post('storegateway', 'DepositController@store');
    Route::get('approvebk/{id}', 'DepositController@approvebk')->name('deposit.approvebk');
    Route::get('declinebk/{id}', 'DepositController@declinebk')->name('deposit.declinebk');
    Route::get('deposit-approved', 'DepositController@depositapproved')->name('admin.deposit.approved');
    Route::get('deposit-pending', 'DepositController@depositpending')->name('admin.deposit.pending');
    Route::get('deposit-declined', 'DepositController@depositdeclined')->name('admin.deposit.declined');
    Route::get('deposit/delete/{id}', 'DepositController@DestroyDeposit')->name('deposit.delete');
    Route::get('approvedeposit/{id}', 'DepositController@approve')->name('deposit.approve');
    Route::get('declinedeposit/{id}', 'DepositController@decline')->name('deposit.decline');

    //Save 4 me controller
    Route::get('save-completed', 'SaveController@Completed')->name('admin.save.completed');
    Route::get('save-pending', 'SaveController@Pending')->name('admin.save.pending');
    Route::get('save/delete/{id}', 'SaveController@Destroy')->name('save.delete');
    Route::get('save-release/{id}', 'SaveController@Release')->name('save.release');    
    
    //Loan controller
    Route::get('add-loan', 'AdminController@AddLoan')->name('admin.add.loan');
    Route::post('addLoan', 'AdminController@AddLoanProcess')->name('admin.add.loan.process');
    Route::get('before-approve/{id}', 'AdminController@ApproveLoanBefore')->name('admin.loan.before');
    Route::get('loan-completed', 'AdminController@Loancompleted')->name('admin.loan.completed');
    Route::get('loan-detail/{id}/{user_id}/{state}', 'AdminController@Loandetail')->name('admin.loan.detail');
    Route::get('loan-approval', 'AdminController@Loanapproval')->name('admin.loan.approval');
    Route::get('loan-pending', 'AdminController@Loanpending')->name('admin.loan.pending');
    Route::get('loan-hold', 'AdminController@Loanhold')->name('admin.loan.hold');
    Route::get('loan/delete/{id}', 'AdminController@LoanDestroy')->name('loan.delete');
    Route::post('loan-approve/{id}', 'AdminController@Loanapprove')->name('loan.approve');
    Route::get('agunan/{files}', 'AdminController@AgunanDetail')->name('loan.agunan');
    Route::post('payloan/{id}', 'AdminController@payloan')->name('admin.payloan');
    Route::get('print-loan/{id}', 'AdminController@Printloan')->name('admin.print.loan');
    Route::get('print-monitoring', 'AdminController@PrintMonitoring')->name('admin.print.monitoring');
    
    //Survey Controller
    Route::post('add-survey/{id}', 'AdminController@AddSurvey')->name('admin.add.survey');
    Route::post('ket-survey/{id}', 'AdminController@KetSurvey')->name('admin.ket.survey');
    Route::get('approve-survey/{id}', 'AdminController@ApproveSurvey')->name('admin.approve.survey');
    Route::post('survey-image/{id}', 'AdminController@UploadImageSurvey')->name('admin.upload.image');
    Route::get('survey-image/{id}', 'AdminController@UploadImageSurvey')->name('admin.upload.image');

    //Py scheme controller
    Route::get('py-completed', 'PyschemeController@Completed')->name('admin.py.completed');
    Route::get('py-pending', 'PyschemeController@Pending')->name('admin.py.pending');
    Route::get('py-plans', 'PyschemeController@Plans')->name('admin.py.plans');
    Route::get('py/delete/{id}', 'PyschemeController@Destroy')->name('py.delete');
    Route::get('py-plan/delete/{id}', 'PyschemeController@PlanDestroy')->name('py.plan.delete');
    Route::get('py-plan-create', 'PyschemeController@Create')->name('admin.plan.create');
    Route::post('py-plan-create', 'PyschemeController@Store')->name('admin.plan.store');
    Route::get('py-plan/{id}', 'PyschemeController@Edit')->name('admin.plan.edit');
    Route::post('py-plan-edit', 'PyschemeController@Update')->name('admin.plan.update');

    //Setting controller
    Route::get('settings', 'SettingController@Settings')->name('admin.setting');
    Route::post('settings', 'SettingController@SettingsUpdate')->name('admin.settings.update');    
    Route::get('email', 'SettingController@Email')->name('admin.email');
    Route::post('email', 'SettingController@EmailUpdate')->name('admin.email.update');    
    Route::get('sms', 'SettingController@Sms')->name('admin.sms');
    Route::post('sms', 'SettingController@SmsUpdate')->name('admin.sms.update');    
    Route::get('account', 'SettingController@Account')->name('admin.account');
    Route::post('account', 'SettingController@AccountUpdate')->name('admin.account.update');

    //Transfer controller
    Route::get('own-bank', 'TransferController@Ownbank')->name('admin.ownbank');  
    Route::get('own-bank/delete/{id}', 'TransferController@Destroyownbank')->name('ownbank.delete');
    Route::get('other-bank', 'TransferController@Otherbank')->name('admin.otherbank');  
    Route::get('other-bank/delete/{id}', 'TransferController@Destroyotherbank')->name('otherbank.delete');
    Route::get('app-otherbank/{id}', 'TransferController@Approve')->name('otherbank.approve');    
    
    //User controller
    Route::get('users', ['as' => 'users', 'uses' => 'AdminController@Users']);  
    Route::get('add-users', 'AdminController@UsersAdd')->name('admin.add_users');  
    Route::get('messages', 'AdminController@Messages')->name('admin.message');  
    Route::get('unblock-user/{id}', 'AdminController@Unblockuser')->name('user.unblock');
    Route::get('block-user/{id}', 'AdminController@Blockuser')->name('user.block');
    Route::get('manage-user/{id}', 'AdminController@Manageuser')->name('user.manage');
    Route::get('user/delete/{id}', 'AdminController@Destroyuser')->name('user.delete');
    Route::get('email/{id}/{name}', 'AdminController@Email')->name('user.email');
    Route::post('email_send', 'AdminController@Sendemail')->name('user.email.send');    
    Route::get('promo', 'AdminController@Promo')->name('user.promo');
    Route::post('promo', 'AdminController@Sendpromo')->name('user.promo.send');
    Route::get('message/delete/{id}', 'AdminController@Destroymessage')->name('message.delete');
    Route::get('ticket', 'AdminController@Ticket')->name('admin.ticket');
    Route::get('ticket/delete/{id}', 'AdminController@Destroyticket')->name('ticket.delete');
    Route::get('close-ticket/{id}', 'AdminController@Closeticket')->name('ticket.close');
    Route::get('manage-ticket/{id}', 'AdminController@Manageticket')->name('ticket.manage');
    Route::post('reply-ticket', 'AdminController@Replyticket')->name('ticket.reply');
    Route::post('profile-update', 'AdminController@Profileupdate');
    Route::post('credit-account', 'AdminController@Credit');
    Route::post('debit-account', 'AdminController@Debit');
    Route::post('add-user', 'AdminController@AddUserProcess');
    Route::get('approve-kyc/{id}', 'AdminController@Approvekyc')->name('admin.approve.kyc');
    Route::get('reject-kyc/{id}', 'AdminController@Rejectkyc')->name('admin.reject.kyc');

    //Asset controller
    Route::get('asset-buy', 'AssetController@Buy')->name('admin.asset.buy');
    Route::get('asset-sell', 'AssetController@Sell')->name('admin.asset.sell');
    Route::get('asset-exchange', 'AssetController@Exchange')->name('admin.asset.exchange');
    Route::get('asset-plans', 'AssetController@Plans')->name('admin.asset.plans');
    Route::get('asset/delete/{id}', 'AssetController@Destroy')->name('asset.delete');
    Route::get('asset-plan/delete/{id}', 'AssetController@PlanDestroy')->name('asset.plan.delete');
    Route::get('asset-plan-create', 'AssetController@Create')->name('admin.asset.create');
    Route::post('asset-plan-create', 'AssetController@Store')->name('admin.asset.store');
    Route::get('asset-plan/{id}', 'AssetController@Edit')->name('admin.asset.edit');
    Route::post('asset-plan-edit', 'AssetController@Update')->name('admin.asset.update');

    //Merchant controller
    Route::get('approved-merchant', 'MerchantController@Approvedmerchant')->name('approved.merchant');
    Route::get('pending-merchant', 'MerchantController@Pendingmerchant')->name('pending.merchant');
    Route::get('declined-merchant', 'MerchantController@Declinedmerchant')->name('declined.merchant');
    Route::get('merchant-log', 'MerchantController@merchantlog')->name('merchant.log');
    Route::get('transfer-log', 'MerchantController@transferlog')->name('transfer.log');
    Route::get('merchant/delete/{id}', 'MerchantController@Destroymerchant')->name('merchant.delete');
    Route::get('log/delete/{id}', 'MerchantController@Destroylog')->name('log.delete');
    Route::get('approvemerchant/{id}', 'MerchantController@approve')->name('merchant.approve');
    Route::get('declinemerchant/{id}', 'MerchantController@decline')->name('merchant.decline');
});

Route::group(['prefix' => 'admin-unit', 'middleware' => 'auth:admin-unit'], function () {
    Route::get('/logout', 'AdminUnitController@logout')->name('admin-unit.logout');
    Route::get('/dashboard', 'AdminUnitController@dashboard')->name('admin-unit.dashboard');

    //Blog controller
    Route::post('/createcategory', 'PostController@CreateCategory');
    Route::post('/updatecategory', 'PostController@UpdateCategory');
    Route::get('/post-category', 'PostController@category')->name('admin-unit.cat');
    Route::get('/unblog/{id}', 'PostController@unblog')->name('blog.unpublish');
    Route::get('/pblog/{id}', 'PostController@pblog')->name('blog.publish');
    Route::get('blog', 'PostController@index')->name('admin-unit.blog');
    Route::get('blog/create', 'PostController@create')->name('blog.create');
    Route::post('blog/create', 'PostController@store')->name('blog.store');
    Route::get('blog/delete/{id}', 'PostController@destroy')->name('blog.delete');
    Route::get('category/delete/{id}', 'PostController@delcategory')->name('blog.delcategory');
    Route::get('blog/edit/{id}', 'PostController@edit')->name('blog.edit');
    Route::post('blog-update', 'PostController@updatePost')->name('blog.update');

    //Web controller
    Route::post('social-links/update', 'WebController@UpdateSocial')->name('social-links.update');
    Route::get('social-links', 'WebController@sociallinks')->name('social-links'); 

    Route::post('about-us/update', 'WebController@UpdateAbout')->name('about-us.update');
    Route::get('about-us', 'WebController@aboutus')->name('about-us'); 

    Route::post('privacy-policy/update', 'WebController@UpdatePrivacy')->name('privacy-policy.update');
    Route::get('privacy-policy', 'WebController@privacypolicy')->name('privacy-policy');

    Route::post('terms/update', 'WebController@UpdateTerms')->name('terms.update');
    Route::get('terms', 'WebController@terms')->name('admin-unit.terms'); 

    Route::post('/createfaq', 'WebController@CreateFaq');   
    Route::post('faq/update', 'WebController@UpdateFaq')->name('faq.update');
    Route::get('faq/delete/{id}', 'WebController@DestroyFaq')->name('faq.delete');
    Route::get('faq', 'WebController@faq')->name('admin-unit.faq');   
    
    Route::post('/createservice', 'WebController@CreateService');   
    Route::post('service/update', 'WebController@UpdateService')->name('service.update');
    Route::get('service/edit/{id}', 'WebController@EditService')->name('brand.edit');
    Route::get('service/delete/{id}', 'WebController@DestroyService')->name('service.delete');
    Route::get('service', 'WebController@services')->name('admin-unit.service'); 
    
    Route::post('/createpage', 'WebController@CreatePage');
    Route::post('page/update', 'WebController@UpdatePage')->name('page.update');
    Route::get('page/delete/{id}', 'WebController@DestroyPage')->name('page.delete');
    Route::get('page', 'WebController@page')->name('admin-unit.page');
    Route::get('/unpage/{id}', 'WebController@unpage')->name('page.unpublish');
    Route::get('/ppage/{id}', 'WebController@ppage')->name('page.publish');
    
    Route::post('/createreview', 'WebController@CreateReview');
    Route::post('review/update', 'WebController@UpdateReview')->name('review.update');
    Route::get('review/edit/{id}', 'WebController@EditReview')->name('review.edit');
    Route::get('review/delete/{id}', 'WebController@DestroyReview')->name('review.delete');
    Route::get('review', 'WebController@review')->name('admin-unit.review');
    Route::get('/unreview/{id}', 'WebController@unreview')->name('review.unpublish');
    Route::get('/preview/{id}', 'WebController@preview')->name('review.publish');
    
    Route::post('/createbrand', 'WebController@CreateBrand');
    Route::post('brand/update', 'WebController@UpdateBrand')->name('brand.update');
    Route::get('brand/edit/{id}', 'WebController@EditBrand')->name('brand.edit');
    Route::get('brand/delete/{id}', 'WebController@DestroyBrand')->name('brand.delete');
    Route::get('brand', 'WebController@brand')->name('admin-unit.brand');
    Route::get('/unbrand/{id}', 'WebController@unbrand')->name('brand.unpublish');
    Route::get('/pbrand/{id}', 'WebController@pbrand')->name('brand.publish');
    
    Route::post('createbranch', 'WebController@CreateBranch');   
    Route::post('branch/update', 'WebController@UpdateBranch')->name('branch.update');
    Route::get('branch/delete/{id}', 'WebController@DestroyBranch')->name('branch.delete');
    Route::get('branch', 'WebController@branch')->name('admin-unit.branch');

    Route::get('currency', 'WebController@currency')->name('admin-unit.currency');
    Route::get('pcurrency/{id}', 'WebController@pcurrency')->name('blog.publish'); 
    
    Route::get('logo', 'WebController@logo')->name('admin-unit.logo');
    Route::post('updatelogo', 'WebController@UpdateLogo');
    Route::post('updatefavicon', 'WebController@UpdateFavicon');

    Route::get('home-page', 'WebController@homepage')->name('homepage');   
    Route::post('home-page/update', 'WebController@Updatehomepage')->name('homepage.update');
    Route::post('section1/update', 'WebController@section1');
    Route::post('section2/update', 'WebController@section2');
    Route::post('section3/update', 'WebController@section3');
    Route::post('section4/update', 'WebController@section4');
    Route::post('section8/update', 'WebController@section8');
    Route::post('section9/update', 'WebController@section9');

    //Unit Controller
    Route::get('area-management', 'AdminUnitController@AreaManagement')->name('admin-unit.area.management');
    Route::post('add-unit', 'AdminUnitController@AddUnit')->name('admin-unit.add.unit');
    Route::post('edit-unit', 'AdminUnitController@EditUnit')->name('admin-unit.edit.unit');
    Route::get('unit-delete/{id}', 'AdminUnitController@DeleteUnit')->name('admin-unit.delete.unit');
    
    //Usaha Management
    Route::get('jenis-management', 'AdminUnitController@JenisManagement')->name('admin-unit.usaha.jenis');
    Route::post('edit-jenis', 'AdminUnitController@EditJenis')->name('admin-unit.edit.jenis');
    Route::get('jenis-delete/{id}', 'AdminUnitController@DeleteJenis')->name('admin-unit.delete.jenis');
    Route::get('usaha-management', 'AdminUnitController@UsahaManagement')->name('admin-unit.usaha.management');
    Route::post('add-usaha', 'AdminUnitController@AddUsaha')->name('admin-unit.add.usaha');
    Route::post('edit-usaha', 'AdminUnitController@EditUsaha')->name('admin-unit.edit.usaha');
    Route::get('usaha-delete/{id}', 'AdminUnitController@DeleteUsaha')->name('admin-unit.delete.usaha');

    //Wilayah Management
    Route::post('get-kota', 'AdminUnitController@GetKota')->name('admin-unit.get.kota');
    Route::get('kota', 'AdminUnitController@GetKota')->name('admin-unit.kota');

    //Withdrawal controller
    Route::get('withdraw-log', 'WithdrawController@withdrawlog')->name('admin-unit.withdraw.log');
    Route::get('withdraw-method', 'WithdrawController@withdrawmethod')->name('admin-unit.withdraw.method');
    Route::post('withdraw-method', 'WithdrawController@store')->name('admin-unit.withdraw.store');
    Route::get('withdraw-method/delete/{id}', 'WithdrawController@DestroyMethod')->name('withdrawmethod.delete');
    Route::get('withdraw-approved', 'WithdrawController@withdrawapproved')->name('admin-unit.withdraw.approved');
    Route::get('withdraw-declined', 'WithdrawController@withdrawdeclined')->name('admin-unit.withdraw.declined');
    Route::get('withdraw-unpaid', 'WithdrawController@withdrawunpaid')->name('admin-unit.withdraw.unpaid');
    Route::get('withdraw/delete/{id}', 'WithdrawController@DestroyWithdrawal')->name('withdraw.delete');
    Route::get('approvewithdraw/{id}', 'WithdrawController@approve')->name('withdraw.approve');
    Route::get('declinewithdraw/{id}', 'WithdrawController@decline')->name('withdraw.declined');  
    Route::get('approvewithdrawm/{id}', 'WithdrawController@approvem')->name('withdraw.approvem');
    Route::get('/declinewithdrawm/{id}', 'WithdrawController@declinem')->name('withdraw.declinedm');  
    
    //Deposit controller
    Route::get('bank-transfer', 'DepositController@banktransfer')->name('admin-unit.banktransfer');
    Route::get('bank_transfer/delete/{id}', 'DepositController@DestroyTransfer')->name('transfer.delete');
    Route::post('bankdetails', 'DepositController@bankdetails');
    Route::get('deposit-log', 'DepositController@depositlog')->name('admin-unit.deposit.log');
    Route::get('deposit-method', 'DepositController@depositmethod')->name('admin-unit.deposit.method');
    Route::post('storegateway', 'DepositController@store');
    Route::get('approvebk/{id}', 'DepositController@approvebk')->name('deposit.approvebk');
    Route::get('declinebk/{id}', 'DepositController@declinebk')->name('deposit.declinebk');
    Route::get('deposit-approved', 'DepositController@depositapproved')->name('admin-unit.deposit.approved');
    Route::get('deposit-pending', 'DepositController@depositpending')->name('admin-unit.deposit.pending');
    Route::get('deposit-declined', 'DepositController@depositdeclined')->name('admin-unit.deposit.declined');
    Route::get('deposit/delete/{id}', 'DepositController@DestroyDeposit')->name('deposit.delete');
    Route::get('approvedeposit/{id}', 'DepositController@approve')->name('deposit.approve');
    Route::get('declinedeposit/{id}', 'DepositController@decline')->name('deposit.decline');

    //Save 4 me controller
    Route::get('save-completed', 'SaveController@Completed')->name('admin-unit.save.completed');
    Route::get('save-pending', 'SaveController@Pending')->name('admin-unit.save.pending');
    Route::get('save/delete/{id}', 'SaveController@Destroy')->name('save.delete');
    Route::get('save-release/{id}', 'SaveController@Release')->name('save.release');    
    
    //Loan controller
    Route::get('add-loan', 'AdminUnitController@AddLoan')->name('admin-unit.add.loan');
    Route::post('addLoan', 'AdminUnitController@AddLoanProcess')->name('admin-unit.add.loan.process');
    Route::get('before-approve/{id}', 'AdminUnitController@ApproveLoanBefore')->name('admin-unit.loan.before');
    Route::get('loan-completed', 'AdminUnitController@Loancompleted')->name('admin-unit.loan.completed');
    Route::get('loan-detail/{id}/{user_id}/{state}', 'AdminUnitController@Loandetail')->name('admin-unit.loan.detail');
    Route::get('loan-pending', 'AdminUnitController@Loanpending')->name('admin-unit.loan.pending');
    Route::get('loan-hold', 'AdminUnitController@Loanhold')->name('admin-unit.loan.hold');
    Route::get('loan/delete/{id}', 'AdminUnitController@LoanDestroy')->name('loan.delete');
    Route::post('loan-approve/{id}', 'AdminUnitController@Loanapprove')->name('loan.approve');
    Route::get('agunan/{files}', 'AdminUnitController@AgunanDetail')->name('loan.agunan');
    Route::post('payloan/{id}', 'AdminUnitController@payloan')->name('admin-unit.payloan');
    
    //Survey Controller
    Route::get('ajukan-kandir/{id}', 'AdminUnitController@AjukanKandir')->name('admin-unit.ajukan.kandir');
    Route::get('print-survey/{id}', 'AdminunitController@PrintSurvey')->name('admin-unit.print.survey');
    Route::post('add-survey/{id}', 'AdminUnitController@AddSurvey')->name('admin-unit.add.survey');
    Route::post('ket-survey/{id}', 'AdminUnitController@KetSurvey')->name('admin-unit.ket.survey');
    Route::get('approve-survey/{id}', 'AdminUnitController@ApproveSurvey')->name('admin-unit.approve.survey');
    Route::post('survey-image/{id}', 'AdminUnitController@UploadImageSurvey')->name('admin-unit.upload.image');
    Route::get('survey-image/{id}', 'AdminUnitController@UploadImageSurvey')->name('admin-unit.upload.image');

    //Py scheme controller
    Route::get('py-completed', 'PyschemeController@Completed')->name('admin-unit.py.completed');
    Route::get('py-pending', 'PyschemeController@Pending')->name('admin-unit.py.pending');
    Route::get('py-plans', 'PyschemeController@Plans')->name('admin-unit.py.plans');
    Route::get('py/delete/{id}', 'PyschemeController@Destroy')->name('py.delete');
    Route::get('py-plan/delete/{id}', 'PyschemeController@PlanDestroy')->name('py.plan.delete');
    Route::get('py-plan-create', 'PyschemeController@Create')->name('admin-unit.plan.create');
    Route::post('py-plan-create', 'PyschemeController@Store')->name('admin-unit.plan.store');
    Route::get('py-plan/{id}', 'PyschemeController@Edit')->name('admin-unit.plan.edit');
    Route::post('py-plan-edit', 'PyschemeController@Update')->name('admin-unit.plan.update');

    //Setting controller
    Route::get('settings', 'SettingController@Settings')->name('admin-unit.setting');
    Route::post('settings', 'SettingController@SettingsUpdate')->name('admin-unit.settings.update');    
    Route::get('email', 'SettingController@Email')->name('admin-unit.email');
    Route::post('email', 'SettingController@EmailUpdate')->name('admin-unit.email.update');    
    Route::get('sms', 'SettingController@Sms')->name('admin-unit.sms');
    Route::post('sms', 'SettingController@SmsUpdate')->name('admin-unit.sms.update');    
    Route::get('account', 'SettingController@Account')->name('admin-unit.account');
    Route::post('account', 'SettingController@AccountUpdate')->name('admin-unit.account.update');

    //Transfer controller
    Route::get('own-bank', 'TransferController@Ownbank')->name('admin-unit.ownbank');  
    Route::get('own-bank/delete/{id}', 'TransferController@Destroyownbank')->name('ownbank.delete');
    Route::get('other-bank', 'TransferController@Otherbank')->name('admin-unit.otherbank');  
    Route::get('other-bank/delete/{id}', 'TransferController@Destroyotherbank')->name('otherbank.delete');
    Route::get('app-otherbank/{id}', 'TransferController@Approve')->name('otherbank.approve');    
    
    //User controller
    Route::get('users', 'AdminUnitController@Users')->name('admin-unit.users');  
    Route::get('add-users', 'AdminUnitController@UsersAdd')->name('admin-unit.add_users');  
    Route::get('messages', 'AdminUnitController@Messages')->name('admin-unit.message');  
    Route::get('unblock-user/{id}', 'AdminUnitController@Unblockuser')->name('user.unblock');
    Route::get('block-user/{id}', 'AdminUnitController@Blockuser')->name('user.block');
    Route::get('manage-user/{id}', 'AdminUnitController@Manageuser')->name('user.manage');
    Route::get('user/delete/{id}', 'AdminUnitController@Destroyuser')->name('user.delete');
    Route::get('email/{id}/{name}', 'AdminUnitController@Email')->name('user.email');
    Route::post('email_send', 'AdminUnitController@Sendemail')->name('user.email.send');    
    Route::get('promo', 'AdminUnitController@Promo')->name('user.promo');
    Route::post('promo', 'AdminUnitController@Sendpromo')->name('user.promo.send');
    Route::get('message/delete/{id}', 'AdminUnitController@Destroymessage')->name('message.delete');
    Route::get('ticket', 'AdminUnitController@Ticket')->name('admin-unit.ticket');
    Route::get('ticket/delete/{id}', 'AdminUnitController@Destroyticket')->name('ticket.delete');
    Route::get('close-ticket/{id}', 'AdminUnitController@Closeticket')->name('ticket.close');
    Route::get('manage-ticket/{id}', 'AdminUnitController@Manageticket')->name('ticket.manage');
    Route::post('reply-ticket', 'AdminUnitController@Replyticket')->name('ticket.reply');
    Route::post('profile-update', 'AdminUnitController@Profileupdate');
    Route::post('credit-account', 'AdminUnitController@Credit');
    Route::post('debit-account', 'AdminUnitController@Debit');
    Route::post('add-user', 'AdminUnitController@AddUserProcess');
    Route::get('approve-kyc/{id}', 'AdminUnitController@Approvekyc')->name('admin-unit.approve.kyc');
    Route::get('reject-kyc/{id}', 'AdminUnitController@Rejectkyc')->name('admin-unit.reject.kyc');
    Route::get('add-loan', 'AdminController@AddLoan')->name('admin.add.loan');
    Route::post('addLoan', 'AdminController@AddLoanProcess')->name('admin.add.loan.process');

    //Asset controller
    Route::get('asset-buy', 'AssetController@Buy')->name('admin-unit.asset.buy');
    Route::get('asset-sell', 'AssetController@Sell')->name('admin-unit.asset.sell');
    Route::get('asset-exchange', 'AssetController@Exchange')->name('admin-unit.asset.exchange');
    Route::get('asset-plans', 'AssetController@Plans')->name('admin-unit.asset.plans');
    Route::get('asset/delete/{id}', 'AssetController@Destroy')->name('asset.delete');
    Route::get('asset-plan/delete/{id}', 'AssetController@PlanDestroy')->name('asset.plan.delete');
    Route::get('asset-plan-create', 'AssetController@Create')->name('admin-unit.asset.create');
    Route::post('asset-plan-create', 'AssetController@Store')->name('admin-unit.asset.store');
    Route::get('asset-plan/{id}', 'AssetController@Edit')->name('admin-unit.asset.edit');
    Route::post('asset-plan-edit', 'AssetController@Update')->name('admin-unit.asset.update');

    //Merchant controller
    Route::get('approved-merchant', 'MerchantController@Approvedmerchant')->name('approved.merchant');
    Route::get('pending-merchant', 'MerchantController@Pendingmerchant')->name('pending.merchant');
    Route::get('declined-merchant', 'MerchantController@Declinedmerchant')->name('declined.merchant');
    Route::get('merchant-log', 'MerchantController@merchantlog')->name('merchant.log');
    Route::get('transfer-log', 'MerchantController@transferlog')->name('transfer.log');
    Route::get('merchant/delete/{id}', 'MerchantController@Destroymerchant')->name('merchant.delete');
    Route::get('log/delete/{id}', 'MerchantController@Destroylog')->name('log.delete');
    Route::get('approvemerchant/{id}', 'MerchantController@approve')->name('merchant.approve');
    Route::get('declinemerchant/{id}', 'MerchantController@decline')->name('merchant.decline');

    //Survey Controller
    Route::get('/upload', 'UploadController@upload');
    Route::post('/upload/proses', 'UploadController@proses_upload');
});