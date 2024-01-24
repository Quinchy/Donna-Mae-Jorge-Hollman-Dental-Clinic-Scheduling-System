@extends('layouts.main')
@section('content')
<div class="main-container">
    <div class="progress-bar-container">
        <div class="milestone-1"></div>
        <div class="road-1"></div>
        <div class="milestone-2"></div>
        <div class="road-2"></div>
        <div class="milestone-3"></div>
        <div class="road-3"></div>
        <div class="milestone-4"></div>
    </div>
    <div class="register-container">
        <div class="register-heading-container">
            <h1 class="register-title">REGISTER</h1>
            <p class="register-description">Already have an account? <a class="login-link" href="{{ route('login') }}">Login your Account</a></p>
        </div>
        <div class="register-section-container">
            <form class="register-form-container" method="POST" action="{{ route('register.step1.post') }}">
                <div class="warning-text">
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span><br>
                    @endforeach
                </div>
                @csrf
                <div class="email-container">
                    <label class="email-title" for="email">Email</label>
                    
                    <input class="email-textfield" id="email" type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="password-container">
                    <label class="password-title" for="password">Password</label>
                    <input class="password-textfield" id="password" type="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="9" viewBox="0 0 20 9" fill="none" >
                            <path d="M3.159 1C4.41028 3.32543 7.00385 4.92298 10.0004 4.92298C12.997 4.92298 15.5905 3.32543 16.8418 1M4.53423 2.787L1.64258 5.21041M7.96321 4.67714L6.57086 8.1837M15.4652 2.787L18.3569 5.21041M12.0314 4.67714L13.4237 8.1837" stroke="#858585" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" width="19" height="14" viewBox="0 0 19 14" fill="none" style="display: none;">
                            <path d="M17.6532 5.85297C17.868 6.12076 17.9869 6.46867 17.9869 6.8294C17.9869 7.19013 17.868 7.53803 17.6532 7.80582C16.2931 9.45263 13.197 12.6588 9.58283 12.6588C5.96865 12.6588 2.87263 9.45263 1.51246 7.80582C1.29763 7.53803 1.17871 7.19013 1.17871 6.8294C1.17871 6.46867 1.29763 6.12076 1.51246 5.85297C2.87263 4.20616 5.96865 1 9.58283 1C13.197 1 16.2931 4.20616 17.6532 5.85297Z" stroke="#858585" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.58303 9.42022C11.0139 9.42022 12.1738 8.26028 12.1738 6.82941C12.1738 5.39855 11.0139 4.23861 9.58303 4.23861C8.15216 4.23861 6.99222 5.39855 6.99222 6.82941C6.99222 8.26028 8.15216 9.42022 9.58303 9.42022Z" stroke="#858585" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
                <div class="confirm-password-container">
                    <label class="confirm-password-title" for="password_confirmation">Confirm Password</label>
                    <input class="confirm-password-textfield" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="9" viewBox="0 0 20 9" fill="none" >
                            <path d="M3.159 1C4.41028 3.32543 7.00385 4.92298 10.0004 4.92298C12.997 4.92298 15.5905 3.32543 16.8418 1M4.53423 2.787L1.64258 5.21041M7.96321 4.67714L6.57086 8.1837M15.4652 2.787L18.3569 5.21041M12.0314 4.67714L13.4237 8.1837" stroke="#858585" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" width="19" height="14" viewBox="0 0 19 14" fill="none" style="display: none;">
                            <path d="M17.6532 5.85297C17.868 6.12076 17.9869 6.46867 17.9869 6.8294C17.9869 7.19013 17.868 7.53803 17.6532 7.80582C16.2931 9.45263 13.197 12.6588 9.58283 12.6588C5.96865 12.6588 2.87263 9.45263 1.51246 7.80582C1.29763 7.53803 1.17871 7.19013 1.17871 6.8294C1.17871 6.46867 1.29763 6.12076 1.51246 5.85297C2.87263 4.20616 5.96865 1 9.58283 1C13.197 1 16.2931 4.20616 17.6532 5.85297Z" stroke="#858585" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.58303 9.42022C11.0139 9.42022 12.1738 8.26028 12.1738 6.82941C12.1738 5.39855 11.0139 4.23861 9.58303 4.23861C8.15216 4.23861 6.99222 5.39855 6.99222 6.82941C6.99222 8.26028 8.15216 9.42022 9.58303 9.42022Z" stroke="#858585" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </div>
                <button class="next-button" type="submit">Next</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('css')
<link href="{{ asset('css/register.css') }}" rel="stylesheet">
@endsection
@section('js')
<script>
function togglePasswordVisibility(fieldId, icon) {
    var passwordInput = document.getElementById(fieldId);
    var isOpenEye = icon.querySelector('.eye-open');
    var isClosedEye = icon.querySelector('.eye-closed');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        isOpenEye.style.display = 'none';
        isClosedEye.style.display = 'block';
    } else {
        passwordInput.type = 'password';
        isOpenEye.style.display = 'block';
        isClosedEye.style.display = 'none';
    }
}
</script>
@endsection