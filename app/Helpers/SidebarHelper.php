<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class SidebarHelper
{
    public static function get()
    {
        $permissions = auth()->user()->permissions;

        $result = new Collection();

        $result->push([
            'title' => 'Real Count',
            'items' => [
                [
                    'title' => 'Perhitungan Suara',
                    'route' => 'vote.count',
                    'icon' => 'fas fa-check-to-slot',
                    'permission' => $permissions->some('count vote')
                ],
                [
                    'title' => 'Rekapitulasi Suara',
                    'route' => 'vote.recap',
                    'icon' => 'fas fa-square-poll-vertical',
                    'permission' => $permissions->some('recap vote')
                ],
            ],
        ]);

        $result->push([
            'title' => 'Pemilih',
            'items' => [
                [
                    'title' => 'DPT',
                    'route' => 'dpt',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read dpt')
                ],
                [
                    'title' => 'Data Pemilih',
                    'route' => 'voters',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read voter')
                ],
                [
                    'title' => 'Tambah Data',
                    'route' => 'voters.create',
                    'icon' => 'fas fa-plus',
                    'permission' => $permissions->some('create voter')
                ],
                [
                    'title' => 'Cetak',
                    'route' => 'voters.print',
                    'icon' => 'fas fa-print',
                    'permission' => $permissions->some('print voter')
                ],
                [
                    'title' => 'Migrasi',
                    'route' => 'voters.migration',
                    'icon' => 'fas fa-person-walking-dashed-line-arrow-right',
                    'permission' => $permissions->some('migration voter')
                ],
            ]
        ]);

        $result->push([
            'title' => 'Regional',
            'items' => [
                [
                    'title' => 'Data Rekap',
                    'route' => 'region',
                    'icon' => 'fas fa-server',
                    'permission' => $permissions->some('read region')
                ],
                [
                    'title' => 'Kecamatan',
                    'route' => 'region.district',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read district')
                ],
                [
                    'title' => 'Kelurahan/Desa',
                    'route' => 'region.village',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read village')
                ],
                [
                    'title' => 'TPS',
                    'route' => 'region.tps',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read tps')
                ],
            ]
        ]);

        $result->push([
            'title' => 'Data Master',
            'items' => [
                [
                    'title' => 'Data Rekap',
                    'route' => 'master',
                    'icon' => 'fas fa-server',
                    'permission' => $permissions->some('read master')
                ],
                [
                    'title' => 'Status Perkawinan',
                    'route' => 'master.marital_status',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read marital_status')
                ],
                [
                    'title' => 'Pekerjaan',
                    'route' => 'master.profession',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read profession')
                ],
                [
                    'title' => 'Agama',
                    'route' => 'master.religion',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read religion')
                ],
                [
                    'title' => 'Kewarganegaraan',
                    'route' => 'master.nasionality',
                    'icon' => 'fas fa-database',
                    'permission' => $permissions->some('read nasionality')
                ],
            ]
        ]);

        $result->push([
            'title' => 'Pengguna',
            'items' => [
                [
                    'title' => 'Personalisasi',
                    'route' => 'personalization',
                    'icon' => 'fas fa-user',
                    'permission' => true
                ],
                [
                    'title' => 'Manajemen Pengguna',
                    'route' => 'users',
                    'icon' => 'fas fa-users',
                    'permission' => $permissions->some('read users')
                ],
                [
                    'title' => 'Manajemen Administrator',
                    'route' => 'users.administrator',
                    'icon' => 'fas fa-users',
                    'permission' => $permissions->some('read users administrator')
                ],
            ]
        ]);

        $result->push([
            'title' => 'Pengaturan',
            'items' => [
                [
                    'title' => 'Log Aktivitas',
                    'route' => 'log_activity',
                    'icon' => 'fas fa-list-alt',
                    'permission' => $permissions->some('log_activity config')
                ],
                [
                    'title' => 'Umum',
                    'route' => 'general',
                    'icon' => 'fas fa-cog',
                    'permission' => $permissions->some('general config')
                ]
            ]
        ]);

        return $result;
    }
}
