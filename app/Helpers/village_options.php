<?php
use App\Models\Village;

if (!function_exists('village_options')) {
    function village_options() {
        return Village::orderBy('name')->pluck('name');
    }
}
