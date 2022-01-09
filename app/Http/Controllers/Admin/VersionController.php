<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        return view('admin.versions.version', [
            'versions' => Version::all(),
        ]);
    }

    public function update(Request $request)
    {
        $version = new Version;
        try {
            $version->query()->update(['is_used' => null]);
            $version::find($request->id)->update(['is_used' => 1]);
            session()->put('version', $version::firstWhere('is_used', 1));
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'mengubah versi';
        return back()->with('alert', $alert);
    }
}
