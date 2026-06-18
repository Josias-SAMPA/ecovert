<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * List all users
     */
    public function listUsers()
    {
        $users = User::where('role', '!=', 'admin')->paginate(15);
        return view('admin.users', ['users' => $users]);
    }

    /**
     * List all partners
     */
    public function listPartners()
    {
        $partners = Partner::paginate(15);
        return view('admin.partners', ['partners' => $partners]);
    }

    /**
     * View partner details
     */
    public function viewPartner(Partner $partner)
    {
        return view('admin.partner-detail', ['partner' => $partner]);
    }

    /**
     * Approve partner
     */
    public function approvePartner(Partner $partner)
    {
        $partner->update(['status' => 'approved']);
        return back()->with('success', 'Partenaire approuvé avec succès');
    }

    /**
     * Reject partner
     */
    public function rejectPartner(Partner $partner)
    {
        $partner->update(['status' => 'rejected']);
        return back()->with('success', 'Partenaire rejeté');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé');
    }

    /**
     * Change user status
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Statut utilisateur mis à jour');
    }
}
