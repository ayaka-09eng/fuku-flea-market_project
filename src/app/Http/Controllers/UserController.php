<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function create() {
        $user = auth()->user();
        return view('users.create', compact('user'));
    }
}
