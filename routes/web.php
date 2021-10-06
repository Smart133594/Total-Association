<?php

use App\Http\Controllers\AccessDeviceController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdminLogin;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\ajaxController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\MasterassociationController;
use App\Http\Controllers\SubassociationController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\PropertytypeController;
use App\Http\Controllers\PaymentbracketController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\PettypeController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DigitalsignageController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\FinesController;
use App\Http\Controllers\FacilitiesfeeController;
use App\Http\Controllers\FacilitiestypeController;
use App\Http\Controllers\facilitiesController;
use App\Http\Controllers\WorkForceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PunchClockAuthController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\PunchClockController;
use App\Http\Controllers\DepartManageController;
use App\Http\Controllers\EmailController;

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

Route::redirect('/dashboard', '/admin_panel/dashboard');
Route::get('upload/{file}', function ($file) {
    $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $file);
    return response()->file($path);
});
Route::get('thumb/{file}', function ($file) {
    $path = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $file);
    return response()->file($path);
});


/*admin*/
Route::middleware([CheckAdminLogin::class])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('/', [UserController::class, 'index'])->name('dashboard');

    Route::Resource('master-association', MasterassociationController::class);
    Route::Resource('sub-association', SubassociationController::class);
    Route::Resource('properties', PropertyController::class);
    Route::Resource('buildings', BuildingController::class);
    Route::Resource('property-type', PropertytypeController::class);
    Route::Resource('payment-bracket', PaymentbracketController::class);
    Route::Resource('owner', OwnerController::class);
    Route::Resource('guest', GuestController::class);
    Route::Resource('resident', ResidentController::class);
    Route::Resource('application', ApplicationController::class);
    Route::Resource('pettype', PettypeController::class);
    Route::Resource('pet', PetController::class);
    Route::Resource('template', TemplateController::class);
    Route::Resource('manager', UsersController::class);
    Route::Resource('digital-signage-group', DigitalsignageController::class);
    Route::Resource('incident', IncidentController::class);
    Route::Resource('fines', FinesController::class);
    Route::Resource('facilities-type', FacilitiestypeController::class);
    Route::Resource('facilities', facilitiesController::class);
    // employeers
    Route::resource('work-force', WorkForceController::class);
    Route::get('/work-force/set-active/{id}', [WorkForceController::class, 'setActive']);

    Route::resource('department', DepartmentController::class);
    Route::resource('work-log', WorkLogController::class);
    Route::resource('punch-clock', PunchClockController::class);
    Route::get('/downlaod/pdf', [PunchClockController::class, 'download']);
    Route::resource('departmanage', DepartManageController::class);
    Route::post('/exportPunchClock', [PunchClockController::class, 'exportTimeSheet']);
    Route::post('/exportPunchClock1', [PunchClockController::class, 'exportTimeSheet1']);
    /*facilities*/
    
    Route::get('/facilities-rental/{id}', [facilitiesController::class, 'show']);
    Route::get('/facilities-rental/', [FacilitiesController::class, 'index'])->name('facilities-rental');
    Route::get('/facilities-status/{id}', [FacilitiesController::class, 'status'])->name('status');
    Route::get('/facilitiestype-status/{id}', [FacilitiestypeController::class, 'status'])->name('status');
    Route::get('/record-note/{id}', [FacilitiesController::class, 'recordanote'])->name('recordanote');
    Route::get('/paymentinfo/{id}', [FacilitiesController::class, 'paymentinfo'])->name('paymentinfo');
    Route::get('/facilities-rental-event/{id}', [FacilitiesController::class, 'events']);
    Route::get('/edit_rent/{id}', [FacilitiesController::class, 'edit_rent']);
    Route::get('/contract/{id}', [FacilitiesController::class, 'contract']);
    Route::get('/rent-facilities/{id}', [FacilitiesController::class, 'rent']);
    Route::get('/checkavail/{from}/{to}/{id}', [FacilitiesController::class, 'checkavail']);

    Route::post('/insertfacilitiesfees', [FacilitiesfeeController::class, 'insertfacilitiesfees']);
    Route::get('/facilitiestable/{ref}', [FacilitiesfeeController::class, 'facilitiestable']);
    Route::post('/rent-store/', [FacilitiesController::class, 'rentstore'])->name('rent.store');



    Route::get('/rent-a-facilities/', [FacilitiesController::class, 'rentfacilities'])->name('rentfacilities');
    Route::get('/checkavailability/{id}', [FacilitiesController::class, 'checkavailability'])->name('checkavailability');



    Route::get('/approve-facility-payments/{id}', [FacilitiesController::class, 'approvepayment']);
    Route::get('/downloadcontract/{id}', [FacilitiesController::class, 'downloadcontract']);

    /*facilities*/

    Route::get('/remove_incident_media/{id}', [IncidentController::class, 'removemedia'])->name('removemedia');

    /*Properties and Residents*/

    Route::get('/bulk-communication', [TemplateController::class, 'bulkcommunication'])->name('bulk.communication');
    Route::post('/send-bulkmail', [TemplateController::class, 'sendbulkmail'])->name('send.bulkmail');
    Route::get('/letter-generator', [TemplateController::class, 'lettergenerator'])->name('letter.generator');
    Route::post('/download-letter', [TemplateController::class, 'downloadletter'])->name('download-letter');
    Route::get('/get-person/{type}/{property}', [TemplateController::class, 'getperson'])->name('get-person');
    Route::get('/owner-properties', [PropertyController::class, 'owner_property'])->name('owner_property');

    Route::get('/member-owner', [OwnerController::class, 'index'])->name('member-owner');
    Route::get('/member-owner/{id}', [OwnerController::class, 'show'])->name('member-owner.show');
    Route::get('/member-resident/{id}', [ResidentController::class, 'show'])->name('member-resident.show');

    Route::get('/member-resident', [ResidentController::class, 'index'])->name('member-resident');
    Route::get('/uploaddoc/{ref}', [OwnerController::class, 'uploaddoc']);
    Route::post('/uploadownerdocument', [OwnerController::class, 'uploadownerdocument']);
    Route::get('/uploaddocresident/{ref}', [ResidentController::class, 'uploaddoc']);
    Route::post('/uploadresidentdocument', [ResidentController::class, 'uploadresidentdocument']);

    Route::post('/uploadincidentdocument', [IncidentController::class, 'uploadincidentdocument']);
    Route::get('/uploadincidentdoc/{ref}', [IncidentController::class, 'uploaddoc']);


    Route::post('/fine-update', [FinesController::class, 'fineupdate'])->name('fine-update');
    Route::get('/fine-resendemail/{id}', [FinesController::class, 'resendemail'])->name('fine-resendemail');
    // find incident on property page
    Route::get('/fine-incident/{id}', [IncidentController::class, 'findIncident'])->name('fine-incident');
    // ----------------------------

    Route::get('/approve-pet-entry/{id}', [PetController::class, 'approve'])->name('pet.approve');
    Route::get('/pet-declined/{id}', [PetController::class, 'declined'])->name('pet.declined');
    Route::get('/getvaccination/{type}/{ref}', [PetController::class, 'getvaccination'])->name('pet.getvaccination');
    Route::post('/uploaddocument', [PetController::class, 'uploaddocument'])->name('pet.uploaddocument');
    Route::get('/pet-showdetails/{tags}/{ref}', [PetController::class, 'showdetails'])->name('pet.showdetails');
    Route::get('/showproperties/{id}', [PropertyController::class, 'show'])->name('propertyController.show');

    Route::get('/email-page', [EmailController::class, 'showemailpage'])->name('email.showemailpage');
    Route::post('/email-getitems', [EmailController::class, 'getemailitems'])->name('email.getitems');
    Route::get('/email-flagged/{id}', [EmailController::class, 'setflaggeditem'])->name('email.setflaggeditem');
    Route::post('/email-read', [EmailController::class, 'setreaditems'])->name('email.setreaditems');
    Route::post('/email-movetofolder', [EmailController::class, 'movetofolder'])->name('email.movetofolder');
    Route::get('/email-boxcount', [EmailController::class, 'boxcount'])->name('email.boxcount');
    Route::post('/email-delete', [EmailController::class, 'deletemail'])->name('email.deletemail');





    /*Properties and Residents*/

    /*application*/
        Route::get('/getapplication-details/{id}', [ApplicationController::class, 'details'])->name('getapplicationdetails');
        Route::get('/applicationapproval/{id}/{status}', [ApplicationController::class, 'applicationapproval'])->name('applicationapproval');
        Route::get('/chackemail-application/{id}', [ApplicationController::class, 'chackemail'])->name('chackemail');
    /*application*/

    /*other*/
        Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
        Route::get('/change-pwd', [UsersController::class, 'changepwd'])->name('change-pwd');
        Route::post('/change-pwd-save', [UsersController::class, 'changepwdsave'])->name('change-pwd-save');
    /*other*/

    /*ajax*/
        Route::get('/delimg/{table?}/{field?}/{id?}', [ajaxController::class, 'deleteimg'])->name('deleteimg');
        Route::get('/statuschange/{table?}/{field?}/{id?}', [ajaxController::class, 'statuschange'])->name('statuschange');
        Route::get('/getfloor/{id?}', [ajaxController::class, 'getfloor'])->name('getfloor');
        Route::get('/get-ownerdetails/{id?}', [ResidentController::class, 'getownerdetails'])->name('getownerdetails');
        Route::get('/gets-owner/{id?}', [PetController::class, 'getsowner'])->name('getsowner');
        Route::get('/get-residents/{id?}', [GuestController::class, 'getresidents'])->name('getresidents');
        // guest add/remove blacklist
        Route::post('/addblacklist/{id?}', [GuestController::class, 'addBlacklist'])->name('addBlacklist');
        Route::get('/rmBlacklist/{id?}', [GuestController::class, 'rmBlacklist'])->name('rmBlacklist');
        Route::get('/getbuilding/{id?}', [ajaxController::class, 'getbuilding'])->name('getbuilding');
        Route::get('/paymentbracket/{id?}', [ajaxController::class, 'paymentbracket'])->name('paymentbracket');
        Route::get('/getproperty/{id?}', [ajaxController::class, 'getproperty'])->name('getproperty');
    /*ajax*/
    //Route::view('/master-association', ['admin.properties.master-association'])->name('master-association');

    /*setting*/
        Route::get('/property-setting', [SettingController::class, 'property_setting'])->name('property_setting');
        Route::get('/pet-setting', [SettingController::class, 'petsetting'])->name('pet-setting');
        Route::get('/fine-setting', [SettingController::class, 'finesetting'])->name('fine-setting');
        Route::get('/application-setting', [SettingController::class, 'application_setting'])->name('application_setting');
        Route::post('/save-setting', [SettingController::class, 'store'])->name('save-setting');
        Route::get('/gettemplate/{id}', [TemplateController::class, 'gettemplate'])->name('gettemplate');
        Route::get('/getresponsible/{type}', [ajaxController::class, 'getresponsible'])->name('getresponsible');
    /*setting*/

        Route::resource('access-settings', AccessDeviceController::class);
        Route::resource('punchclock-auth', PunchClockAuthController::class);

});
/*admin*/


/*front application*/
Route::get('/application-form/{id}', [ApplicationController::class, 'application'])->name('application-form');
Route::post('/application-store', [ApplicationController::class, 'applicationstore'])->name('application-store');
Route::get('/pay-application/{id}', [ApplicationController::class, 'payapplication'])->name('pay-application');
Route::post('/success', [ApplicationController::class, 'success'])->name('success');
Route::get('/cancel', [ApplicationController::class, 'cancel'])->name('cancel');
Route::get('/application-submitted/{id}', [ApplicationController::class, 'applicationsubmitted'])->name('applicationsubmitted');
Route::get('/application-resent/{id}', [ApplicationController::class, 'resent'])->name('resent');
Route::get('/application-assignpayment/{id}', [ApplicationController::class, 'assignpayment'])->name('assignpayment');
/* fromnt application*/
Route::get('/department/add_note/{note}', [DepartmentController::class, 'add_note'])->name('add_note');
Route::get('/department/delete_note/{id}', [DepartmentController::class, 'delete_note'])->name('delete_note');
Route::get('/department/delete_file/{id}', [DepartmentController::class, 'delete_file'])->name('delete_file');
Route::post('/department/add_task_note', [DepartmentController::class, 'add_task_note']);

Route::post('/department/add_note', [DepartmentController::class, 'add_note']);
Route::post('/department/get_note', [DepartmentController::class, 'get_note']);
Route::post('/department/edit_note', [DepartmentController::class, 'edit_note']);
Route::post('/department/delete_note', [DepartmentController::class, 'delete_note']);

Route::post('/department/add_file', [DepartmentController::class, 'add_file']);


Route::get('/total_tv/{id}', [DigitalsignageController::class, 'tv'])->name('total_tv');
Route::get('/checked_tv/{id}', [DigitalsignageController::class, 'tvchange'])->name('checked_tv');


/*Ajax*/


/*Ajax*/

/*frontend*/

Route::view('/mail/format', 'mail.format');
Route::view('/account', 'account.index');
/*frontend*/
?>
