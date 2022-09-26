<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Barangay;
use App\Models\Account;
use DataTables;


class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $barangays = Barangay::all();
        $account = [];
        if($request->ajax()) {
            $account = DB::table('users')
                            ->where('is_admin', '1')
                            ->select('users.*')
                            ->get();
            return DataTables::of($account)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-success btn-sm editAccount"><i class="fas fa-fw fa-pencil-alt"></i> Edit</a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteAccount"><i class="fas fa-fw fa-trash-alt"></i> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin/account', compact('account', 'barangays'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        $request->validate([
            'account_id' => 'required',
            'barangay_id' => 'required',
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
            'contactNumber' => 'required|min:11',
        ]);
        // insert
        $account = Account::updateOrCreate([
            'id' => $request->id
        ],[
            'barangayId' => $request->barangayName,
            'barangaySecretary' => $request->barangaySecretary,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'contactNumber' => $request->contactNumber,
        ]);
        return response()->json(['success'=>'Barangay saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        User::where('id', $request->id)->delete();
    }
}
