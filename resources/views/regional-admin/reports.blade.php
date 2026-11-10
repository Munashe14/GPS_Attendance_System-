@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Anomaly Reports</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">Flagged Attendance Records</h3>
            <p class="text-muted mb-4">
                These attendance records were flagged because the student's GPS location was outside the allowed radius of the regional centre.
            </p>
            
            @if($flaggedRecords->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Module</th>
                                <th>Centre</th>
                                <th>Scan Time</th>
                                <th>Distance</th>
                                <th>Allowed Radius</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($flaggedRecords as $record)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $record->student->full_name }}</div>
                                        <small class="text-muted">{{ $record->student->pin }}</small>
                                    </td>
                                    <td>{{ $record->session->module->module_code }}</td>
                                    <td>{{ $record->session->centre->centre_name }}</td>
                                    <td>{{ $record->scan_time->format('M d, Y H:i:s') }}</td>
                                    <td class="text-danger fw-bold">{{ number_format($record->distance_m, 2) }} m</td>
                                    <td>{{ $record->session->centre->radius_m }} m</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted py-4">No flagged attendance records found. All students are within their centre's GPS boundaries.</p>
            @endif
        </div>
    </div>
</div>
@endsection
