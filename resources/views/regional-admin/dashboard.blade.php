@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Regional Admin Dashboard</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Total Centres</h3>
                    <p class="display-6 text-primary fw-bold">{{ $centres->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Total Students</h3>
                    <p class="display-6 text-success fw-bold">{{ $centres->sum('students_count') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="h5 card-title">Total Sessions</h3>
                    <p class="display-6 text-info fw-bold">{{ $centres->sum('sessions_count') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h5 card-title">Regional Centres Overview</h3>
                <a href="{{ route('regional-admin.centres') }}" class="btn btn-primary">
                    Manage Centres
                </a>
            </div>

            @if($centres->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Centre Name</th>
                                <th>Province</th>
                                <th>Students</th>
                                <th>Sessions</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($centres as $centre)
                                <tr>
                                    <td class="fw-bold">{{ $centre->centre_name }}</td>
                                    <td>{{ $centre->province }}</td>
                                    <td>{{ $centre->students_count }}</td>
                                    <td>{{ $centre->sessions_count }}</td>
                                    <td>
                                        @if($centre->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted py-4">No centres found.</p>
            @endif
        </div>
    </div>
</div>
@endsection
