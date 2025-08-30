<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ImpersonationController extends Controller
{
    public function create(): View
    {
        return view('admin.impersonate');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->session()->has('impersonator_id')) {
            return back()->withErrors(['username' => 'Impersonation is already active.']);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:50'],
        ]);

        $target = User::where('username', $validated['username'])->first();

        if (!$target) {
            return back()->withErrors(['username' => 'User not found.'])->withInput();
        }

        if ($target->is_admin) {
            return back()->withErrors(['username' => 'You cannot impersonate administrators.'])->withInput();
        }

        if ($target->id === Auth::id()) {
            return back()->withErrors(['username' => 'You cannot impersonate yourself.'])->withInput();
        }

        $request->session()->put('impersonator_id', Auth::id());
        Auth::loginUsingId($target->id);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $adminId = (int) $request->session()->get('impersonator_id', 0);
        if ($adminId <= 0) {
            abort(404);
        }

        $request->session()->forget('impersonator_id');
        Auth::loginUsingId($adminId);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
}
