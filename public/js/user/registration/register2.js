let cooldownTime = 60; // Cooldown time in seconds
let remainingTime = cooldownTime;
let timerElement, resendButton;

document.addEventListener('DOMContentLoaded', (event) => {
    timerElement = document.getElementById('resend-timer');
    resendButton = document.querySelector('.resend-button');

    function moveToNext(current, nextFieldId) {
        if (current.value.length >= 1 && nextFieldId) {
            document.getElementById(nextFieldId).focus();
        }
    }

    function handlePaste(e) {
        var pasteData = e.clipboardData.getData('text');
        var inputs = document.querySelectorAll('.verification-code-input');
        pasteData.split('').forEach((char, index) => {
            if (index < inputs.length) {
                inputs[index].value = char;
            }
        });
        for (var i = 0; i < inputs.length; i++) {
            if (!inputs[i].value) {
                inputs[i].focus();
                break;
            }
        }
        e.preventDefault();
    }

    document.querySelectorAll('.verification-code-input').forEach((input, index, arr) => {
        input.addEventListener('keydown', (e) => {
            if (e.key === "Backspace" && input.value === '' && index !== 0) {
                arr[index - 1].focus();
            }
        });
        input.addEventListener('paste', handlePaste);
    });

    document.querySelector('.resend-button').addEventListener('click', resendCode);

    // Initialize the timer on page load
    startTimer();
});

function startTimer() {
    resendButton.disabled = true;
    timerElement.innerText = `Please wait ${remainingTime} seconds before requesting a new code.`;
    let interval = setInterval(() => {
        remainingTime--;
        if (remainingTime <= 0) {
            clearInterval(interval);
            resendButton.disabled = false;
            timerElement.innerText = '';
        } else {
            timerElement.innerText = `Please wait ${remainingTime} seconds before requesting a new code.`;
        }
    }, 1000);
}

function resendCode() {
    fetch("/register/resend-code", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Success:', data);
            alert('Verification code resent successfully.');
            remainingTime = cooldownTime; // Reset the timer
            startTimer(); // Start the timer again
        } else {
            alert(data.error);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        alert('Failed to resend verification code.');
    });
}