@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Manage Regional Centres</h2>
@endsection

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="h5 card-title">Regional Centres</h3>
                <a href="{{ route('regional-admin.create-centre') }}" class="btn btn-primary">
                    Add New Centre
                </a>
            </div>

            @if($centres->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Centre Name</th>
                                <th>Province</th>
                                <th>GPS Coordinates</th>
                                <th>Radius (m)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($centres as $centre)
                                <tr>
                                    <td class="fw-bold">{{ $centre->centre_name }}</td>
                                    <td>{{ $centre->province }}</td>
                                    <td>{{ $centre->latitude }}, {{ $centre->longitude }}</td>
                                    <td>{{ $centre->radius_m }}</td>
                                    <td>
                                        @if($centre->status == 'Active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('regional-admin.edit-centre', $centre->centre_id) }}" class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center text-muted py-4">No centres found. Add your first centre to get started.</p>
            @endif
        </div>
    </div>
</div>
@endsection
