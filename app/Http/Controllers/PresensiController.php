<?php

namespace App\Http\Controllers;

use App\Presensi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PresensiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
        // $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        // $data = Presensi::with('user');
        // dd($data);
        if ($request->ajax()) {
            $data = Presensi::with('user');
            return DataTables::eloquent($data)
                ->addColumn('action', function ($data) {
                    return view('layouts._action', [
                        'model' => '',
                        'edit_url' => '',
                        'show_url' => route('presensi.show', $data->id),
                        'delete_url' => '',
                    ]);
                })
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->toJson();
        }

        // $users = User::paginate(5);
        return view('pages.attendance.index');
    }

    public function show($id)
    {
        $attendance = Presensi::with(['user', 'presensidetail'])->findOrFail($id);
        return view('pages.attendance.show', compact('attendance'));
    }
}
