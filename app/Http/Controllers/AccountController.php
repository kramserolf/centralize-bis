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
            $account = DB::table('users as u')
                            ->leftJoin('accounts as a', 'u.id', 'a.user_id')
                            ->leftJoin('barangays as b', 'a.barangay_id', 'b.id')
                            ->select('u.*', 'b.barangayName as barangay')
                            ->where('u.is_role', '1')
                            ->get();
            return DataTables::of($account)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-secondary btn-sm editAccount"><i class="bi-pencil-square"></i> Edit</a> ';
                    $btn .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="btn btn-outline-danger btn-sm deleteAccount"><i class="bi-trash"></i> Delete</a>';
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
            'barangay_id' => 'required',
            'name' => 'required',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'contact_number' => 'required|min:10',
        ]);
        // insert into users
        $user = User::updateOrCreate([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_role' => 1,
        ]);
        // get inserted ID
        $lastInsertId = $user->id;
        // insert into accounts
        $account = Account::updateOrCreate([
            'barangay_id' => $request->barangay_id,
            'user_id' => $lastInsertId,
            'contact_number' => $request->contact_number
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
