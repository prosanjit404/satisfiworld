<?php


use App\Models\GeneralSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



    function gs($key = null) {
        $general = GeneralSetting::first();
        if ($key) {
            return @$general->$key;
        }
        return $general;
    }

    function toast($message, $type = 'success', $icon = null)
    {
        session()->flash('toast', ['message' => $message,'type' => $type,'icon' => $icon,]);
    }

    function keyToTitle($text) {
        return ucfirst(preg_replace("/[^A-Za-z0-9 ]/", ' ', $text));
    }

    function menuActive($pattern, $class = 'active')
    {
        return request()->routeIs($pattern) ? $class : '';
    }

    function menuOpen($pattern, $class = 'open')
    {
        return request()->routeIs($pattern) ? $class : '';
    }

    function submenuShow($pattern)
    {
        return request()->routeIs($pattern) ? 'max-height: none;' : '';
    }



    function get_trx(){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $trx = '';
        for ($i = 0; $i < 8; $i++) {
            $trx .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $trx;
    }















