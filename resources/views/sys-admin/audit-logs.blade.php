@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Audit Logs</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">System Activity Logs</h3>
            
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Timestamp</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Module</th>
                                <th>IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->log_time->format('M d, Y H:i:s') }}</td>
                                    <td class="fw-bold">{{ $log->user->username }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->module }}</td>
                                    <td>{{ $log->ip_address ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $logs->links() }}
            @else
                <p class="text-center text-muted py-4">No audit logs found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
