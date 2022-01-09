<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IdentityController extends Controller
{
    public function index()
    {
        $level = auth()->user()->level;
        if ($level === '0') {
            $route = 'dev';
        } elseif ($level == 1) {
            $route = 'studentHome';
        } else {
            $route = 'teacherHome';
        }

        return redirect(route($route));
    }
}
