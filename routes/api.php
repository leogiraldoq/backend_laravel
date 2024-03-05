<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstructionsController;
use App\Http\Controllers\BoutiquesController;
use App\Http\Controllers\CostumersController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\PickUpCompanyController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\ModulesController;
use App\Http\Controllers\LabelCreateController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\ShippersController;
use App\Http\Controllers\BoxesController;
use App\Http\Controllers\QrCodesController;
use App\Http\Controllers\PreBillingControler;
use App\Http\Controllers\ProcessingController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\QualityController;
use App\Http\Controllers\SendController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Events\PreBilling;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/broadcast',function(){
    brodcast( new PreBilling());
    return "Message Sent";
});

Route::get('/hashing/{text}',function($text){
    echo Hash::make($text);
});

//Auth
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/forgot-password', [UsersController::class , 'forgotPassword']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
    ], function(){
        Route::get('/me',[AuthController::class,'me']);
        Route::get('/logout',[AuthController::class,'logout']);
});

//Users
Route::group([
        'middleware' => 'api',
        'prefix' => 'user'
    ],function(){
        Route::get('/list-all',[UsersController::class , 'list']);
        Route::get('/{id}',[UsersController::class , 'show']);
        Route::post('/create',[UsersController::class , 'create']);
        Route::post('/update',[UsersController::class , 'update']);
        Route::put('/change-status/{id}',[UsersController::class , 'changeStatus']);
        Route::post('/reset-password',[UsersController::class , 'changePassword']);
});

//Employees
Route::group([
        'middleware' => 'api',
        'prefix' => 'employee'
    ],function(){
        Route::get('/list-all',[EmployeesController::class , 'list']);
        Route::get('/{id}',[EmployeesController::class, 'show']);
        Route::post('/create',[EmployeesController::class , 'create']);
        Route::put('/update/{id}',[EmployeesController::class , 'update']);
        Route::put('/change-status/{id}',[EmployeesController::class , 'changeStatus']);
});

//Pick Up Companies
Route::group([
        'middleware' => 'api',
        'prefix'=>'pick-up-company'
    ],function(){
        Route::get('/list-all',[PickUpCompanyController::class,'list']);
        Route::get('/{id}',[PickUpCompanyController::class,'show']);
        Route::post('/create',[PickUpCompanyController::class,'create']);
        Route::put('/update/{id}',[PickUpCompanyController::class,'update']);
        Route::put('/change-status/{id}',[PickUpCompanyController::class,'changeStatus']);
});

//Costumers
Route::group([
        'middleware' => 'api',
        'prefix' => 'costumer'
    ],function(){
        Route::get('/list-all',[CostumersController::class,'listAll']);
        Route::get('/{id}',[CostumersController::class,'show']);
        Route::post('/create',[CostumersController::class,'create']);
        Route::put('/update/{id}',[CostumersController::class,'update']);
        Route::put('/change-status/{id}',[CostumersController::class,'changeStatus']);
        Route::get('/list-all/boutiques',[CostumersController::class,'listAllAndBoutiques']);
        Route::get('/list-all/customers',[CostumersController::class,'listAllActive']);
        Route::get('/not-process/list/shops/{id}',[CostumersController::class, 'listShipperNotProcess']);
        Route::post('/not-process/create/shop',[CostumersController::class,'createShopNotProcess']);
        Route::post('/not-process/delete/shop',[CostumersController::class,'deleteShopNotProcess']);
});

//Boutique
Route::group([
        'middleware' => 'api',
        'prefix'=>'boutique'
    ],function(){
        Route::get('/list-all-per-costumer/{idCostumer}',[BoutiquesController::class,'listAllPerCostumer']);
        Route::get('/{id}',[BoutiquesController::class,'show']);
        Route::post('/create',[BoutiquesController::class,'create']);
        Route::put('/update/{id}',[BoutiquesController::class,'update']);
        Route::get('/instructions/{idCustomer}',[BoutiquesController::class,'instructions']);
});

//Instructions
Route::group([
        'middleware' => 'api',
        'prefix'=>'instrucction'
    ],function(){
        Route::post('/create/per-costumer',[InstructionsController::class,'create']);
});
    
//Profile
Route::group([
        'middleware' => 'api',
        'prefix'=>'profile'
    ],function(){
        Route::get('/list-all',[ProfilesController::class,'listAll']);
        Route::post('/create',[ProfilesController::class,'create']);
        Route::get('/show/users/module/{moduleName}', [ProfilesController::class,'showUsersModule']);
    }
);

//Modules
Route::group([
        'middleware' => 'api',
        'prefix'=>'module'
    ],function(){
        Route::get('/list-all',[ModulesController::class,'listAll']);
        Route::post('/create',[ModulesController::class,'create']);
    }
);

//Labels
Route::group([
        'middleware' => 'api',
        'prefix' => 'label'
    ],function(){
        Route::get('/print/content/list-all',[LabelCreateController::class,'listAllLabelContents']);
        Route::post('/print/content/create',[LabelCreateController::class, 'createLabelContent']);
        Route::get('/print/size/list-all',[LabelCreateController::class,'listAllLabelsSize']);
        Route::post('/print/size/create',[LabelCreateController::class,'createLabelsSize']);
    }
);

//Receiving
Route::group([
        'middleware' => 'api',
        'prefix' => 'receive'    
    ], function(){
        Route::post('/create',[ReceiveController::class,'create']);
        Route::get('/list-per-date/{date}',[ReceiveController::class,'queryByDate']);
        Route::get('/details/list-per-date/{date}',[ReceiveController::class,'queryDetailsPerDate']);
        Route::get('/list-all',[ReceiveController::class,'queryAll']);
        Route::get('/details/list-all',[ReceiveController::class,'queryAllDetails']);
        Route::post('/upser/ticket',[ReceiveController::class, 'addTicketSupport']);
        Route::get('/ticket/{idReceive}',[ReceiveController::class, 'getTicket']);
        Route::get('/delete/{idB64REceive}/{followNumber}',[ReceiveController::class, 'delete']);
        Route::get('/details/list-all',[ReceiveController::class,'queryAllDetails']);
});

//Shippers
    Route::group([
        'middleware' => 'api',
        'prefix' => 'shippers'    
    ], function(){
        Route::get('/list-all',[ShippersController::class,'listAll']);
        Route::post('/create',[ShippersController::class,'create']);
        Route::get('/list/process-notprocess/{id}',[ShippersController::class,'listProcessNotProcess']);
        Route::get('/verify/process-not/{idCustomer}/{idShipper}',[ShippersController::class,'processOrNot']);
});

//Products
Route::group([
        'middleware' => 'api',
        'prefix' => 'products'    
    ], function(){
        Route::get('/list-all',[ProductsController::class, 'show']);
        Route::post('/create',[ProductsController::class,'create']);
        Route::get('/boxes/list',[ProductsController::class,'showWithBoxes']);
        Route::get('/boxes',[ProductsController::class,'showBoxes']);
});

//Boxes
Route::group([
        'middleware' => 'api',
        'prefix' => 'box'    
    ], function(){
        Route::get('/list-all',[BoxesController::class,'list']);
        Route::post('/create',[BoxesController::class,'create']);
});

//QrCodes
Route::group([
        'middleware' => 'api',
        'prefix' => 'qr-code'    
    ],function(){
        Route::get('/pre-bill/show/info/{code}/{channel}',[QrCodesController::class,'readQrPreBill']);
        Route::get('/processing/show/info/{code}',[QrCodesController::class,'readQrProcessing']);
        Route::get('/quality/show/info/{code}',[QrCodesController::class,'readQrQuality']);
        Route::get('/shipping/show/info/{code}/{channel}',[QrCodesController::class,'readQrShipping']);
});

//PreBilling
Route::group([
        'middleware' => 'api',
        'prefix' => 'pre-bill'        
    ],function(){
        Route::post('/create',[PreBillingControler::class,'create']);
        Route::get('/list-all',[PreBillingControler::class,'index']);
});

//Processing manufacturing
Route::group([
        'middleware' => 'api',
        'prefix' => 'processing'        
    ],function(){
        Route::post('/create',[ProcessingController::class,'create']);
});

//Quality
Route::group([
        'middleware' => 'api',
        'prefix' => 'quality'        
    ],function(){
        Route::post('/create',[QualityController::class,'create']);
});

//Send
Route::group([
        'middleware' => 'api',
        'prefix' => 'send'        
    ],function(){
        Route::post('/create',[SendController::class,'createPrepare']);
        Route::get('/to-deliver', [SendController::class,'toDelivery']);
        Route::get('/to-deliver/customer/{idCustomer}', [SendController::class,'toDeliveryPerCustumer']);
});
