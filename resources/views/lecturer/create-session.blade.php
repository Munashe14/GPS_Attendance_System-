@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Create New Session</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('lecturer.store-session') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="module_id">Module</label>
                    <select id="module_id" name="module_id" class="form-select" required>
                        <option value="">Select a module</option>
                        @foreach($modules as $module)
                            <option value="{{ $module->module_id }}">{{ $module->module_code }} - {{ $module->module_name }}</option>
                        @endforeach
                    </select>
                    @error('module_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="centre_id">Regional Centre</label>
                    <select id="centre_id" name="centre_id" class="form-select" required>
                        <option value="">Select a centre</option>
                        @foreach($centres as $centre)
                            <option value="{{ $centre->centre_id }}">{{ $centre->centre_name }} ({{ $centre->province }})</option>
                        @endforeach
                    </select>
                    @error('centre_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="session_date">Session Date</label>
                    <input id="session_date" name="session_date" type="date" class="form-control" required>
                    @error('session_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="start_time">Start Time</label>
                    <input id="start_time" name="start_time" type="time" class="form-control" required>
                    @error('start_time')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('lecturer.dashboard') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Create Session
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
