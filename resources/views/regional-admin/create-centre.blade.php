@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Add New Regional Centre</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('regional-admin.store-centre') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="centre_name">Centre Name</label>
                    <input id="centre_name" name="centre_name" type="text" class="form-control" required>
                    @error('centre_name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="province">Province</label>
                    <input id="province" name="province" type="text" class="form-control" required>
                    @error('province')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="latitude">Latitude</label>
                    <input id="latitude" name="latitude" type="number" step="any" class="form-control" required>
                    @error('latitude')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="longitude">Longitude</label>
                    <input id="longitude" name="longitude" type="number" step="any" class="form-control" required>
                    @error('longitude')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="radius_m">GPS Radius (meters)</label>
                    <input id="radius_m" name="radius_m" type="number" class="form-control" value="50" required>
                    @error('radius_m')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('regional-admin.centres') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Create Centre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
