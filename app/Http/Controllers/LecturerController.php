<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Module;
use App\Models\RegionalCentre;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;

class LecturerController extends Controller
{
    public function dashboard()
    {
        $sessions = Session::with(['module', 'centre', 'attendanceRecords'])
            ->where('lecturer_id', auth()->id())
            ->orderBy('session_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        return view('lecturer.dashboard', compact('sessions'));
    }

    public function createSession()
    {
        $modules = Module::all();
        $centres = RegionalCentre::where('status', 'Active')->get();

        return view('lecturer.create-session', compact('modules', 'centres'));
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,module_id',
            'centre_id' => 'required|exists:regional_centres,centre_id',
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
        ]);

        $session = Session::create([
            'module_id' => $request->module_id,
            'centre_id' => $request->centre_id,
            'lecturer_id' => auth()->id(),
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'status' => 'Scheduled',
        ]);

        return redirect()->route('lecturer.session', $session->session_id)
            ->with('success', 'Session created successfully.');
    }

    public function session($id)
    {
        $session = Session::with(['module', 'centre', 'attendanceRecords.student'])
            ->findOrFail($id);

        $this->authorizeSession($session);

        return view('lecturer.session', compact('session'));
    }

    public function activateSession($id)
    {
        $session = Session::findOrFail($id);
        $this->authorizeSession($session);

        $session->update([
            'status' => 'Active',
            'qr_token' => Str::random(32),
            'qr_expires_at' => now()->addMinutes(2),
        ]);

        return redirect()->route('lecturer.session', $id)
            ->with('success', 'Session activated. QR code is now valid for 2 minutes.');
    }

    public function refreshQrCode($id)
    {
        $session = Session::findOrFail($id);
        $this->authorizeSession($session);

        if ($session->status !== 'Active') {
            return back()->with('error', 'Session must be active to refresh QR code.');
        }

        $session->update([
            'qr_token' => Str::random(32),
            'qr_expires_at' => now()->addMinutes(2),
        ]);

        return redirect()->route('lecturer.session', $id)
            ->with('success', 'QR code refreshed. Valid for another 2 minutes.');
    }

    public function generateQrCode($id)
    {
        $session = Session::findOrFail($id);
        $this->authorizeSession($session);

        if (!$session->qr_token || $session->qr_expires_at->isPast()) {
            return response()->json(['error' => 'QR code not available or expired'], 400);
        }

        $qrCode = new QrCode($session->qr_token);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return response($result->getString())
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'inline; filename=qrcode.png');
    }

    public function closeSession($id)
    {
        $session = Session::findOrFail($id);
        $this->authorizeSession($session);

        $session->update([
            'status' => 'Closed',
            'qr_token' => null,
            'qr_expires_at' => null,
        ]);

        return redirect()->route('lecturer.session', $id)
            ->with('success', 'Session closed successfully.');
    }

    private function authorizeSession($session)
    {
        if ($session->lecturer_id !== auth()->id()) {
            abort(403, 'You do not have permission to access this session.');
        }
    }
}
