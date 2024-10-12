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
            Route::get('/read-csv/{type}/{session}', function () {
                $data_added = new Illuminate\Support\Collection;
                try {
                    set_time_limit(0);
                    // \Illuminate\Support\Facades\DB::table('role_has_permissions')->truncate();
                    // \Illuminate\Support\Facades\DB::table('model_has_roles')->truncate();
                    // \Illuminate\Support\Facades\DB::table('model_has_permissions')->truncate();
                    // \App\Models\User::truncate();
                    // \Spatie\Permission\Models\Permission::truncate();
                    // \Spatie\Permission\Models\Role::truncate();
                    if (request()->type == 'kecamatan') {
                        // START DISTRICT COOR
                        $file = fopen("koor kecamatan.csv", "r");
                        $district_coor = new Illuminate\Support\Collection;
                        while (! feof($file)) {
                            $data = fgetcsv($file);
                            if ($data)
                                $district_coor->push([
                                    'username' => \Illuminate\Support\Str::of($data[1] . ' ' . $data[0])->lower()->snake()->value,
                                    'fullname' => $data[1],
                                    'district' => "PADANGSIDIMPUAN $data[0]"
                                ]);
                        }
                        fclose($file);

                        $district_coor->shift();
                        $district_coor->all();

                        foreach ($district_coor as $coor) {
                            \App\Models\User::create([
                                'username' => $coor['username'],
                                'fullname' => $coor['fullname'],
                                'district_id' => \App\Models\District::where('name', $coor['district'])->first()->id,
                                'password' => bcrypt($coor['username'])
                            ])->assignRole('Koordinator Kecamatan');
                            $data_added->push($coor);
                        }
                    }


                    if (request()->type == 'lainnya') {
                        // START VILLAGE COOR, TPS COOR, TEAM
                        $file1 = fopen("koor kelurahan, koor tps, tim bersinar.csv", "r");
                        $file2 = fopen("koor kelurahan, koor tps, tim bersinar 2.csv", "r");
                        $file3 = fopen("koor kelurahan, koor tps, tim bersinar 3.csv", "r");
                        // 0 => Kode
                        // 1 => Nama
                        // 2 => Peran
                        // 3 => Kecamatan
                        // 4 => Kelurahan
                        // 5 => TPS

                        while (! feof(${'file' . request()->session})) {
                            $data = fgetcsv(${'file' . request()->session});
                            if ($data) {
                                $username = $data[0] . ' ' . explode(' ', $data[1])[0];
                                if (count(explode(' ', $data[1])) > 1)
                                    $username .= ' ' . explode(' ', $data[1])[1];

                                $username = \Illuminate\Support\Str::of($username)->lower()->snake()->value;

                                if (in_array($data[2], ['Koordinator Kelurahan/Desa', 'Koordinator TPS']))
                                    $username = "coor_" . $username;

                                $payload = [
                                    'username' => $username,
                                    'fullname' => $data[1],
                                    'district_id' => \App\Models\District::where('name', "PADANGSIDIMPUAN $data[3]")->first()->id,
                                    'village_id' => \App\Models\Village::where('name', $data[4])->first()->id,
                                    'tps_id' => \App\Models\Tps::where('name', "TPS $data[5]")->first()->id,
                                    'password' => bcrypt($username)
                                ];

                                \App\Models\User::create($payload)->assignRole($data[2]);

                                $data_added->push([
                                    ...$payload,
                                    'peran' => $data[2]
                                ]);
                            }
                        }
                        fclose(${'file' . request()->session});
                    }

                    echo "Done";
                } catch (\Exception $e) {
                    ddd($e->getMessage(), $data_added->last());
                }
            })->middleware('role:Superadmin');

            Route::get('/', [DatasetController::class, 'index'])->name('dashboard');

            // Route::get('/', function () {
            //     ddd(\App\Helpers\SidebarHelper::get());
            // })->name('dashboard');

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

            Route::get('/personalization', [UserController::class, 'personalization'])->name('personalization');

            Route::get('/general', [ConfigurationController::class, 'general'])
                ->middleware('permission:general config')
                ->name('general');
            Route::get('/log_activity', [ConfigurationController::class, 'log_activity'])
                ->middleware('permission:log_activity config')
                ->name('log_activity');
        }
    );
