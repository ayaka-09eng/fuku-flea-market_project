<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    public function store(Request $request) {
        app(\App\Actions\Fortify\CreateNewUser::class)->create($request->all());
        return redirect()->route('profile.create');
    }
}
