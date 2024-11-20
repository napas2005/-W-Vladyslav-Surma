<?php

use App\Models\MetaTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


function get_locales()
{
    return array_keys(config('laravellocalization.supportedLocales'));
}
