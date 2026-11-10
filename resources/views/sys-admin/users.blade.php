@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Manage Users</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">System Users</h3>
            
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Linked Student</th>
                                <th>Status</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td class="fw-bold">{{ $user->username }}</td>
                                    <td>
                                        @if($user->role == 'Student')
                                            <span class="badge bg-success">Student</span>
                                        @elseif($user->role == 'Lecturer')
                                            <span class="badge bg-primary">Lecturer</span>
                                        @elseif($user->role == 'RegionalAdmin')
                                            <span class="badge bg-info">Regional Admin</span>
                                        @else
                                            <span class="badge bg-danger">Sys Admin</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->student ? $user->student->full_name : '-' }}</td>
                                    <td>
                                        @if($user->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->last_login ? $user->last_login->format('M d, Y H:i') : 'Never' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted py-4">No users found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
