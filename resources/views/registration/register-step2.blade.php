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
            <h1 class="register-title">VERIFY YOUR EMAIL</h1>
            <p class="register-description">We sent a <b>code</b> into your email.</p>
            <p class="register-description2">Please check your email immediately and write the confirmation code below. If you don't see it, you may <b>check your spam</b> folder.</p>
        </div>
        <div class="warning-text">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span><br>
            @endforeach
        </div>
        <form class="register-form-container" method="POST" action="{{ route('register.verify-code') }}">
            @csrf
            <div class="verification-code-container">
                <input class="verification-code-input" id="digit-1" name="digit-1" type="number" maxlength="1" oninput="moveToNext(this, 'digit-2')" autofocus>
                <input class="verification-code-input" id="digit-2" name="digit-2" type="number" maxlength="1" oninput="moveToNext(this, 'digit-3')">
                <input class="verification-code-input" id="digit-3" name="digit-3" type="number" maxlength="1" oninput="moveToNext(this, 'digit-4')">
                <input class="verification-code-input" id="digit-4" name="digit-4" type="number" maxlength="1" oninput="moveToNext(this, 'digit-5')">
                <input class="verification-code-input" id="digit-5" name="digit-5" type="number" maxlength="1" oninput="moveToNext(this, 'digit-6')">
                <input class="verification-code-input" id="digit-6" name="digit-6" type="number" maxlength="1" oninput="moveToNext(this, null)">
            </div>
            <div class="button-container">
                <button class="verify-button" type="submit">Verify</button>
                <button class="resend-button" type="submit" onclick="resendCode()">Resend Verification</button>
            </div>
        </form>        
    </div>
</div>
@endsection
@section('css')
<link href="{{ asset('css/register2.css') }}" rel="stylesheet">
@endsection
@section('js')
<script>
function moveToNext(current, nextFieldId) {
    if (current.value.length >= 1 && nextFieldId) {
        document.getElementById(nextFieldId).focus();
    }
}
function handlePaste(e) {
    var pasteData = e.clipboardData.getData('text');
    var inputs = document.querySelectorAll('.verification-code-input');
    // Split the pasted data and fill the inputs
    pasteData.split('').forEach((char, index) => {
        if (index < inputs.length) {
            inputs[index].value = char;
        }
    });
    // Focus the next empty input field
    for (var i = 0; i < inputs.length; i++) {
        if (!inputs[i].value) {
            inputs[i].focus();
            break;
        }
    }
    // Prevent the default paste action
    e.preventDefault();
}
function resendCode() {
    fetch("{{ route('register.resend-code') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
document.querySelectorAll('.verification-code-input').forEach((input, index, arr) => {
    input.addEventListener('keydown', (e) => {
        if (e.key === "Backspace" && input.value === '' && index !== 0) {
            arr[index - 1].focus();
        }
    });
    // Add paste event listener
    input.addEventListener('paste', handlePaste);
});
</script>
@endsection