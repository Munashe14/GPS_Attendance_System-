@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Lecturer Dashboard</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h5 card-title mb-0">My Sessions</h3>
                <a href="{{ route('lecturer.create-session') }}" class="btn btn-primary">
                    Create New Session
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($sessions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Module</th>
                                <th>Centre</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Attendance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $session->module->module_code }}</div>
                                        <small class="text-muted">{{ $session->module->module_name }}</small>
                                    </td>
                                    <td>{{ $session->centre->centre_name }}</td>
                                    <td>{{ $session->session_date->format('M d, Y') }}</td>
                                    <td>{{ $session->start_time->format('H:i') }}</td>
                                    <td>
                                        @if($session->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($session->status == 'Scheduled')
                                            <span class="badge bg-primary">Scheduled</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{ $session->attendanceRecords->count() }}</td>
                                    <td>
                                        <a href="{{ route('lecturer.session', $session->session_id) }}" class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <p>No sessions found. Create your first session to get started.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
