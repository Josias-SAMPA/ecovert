<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerController extends Controller
{
    /**
     * Show partner profile edit form
     */
    public function editProfile()
    {
        $partner = Auth::user()->partner;
        return view('partner.edit-profile', ['partner' => $partner]);
    }

    /**
     * Update partner profile
     */
    public function updateProfile(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'type' => 'required|in:institutional,technical,investor',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'contact_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $partner = Auth::user()->partner;

        if (!$partner) {
            $partner = Partner::create([
                'user_id' => Auth::id(),
                'company_name' => $request->company_name,
                'type' => $request->type,
                'description' => $request->description,
                'website' => $request->website,
                'contact_email' => $request->contact_email,
            ]);
        } else {
            $partner->update($request->only([
                'company_name', 'type', 'description', 'website', 'contact_email'
            ]));
        }

        return back()->with('success', 'Profil partenaire mis à jour');
    }

    /**
     * View partner's analytics
     */
    public function analytics()
    {
        $partner = Auth::user()->partner;
        return view('partner.analytics', ['partner' => $partner]);
    }
}
