@extends('layouts.elections')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Voting Log In</h4>
                    </div>
                </div>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <!-- Registration Number Form -->
                    <form id="searchForm">
                        <div class="mb-3">
                            <label for="registration_number" class="form-label">Registration Number</label>
                            <input type="text" id="registration_number" name="registration_number" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                    <!-- Mobile Number and OTP Form -->
                    <div id="mobileForm" style="display: none; margin-top: 20px;">
                        <form id="otpForm">
                            <div class="mb-3">
                                <label for="mobileNumber" class="form-label">Mobile Number</label>
                                <input type="text" id="mobileNumber" class="form-control" readonly>
                            </div>
                            <button type="button" id="sendOtp" class="btn btn-primary">Send OTP</button>
                            <div id="recaptcha-container"></div>

                        </form>
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

        const recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            size: 'invisible', // Or 'normal' for a visible Recaptcha
            callback: (response) => {
                console.log('Recaptcha solved successfully:', response);
            },
            'expired-callback': () => {
                console.error('Recaptcha expired. Please reload the page or retry.');
            }
        });

        // Log errors during Recaptcha setup
        recaptchaVerifier.render().then((widgetId) => {
            console.log('Recaptcha Widget ID:', widgetId);
        }).catch((error) => {
            console.error('Recaptcha setup error:', error);
        });


        document.getElementById('searchForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const registrationNumber = document.getElementById('registration_number').value;

            fetch('{{ route('voting.check') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ registration_number: registrationNumber }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.mobile_number) {
                        document.getElementById('mobileNumber').value = data.mobile_number;
                        document.getElementById('mobileForm').style.display = 'block';

                        // Save practitioner ID in localStorage
                        localStorage.setItem('practitionerId', data.practitioner_id);
                    } else {
                        alert('No mobile number found.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });


        document.getElementById('sendOtp').addEventListener('click', function () {
            const phoneNumber = document.getElementById('mobileNumber').value;

            if (!phoneNumber) {
                alert('Invalid phone number.');
                return;
            }

            firebase.auth().signInWithPhoneNumber(phoneNumber, recaptchaVerifier)
                .then((confirmationResult) => {
                    // Save the verification ID
                    localStorage.setItem('verificationId', confirmationResult.verificationId);

                    // Save the practitioner ID (ensure it is set in localStorage during registration check)
                    const practitionerId = localStorage.getItem('practitionerId');
                    if (!practitionerId) {
                        alert('Practitioner ID is missing. Please request a new OTP.');
                        return;
                    }

                    alert('OTP sent successfully!');
                    window.location.href = `{{ route('otp.verify.page') }}?practitioner_id=${practitionerId}`;
                })
                .catch((error) => {
                    console.error('Error Sending OTP:', error);
                    alert('Error sending OTP. Please try again.');
                });
        });

    </script>
@endpush
