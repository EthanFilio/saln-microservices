@extends('layouts.app')

@section('title', 'Login - SALN Filing System')

@section('styles')
<style>
    .login-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 24px 0;
        background: linear-gradient(135deg, rgba(77, 159, 255, 0.05) 0%, rgba(45, 134, 89, 0.05) 100%);
    }

    .login-card {
        animation: fadeIn 0.5s ease-out;
    }

    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-bottom: 24px;
    }

    .step-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--border-color);
        transition: var(--transition);
    }

    .step-dot.active {
        background-color: var(--primary-color);
        width: 24px;
        border-radius: 4px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 14px;
        transition: var(--transition);
    }

    .back-link:hover {
        color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .login-container {
            padding: 16px 0;
        }
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="card login-card" style="max-width: 480px; margin: 0 auto; width: 90%;">
        <div class="text-center" style="margin-bottom: 32px;">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary-color); margin-bottom: 16px;">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <line x1="16" y1="13" x2="8" y2="13"></line>
                <line x1="16" y1="17" x2="8" y2="17"></line>
            </svg>
            <h2 style="margin-bottom: 8px;">Welcome Back</h2>
            <p class="text-muted">Enter your email to get started</p>
        </div>

        <div class="step-indicator">
            <div class="step-dot active" id="step-dot-1"></div>
            <div class="step-dot" id="step-dot-2"></div>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <p style="margin-bottom: 0;">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Step 1: Email Entry -->
        <div id="email-step">
            <form id="email-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        required 
                        placeholder="your.email@example.com"
                        value="{{ old('email') }}"
                    >
                    <p class="form-help">
                        We'll send you a 6-digit verification code
                    </p>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    Send Verification Code
                </button>
            </form>

            <div class="privacy-notice" style="margin-top: 24px;">
                <p style="font-size: 14px; margin-bottom: 8px;">
                    <strong>Data Privacy Notice</strong>
                </p>
                <p style="font-size: 13px; margin-bottom: 4px;">
                    • Your data is stored temporarily
                </p>
                <p style="font-size: 13px; margin-bottom: 4px;">
                    • Automatically deleted after 5 days of inactivity
                </p>
                <p style="font-size: 13px; margin-bottom: 0;">
                    • Logging in again resets the 5-day timer
                </p>
            </div>
        </div>

        <!-- Step 2: Code Verification & Password -->
        <div id="verification-step" style="display: none;">
            <form action="{{ route('verify.login') }}" method="POST">
                @csrf
                <input type="hidden" id="email-hidden" name="email">

                <div class="form-group">
                    <label for="code">Verification Code *</label>
                    <input 
                        type="text" 
                        id="code" 
                        name="code" 
                        required 
                        maxlength="6"
                        placeholder="000000"
                        pattern="[0-9]{6}"
                        style="text-align: center; font-size: 1.5rem; letter-spacing: 0.5rem; font-weight: 600;"
                    >
                    <p class="form-help">
                        Enter the 6-digit code sent to your email
                    </p>
                    <p id="dev-code-display" style="display: none; color: var(--success-color); font-weight: 600; margin-top: 8px; padding: 8px; background-color: rgba(76, 175, 80, 0.1); border-radius: var(--radius-sm);"></p>
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required 
                        minlength="8"
                        placeholder="Minimum 8 characters"
                    >
                    <p class="form-help">
                        Create a password or enter your existing one
                    </p>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <span>Verify & Login</span>
                </button>

                <button type="button" id="back-button" class="btn btn-secondary" style="width: 100%; margin-top: 12px;">
                    ← Back
                </button>
            </form>
        </div>
    </div>

    <div class="text-center" style="margin-top: 24px;">
        <a href="{{ route('landing') }}" class="back-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to home
        </a>
    </div>
</div>

@section('scripts')
<script>
    const emailForm = document.getElementById('email-form');
    const emailStep = document.getElementById('email-step');
    const verificationStep = document.getElementById('verification-step');
    const emailInput = document.getElementById('email');
    const emailHidden = document.getElementById('email-hidden');
    const backButton = document.getElementById('back-button');
    const devCodeDisplay = document.getElementById('dev-code-display');
    const stepDot1 = document.getElementById('step-dot-1');
    const stepDot2 = document.getElementById('step-dot-2');

    emailForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(emailForm);
        const submitButton = emailForm.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner"></span> Sending...';

        try {
            const response = await fetch('{{ route("send.code") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                emailHidden.value = emailInput.value;
                emailStep.style.display = 'none';
                verificationStep.style.display = 'block';
                
                // Update step indicators
                stepDot1.classList.remove('active');
                stepDot2.classList.add('active');
                
                // Show dev code if available (debug mode)
                if (data.dev_code) {
                    devCodeDisplay.innerHTML = `<strong>Development Code:</strong> ${data.dev_code}`;
                    devCodeDisplay.style.display = 'block';
                }
                
                // Focus on code input
                document.getElementById('code').focus();
            } else {
                alert('Failed to send verification code. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        } finally {
            submitButton.disabled = false;
            submitButton.innerHTML = originalText;
        }
    });

    backButton.addEventListener('click', () => {
        verificationStep.style.display = 'none';
        emailStep.style.display = 'block';
        devCodeDisplay.style.display = 'none';
        
        // Update step indicators
        stepDot1.classList.add('active');
        stepDot2.classList.remove('active');
    });

    // Auto-format code input
    const codeInput = document.getElementById('code');
    codeInput.addEventListener('input', (e) => {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });

    // Auto-submit when 6 digits are entered (optional UX enhancement)
    codeInput.addEventListener('input', (e) => {
        if (e.target.value.length === 6) {
            document.getElementById('password').focus();
        }
    });
</script>
@endsection
@endsection
