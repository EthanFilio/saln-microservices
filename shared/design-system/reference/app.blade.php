<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SALN Filing System')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #0066cc;
            --primary-hover: #0052a3;
            --success-color: #2d8659;
            --error-color: #d32f2f;
            --warning-color: #f57c00;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-muted: #999999;
            --bg-white: #ffffff;
            --bg-light: #f9f9f9;
            --bg-gray: #f5f5f5;
            --border-color: #e0e0e0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 4px 16px rgba(0, 0, 0, 0.1);
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --transition: all 0.3s ease;
        }

        [data-theme="dark"] {
            --primary-color: #4d9fff;
            --primary-hover: #3a8eef;
            --success-color: #4caf50;
            --error-color: #f44336;
            --warning-color: #ff9800;
            --text-primary: #e4e4e4;
            --text-secondary: #b0b0b0;
            --text-muted: #808080;
            --bg-white: #1a1a1a;
            --bg-light: #242424;
            --bg-gray: #2a2a2a;
            --border-color: #3a3a3a;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 2px 8px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 4px 16px rgba(0, 0, 0, 0.5);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--bg-white);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .container-narrow {
            max-width: 640px;
            margin: 0 auto;
            padding: 0 24px;
        }

        @media (max-width: 768px) {
            .container, .container-narrow {
                padding: 0 16px;
            }
        }

        /* Typography */
        h1 {
            font-size: clamp(2rem, 5vw, 2.5rem);
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 16px;
            color: var(--text-primary);
        }

        h2 {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        h3 {
            font-size: clamp(1.25rem, 3vw, 1.5rem);
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 12px;
            color: var(--text-primary);
        }

        h4 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-primary);
        }

        p {
            margin-bottom: 16px;
            color: var(--text-secondary);
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .btn {
                padding: 10px 20px;
                font-size: 14px;
            }
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--bg-light);
            border-color: var(--text-muted);
        }

        .btn-success {
            background-color: var(--success-color);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-success:hover {
            background-color: #236b47;
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Forms */
        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-primary);
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            background-color: var(--bg-white);
            color: var(--text-primary);
            transition: var(--transition);
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(77, 159, 255, 0.1);
        }

        input::placeholder,
        textarea::placeholder {
            color: var(--text-muted);
        }

        .form-help {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .error {
            color: var(--error-color);
            font-size: 14px;
            margin-top: 4px;
        }

        /* Navigation */
        .navbar {
            background-color: var(--bg-white);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
            transition: var(--transition);
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .navbar-left,
        .navbar-right {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 12px;
            }
            
            .navbar-left,
            .navbar-right {
                width: 100%;
                justify-content: center;
            }
        }

        .navbar .btn {
            padding: 8px 16px;
            font-size: 14px;
        }

        /* Cards */
        .card {
            background-color: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 32px;
            margin-bottom: 24px;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        @media (max-width: 768px) {
            .card {
                padding: 20px;
                border-radius: var(--radius-sm);
            }
        }

        .card-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background-color: var(--bg-white);
            border-radius: var(--radius-md);
            padding: 32px;
            max-width: 480px;
            width: 100%;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            max-height: 90vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .modal-content {
                padding: 24px;
                max-width: 100%;
            }
        }

        .modal-header {
            margin-bottom: 16px;
        }

        .modal-body {
            margin-bottom: 24px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Privacy notice */
        .privacy-notice {
            background-color: rgba(77, 159, 255, 0.1);
            border-left: 4px solid var(--primary-color);
            padding: 16px;
            margin: 24px 0;
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }

        .privacy-notice p {
            color: var(--text-primary);
            font-size: 14px;
            margin-bottom: 0;
        }

        /* Alerts */
        .alert {
            padding: 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 24px;
            border-left: 4px solid;
            transition: var(--transition);
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border-color: var(--success-color);
        }

        .alert-error {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--error-color);
            border-color: var(--error-color);
        }

        .alert-info {
            background-color: rgba(77, 159, 255, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Theme Toggle Button */
        .theme-toggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            z-index: 999;
        }

        .theme-toggle:hover {
            transform: scale(1.1) rotate(15deg);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .theme-toggle svg {
            width: 24px;
            height: 24px;
        }

        @media (max-width: 768px) {
            .theme-toggle {
                bottom: 16px;
                right: 16px;
                width: 48px;
                height: 48px;
            }
            
            .theme-toggle svg {
                width: 20px;
                height: 20px;
            }
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid var(--border-color);
            border-top: 3px solid var(--primary-color);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Utility classes */
        .text-center {
            text-align: center;
        }

        .text-muted {
            color: var(--text-muted);
        }

        .mt-1 { margin-top: 8px; }
        .mt-2 { margin-top: 16px; }
        .mt-3 { margin-top: 24px; }
        .mt-4 { margin-top: 32px; }
        .mb-1 { margin-bottom: 8px; }
        .mb-2 { margin-bottom: 16px; }
        .mb-3 { margin-bottom: 24px; }
        .mb-4 { margin-bottom: 32px; }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Selection */
        ::selection {
            background-color: var(--primary-color);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .navbar-content {
                flex-direction: column;
                gap: 12px;
            }

            .card {
                padding: 24px;
            }

            footer {
                padding: 32px 0 !important;
            }

            footer > div > div {
                text-align: center;
            }
        }

        /* Link hover effects */
        a {
            transition: color 0.2s ease;
        }

        a:hover {
            color: var(--primary-color);
        }

        /* Improved button focus */
        .btn:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
    @yield('styles')
</head>
<body>
    @yield('content')
    
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme" title="Toggle dark/light mode">
        <svg id="theme-icon-light" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg id="theme-icon-dark" style="display: block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>
    
    <script>
        // CSRF token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Theme toggle functionality
        const themeToggle = document.getElementById('theme-toggle');
        const themeIconLight = document.getElementById('theme-icon-light');
        const themeIconDark = document.getElementById('theme-icon-dark');
        const html = document.documentElement;
        
        // Check for saved theme preference or default to 'light' mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', currentTheme);
        updateThemeIcon(currentTheme);
        
        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIconLight.style.display = 'block';
                themeIconDark.style.display = 'none';
            } else {
                themeIconLight.style.display = 'none';
                themeIconDark.style.display = 'block';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
