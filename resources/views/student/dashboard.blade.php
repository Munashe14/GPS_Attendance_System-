@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Student Dashboard</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="h5 card-title">Welcome, {{ $student->full_name }}</h3>
                    <p class="mb-0">
                        <strong>PIN:</strong> {{ $student->pin }}<br>
                        <strong>Programme:</strong> {{ $student->programme }}<br>
                        <strong>Centre:</strong> {{ $student->centre->centre_name }}
                    </p>
                </div>
                <a href="{{ route('student.scan') }}" class="btn btn-primary">
                    Scan QR Code
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">Attendance History</h3>
            
            @if($attendanceRecords->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Module</th>
                                <th>Centre</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Distance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceRecords as $record)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $record->session->module->module_code }}</div>
                                        <small class="text-muted">{{ $record->session->module->module_name }}</small>
                                    </td>
                                    <td>{{ $record->session->centre->centre_name }}</td>
                                    <td>{{ $record->scan_time->format('M d, Y') }}</td>
                                    <td>{{ $record->scan_time->format('H:i:s') }}</td>
                                    <td>{{ number_format($record->distance_m, 2) }} m</td>
                                    <td>
                                        @if($record->status == 'Present')
                                            <span class="badge bg-success">Present</span>
                                        @else
                                            <span class="badge bg-warning">Flagged</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted py-4">No attendance records yet. Scan a QR code to mark your attendance.</p>
            @endif
        </div>
    </div>
</div>
@endsection
