<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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

Route::apiResources([
    'user' => API\UserController::class,
    'doctor' => API\DoctorController::class,
    'nurse' => API\NurseController::class,
    'pharmacist' => API\PharmacistController::class,
    'accountant' => API\AccountantController::class,
    'staff' => API\StaffController::class,
    'patient' => API\PatientController::class,
    'patientvital' => API\PatientVitalController::class,
    'message' => API\MessageController::class,
    'room' => API\RoomController::class,
    'pendinglab' => API\LabController::class,
    'lab' => API\LabFindingController::class,
    'inpatient' => API\InpatientController::class,
    'outpatient' => API\OutpatientController::class,
    'consultbill' => API\ConsultationBillController::class,
    'labtestbill' => API\LabTestBillController::class,
    'drugbill' => API\DrugBillController::class,
    'consult' => API\ConsultationController::class,
    'prescribe' => API\PrescriptionController::class,
    'purchasedrug' => API\DrugPurchaseController::class,
    'drug' => API\DrugController::class,
    'labtest' => API\LabTestController::class,
    'payment' => API\PaymentController::class,
    'consultcharge' => API\ConsultationChargeController::class,
    'drugcharge' => API\DrugChargeController::class,
    'labtestcharge' => API\LabTestChargeController::class
]);

Route::post('message',[API\ConversationController::class,'sendMessage']);
Route::post('chat/{id}',[API\ConversationController::class,'addChat']);
Route::get('chat',[API\ConversationController::class,'fetchChat']);
Route::get('listdoctors',[API\DoctorController::class,'list']);
Route::get('listpatients',[API\PatientController::class,'list']);
Route::get('labfindings',[API\LabFindingController::class,'labFindings']);
Route::get('pendingprescribe',[API\PrescriptionController::class,'pendingPrescribe']);
Route::get('listlabs',[API\LabController::class,'list']);
Route::get('listlabtests',[API\LabTestController::class,'list']);
Route::get('listdrugs',[API\DrugController::class,'list']);
Route::get('listusers',[API\UserController::class,'list']);
Route::get('listpayments',[API\PaymentController::class,'list']);
Route::get('listconsultationcharges',[API\ConsultationChargeController::class,'list']);
Route::get('sentmessage',[API\MessageController::class,'indexsent']);
Route::get('countmessage',[API\MessageController::class,'countMessage']);
// Route::get('newmessage',[API\MessageController::class,'newMessage']);
Route::post('dischargeinpatient/{id}',[API\InpatientController::class,'discharge']);
Route::get('profile',[API\ProfileController::class,'index']);
Route::put('profile',[API\ProfileController::class,'update']);
Route::get('countsentmessages',[API\ProfileController::class,'countSent']);
Route::get('countreceivedmessages',[API\ProfileController::class,'countReceived']);
Route::get('countchatmessages',[API\ProfileController::class,'countChats']);
Route::get('countpatients',[API\PatientController::class,'countPatients']);
Route::get('countpatientvitals',[API\PatientVitalController::class,'countPatientVitals']);
Route::get('countconsultations',[API\ConsultationController::class,'countConsultations']);
Route::get('countlabfindings',[API\LabFindingController::class,'countLabFindings']);
Route::get('countprescriptions',[API\PrescriptionController::class,'countPrescriptions']);
Route::get('countdrugpurchases',[API\DrugPurchaseController::class,'countDrugPurchases']);
Route::get('countpendinglabs',[API\LabController::class,'countPendingLabs']);
Route::get('countpendinglabfindings',[API\LabFindingController::class,'countPendingLabFindings']);
Route::get('countpendingdrugsales',[API\DrugPurchaseController::class,'countPendingDrugSales']);
Route::get('completedlabfindings',[API\LabFindingController::class,'completedLabFindings']);
Route::get('completedprescriptions',[API\PrescriptionController::class,'completedPrescriptions']);
