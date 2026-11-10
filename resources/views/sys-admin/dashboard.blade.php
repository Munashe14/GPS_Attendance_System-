@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">System Admin Dashboard</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="row row-cols-1 row-cols-md-4 g-4 mb-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Total Users</h3>
                    <p class="display-6 text-primary fw-bold">{{ $userCount }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Students</h3>
                    <p class="display-6 text-success fw-bold">{{ $studentCount }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Lecturers</h3>
                    <p class="display-6 text-info fw-bold">{{ $lecturerCount }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Admins</h3>
                    <p class="display-6 text-danger fw-bold">{{ $adminCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">Quick Actions</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <a href="{{ route('sys-admin.users') }}" class="card text-decoration-none">
                        <div class="card-body bg-light border border-primary">
                            <h4 class="h6 card-title text-primary">Manage Users</h4>
                            <p class="card-text small text-primary">View and manage all system users</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('sys-admin.audit-logs') }}" class="card text-decoration-none">
                        <div class="card-body bg-light border border-success">
                            <h4 class="h6 card-title text-success">Audit Logs</h4>
                            <p class="card-text small text-success">View system activity logs</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('regional-admin.dashboard') }}" class="card text-decoration-none">
                        <div class="card-body bg-light border border-info">
                            <h4 class="h6 card-title text-info">Regional Centres</h4>
                            <p class="card-text small text-info">Manage regional centres</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
