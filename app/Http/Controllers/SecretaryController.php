<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use DataTables;
class SecretaryController extends Controller
{
    
    public function index()
    {
        return view('secretary.home');
    }

    public function account()
    {
        $account = [];
        if($request->ajax()) {
            $account = DB::table('users')
                            ->where('is_admin', '1')
                            -get();
            return DataTables::of($barangay)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-success btn-sm editBarangay"><i class="fas fa-fw fa-pencil-alt"></i> Edit</a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBarangay"><i class="fas fa-fw fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin/barangay', compact('barangay'));
    }
}
