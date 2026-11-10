@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Session Details</h2>
@endsection

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="h5 card-title">{{ $session->module->module_code }} - {{ $session->module->module_name }}</h3>
                    <p class="mb-0">
                        <strong>Centre:</strong> {{ $session->centre->centre_name }}<br>
                        <strong>Date:</strong> {{ $session->session_date->format('F d, Y') }}<br>
                        <strong>Time:</strong> {{ $session->start_time->format('H:i') }}<br>
                        <strong>Status:</strong> 
                        @if($session->status == 'Active')
                            <span class="badge bg-success">Active</span>
                        @elseif($session->status == 'Scheduled')
                            <span class="badge bg-primary">Scheduled</span>
                        @else
                            <span class="badge bg-secondary">Closed</span>
                        @endif
                    </p>
                </div>
                <div class="btn-group">
                    @if($session->status == 'Scheduled')
                        <form method="POST" action="{{ route('lecturer.activate-session', $session->session_id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                Activate Session
                            </button>
                        </form>
                    @elseif($session->status == 'Active')
                        <form method="POST" action="{{ route('lecturer.refresh-qr', $session->session_id) }}">
                            @csrf
                            <button type="submit" class="btn btn-info">
                                Refresh QR Code
                            </button>
                        </form>
                        <form method="POST" action="{{ route('lecturer.close-session', $session->session_id) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Close Session
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('lecturer.dashboard') }}" class="btn btn-secondary">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($session->status == 'Active' && $session->qr_token && $session->qr_expires_at)
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h3 class="h5 card-title mb-4">QR Code</h3>
                <img id="qr-code" src="{{ route('lecturer.generate-qr', $session->session_id) }}" alt="QR Code" class="img-fluid border" style="max-width: 256px;">
                <div class="mt-3">
                    <p class="mb-1">Expires in: <span id="countdown" class="fw-bold text-danger">--:--</span></p>
                    <small class="text-muted">Students scan this code to mark attendance</small>
                </div>
            </div>
        </div>

        <script>
            const expiresAt = new Date('{{ $session->qr_expires_at->toISOString() }}');
            
            function updateCountdown() {
                const now = new Date();
                const diff = expiresAt - now;
                
                if (diff <= 0) {
                    document.getElementById('countdown').textContent = 'EXPIRED';
                    document.getElementById('qr-code').style.opacity = '0.5';
                    return;
                }
                
                const minutes = Math.floor(diff / 60000);
                const seconds = Math.floor((diff % 60000) / 1000);
                document.getElementById('countdown').textContent = 
                    String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
            }
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        </script>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">Attendance Records ({{ $session->attendanceRecords->count() }})</h3>
            
            @if($session->attendanceRecords->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Scan Time</th>
                                <th>Distance</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($session->attendanceRecords as $record)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $record->student->full_name }}</div>
                                        <small class="text-muted">{{ $record->student->pin }}</small>
                                    </td>
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
                <p class="text-center text-muted py-4">No attendance records yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection
