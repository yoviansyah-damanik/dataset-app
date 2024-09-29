<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Configuration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class GeneralHelper
{
    private static $configs;

    public function __construct()
    {
        if (Schema::hasTable('configurations'))
            static::$configs = Configuration::get();
    }

    private static function get($config)
    {
        return collect(static::$configs)
            ->where('attribute', $config)
            ->first()
            ->value;
    }

    public static function get_app_name()
    {
        return static::get('app_name')
            ?: env('APP_NAME');
    }

    public static function get_abb_app_name()
    {
        return static::get('abb_app_name')
            ?: env('ABB_APP_NAME');
    }

    public static function get_unit_name()
    {
        return static::get('unit_name')
            ?: env('UNIT_NAME');
    }

    public static function get_version()
    {
        return static::get('version')
            ?: 'DEV';
    }

    public static function get_app_logo()
    {
        $logo = static::get('app_logo');

        if (!$logo || !Storage::disk('public')->exists($logo))
            return asset('logo_default.png');

        return asset($logo);
    }

    public static function get_candidate_callsign()
    {
        return static::get('candidate_callsign')
            ?: 'Wali Kota';
    }

    public static function get_candidate_1_name()
    {
        return static::get('candidate_1_name')
            ?: '-';
    }

    public static function get_candidate_2_name()
    {
        return static::get('candidate_2_name')
            ?: '-';
    }

    public static function get_candidate_1_picture()
    {
        $candidate = static::get('candidate_1_picture');

        if (!$candidate || !Storage::disk('public')->exists($candidate))
            return asset('candidate.png');

        return asset($candidate);
    }

    public static function get_candidate_2_picture()
    {
        $candidate = static::get('candidate_2_picture');

        if (!$candidate || !Storage::disk('public')->exists($candidate))
            return asset('candidate.png');

        return asset($candidate);
    }

    public static function get_favicon()
    {
        $favicon = static::get('app_favicon');

        if (!$favicon || !Storage::disk('public')->exists($favicon))
            return asset('favicon_default.png');

        return asset($favicon);
    }

    public static function get_ads()
    {
        $ads = static::get('app_ads');

        if (!$ads || !Storage::disk('public')->exists($ads))
            return asset('ads_default.png');

        return asset($ads);
    }

    public static function get_login_background()
    {
        $login_background = static::get('app_login_background');

        if (!$login_background || !Storage::disk('public')->exists($login_background))
            return asset('login_background_default.jpg');

        return asset($login_background);
    }

    public static function get_age($date, $withMonth = false, $withDay = false)
    {
        $format = '%y Tahun';

        if ($withMonth)
            $format .= ' %m Bulan';

        if ($withDay)
            $format .= ' %m Hari';

        return Carbon::parse($date)->diff(\Carbon\Carbon::now())->format($format);
    }

    public static function number_format($number, $with_comma = false, $commas_total = 2)
    {
        return number_format($number, $with_comma ? $commas_total : 0, ',', '.');
    }
}
