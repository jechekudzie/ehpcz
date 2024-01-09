<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\EmploymentController;
use App\Http\Controllers\PractitionerController;
use App\Http\Controllers\PractitionerIdentificationController;
use App\Http\Controllers\PractitionerProfessionsController;
use App\Http\Controllers\ProfessionalQualificationController;
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

Route::get('/', function () {

    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Administration Dashboard Utilities Routes
|--------------------------------------------------------------------------
*/

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

// PaymentCategoryController
Route::resource('payment-categories', PaymentCategoryController::class)->names([
    'index' => 'payment-categories.index',
    'create' => 'payment-categories.create',
    'store' => 'payment-categories.store',
    'show' => 'payment-categories.show',
    'edit' => 'payment-categories.edit',
    'update' => 'payment-categories.update',
    'destroy' => 'payment-categories.destroy',
]);



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
Route::get('practitioner-contacts', [ContactController::class,'index'])->name('practitioner-contacts.index');
Route::post('practitioner-contacts/{practitioner}/store', [ContactController::class,'store'])->name('practitioner-contacts.store');

// Practitioner Address Routes
Route::get('practitioner-address', [AddressController::class,'index'])->name('practitioner-address.index');
Route::post('practitioner-address/{practitioner}/store', [AddressController::class,'store'])->name('practitioner-address.store');


//Practitioner Employment EmploymentController Routes
Route::get('practitioner-employments/{practitioner}', [EmploymentController::class,'index'])->name('practitioner-employments.index');
//store route
Route::post('practitioner-employments/{practitioner}/store', [EmploymentController::class,'store'])->name('practitioner-employments.store');
//edit route
Route::get('practitioner-employments/{employment}/edit', [EmploymentController::class,'edit'])->name('practitioner-employments.edit');
//update route
Route::patch('practitioner-employments/{employment}/update', [EmploymentController::class,'update'])->name('practitioner-employments.update');

//practitioner professions routes
Route::get('practitioner-professions/{practitioner}', [PractitionerProfessionsController::class,'index'])->name('practitioner-professions.index');
//store route
Route::post('practitioner-professions/{practitioner}/store', [PractitionerProfessionsController::class,'store'])->name('practitioner-professions.store');
//edit route
Route::get('practitioner-professions/{practitionerProfession}/edit', [PractitionerProfessionsController::class,'edit'])->name('practitioner-professions.edit');
//update route
Route::patch('practitioner-professions/{practitionerProfession}/update', [PractitionerProfessionsController::class,'update'])->name('practitioner-professions.update');


//Practitioner Professional Qualifications routes for ProfessionalQualificationController
Route::get('practitioner-professional-qualifications/{practitionerProfession}', [ProfessionalQualificationController::class,'index'])->name('practitioner-professional-qualifications.index');
//store route
Route::post('practitioner-professional-qualifications/{practitionerProfession}/store', [ProfessionalQualificationController::class,'store'])->name('practitioner-professional-qualifications.store');
//edit route
Route::get('practitioner-professional-qualifications/{professionalQualification}/edit', [ProfessionalQualificationController::class,'edit'])->name('practitioner-professional-qualifications.edit');
//update route
Route::patch('practitioner-professional-qualifications/{professionalQualification}/update', [ProfessionalQualificationController::class,'update'])->name('practitioner-professional-qualifications.update');
//delete route
Route::delete('practitioner-professional-qualifications/{professionalQualification}/destroy', [ProfessionalQualificationController::class,'destroy'])->name('practitioner-professional-qualifications.destroy');


/*
 *
|--------------------------------------------------------------------------
| Practitioners Dashboard Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/home', [HomeController::class, 'index'])->name('home');
