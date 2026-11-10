@extends('layouts.app')

@section('header')
    <h2 class="h4 mb-0">Scan QR Code</h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h3 class="h5 card-title mb-4">Scan Session QR Code</h3>
            <p class="text-muted mb-4">
                Point your camera at the QR code displayed by your lecturer to mark your attendance.
                Your GPS location will be captured automatically.
            </p>

            <div id="qr-reader" class="mb-4"></div>
            <div id="qr-result" class="d-none mb-4 p-3 rounded"></div>

            <div id="loading" class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Initializing camera...</p>
            </div>

            <div id="error" class="d-none alert alert-danger mb-4"></div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary">
            Back to Dashboard
        </a>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    let html5QrcodeScanner;

    function onScanSuccess(decodedText, decodedResult) {
        // Stop scanning
        if (html5QrcodeScanner) {
            html5QrcodeScanner.stop();
        }

        // Get GPS location
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    submitAttendance(decodedText, position.coords.latitude, position.coords.longitude);
                },
                function(error) {
                    showError('Unable to get your location. Please enable location services and try again.');
                    restartScanner();
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            showError('Geolocation is not supported by your browser.');
            restartScanner();
        }
    }

    function onScanFailure(error) {
        // Handle scan failure, usually better to ignore and keep scanning
        console.warn(`Code scan error = ${error}`);
    }

    function submitAttendance(qrToken, latitude, longitude) {
        const resultDiv = document.getElementById('qr-result');
        const loadingDiv = document.getElementById('loading');
        
        resultDiv.classList.remove('d-none');
        resultDiv.className = 'mb-4 p-3 rounded alert alert-info';
        resultDiv.innerHTML = '<p>Submitting attendance...</p>';

        fetch('{{ route("student.validate-attendance") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                qr_token: qrToken,
                latitude: latitude,
                longitude: longitude
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                resultDiv.className = 'mb-4 p-3 rounded alert alert-success';
                resultDiv.innerHTML = `
                    <p class="fw-bold">${data.message}</p>
                    <p class="small mt-2">Distance from centre: ${data.distance} meters</p>
                    <p class="small">Status: <strong>${data.status}</strong></p>
                `;
            } else {
                resultDiv.className = 'mb-4 p-3 rounded alert alert-danger';
                resultDiv.innerHTML = `<p class="fw-bold">${data.message}</p>`;
                setTimeout(restartScanner, 3000);
            }
        })
        .catch(error => {
            resultDiv.className = 'mb-4 p-3 rounded alert alert-danger';
            resultDiv.innerHTML = '<p class="fw-bold">Error submitting attendance. Please try again.</p>';
            setTimeout(restartScanner, 3000);
        });
    }

    function showError(message) {
        const errorDiv = document.getElementById('error');
        errorDiv.classList.remove('d-none');
        errorDiv.textContent = message;
    }

    function restartScanner() {
        document.getElementById('qr-result').classList.add('d-none');
        document.getElementById('error').classList.add('d-none');
        startScanner();
    }

    function startScanner() {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            { fps: 10, qrbox: { width: 250, height: 250 } },
            /* verbose= */ false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        document.getElementById('loading').classList.add('d-none');
    }

    // Start scanner when page loads
    document.addEventListener('DOMContentLoaded', function() {
        startScanner();
    });
</script>
@endsection
