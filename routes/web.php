<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DptController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoterController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\ConfigurationController;

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

Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest')->name('login.do');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')
    ->group(
        function () {
            Route::get('/read-csv', [ConfigurationController::class, 'load_data'])->middleware('role:Superadmin');

            Route::get('/', [DatasetController::class, 'index'])->name('dashboard');

            Route::get('/users', [UserController::class, 'index'])
                ->middleware('permission:read users')->name('users');
            Route::get('/users/administrator', [UserController::class, 'administrator'])
                ->middleware('permission:read users administrator')->name('users.administrator');
            Route::delete('/users/{user:id}/destroy', [DatasetController::class, 'destroy_users'])
                ->middleware('permission:delete users')->name('users.destroy');

            Route::get('/dpt', [DptController::class, 'index'])
                ->middleware('permission:read dpt')
                ->name('dpt');

            Route::get('/voter', [VoterController::class, 'index'])
                ->middleware('permission:read voter')
                ->name('voters');
            Route::get('/voter/create', [VoterController::class, 'create'])
                ->middleware('permission:create voter')
                ->name('voters.create');
            Route::get('/voter/create/family', [VoterController::class, 'create_family'])
                ->middleware('permission:create voter family')
                ->name('voters.create.family');
            Route::get('/voter/migration', [VoterController::class, 'migration'])
                ->middleware('permission:migration voter')
                ->name('voters.migration');
            Route::get('/voter/transfer', [VoterController::class, 'transfer'])
                ->middleware('permission:transfer voter')
                ->name('voters.transfer');
            Route::get('/voter/print', [VoterController::class, 'print'])
                ->middleware('permission:print voter')
                ->name('voters.print');
            Route::get('/voter/{voter:id}', [VoterController::class, 'show'])
                ->middleware(['permission:show voter', 'voter_access'])
                ->name('voters.show');
            Route::get('/voter/{voter:id}/edit', [VoterController::class, 'edit'])
                ->middleware(['permission:update voter', 'voter_access'])
                ->name('voters.edit');
            Route::get('/voter/{voter:id}/delete', [VoterController::class, 'delete'])
                ->middleware('permission:delete voter')
                ->name('voters.delete');

            Route::get('/region', [RegionController::class, 'index'])
                ->middleware('permission:read master')
                ->name('region');
            Route::get('/region/district', [RegionController::class, 'district'])
                ->middleware('permission:read district')
                ->name('region.district');
            Route::get('/region/village', [RegionController::class, 'village'])
                ->middleware('permission:read village')
                ->name('region.village');
            Route::get('/region/tps', [RegionController::class, 'tps'])
                ->middleware('permission:read tps')
                ->name('region.tps');

            Route::get('/master', [MasterController::class, 'index'])
                ->middleware('permission:read master')
                ->name('master');
            Route::get('/master/religion', [MasterController::class, 'religion'])
                ->middleware('permission:read religion')
                ->name('master.religion');
            Route::get('/master/nasionality', [MasterController::class, 'nasionality'])
                ->middleware('permission:read nasionality')
                ->name('master.nasionality');
            Route::get('/master/profession', [MasterController::class, 'profession'])
                ->middleware('permission:read profession')
                ->name('master.profession');
            Route::get('/master/marital_status', [MasterController::class, 'marital_status'])
                ->middleware('permission:read marital_status')
                ->name('master.marital_status');

            Route::get('/personalization', [UserController::class, 'personalization'])
                ->middleware('permission:personalization')
                ->name('personalization');

            Route::get('/general', [ConfigurationController::class, 'general'])
                ->middleware('permission:general config')
                ->name('general');
            Route::get('/log_activity', [ConfigurationController::class, 'log_activity'])
                ->middleware('permission:log_activity config')
                ->name('log_activity');
        }
    );
