<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $rw4Coords = [
            [-7.1245, 110.1230],
            [-7.1242, 110.1245],
            [-7.1225, 110.1247],
            [-7.1220, 110.1231]
        ];
        return view('welcome', compact('rw4Coords'));
    }

}
