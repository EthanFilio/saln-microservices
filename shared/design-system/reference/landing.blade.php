@extends('layouts.app')

@section('title', 'Simplify Your SALN Filing')

@section('styles')
<style>
    .hero-section {
        padding: 80px 0;
        text-align: center;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 48px 0;
        }
    }

    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        margin-bottom: 48px;
    }

    @media (max-width: 768px) {
        .feature-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }

    .feature-icon {
        font-size: 2rem;
        margin-bottom: 12px;
        filter: grayscale(0);
        transition: var(--transition);
    }

    .card:hover .feature-icon {
        transform: scale(1.1);
    }

    header {
        backdrop-filter: blur(10px);
        background-color: var(--bg-white);
    }

    .logo-text {
        background: linear-gradient(135deg, var(--primary-color), var(--success-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 32px;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 24px;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<header style="background-color: var(--bg-white); border-bottom: 1px solid var(--border-color); padding: 16px 0; position: sticky; top: 0; z-index: 100;">
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary-color);">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                <h3 class="logo-text" style="margin: 0; font-size: 1.25rem; font-weight: 700;">SALN Filing System</h3>
            </div>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    </div>
</header>

<div class="container-narrow hero-section fade-in">
    <!-- Hero Section -->
    <div class="text-center" style="margin-bottom: 64px;">
        <h1 style="margin-bottom: 24px;">Simplify Your SALN Filing</h1>
        <p style="font-size: 1.125rem; color: var(--text-secondary); max-width: 560px; margin: 0 auto 32px;">
            A modern, user-friendly way to complete your Statement of Assets, Liabilities, and Net Worth. 
            Easier than PDFs, privacy-first, and generates an official SALN document.
        </p>
        <a href="{{ route('login') }}" class="btn btn-primary" style="font-size: 18px; padding: 14px 32px;">
            Get Started
        </a>
    </div>

    <!-- Features -->
    <div style="margin-bottom: 64px;">
        <div class="feature-grid">
            <div class="card fade-in" style="text-align: center;">
                <div class="feature-icon">✨</div>
                <h3>Easier SALN Completion</h3>
                <p style="margin-bottom: 0;">
                    Fill out your SALN with a clean, intuitive form interface. No more struggling with PDF editors.
                </p>
            </div>

            <div class="card fade-in" style="text-align: center; animation-delay: 0.1s;">
                <div class="feature-icon">📄</div>
                <h3>Auto-Generated Official PDF</h3>
                <p style="margin-bottom: 0;">
                    Your form data is automatically converted to the official SALN PDF format when you're ready.
                </p>
            </div>

            <div class="card fade-in" style="text-align: center; animation-delay: 0.2s;">
                <div class="feature-icon">🔒</div>
                <h3>Privacy-First Design</h3>
                <p style="margin-bottom: 0;">
                    Your data is stored temporarily and automatically deleted after 5 days of inactivity. 
                    No long-term storage, no unnecessary tracking.
                </p>
            </div>
        </div>
    </div>

    <!-- Privacy Notice -->
    <div class="privacy-notice" style="margin-bottom: 48px;">
        <p style="font-weight: 500; margin-bottom: 8px;">
            🔒 Your Privacy Matters
        </p>
        <p style="font-size: 14px; color: var(--text-secondary);">
            This system stores your SALN data temporarily for your convenience. All data is automatically 
            deleted after 5 days of inactivity. You can also export your data locally at any time as JSON.
        </p>
    </div>

    <!-- Footer -->
    <div class="text-center" style="padding-top: 32px; border-top: 1px solid var(--border-color);">
        <p class="text-muted" style="font-size: 14px; margin-bottom: 8px;">
            <strong>Disclaimer:</strong> This is an unofficial tool to assist with SALN preparation. 
            Always verify with your agency's requirements.
        </p>
        <p class="text-muted" style="font-size: 14px; margin-bottom: 0;">
            By using this service, you agree to our data privacy practices.
        </p>
    </div>
</div>

<!-- Footer -->
<footer style="background-color: var(--bg-light); border-top: 1px solid var(--border-color); padding: 48px 0; margin-top: 64px;">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--primary-color);">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                    </svg>
                    <h4 style="margin: 0;">SALN Filing</h4>
                </div>
                <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">Simplifying SALN compliance for Filipino government employees.</p>
            </div>
            <div>
                <h4 style="margin-bottom: 12px; font-size: 1rem;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;"><a href="{{ route('login') }}" style="font-size: 14px; color: var(--text-secondary); text-decoration: none;">Login</a></li>
                    <li style="margin-bottom: 8px;"><a href="#" style="font-size: 14px; color: var(--text-secondary); text-decoration: none;">Privacy Policy</a></li>
                    <li style="margin-bottom: 8px;"><a href="#" style="font-size: 14px; color: var(--text-secondary); text-decoration: none;">Terms of Service</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 12px; font-size: 1rem;">Support</h4>
                <p style="font-size: 14px; color: var(--text-secondary); margin-bottom: 8px;">For technical assistance, contact your IT department.</p>
                <p style="font-size: 14px; color: var(--text-secondary); margin: 0;">Monday - Friday, 8:00 AM - 5:00 PM</p>
            </div>
        </div>
        <div style="padding-top: 24px; border-top: 1px solid var(--border-color); text-align: center;">
            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
                © {{ date('Y') }} SALN Filing System. All rights reserved. | Unofficial tool for SALN preparation.
            </p>
        </div>
    </div>
</footer>
@endsection
