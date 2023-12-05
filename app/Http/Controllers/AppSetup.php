<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class AppSetup extends Controller
{
    public function storage()
    {
        Artisan::call("storage:link");
        return "<pre>".Artisan::output()."</pre>";
    }

    public function resetDatabase()
    {
        Artisan::call("migrate:fresh --seed");
        return "<pre>".Artisan::output()."</pre>";
    }

    public function upgradeDatabase()
    {
        Artisan::call("migrate");
        return "<pre>".Artisan::output()."</pre>";
    }
}
