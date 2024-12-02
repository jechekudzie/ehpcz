<?php

use App\Http\Controllers\ActiveExchangeRateTypeController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\VotingLoginController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\ElectionController;
use App\Http\Controllers\ElectionGroupController;
use App\Http\Controllers\ElectionGroupProfessionController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\ExchangeRateTypeController;
use App\Http\Controllers\FeeCategoryController;
use App\Http\Controllers\FeeItemController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\PractitionerIdentificationController;
use App\Http\Controllers\PractitionerProfessionsController;
use App\Http\Controllers\ProfessionalQualificationController;
use App\Http\Controllers\ProfessionalQualificationFilesController;
use App\Http\Controllers\RegistrationApprovalController;
use App\Http\Controllers\RegistrationRuleController;
use App\Http\Controllers\SignatureController;

use App\Models\ActiveExchangeRateType;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\IdentificationTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProfessionController;
use App\Http\Controllers\AddressTypeController;
use App\Http\Controllers\ContactTypeController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\PaymentCategoryController;
use App\Http\Controllers\QualificationLevelController;
use App\Http\Controllers\RequirementCategoryController;
use App\Http\Controllers\AccreditedInstitutionController;
use App\Http\Controllers\QualificationCategoryController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your website application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::resource('elections', ElectionController::class);

Route::patch('/elections/{election}/status-update', [ElectionController::class, 'updateStatus'])->name('elections.updateStatus');


//election group routes where election group belong to an election
// Use resource routing with shallow nesting for ElectionGroup under Election
Route::resource('elections.groups', ElectionGroupController::class)->shallow();

// Route to view and manage professions within an election group
Route::get('elections/{election}/groups/{group}/professions', [ElectionGroupProfessionController::class, 'index'])->name('elections.groups.professions.index');
Route::post('elections/{election}/groups/{group}/professions', [ElectionGroupProfessionController::class, 'store'])->name('elections.groups.professions.store');
Route::delete('elections/{election}/groups/{group}/professions/{profession}', [ElectionGroupProfessionController::class, 'destroy'])->name('elections.groups.professions.destroy');

// Category management routes for a group within an election
Route::get('elections/{election}/groups/{group}/categories', [\App\Http\Controllers\ProfessionCategoryController::class, 'index'])->name('elections.groups.categories.index');
Route::post('elections/{election}/groups/{group}/categories', [\App\Http\Controllers\ProfessionCategoryController::class, 'store'])->name('elections.groups.categories.store');
Route::delete('elections/{election}/groups/{group}/categories/{category}', [\App\Http\Controllers\ProfessionCategoryController::class, 'destroy'])->name('elections.groups.categories.destroy');

//Candidates
Route::get('elections/{election}/categories/{category}/candidates', [\App\Http\Controllers\CandidateController::class, 'index'])->name('elections.categories.candidates.index');
Route::post('elections/{election}/categories/{category}/candidates', [\App\Http\Controllers\CandidateController::class, 'store'])->name('elections.categories.candidates.store');
Route::delete('elections/{election}/categories/{category}/candidates/{candidate}', [\App\Http\Controllers\CandidateController::class, 'destroy'])->name('elections.categories.candidates.destroy');

Route::get('elections/{election}/categories/{category}/practitioners/search', [CandidateController::class, 'searchPractitioners'])->name('elections.categories.practitioners.search');

//Elections /index
Route::get('/voting', [\App\Http\Controllers\ElectionVotingController::class, 'index'])->name('election-voting.index');


Route::get('/voting/login', [VotingLoginController::class, 'showLoginForm'])->name('voting.login');
Route::post('/voting/authenticate', [VotingLoginController::class, 'authenticate'])->name('voting.authenticate');
Route::get('/otp/verify/{practitioner_id}/{election_id}/{mobile_number}/{id_number}', [VotingLoginController::class, 'showOTPVerificationForm'])->name('otp.verify');
Route::post('/otp/verify', [VotingLoginController::class, 'verifyOTP'])->name('otp.verify.submit');
Route::get('/logout', [VotingLoginController::class, 'logout'])->name('practitioner.logout');

Route::get('/elections/practitioners/{practitioner}/edit', [VotingLoginController::class, 'edit'])->name('practitioner.update');
Route::post('/elections/practitioners/{practitioner}/update', [VotingLoginController::class, 'update'])->name('practitioner.update.submit');
// Show OTP verification form
Route::get('/elections/practitioners/{practitioner}/verify-otp', [VotingLoginController::class, 'showVerifyOtpForm'])->name('practitioner.verify.otp.form');

// Handle OTP verification
Route::post('/elections/practitioners/{practitioner}/verify-otp', [VotingLoginController::class, 'verifyOtpForPractitioner'])->name('practitioner.verify.otp');

//Dummy votes route
Route::get('/voting/dummy-votes', [\App\Http\Controllers\ElectionVotingController::class, 'simulateVotes'])->name('voting.dummy-votes');

//voting results
Route::get('/voting/results', [\App\Http\Controllers\ElectionVotingController::class, 'results'])->name('voting.results');

//voters roll
Route::get('/voting/voters-roll', [\App\Http\Controllers\ElectionVotingController::class, 'votersRoll'])->name('voting.voters-roll');

Route::get('/datanow', function () {

    $professions = \App\Models\Profession::all();
    $qualifications = \App\Models\Qualification::all();

    foreach ($professions as $profession) {

        echo  $profession->name . '<br>';
    }

    echo '<br>';
    echo '<br>';
    echo '<br>';

    foreach ($qualifications as $qualification) {

        echo  $qualification->name . '<br>';
    }


});


Route::get('/', function () {

    return view('auth.login');

});

Route::get('/index', function () {

    return view('index');

});

Route::get('/practitioner/index', function () {

    return view('administration.practitioners.index');

});



/*
|--------------------------------------------------------------------------
| Administration Dashboard Utilities Routes
|--------------------------------------------------------------------------
*/

//system users for UserController
Route::get('admin/users/index', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');
Route::post('admin/users/store', [\App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
Route::get('admin/users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('admin.users.edit');
Route::patch('admin/users/{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
Route::delete('admin/users/{user}/destroy', [\App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');

//practitioner data
Route::get('admin/practitioner-data/index', [\App\Http\Controllers\PractitionerDataController::class, 'index'])->name('admin.practitioner-data.index');

//paynow routes
Route::get('/paynow', [\App\Http\Controllers\AdminController::class, 'initiatePayment'])->name('paynow');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['role:admin|super-admin|reception|accountant|accounts-clerk|procurement|registrar']], function () {
        // Define your routes here

//create import route for PractitionersImportController
        Route::get('import/practitioners', [\App\Http\Controllers\PractitionersImportController::class, 'index'])->name('import.practitioners');
//store import route for PractitionersImportController
        Route::post('import/practitioners', [\App\Http\Controllers\PractitionersImportController::class, 'store'])->name('import.practitioners.store');


// Landing page
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

// TitleController
        Route::resource('titles', TitleController::class)->names([
            'index' => 'titles.index',
            'create' => 'titles.create',
            'store' => 'titles.store',
            'show' => 'titles.show',
            'edit' => 'titles.edit',
            'update' => 'titles.update',
            'destroy' => 'titles.destroy',
        ]);

// GenderController
        Route::resource('genders', GenderController::class)->names([
            'index' => 'genders.index',
            'create' => 'genders.create',
            'store' => 'genders.store',
            'show' => 'genders.show',
            'edit' => 'genders.edit',
            'update' => 'genders.update',
            'destroy' => 'genders.destroy',
        ]);

// IdentificationTypeController
        Route::resource('identification-types', IdentificationTypeController::class)->names([
            'index' => 'identification-types.index',
            'create' => 'identification-types.create',
            'store' => 'identification-types.store',
            'show' => 'identification-types.show',
            'edit' => 'identification-types.edit',
            'update' => 'identification-types.update',
            'destroy' => 'identification-types.destroy',
        ]);

// ContactTypeController
        Route::resource('contact-types', ContactTypeController::class)->names([
            'index' => 'contact-types.index',
            'create' => 'contact-types.create',
            'store' => 'contact-types.store',
            'show' => 'contact-types.show',
            'edit' => 'contact-types.edit',
            'update' => 'contact-types.update',
            'destroy' => 'contact-types.destroy',
        ]);

// AddressTypeController
        Route::resource('address-types', AddressTypeController::class)->names([
            'index' => 'address-types.index',
            'create' => 'address-types.create',
            'store' => 'address-types.store',
            'show' => 'address-types.show',
            'edit' => 'address-types.edit',
            'update' => 'address-types.update',
            'destroy' => 'address-types.destroy',
        ]);

// ProfessionController
        Route::resource('professions', ProfessionController::class)->names([
            'index' => 'professions.index',
            'create' => 'professions.create',
            'store' => 'professions.store',
            'show' => 'professions.show',
            'edit' => 'professions.edit',
            'update' => 'professions.update',
            'destroy' => 'professions.destroy',
        ]);

// QualificationController
        Route::resource('qualifications', QualificationController::class)->names([
            'index' => 'qualifications.index',
            'create' => 'qualifications.create',
            'store' => 'qualifications.store',
            'show' => 'qualifications.show',
            'edit' => 'qualifications.edit',
            'update' => 'qualifications.update',
            'destroy' => 'qualifications.destroy',
        ]);

// QualificationCategoryController
        Route::resource('qualification-categories', QualificationCategoryController::class)->names([
            'index' => 'qualification-categories.index',
            'create' => 'qualification-categories.create',
            'store' => 'qualification-categories.store',
            'show' => 'qualification-categories.show',
            'edit' => 'qualification-categories.edit',
            'update' => 'qualification-categories.update',
            'destroy' => 'qualification-categories.destroy',
        ]);

// QualificationLevelController
        Route::resource('qualification-levels', QualificationLevelController::class)->names([
            'index' => 'qualification-levels.index',
            'create' => 'qualification-levels.create',
            'store' => 'qualification-levels.store',
            'show' => 'qualification-levels.show',
            'edit' => 'qualification-levels.edit',
            'update' => 'qualification-levels.update',
            'destroy' => 'qualification-levels.destroy',
        ]);

// RequirementsCategoryController
        Route::resource('requirement-categories', RequirementCategoryController::class)->names([
            'index' => 'requirement-categories.index',
            'create' => 'requirement-categories.create',
            'store' => 'requirement-categories.store',
            'show' => 'requirement-categories.show',
            'edit' => 'requirement-categories.edit',
            'update' => 'requirement-categories.update',
            'destroy' => 'requirement-categories.destroy',
        ]);

// RequirementController
        Route::resource('requirements', RequirementController::class)->names([
            'index' => 'requirements.index',
            'create' => 'requirements.create',
            'store' => 'requirements.store',
            'show' => 'requirements.show',
            'edit' => 'requirements.edit',
            'update' => 'requirements.update',
            'destroy' => 'requirements.destroy',
        ]);

// RegisterController
        Route::resource('registers', RegisterController::class)->names([
            'index' => 'registers.index',
            'create' => 'registers.create',
            'store' => 'registers.store',
            'show' => 'registers.show',
            'edit' => 'registers.edit',
            'update' => 'registers.update',
            'destroy' => 'registers.destroy',
        ]);

// InstitutionController
        Route::resource('institutions', InstitutionController::class)->names([
            'index' => 'institutions.index',
            'create' => 'institutions.create',
            'store' => 'institutions.store',
            'show' => 'institutions.show',
            'edit' => 'institutions.edit',
            'update' => 'institutions.update',
            'destroy' => 'institutions.destroy',
        ]);

// AccreditedInstitutionController
        Route::resource('accredited-institutions', AccreditedInstitutionController::class)->names([
            'index' => 'accredited-institutions.index',
            'create' => 'accredited-institutions.create',
            'store' => 'accredited-institutions.store',
            'show' => 'accredited-institutions.show',
            'edit' => 'accredited-institutions.edit',
            'update' => 'accredited-institutions.update',
            'destroy' => 'accredited-institutions.destroy',
        ]);

//conditions
        Route::get('admin/conditions/index', [\App\Http\Controllers\ConditionController::class, 'index'])->name('admin.conditions.index');
        Route::post('admin/conditions/store', [\App\Http\Controllers\ConditionController::class, 'store'])->name('admin.conditions.store');
        Route::get('admin/conditions/{condition}/edit', [\App\Http\Controllers\ConditionController::class, 'edit'])->name('admin.conditions.edit');
        Route::patch('admin/conditions/{condition}/update', [\App\Http\Controllers\ConditionController::class, 'update'])->name('admin.conditions.update');
        Route::delete('admin/conditions/{condition}/destroy', [\App\Http\Controllers\ConditionController::class, 'destroy'])->name('admin.conditions.destroy');

//signatures
        Route::get('admin/signatures/index', [\App\Http\Controllers\SignatureController::class, 'index'])->name('admin.signatures.index');
        Route::post('admin/signatures/store', [\App\Http\Controllers\SignatureController::class, 'store'])->name('admin.signatures.store');
        Route::get('admin/signatures/{signature}/edit', [\App\Http\Controllers\SignatureController::class, 'edit'])->name('admin.signatures.edit');
        Route::patch('admin/signatures/{signature}/update', [\App\Http\Controllers\SignatureController::class, 'update'])->name('admin.signatures.update');
        Route::delete('admin/signatures/{signature}/destroy', [\App\Http\Controllers\SignatureController::class, 'destroy'])->name('admin.signatures.destroy');

//mark signature as active
        Route::get('admin/signatures/activate/{signature}', [SignatureController::class, 'toggleActivation'])->name('admin.signatures.activate');


//create permissions
        Route::get('/admin/permissions', [\App\Http\Controllers\PermissionController::class, 'index'])->name('admin.permissions.index');
        Route::post('/admin/permissions/store', [\App\Http\Controllers\PermissionController::class, 'store'])->name('admin.permissions.store');
        Route::get('/admin/permissions/{permission}/edit', [\App\Http\Controllers\PermissionController::class, 'edit'])->name('admin.permissions.edit');
        Route::patch('/admin/permissions/{permission}/update', [\App\Http\Controllers\PermissionController::class, 'update'])->name('admin.permissions.update');
        Route::delete('/admin/permissions/{permission}', [\App\Http\Controllers\PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

//assign permission to organisation roles
        Route::get('/admin/permissions/{role}/assignPermission', [\App\Http\Controllers\PermissionController::class, 'assignPermission'])->name('admin.permissions.assign');
        Route::post('/admin/permissions/{role}/assignPermissionToRole', [\App\Http\Controllers\PermissionController::class, 'assignPermissionToRole'])->name('admin.permissions.assign-permission-to-role');

//roles controller
        Route::resource('admin/roles', \App\Http\Controllers\RolesController::class)->names([
            'index' => 'roles.index',
            'create' => 'roles.create',
            'store' => 'roles.store',
            'show' => 'roles.show',
            'edit' => 'roles.edit',
            'update' => 'roles.update',
            'destroy' => 'roles.destroy',
        ]);


        /*// PaymentCategoryController
        Route::resource('payment-categories', PaymentCategoryController::class)->names([
            'index' => 'payment-categories.index',
            'create' => 'payment-categories.create',
            'store' => 'payment-categories.store',
            'show' => 'payment-categories.show',
            'edit' => 'payment-categories.edit',
            'update' => 'payment-categories.update',
            'destroy' => 'payment-categories.destroy',
        ]);*/


    });


    /*
    |--------------------------------------------------------------------------
    | Practitioners Dashboard Routes
    |--------------------------------------------------------------------------
    */

//PractitionerController Routes
    Route::resource('practitioners', PractitionerController::class)->names([
        'index' => 'practitioners.index',
        'create' => 'practitioners.create',
        'store' => 'practitioners.store',
        'show' => 'practitioners.show',
        'edit' => 'practitioners.edit',
        'update' => 'practitioners.update',
        'destroy' => 'practitioners.destroy',
    ]);


// Practitioner Identification Routes
    Route::post('practitioner-identifications/store/{practitioner}', [PractitionerIdentificationController::class, 'store'])->name('practitioner-identifications.store');
    Route::get('practitioner-identifications/{practitionerIdentification}/edit', [PractitionerIdentificationController::class, 'edit'])->name('practitioner-identifications.edit');
    Route::patch('practitioner-identifications/{practitionerIdentification}/update', [PractitionerIdentificationController::class, 'update'])->name('practitioner-identifications.update');
    Route::delete('practitioner-identifications/{identification}', [PractitionerIdentificationController::class, 'destroy'])->name('practitioner-identifications.destroy');

// Practitioner Contact Routes
    Route::get('practitioner-contacts', [ContactController::class, 'index'])->name('practitioner-contacts.index');
    Route::post('practitioner-contacts/{practitioner}/store', [ContactController::class, 'store'])->name('practitioner-contacts.store');

// Practitioner Address Routes
    Route::get('practitioner-address', [AddressController::class, 'index'])->name('practitioner-address.index');
    Route::post('practitioner-address/{practitioner}/store', [AddressController::class, 'store'])->name('practitioner-address.store');


//Practitioner Employment EmploymentController Routes
    Route::get('practitioner-employments/{practitioner}', [EmploymentController::class, 'index'])->name('practitioner-employments.index');
//store route
    Route::post('practitioner-employments/{practitioner}/store', [EmploymentController::class, 'store'])->name('practitioner-employments.store');
//edit route
    Route::get('practitioner-employments/{employment}/edit', [EmploymentController::class, 'edit'])->name('practitioner-employments.edit');
//update route
    Route::patch('practitioner-employments/{employment}/update', [EmploymentController::class, 'update'])->name('practitioner-employments.update');

//Practitioner professions routes
    Route::get('practitioner-professions/{practitioner}', [PractitionerProfessionsController::class, 'index'])->name('practitioner-professions.index');
//store route
    Route::post('practitioner-professions/{practitioner}/store', [PractitionerProfessionsController::class, 'store'])->name('practitioner-professions.store');
//edit route
    Route::get('practitioner-professions/{practitionerProfession}/edit', [PractitionerProfessionsController::class, 'edit'])->name('practitioner-professions.edit');
//update route
    Route::patch('practitioner-professions/{practitionerProfession}/update', [PractitionerProfessionsController::class, 'update'])->name('practitioner-professions.update');


//Practitioner Professional Qualifications routes for ProfessionalQualificationController
    Route::get('practitioner-professional-qualifications/{practitionerProfession}', [ProfessionalQualificationController::class, 'index'])->name('practitioner-professional-qualifications.index');
//store route
    Route::post('practitioner-professional-qualifications/{practitionerProfession}/store', [ProfessionalQualificationController::class, 'store'])->name('practitioner-professional-qualifications.store');
//edit route
    Route::get('practitioner-professional-qualifications/{professionalQualification}/edit', [ProfessionalQualificationController::class, 'edit'])->name('practitioner-professional-qualifications.edit');
//update route
    Route::patch('practitioner-professional-qualifications/{professionalQualification}/update', [ProfessionalQualificationController::class, 'update'])->name('practitioner-professional-qualifications.update');
//delete route
    Route::delete('practitioner-professional-qualifications/{professionalQualification}/destroy', [ProfessionalQualificationController::class, 'destroy'])->name('practitioner-professional-qualifications.destroy');


////Practitioner Professional Qualifications routes for ProfessionalQualificationFilesController
//professional qualifications files
    Route::get('professional-qualification-files/{professionalQualification}/index', [ProfessionalQualificationFilesController::class, 'index'])->name('practitioner-professional-qualifications.file.index');
//professional qualifications files store
    Route::post('professional-qualification-files/{professionalQualification}/files/store', [ProfessionalQualificationFilesController::class, 'store'])->name('practitioner-professional-qualifications.files.store');
//professional qualifications files edit
    Route::get('professional-qualification-files/{professionalQualification}/files/{qualificationFile}/edit', [ProfessionalQualificationFilesController::class, 'edit'])->name('practitioner-professional-qualifications.files.edit');
//professional qualifications files update
    Route::patch('professional-qualification-files/{professionalQualification}/update', [ProfessionalQualificationFilesController::class, 'update'])->name('practitioner-professional-qualifications.files.update');
//professional qualifications files destroy
    Route::delete('professional-qualification-files/{professionalQualification}/destroy', [ProfessionalQualificationFilesController::class, 'destroy'])->name('practitioner-professional-qualifications.files.destroy');

//FeesCategory
    Route::get('fees-categories/index', [FeeCategoryController::class, 'index'])->name('fees-categories.index');
    Route::post('fees-categories/store', [FeeCategoryController::class, 'store'])->name('fees-categories.store');
    Route::get('fees-categories/{feeCategory}/edit', [FeeCategoryController::class, 'edit'])->name('fees-categories.edit');
    Route::patch('fees-categories/{feeCategory}/update', [FeeCategoryController::class, 'update'])->name('fees-categories.update');
    Route::delete('fees-categories/{feeCategory}/destroy', [FeeCategoryController::class, 'destroy'])->name('fees-categories.destroy');

//fees items for a category
    Route::get('fees-categories/{feeCategory}/index', [FeeItemController::class, 'index'])->name('fees-categories.items');
    Route::post('fees-categories/{feeCategory}/items/store', [FeeItemController::class, 'store'])->name('fees-categories.items.store');
    Route::get('fees-categories/{feeCategory}/items/{feeItem}/edit', [FeeItemController::class, 'edit'])->name('fees-categories.items.edit');
    Route::patch('fees-categories/{feeCategory}/items/{feeItem}/update', [FeeItemController::class, 'update'])->name('fees-categories.items.update');
    Route::delete('fees-categories/{feeCategory}/items/{feeItem}/destroy', [FeeItemController::class, 'destroy'])->name('fees-categories.items.destroy');


//registration rules
    Route::get('registration-rules/index', [RegistrationRuleController::class, 'index'])->name('registration-rules.index');
    Route::post('registration-rules/store', [RegistrationRuleController::class, 'store'])->name('registration-rules.store');
    Route::get('registration-rules/{registrationRule}/edit', [RegistrationRuleController::class, 'edit'])->name('registration-rules.edit');
    Route::patch('registration-rules/{registrationRule}/update', [RegistrationRuleController::class, 'update'])->name('registration-rules.update');
    Route::delete('registration-rules/{registrationRule}/destroy', [RegistrationRuleController::class, 'destroy'])->name('registration-rules.destroy');


//exchange rate types
    Route::get('exchange-rate-types/index', [ExchangeRateTypeController::class, 'index'])->name('exchange-rate-types.index');
    Route::post('exchange-rate-types/store', [ExchangeRateTypeController::class, 'store'])->name('exchange-rate-types.store');
    Route::get('exchange-rate-types/{exchangeRateType}/edit', [ExchangeRateTypeController::class, 'edit'])->name('exchange-rate-types.edit');
    Route::patch('exchange-rate-types/{exchangeRateType}/update', [ExchangeRateTypeController::class, 'update'])->name('exchange-rate-types.update');
    Route::delete('exchange-rate-types/{exchangeRateType}/destroy', [ExchangeRateTypeController::class, 'destroy'])->name('exchange-rate-types.destroy');

//exchange rates
    Route::get('exchange-rates/{exchangeRateType}/index', [ExchangeRateController::class, 'index'])->name('exchange-rates.index');
    Route::post('exchange-rates/{exchangeRateType}/store', [ExchangeRateController::class, 'store'])->name('exchange-rates.store');
    Route::get('exchange-rates/{exchangeRate}/edit', [ExchangeRateController::class, 'edit'])->name('exchange-rates.edit');
    Route::patch('exchange-rates/{exchangeRate}/update', [ExchangeRateController::class, 'update'])->name('exchange-rates.update');
    Route::delete('exchange-rates/{exchangeRate}/destroy', [ExchangeRateController::class, 'destroy'])->name('exchange-rates.destroy');


//activate exchange rate type
    Route::post('exchange-rate-types/activate', [ActiveExchangeRateTypeController::class, 'activate'])->name('exchange-rate-types.activate');

//penalties
    Route::get('penalties/index', [PenaltyController::class, 'index'])->name('penalties.index');
    Route::post('penalties/store', [PenaltyController::class, 'store'])->name('penalties.store');
    Route::get('penalties/{penalty}/edit', [PenaltyController::class, 'edit'])->name('penalties.edit');
    Route::patch('penalties/{penalty}/update', [PenaltyController::class, 'update'])->name('penalties.update');
    Route::delete('penalties/{penalty}/destroy', [PenaltyController::class, 'destroy'])->name('penalties.destroy');

//registration for qualification
    Route::get('registration/{practitionerProfession}/{professionalQualification}/{practitioner}', [\App\Http\Controllers\RegistrationController::class, 'index'])->name('registration.index');
    Route::get('registration/{practitionerProfession}', [\App\Http\Controllers\RegistrationController::class, 'create'])->name('registration.create');
    Route::post('registration/{practitionerProfession}/store', [\App\Http\Controllers\RegistrationController::class, 'storeRegistration'])->name('registration.store');

//renewals
    Route::get('renewals/{practitioner}', [\App\Http\Controllers\RenewalController::class, 'index'])->name('renewals.index');
    Route::post('renewals/{practitioner}/store', [\App\Http\Controllers\RenewalController::class, 'store'])->name('renewals.store');
    Route::get('renewals/{renewal}/edit', [\App\Http\Controllers\RenewalController::class, 'edit'])->name('renewals.edit');
    Route::patch('renewals/{renewal}/update', [\App\Http\Controllers\RenewalController::class, 'update'])->name('renewals.update');
    Route::delete('renewals/{renewal}/destroy', [\App\Http\Controllers\RenewalController::class, 'destroy'])->name('renewals.destroy');

//renewal payments
    Route::get('renewals/{renewal}/payments', [\App\Http\Controllers\PaymentController::class, 'index'])->name('renewal.payments.index');
    Route::get('renewals/{renewal}/payments/create', [\App\Http\Controllers\PaymentController::class, 'create'])->name('renewal.payments.create');
    Route::post('renewals/{renewal}/payments/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('renewal.payments.store');
    Route::get('renewals/{renewal}/payments/{payment}/edit', [\App\Http\Controllers\PaymentController::class, 'edit'])->name('renewal.payments.edit');
    Route::patch('renewals/{renewal}/payments/{payment}/update', [\App\Http\Controllers\PaymentController::class, 'update'])->name('renewal.payments.update');
    Route::delete('renewals/{renewal}/payments/{payment}/destroy', [\App\Http\Controllers\PaymentController::class, 'destroy'])->name('renewal.payments.destroy');

//paynow update
    Route::get('renewals/{transactionReference}/payments/paynow/update', [\App\Http\Controllers\PaymentController::class, 'paynowUpdate'])->name('renewal.payments.paynow.update');

//payment payment summary
    Route::get('renewals/{renewal}/payment/{payment}/summary', [\App\Http\Controllers\PaymentController::class, 'summary'])
        ->name('renewals.payments.summary');

//renewal continuous professional development
    Route::get('renewals/{renewal}/cpd', [\App\Http\Controllers\ContinuousProfessionalDevelopmentController::class, 'index'])->name('renewal.cpd.index');
    Route::post('renewals/{renewal}/cpd/store', [\App\Http\Controllers\ContinuousProfessionalDevelopmentController::class, 'store'])->name('renewal.cpd.store');
    Route::get('renewals/{renewal}/cpd/{cpd}/edit', [\App\Http\Controllers\ContinuousProfessionalDevelopmentController::class, 'edit'])->name('renewal.cpd.edit');
    Route::patch('renewals/{renewal}/cpd/{cpd}/update', [\App\Http\Controllers\ContinuousProfessionalDevelopmentController::class, 'update'])->name('renewal.cpd.update');
    Route::delete('renewals/{renewal}/cpd/{cpd}/destroy', [\App\Http\Controllers\ContinuousProfessionalDevelopmentController::class, 'destroy'])->name('renewal.cpd.destroy');

//renewal certificate
    Route::get('renewals/{renewal}/certificate', [\App\Http\Controllers\CertificateController::class, 'index'])->name('renewal.certificate.index');
//show certificate
    Route::get('renewals/{renewal}/certificate/show', [\App\Http\Controllers\CertificateController::class, 'show'])->name('renewal.certificate.show');
    Route::post('renewals/{renewal}/certificate/store', [\App\Http\Controllers\CertificateController::class, 'store'])->name('renewal.certificate.store');
    Route::get('renewals/{renewal}/certificate/{certificate}/edit', [\App\Http\Controllers\CertificateController::class, 'edit'])->name('renewal.certificate.edit');

//approvals
//get approval page abd pass qualification
    Route::get('/qualifications/{professionalQualification}/approval', [RegistrationApprovalController::class, 'index'])->name('qualifications.approve.index');
    Route::get('/qualifications/{professionalQualification}/approve', [RegistrationApprovalController::class, 'create'])->name('qualifications.approve.create');
    Route::post('/qualifications/{professionalQualification}/approve-by-receptionist', [RegistrationApprovalController::class, 'approveByReceptionist'])->name('qualifications.approve-by-receptionist');
    Route::post('/qualifications/{professionalQualification}/approve-by-admin', [RegistrationApprovalController::class, 'approveByAdmin'])->name('qualifications.approve-by-admin');
    Route::post('/qualifications/{professionalQualification}/approve-by-accountant', [RegistrationApprovalController::class, 'approveByAccountant'])->name('qualifications.approve-by-accountant');
    Route::post('/qualifications/{professionalQualification}/approve-by-registrar', [RegistrationApprovalController::class, 'approveByRegistrar'])->name('qualifications.approve-by-registrar');

//checkForPaymentApproval
    Route::get('/qualifications/{payment}/check-for-payment-approval', [RegistrationApprovalController::class, 'checkForPaymentApproval'])->name('check-for-payment-approval');

});
//portal
// Route for the portal index page
Route::get('/portal', [PortalController::class, 'index'])->name('portal.index');

// R{}}ute to check the existence of a practitioner and redirect to confirmation page
Route::post('/portal/check-existence', [PortalController::class, 'checkExistence'])->name('portal.checkExistence');

// Route for registering a new user
Route::post('/portal/register', [PortalController::class, 'register'])->name('portal.register');

// Route for the confirmation page with practitioner details
Route::get('/portal/confirm/{practitioner}/{registration_number}/{email}/{identification_number}/{practitionerProfession}', [PortalController::class, 'confirm'])->name('portal.confirm');

//portal login
Route::post('/portal/login', [PortalController::class, 'login'])->name('portal.login');

//practitioner data
Route::get('/portal/practitioner-data', [\App\Http\Controllers\PractitionerDataController::class, 'create'])->name('portal.practitioner-data');
//store
Route::post('/portal/practitioner-data/store', [\App\Http\Controllers\PractitionerDataController::class, 'store'])->name('portal.practitioner-data.store');


/*
 *
|--------------------------------------------------------------------------
| Practitioners Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (Auth::check()) {
        // Destroy the active session
        Auth::logout();
    }
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');
