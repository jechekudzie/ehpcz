<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TitleController;
use App\Http\Controllers\GenderController;
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
use App\Http\Controllers\RequirementsCategoryController;
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

// TitleController
Route::resource('titles', TitleController::class);

// GenderController
Route::resource('genders', GenderController::class);

// ContactTypeController
Route::resource('contact-types', ContactTypeController::class);

// AddressTypeController
Route::resource('address-types', AddressTypeController::class);

// ProfessionController
Route::resource('professions', ProfessionController::class);

// QualificationController
Route::resource('qualifications', QualificationController::class);

// QualificationCategoryController
Route::resource('qualification-categories', QualificationCategoryController::class);

// QualificationLevelController
Route::resource('qualification-levels', QualificationLevelController::class);

// RequirementsCategoryController
Route::resource('requirements-categories', RequirementsCategoryController::class);

// RequirementController
Route::resource('requirements', RequirementController::class);

// RegisterController
Route::resource('registers', RegisterController::class);

// InstitutionController
Route::resource('institutions', InstitutionController::class);

// AccreditedInstitutionController
Route::resource('accredited-institutions', AccreditedInstitutionController::class);

// PaymentCategoryController
Route::resource('payment-categories', PaymentCategoryController::class);

Route::resource('contacts', ContactController::class);




Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/table', [AdminController::class, 'table']);
Route::get('/admin/form', [AdminController::class, 'form']);
Route::get('/admin/pickers', [AdminController::class, 'pickers']);
Route::get('/admin/profile', [AdminController::class, 'profile']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

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
