<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * User dashboard
     */
    public function userDashboard()
    {
        return view('dashboard.user', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Partner dashboard
     */
    public function partnerDashboard()
    {
        $user = Auth::user();
        $partner = $user->partner;

        return view('dashboard.partner', [
            'user' => $user,
            'partner' => $partner,
        ]);
    }

    /**
     * Admin dashboard
     */
    public function adminDashboard()
    {
        $totalUsers = \App\Models\User::count();
        $totalPartners = \App\Models\Partner::count();
        $pendingPartners = \App\Models\Partner::where('status', 'pending')->count();

        return view('dashboard.admin', [
            'totalUsers' => $totalUsers,
            'totalPartners' => $totalPartners,
            'pendingPartners' => $pendingPartners,
        ]);
    }
}
