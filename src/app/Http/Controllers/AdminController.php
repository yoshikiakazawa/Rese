<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\CreateOwnerRequest;

class AdminController extends Controller
{
    public function admin() {
        $owners = Owner::all();
        return view('admin.index', compact('owners'));
    }

    public function store(CreateOwnerRequest $request) {
        Owner::create([
            'name' => $request->name,
            'login_owner_id' => $request->login_owner_id,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);
        return redirect()->back()->with('flash-message', 'ownerを作成しました。');
    }

    public function detail($id)
    {
        $owner = Owner::findOrFail($id);
        $shops = Shop::where('owner_id', $id)->with(['area', 'genre'])->get();

        return view('admin.detail', compact('shops', 'owner'));
    }
}
