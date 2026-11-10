<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;

class SysAdminController extends Controller
{
    public function dashboard()
    {
        $userCount = User::count();
        $studentCount = User::where('role', 'Student')->count();
        $lecturerCount = User::where('role', 'Lecturer')->count();
        $adminCount = User::whereIn('role', ['RegionalAdmin', 'SysAdmin'])->count();

        return view('sys-admin.dashboard', compact(
            'userCount',
            'studentCount',
            'lecturerCount',
            'adminCount'
        ));
    }

    public function users()
    {
        $users = User::with('student')->orderBy('username')->get();
        return view('sys-admin.users', compact('users'));
    }

    public function auditLogs()
    {
        $logs = AuditLog::with('user')
            ->orderBy('log_time', 'desc')
            ->paginate(50);

        return view('sys-admin.audit-logs', compact('logs'));
    }
}
