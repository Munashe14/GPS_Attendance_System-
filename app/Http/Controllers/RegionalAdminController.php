<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegionalCentre;
use App\Models\AttendanceRecord;

class RegionalAdminController extends Controller
{
    public function dashboard()
    {
        $centres = RegionalCentre::withCount('students', 'sessions')->get();
        return view('regional-admin.dashboard', compact('centres'));
    }

    public function centres()
    {
        $centres = RegionalCentre::all();
        return view('regional-admin.centres', compact('centres'));
    }

    public function createCentre()
    {
        return view('regional-admin.create-centre');
    }

    public function storeCentre(Request $request)
    {
        $request->validate([
            'centre_name' => 'required|string',
            'province' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_m' => 'required|integer|min:10',
            'status' => 'required|in:Active,Inactive',
        ]);

        RegionalCentre::create($request->all());

        return redirect()->route('regional-admin.centres')
            ->with('success', 'Regional centre created successfully.');
    }

    public function editCentre($id)
    {
        $centre = RegionalCentre::findOrFail($id);
        return view('regional-admin.edit-centre', compact('centre'));
    }

    public function updateCentre(Request $request, $id)
    {
        $request->validate([
            'centre_name' => 'required|string',
            'province' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius_m' => 'required|integer|min:10',
            'status' => 'required|in:Active,Inactive',
        ]);

        $centre = RegionalCentre::findOrFail($id);
        $centre->update($request->all());

        return redirect()->route('regional-admin.centres')
            ->with('success', 'Regional centre updated successfully.');
    }

    public function reports()
    {
        $flaggedRecords = AttendanceRecord::with(['student', 'session.module', 'session.centre'])
            ->where('status', 'Flagged')
            ->orderBy('scan_time', 'desc')
            ->get();

        return view('regional-admin.reports', compact('flaggedRecords'));
    }
}
