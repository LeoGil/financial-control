<?php

namespace App\Http\Controllers;

use App\Jobs\CheckClosedStatements;
use App\Jobs\CheckCurrentStatements;
use App\Jobs\CheckOverdueStatements;
use App\Services\StatementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request, StatementService $service)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'), $request->remember)) {
            return back()->withErrors('Usuário ou senha inválidos.');
        }

        if (!app()->environment('production')) {
            $service->checkOverdueForUser(Auth::id());
            $service->checkNextCurrentStatements(Auth::id());
            $service->checkClosedStatements(Auth::id());
        } else {
            CheckOverdueStatements::dispatch(Auth::id());
            CheckCurrentStatements::dispatch(Auth::id());
            CheckClosedStatements::dispatch(Auth::id());
        }

        return redirect()->route('accounts.index');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
