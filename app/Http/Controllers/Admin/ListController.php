<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekskul;
use App\Models\Social;
use App\Models\Spiritual;
use Illuminate\Http\Request;

class ListController extends Controller
{
    // Spiritual

    public function spiritual()
    {
        return view('admin.lists.spiritual', [
            'spirituals' => Spiritual::all()
        ]);
    }

    public function spiritualStore(Request $request)
    {
        try {
            Spiritual::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah ' . $request->list;
        return back()->with('alert', $alert);
    }

    public function spiritualUpdate(Request $request)
    {
        try {
            Spiritual::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update';
        return back()->with('alert', $alert);
    }

    public function spiritualDestroy(Spiritual $spiritual)
    {
        try {
            $spiritual->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus list ' . $spiritual->list;
        return back()->with('alert', $alert);
    }

    // Social

    public function social()
    {
        return view('admin.lists.social', [
            'socials' => Social::all()
        ]);
    }

    public function socialStore(Request $request)
    {
        try {
            Social::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            \dd($th);
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah ' . $request->list;
        return back()->with('alert', $alert);
    }

    public function socialUpdate(Request $request)
    {
        try {
            Social::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update';
        return back()->with('alert', $alert);
    }

    public function socialDestroy(Social $social)
    {
        try {
            $social->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus list ' . $social->list;
        return back()->with('alert', $alert);
    }

    // Ekskul

    public function ekskul()
    {
        return view('admin.lists.ekskul', [
            'ekskuls' => Ekskul::all()
        ]);
    }

    public function ekskulStore(Request $request)
    {
        try {
            Ekskul::create($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            \dd($th);
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'tambah ' . $request->list;
        return back()->with('alert', $alert);
    }

    public function ekskulUpdate(Request $request)
    {
        try {
            Ekskul::find($request->id)->update($request->input());
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'update';
        return back()->with('alert', $alert);
    }

    public function ekskulDestroy(Ekskul $ekskul)
    {
        try {
            $ekskul->delete();
            $alert['type'] = 'success';
        } catch (\Throwable $th) {
            report($th);
            $alert['type'] = 'danger';
        }

        $alert['message'] = 'hapus list ' . $ekskul->list;
        return back()->with('alert', $alert);
    }
}
