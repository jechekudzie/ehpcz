@extends('layouts.elections')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Verify OTP</h4>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Enter OTP</div>
                        <div class="card-body">
                            <form id="verifyOtpForm">
                                <div class="form-group">
                                    <label for="otp">OTP Code</label>
                                    <input type="text" class="form-control" id="otp" name="otp" required>
                                </div>

                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary" id="verifyOtpButton">Verify OTP</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-auth.js"></script>

    <script>
        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyA3uDIyHhmVpbsf_kttZfqfmDeGa2vMn0o",
            authDomain: "laravel-otp-74400.firebaseapp.com",
            projectId: "laravel-otp-74400",
            storageBucket: "laravel-otp-74400.appspot.com",
            messagingSenderId: "327828211791",
            appId: "1:327828211791:web:6a1716ebd733d07538423a",
            measurementId: "G-1GRP479HC9"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        document.getElementById('verifyOtpButton').addEventListener('click', function () {
            const otp = document.getElementById('otp').value;
            const verificationId = localStorage.getItem('verificationId');
            const practitionerId = new URLSearchParams(window.location.search).get('practitioner_id');

            if (!practitionerId) {
                alert('Verification ID or Practitioner ID is missing. Please request a new OTP.');
                window.location.href = "{{ route('voting.login') }}";
                return;
            }

            const credential = firebase.auth.PhoneAuthProvider.credential(verificationId, otp);

            firebase.auth().signInWithCredential(credential)
                .then((result) => {
                    // Store the practitioner_id in session via the backend
                    fetch('{{ route('voting.storeSession') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ practitioner_id: practitionerId }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('OTP verified successfully!');
                                window.location.href = "{{ route('election-voting.index') }}";
                            } else {
                                alert('Failed to store session. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Error storing session:', error);
                        });
                })
                .catch((error) => {
                    console.error("Invalid OTP or Verification Failed:", error);
                    alert('Invalid OTP. Please try again.');
                });
        });

    </script>
@endpush
