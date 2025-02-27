<?php
/**
 * Wildlife Haven - Enhanced Registration Page
 * Smooth interactive multi-step registration with immersive animations
 */

// Ensure this page is not cached
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

// Base URL for consistent path references
$baseUrl = '/Wildlife';

// Flash message handling
$flashMessage = '';
$flashType = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    $flashType = $_SESSION['flash_type'] ?? 'info';
    unset($_SESSION['flash_message'], $_SESSION['flash_type']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Wildlife Haven</title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= $baseUrl ?>/assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- GSAP for advanced animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- CSS -->
    <style>
        /* Modern color palette with nature-inspired hues */
        :root {
            --color-background: #F9F8F2;
            --color-surface: #FFFFFF;
            --color-primary: #4D724D;
            --color-primary-light: #E0E8E0;
            --color-primary-dark: #3B5B3B;
            --color-accent: #CE6246;
            --color-accent-light: #FADBD3;
            --color-text: #262626;
            --color-text-light: #666666;
            --color-text-muted: #999999;
            --color-border: #E5E5E5;
            --color-error: #DC3545;
            --color-success: #28A745;
            --color-warning: #FFC107;
            --color-info: #17A2B8;
            
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.07);
            --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
            
            --radius-sm: 4px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-full: 9999px;
            
            --transition-fast: 150ms ease;
            --transition-normal: 250ms ease;
            --transition-slow: 350ms ease;
        }
        
        /* Base styles */
        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            color: var(--color-text);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Page container */
        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            z-index: 1;
        }
        
        /* Animated background elements */
        .bg-shapes {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }
        
        .bg-shape {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at center, var(--color-primary-light), transparent 70%);
            opacity: 0.4;
            transform-origin: center;
        }
        
        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
        }
        
        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -50px;
        }
        
        .shape-3 {
            width: 200px;
            height: 200px;
            top: 40%;
            left: 10%;
        }
        
        .shape-4 {
            width: 150px;
            height: 150px;
            right: 15%;
            bottom: 20%;
        }
        
        /* Floating foliage animations */
        .foliage {
            position: absolute;
            opacity: 0.2;
            z-index: -1;
            pointer-events: none;
        }
        
        .leaf1 {
            width: 60px;
            top: 10%;
            left: 5%;
            animation: float 12s ease-in-out infinite;
        }
        
        .leaf2 {
            width: 45px;
            bottom: 15%;
            right: 8%;
            animation: float 14s ease-in-out infinite reverse;
        }
        
        .leaf3 {
            width: 40px;
            top: 20%;
            right: 10%;
            animation: float 16s ease-in-out infinite 1s;
        }
        
        .leaf4 {
            width: 50px;
            bottom: 10%;
            left: 10%;
            animation: float 18s ease-in-out infinite 2s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }
        
        /* Registration card */
        .register-card {
            width: 100%;
            max-width: 580px;
            background-color: var(--color-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            position: relative;
            transition: height 0.5s ease;
        }
        
        /* Top decoration */
        .card-decoration {
            height: 6px;
            background: linear-gradient(to right, var(--color-primary), var(--color-accent));
        }
        
        /* Card header with logo */
        .card-header {
            text-align: center;
            padding: 2rem 2rem 1rem;
        }
        
        .auth-logo {
            margin-bottom: 1rem;
        }
        
        .auth-logo img {
            height: 60px;
            width: auto;
            transition: transform 0.6s ease;
        }
        
        .auth-logo:hover img {
            transform: scale(1.05);
        }
        
        .auth-logo h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            font-size: 1.75rem;
            margin-top: 0.5rem;
            color: var(--color-text);
            position: relative;
            display: inline-block;
        }
        
        .auth-logo h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--color-primary);
            transform: translateX(-50%);
            transition: width 0.3s ease;
        }
        
        .auth-logo:hover h1::after {
            width: 80%;
        }
        
        /* Card title */
        .card-title {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--color-text);
        }
        
        .card-subtitle {
            font-size: 1.05rem;
            color: var(--color-text-light);
            margin-bottom: 1rem;
        }
        
        /* Step progress bar */
        .step-progress {
            display: flex;
            justify-content: space-between;
            margin: 0 auto 2rem;
            max-width: 300px;
            position: relative;
        }
        
        .step-progress::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--color-border);
            transform: translateY(-50%);
            z-index: 1;
        }
        
        .step-progress-bar {
            position: absolute;
            top: 50%;
            left: 0;
            height: 2px;
            background-color: var(--color-primary);
            transform: translateY(-50%);
            transition: width 0.4s ease;
            z-index: 2;
        }
        
        .step-item {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--color-surface);
            border: 2px solid var(--color-border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-muted);
            position: relative;
            z-index: 3;
            transition: all 0.3s ease;
        }
        
        .step-item.active {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
        }
        
        .step-item.completed {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
        }
        
        .step-item.completed::after {
            content: '✓';
            font-size: 0.875rem;
        }
        
        .step-item.completed span {
            display: none;
        }
        
        /* Card body with registration form */
        .card-body {
            padding: 0 2rem 2rem;
            overflow: hidden;
        }
        
        /* Flash message */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
        }
        
        .alert svg {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            flex-shrink: 0;
            margin-top: 0.125rem;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.08);
            border-left: 3px solid var(--color-success);
            color: var(--color-success);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.08);
            border-left: 3px solid var(--color-error);
            color: var(--color-error);
        }
        
        .alert-warning {
            background-color: rgba(255, 193, 7, 0.08);
            border-left: 3px solid var(--color-warning);
            color: var(--color-warning);
        }
        
        .alert-info {
            background-color: rgba(23, 162, 184, 0.08);
            border-left: 3px solid var(--color-info);
            color: var(--color-info);
        }
        
        /* Registration form */
        .register-form {
            width: 100%;
        }
        
        /* Steps container */
        .steps-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        
        /* Individual steps */
        .step {
            width: 100%;
            position: absolute;
            left: 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
            transform: translateX(50px);
        }
        
        .step.active {
            opacity: 1;
            visibility: visible;
            position: relative;
            transform: translateX(0);
        }
        
        .step.left {
            transform: translateX(-50px);
        }
        
        /* Form group */
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            color: var(--color-text);
            font-weight: 500;
        }
        
        .form-group input,
        .form-group select {
            width: 100%;
            height: 3rem;
            padding: 0 1rem;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            color: var(--color-text);
            transition: all 0.3s ease;
            background-color: var(--color-surface);
        }
        
        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(77, 114, 77, 0.15);
        }
        
        /* Input group with icon */
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-muted);
            transition: color 0.3s ease;
        }
        
        .input-group input:focus ~ .input-icon {
            color: var(--color-primary);
        }
        
        /* Toggle password visibility */
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--color-text-muted);
            cursor: pointer;
            padding: 0.25rem;
            transition: color 0.3s ease;
            z-index: 2;
        }
        
        .toggle-password:hover {
            color: var(--color-primary);
        }
        
        /* Password strength indicator */
        .password-strength {
            height: 4px;
            margin-top: 0.5rem;
            border-radius: 2px;
            background-color: #eee;
            overflow: hidden;
        }
        
        .password-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .password-text {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            font-size: 0.8rem;
        }
        
        .password-text .strength {
            font-weight: 500;
        }
        
        .password-requirements {
            margin-top: 0.75rem;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
            font-size: 0.8rem;
            color: var(--color-text-muted);
        }
        
        .requirement i {
            margin-right: 0.5rem;
            font-size: 0.75rem;
        }
        
        .requirement.met {
            color: var(--color-success);
        }
        
        .requirement.unmet {
            color: var(--color-text-muted);
        }
        
        .requirement i.fa-check-circle {
            color: var(--color-success);
        }
        
        .requirement i.fa-circle {
            color: var(--color-text-muted);
        }
        
        /* Helper text */
        .helper-text {
            display: block;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            color: var(--color-text-muted);
        }
        
        /* Form validation */
        .is-invalid {
            border-color: var(--color-error) !important;
        }
        
        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            color: var(--color-error);
            margin-top: 0.25rem;
        }
        
        /* Terms and conditions checkbox */
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            position: relative;
        }
        
        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkbox-mark {
            display: inline-block;
            flex-shrink: 0;
            position: relative;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            margin-top: 2px;
            border: 1.5px solid var(--color-border);
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .checkbox-container input:checked ~ .checkbox-mark {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }
        
        .checkbox-mark:after {
            content: "";
            position: absolute;
            opacity: 0;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            transition: opacity 0.2s ease;
        }
        
        .checkbox-container input:checked ~ .checkbox-mark:after {
            opacity: 1;
        }
        
        .checkbox-container label {
            font-size: 0.9rem;
            line-height: 1.4;
            cursor: pointer;
            margin-bottom: 0;
        }
        
        .checkbox-container a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .checkbox-container a:hover {
            text-decoration: underline;
        }
        
        /* Navigation buttons */
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 2rem;
        }
        
        .btn {
            font-size: 1rem;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150%;
            height: 150%;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.4s ease;
        }
        
        .btn:active::before {
            transform: translate(-50%, -50%) scale(1);
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }
        
        .btn-primary:hover:not(:disabled) {
            background-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary {
            background-color: #f1f1f1;
            color: var(--color-text);
        }
        
        .btn-secondary:hover:not(:disabled) {
            background-color: #e5e5e5;
            transform: translateY(-2px);
        }
        
        .btn-wide {
            width: 100%;
        }
        
        .btn i {
            margin-left: 0.5rem;
        }
        
        .prev-btn i {
            margin-right: 0.5rem;
            margin-left: 0;
        }
        
        /* Loading spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s ease infinite;
            margin-right: 0.5rem;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Social login section */
        .social-login {
            margin-top: 2rem;
        }
        
        .social-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--color-border);
        }
        
        .social-divider-text {
            padding: 0 1rem;
            font-size: 0.9rem;
            color: var(--color-text-muted);
        }
        
        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1rem;
            background-color: var(--color-surface);
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            color: var(--color-text);
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .social-button svg {
            margin-right: 0.5rem;
            width: 20px;
            height: 20px;
        }
        
        .social-button.google:hover {
            border-color: #DB4437;
        }
        
        .social-button.apple:hover {
            border-color: #000000;
        }
        
        /* Registration success animation */
        .success-animation {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--color-success);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .success-icon::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 3px solid var(--color-success);
            opacity: 0;
            animation: pulse 2s ease-out infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.5;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
        
        .success-icon i {
            font-size: 2.5rem;
            color: white;
        }
        
        .success-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            color: var(--color-text);
        }
        
        .success-text {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: var(--color-text-light);
        }
        
        /* Card footer */
        .card-footer {
            padding: 1.5rem 2rem;
            text-align: center;
            background-color: #f9f9f9;
            border-top: 1px solid var(--color-border);
        }
        
        .card-footer p {
            font-size: 0.95rem;
            color: var(--color-text-light);
        }
        
        .card-footer a {
            color: var(--color-primary);
            font-weight: 500;
            text-decoration: none;
        }
        
        .card-footer a:hover {
            text-decoration: underline;
        }
        
        /* Form shake animation for errors */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .shake {
            animation: shake 0.6s ease-in-out;
        }
        
        /* Responsive styles */
        @media (max-width: 640px) {
            .register-card {
                max-width: 100%;
                border-radius: 0;
                box-shadow: none;
            }
            
            .card-header, .card-body {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
            
            .card-title {
                font-size: 1.75rem;
            }
            
            .social-buttons {
                grid-template-columns: 1fr;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 1rem;
            }
            
            .form-actions button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Animated background shapes -->
    <div class="bg-shapes">
        <div class="bg-shape shape-1" id="shape1"></div>
        <div class="bg-shape shape-2" id="shape2"></div>
        <div class="bg-shape shape-3" id="shape3"></div>
        <div class="bg-shape shape-4" id="shape4"></div>
    </div>
    
    <!-- Decorative foliage -->
    <svg class="foliage leaf1" viewBox="0 0 24 24" fill="#4D724D">
        <path d="M17.5 12c3.59 0 7-1.6 8.5-4.5C26 7.5 22.44 2 17.5 2S9 7.5 9 7.5c1.5 2.9 4.91 4.5 8.5 4.5zM17.5 4.5c1.11 0 2 .89 2 2 0 1.1-.9 2-2 2-1.11 0-2-.9-2-2 0-1.11.89-2 2-2zM21 8s-1.32 1.75-3.5 1.75S14 8 14 8s1.32-1.75 3.5-1.75S21 8 21 8zm-10.3 3.38c-.72.35-1.45.52-2.2.52-1.77 0-3.35-.79-4.5-2.1 0 0 1.1-1.17 2.98-2.37-1.5.46-2.85 1.13-3.87 1.93C1.89 10.43 1 11.79 1 13.5c0 .7.15 1.36.41 1.96C5.61 15.9 7.5 12 7.5 12h.83c1.35 0 2.66-.45 3.73-1.27-.35.17-.71.32-1.08.43-.17.05-.34.09-.52.12-.01 0-.01.01-.02.01.19.02.37.05.55.07.6.09 1.19.12 1.77.12 3.47 0 6.54-1.67 8.03-4.41-1.63 2.83-5.09 4.44-8.54 4.44-.83 0-1.62-.12-2.37-.35.19.02.37.05.55.07.6.09 1.19.12 1.77.12 3.47 0 6.54-1.67 8.03-4.41-1.63 2.83-5.09 4.44-8.54 4.44z"/>
    </svg>
    
    <svg class="foliage leaf2" viewBox="0 0 24 24" fill="#4D724D">
        <path d="M12 22c-4.97 0-9-4.03-9-9 0-4.418 2.865-8 7-8 5 0 9 4.582 9 9s-4.03 8-7 8zm0-5c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4z"/>
    </svg>
    
    <svg class="foliage leaf3" viewBox="0 0 24 24" fill="#4D724D">
        <path d="M21 3c-.5 0-4 6-4 6s3.5-1 5.5.5c0 0-2 5.5-7 8.5.5-1.5 1-4.5.5-5-1.5 2-2 3.5-2 5 0 .5 0 1.5.5 2.5C8 18 3 10.5 3 8c1.5.5 3 0 4.5-.5C5 6 2 6 2 6c2.5-2 5.5-2.5 8.5-2.5 1-1 2-2 3.5-1.5-1 1.5.5 3 1 3.5-1 1-2 1.5-3 3 2.5-1 4.5-1 6.5-1-1.5 1-1.5 2.5-1.5 3.5 2.5-1 4-2.5 4-2.5C22.5 4 21 3 21 3z"/>
    </svg>
    
    <svg class="foliage leaf4" viewBox="0 0 24 24" fill="#4D724D">
        <path d="M12.5 2c2.61 0 4.83.84 6.6 2.33 1.58 1.32 2.44 2.9 2.9 4.14-1.8-2.54-5.91-3.25-7.38-1.71 1.63.12 3 .85 3.62 1.7-.26.36-.64.69-1.24.95-1.55-1.93-4.28-2.34-6.06-.99 3.7 2.43 0 6.41 0 6.41-1.79-1.4-2.24-3.91-1.84-5.63-.09.39-.14.81-.14 1.19 0 .09.01.17.01.25-1.12.71-1.96 1.96-1.96 4.36h-1C6 14.63 6 13.33 6 13.33c-2.39.7-4 2.42-4 3C2 12.68 3.96 7.93 7 5.34V4c-3.48 2.61-5 5.9-5 8.14C2 13.39 2.24 15 3 16.5c1.27-2.62 2.96-3 5-3 .34 0 .68.08 1 .08 0 2.67-.67 4.67-2 7.42 1.04-.74 3.34-3.46 4.34-5.14.52-.81 1.06-1.78 1.37-2.56 3.17-2.09 5.06-2.09 6.29-2.09 1.71 0 3 1.25 3 1.25C20.62 7.71 17.61 2 12.5 2zM12 4.25c1.1 0 2 .9 2 2 0 1.11-.9 2-2 2-1.11 0-2-.89-2-2 0-1.1.9-2 2-2z"/>
    </svg>

    <div class="container">
        <div class="register-card" x-data="registrationForm()">
            <!-- Top decoration line -->
            <div class="card-decoration"></div>
            
            <!-- Card header -->
            <div class="card-header">
                <div class="auth-logo">
                    <img src="<?= $baseUrl ?>/assets/images/logo.svg" alt="Wildlife Haven Logo">
                    <h1>Wildlife Haven</h1>
                </div>
                
                <h2 class="card-title">Create Your Account</h2>
                <p class="card-subtitle" x-show="currentStep < 4">Join our community of mindful focus</p>
                
                <!-- Step progress indicator -->
                <div class="step-progress" x-show="currentStep < 4">
                    <div class="step-progress-bar" :style="`width: ${(currentStep - 1) * 50}%`"></div>
                    <div class="step-item" :class="{'active': currentStep === 1, 'completed': currentStep > 1}">
                        <span>1</span>
                    </div>
                    <div class="step-item" :class="{'active': currentStep === 2, 'completed': currentStep > 2}">
                        <span>2</span>
                    </div>
                    <div class="step-item" :class="{'active': currentStep === 3, 'completed': currentStep > 3}">
                        <span>3</span>
                    </div>
                </div>
            </div>
            
            <!-- Card body -->
            <div class="card-body">
                <!-- Flash message display -->
                <?php if ($flashMessage): ?>
                    <div class="alert alert-<?= $flashType ?>">
                        <?php if ($flashType == 'success'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-.997-6l7.07-7.071-1.414-1.414-5.656 5.657-2.829-2.829-1.414 1.414L11.003 16z"/>
                            </svg>
                        <?php elseif ($flashType == 'danger'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm0-8v6h2V7h-2z"/>
                            </svg>
                        <?php elseif ($flashType == 'warning'): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-7v2h2v-2h-2zm0-8v6h2V7h-2z"/>
                            </svg>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/>
                            </svg>
                        <?php endif; ?>
                        <div><?= $flashMessage ?></div>
                    </div>
                <?php endif; ?>
                
                <!-- Registration form -->
                <form id="registration-form" class="register-form" action="<?= $baseUrl ?>/auth/register/process" method="POST" @submit.prevent="submitForm">
                    <div class="steps-container" style="min-height: 300px;">
                        <!-- Step 1: Basic Info -->
                        <div class="step" :class="{'active': currentStep === 1, 'left': currentStep > 1}">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <div class="input-group">
                                    <input 
                                        type="text" 
                                        id="username"
                                        name="username"
                                        x-model="formData.username"
                                        :class="{'is-invalid': errors.username}"
                                        @input="validateUsername"
                                        autocomplete="username"
                                        required
                                    >
                                    <span class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <span class="helper-text">Choose a unique username (3-50 characters)</span>
                                <div class="invalid-feedback" x-show="errors.username" x-text="errors.username"></div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <div class="input-group">
                                    <input 
                                        type="email" 
                                        id="email"
                                        name="email"
                                        x-model="formData.email"
                                        :class="{'is-invalid': errors.email}"
                                        @input="validateEmail"
                                        autocomplete="email"
                                        required
                                    >
                                    <span class="input-icon">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                </div>
                                <span class="helper-text">We'll send a verification link to this address</span>
                                <div class="invalid-feedback" x-show="errors.email" x-text="errors.email"></div>
                            </div>
                            <div class="form-actions">
                                <div></div> <!-- Empty div for flex spacing -->
                                <button 
                                    type="button" 
                                    class="btn btn-primary next-btn" 
                                    @click="goToNextStep"
                                    :disabled="!canProceedFromStep1"
                                >
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2: Password -->
                        <div class="step" :class="{'active': currentStep === 2, 'left': currentStep > 2}">
                            <div class="form-group">
                                <label for="password">Create Password</label>
                                <div class="input-group">
                                    <input 
                                        :type="passwordVisible ? 'text' : 'password'" 
                                        id="password"
                                        name="password"
                                        x-model="formData.password"
                                        :class="{'is-invalid': errors.password}"
                                        @input="validatePassword"
                                        autocomplete="new-password"
                                        required
                                    >
                                    <button 
                                        type="button" 
                                        class="toggle-password" 
                                        @click="passwordVisible = !passwordVisible"
                                    >
                                        <i :class="passwordVisible ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                <div class="password-strength">
                                    <div 
                                        class="password-bar" 
                                        :style="`width: ${passwordStrength}%; background-color: ${getStrengthColor()};`"
                                    ></div>
                                </div>
                                <div class="password-text">
                                    <span>Password strength:</span>
                                    <span class="strength" :style="`color: ${getStrengthColor()};`" x-text="getStrengthText()"></span>
                                </div>
                                
                                <div class="password-requirements">
                                    <div class="requirement" :class="{'met': hasMinimumLength}">
                                        <i :class="hasMinimumLength ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                                        At least 8 characters
                                    </div>
                                    <div class="requirement" :class="{'met': hasUpperAndLowerCase}">
                                        <i :class="hasUpperAndLowerCase ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                                        Contains uppercase and lowercase letters
                                    </div>
                                    <div class="requirement" :class="{'met': hasNumber}">
                                        <i :class="hasNumber ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                                        Contains at least one number
                                    </div>
                                    <div class="requirement" :class="{'met': hasSpecialChar}">
                                        <i :class="hasSpecialChar ? 'fas fa-check-circle' : 'far fa-circle'"></i>
                                        Contains at least one special character
                                    </div>
                                </div>
                                
                                <div class="invalid-feedback" x-show="errors.password" x-text="errors.password"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirm">Confirm Password</label>
                                <div class="input-group">
                                    <input 
                                        :type="confirmPasswordVisible ? 'text' : 'password'" 
                                        id="password_confirm"
                                        name="password_confirm"
                                        x-model="formData.password_confirm"
                                        :class="{'is-invalid': errors.password_confirm}"
                                        @input="validateConfirmPassword"
                                        autocomplete="new-password"
                                        required
                                    >
                                    <button 
                                        type="button" 
                                        class="toggle-password" 
                                        @click="confirmPasswordVisible = !confirmPasswordVisible"
                                    >
                                        <i :class="confirmPasswordVisible ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" x-show="errors.password_confirm" x-text="errors.password_confirm"></div>
                            </div>
                            
                            <div class="form-actions">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary prev-btn" 
                                    @click="goToPrevStep"
                                >
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button 
                                    type="button" 
                                    class="btn btn-primary next-btn" 
                                    @click="goToNextStep"
                                    :disabled="!canProceedFromStep2"
                                >
                                    Continue <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 3: Terms and Preferences -->
                        <div class="step" :class="{'active': currentStep === 3, 'left': currentStep > 3}">
                            <div class="form-group">
                                <div class="checkbox-container">
                                    <input 
                                        type="checkbox" 
                                        id="terms" 
                                        name="terms" 
                                        x-model="formData.terms"
                                        :class="{'is-invalid': errors.terms}"
                                        required
                                    >
                                    <span class="checkbox-mark"></span>
                                    <label for="terms">
                                        I agree to the <a href="<?= $baseUrl ?>/terms" target="_blank">Terms of Service</a> and <a href="<?= $baseUrl ?>/privacy" target="_blank">Privacy Policy</a>
                                    </label>
                                </div>
                                <div class="invalid-feedback" x-show="errors.terms" x-text="errors.terms"></div>
                            </div>
                            
                            <div class="form-group">
                                <div class="checkbox-container">
                                    <input 
                                        type="checkbox" 
                                        id="newsletter" 
                                        name="newsletter" 
                                        x-model="formData.newsletter"
                                    >
                                    <span class="checkbox-mark"></span>
                                    <label for="newsletter">
                                        Send me occasional emails about Wildlife Haven updates, conservation news, and focus tips (optional)
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary prev-btn" 
                                    @click="goToPrevStep"
                                >
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button 
                                    type="submit" 
                                    class="btn btn-primary" 
                                    :disabled="submitting || !canProceedFromStep3"
                                >
                                    <span class="spinner" x-show="submitting"></span>
                                    <span x-text="submitting ? 'Creating Account...' : 'Create Account'"></span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 4: Success -->
                        <div class="step" :class="{'active': currentStep === 4}">
                            <div class="success-animation">
                                <div class="success-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <h3 class="success-title">Account Created!</h3>
                                <p class="success-text">
                                    Your Wildlife Haven journey begins now. We've sent a verification email to 
                                    <strong x-text="formData.email"></strong>.
                                </p>
                                <a href="<?= $baseUrl ?>/auth/login" class="btn btn-primary">
                                    Go to Login <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                
                <!-- Social login options -->
                <div class="social-login" x-show="currentStep === 1">
                    <div class="social-divider">
                        <span class="social-divider-text">Or sign up with</span>
                    </div>
                    
                    <div class="social-buttons">
                        <a href="<?= $baseUrl ?>/auth/google" class="social-button google">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#4285F4"/>
                            </svg>
                            Google
                        </a>
                        
                        <a href="<?= $baseUrl ?>/auth/apple" class="social-button apple">
                            <svg viewBox="0 0 24 24" width="18" height="18">
                                <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 8.42 7.31c1.33.07 2.25.8 3.06.85.83 0 2.13-.84 3.59-.71 1.85.19 3.24 1.05 3.96 2.69-3.14 1.93-2.2 5.55.59 6.75-.62 1.53-1.42 3-2.57 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.26 2.31-2.14 4.2-3.74 4.25z" fill="#000000"/>
                            </svg>
                            Apple
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Card footer -->
            <div class="card-footer" x-show="currentStep < 4">
                <p>Already have an account? <a href="<?= $baseUrl ?>/auth/login">Sign in</a></p>
            </div>
        </div>
    </div>
    
    <script>
        // Alpine.js component for form handling
        function registrationForm() {
            return {
                currentStep: 1,
                submitting: false,
                passwordVisible: false,
                confirmPasswordVisible: false,
                passwordStrength: 0,
                hasMinimumLength: false,
                hasUpperAndLowerCase: false,
                hasNumber: false,
                hasSpecialChar: false,
                
                formData: {
                    username: '',
                    email: '',
                    password: '',
                    password_confirm: '',
                    terms: false,
                    newsletter: false
                },
                
                errors: {
                    username: '',
                    email: '',
                    password: '',
                    password_confirm: '',
                    terms: ''
                },
                
                // Navigation methods
                goToNextStep() {
                    if (this.currentStep === 1 && !this.canProceedFromStep1) {
                        this.shakeForm();
                        return;
                    }
                    
                    if (this.currentStep === 2 && !this.canProceedFromStep2) {
                        this.shakeForm();
                        return;
                    }
                    
                    if (this.currentStep < 3) {
                        this.currentStep++;
                        // Animate background shapes
                        this.animateBackgroundShapes();
                    }
                },
                
                goToPrevStep() {
                    if (this.currentStep > 1) {
                        this.currentStep--;
                        // Animate background shapes
                        this.animateBackgroundShapes();
                    }
                },
                
                shakeForm() {
                    const form = document.querySelector('.register-form');
                    form.classList.add('shake');
                    setTimeout(() => {
                        form.classList.remove('shake');
                    }, 600);
                },
                
                // Form validation methods
                validateUsername() {
                    this.errors.username = '';
                    
                    if (this.formData.username.length < 3) {
                        this.errors.username = 'Username must be at least 3 characters';
                        return false;
                    }
                    
                    if (this.formData.username.length > 50) {
                        this.errors.username = 'Username cannot exceed 50 characters';
                        return false;
                    }
                    
                    if (!/^[a-zA-Z0-9_]+$/.test(this.formData.username)) {
                        this.errors.username = 'Username can only contain letters, numbers, and underscores';
                        return false;
                    }
                    
                    return true;
                },
                
                validateEmail() {
                    this.errors.email = '';
                    
                    if (!this.formData.email) {
                        this.errors.email = 'Email is required';
                        return false;
                    }
                    
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(this.formData.email)) {
                        this.errors.email = 'Please enter a valid email address';
                        return false;
                    }
                    
                    return true;
                },
                
                validatePassword() {
                    this.errors.password = '';
                    
                    // Check minimum length
                    this.hasMinimumLength = this.formData.password.length >= 8;
                    
                    // Check for uppercase and lowercase letters
                    this.hasUpperAndLowerCase = /[a-z]/.test(this.formData.password) && 
                                               /[A-Z]/.test(this.formData.password);
                    
                    // Check for numbers
                    this.hasNumber = /\d/.test(this.formData.password);
                    
                    // Check for special characters
                    this.hasSpecialChar = /[^a-zA-Z0-9]/.test(this.formData.password);
                    
                    // Calculate strength
                    this.calculatePasswordStrength();
                    
                    if (!this.hasMinimumLength) {
                        this.errors.password = 'Password must be at least 8 characters';
                        return false;
                    }
                    
                    return true;
                },
                
                validateConfirmPassword() {
                    this.errors.password_confirm = '';
                    
                    if (this.formData.password !== this.formData.password_confirm) {
                        this.errors.password_confirm = 'Passwords do not match';
                        return false;
                    }
                    
                    return true;
                },
                
                validateTerms() {
                    this.errors.terms = '';
                    
                    if (!this.formData.terms) {
                        this.errors.terms = 'You must agree to the Terms of Service and Privacy Policy';
                        return false;
                    }
                    
                    return true;
                },
                
                // Calculate password strength percentage (0-100)
                calculatePasswordStrength() {
                    let strength = 0;
                    
                    // Length based score
                    if (this.formData.password.length >= 8) strength += 25;
                    
                    // Character type based score
                    if (this.hasUpperAndLowerCase) strength += 25;
                    if (this.hasNumber) strength += 25;
                    if (this.hasSpecialChar) strength += 25;
                    
                    this.passwordStrength = strength;
                },
                
                getStrengthColor() {
                    if (this.passwordStrength <= 25) return '#dc3545'; // weak - red
                    if (this.passwordStrength <= 50) return '#ffc107'; // medium - yellow
                    if (this.passwordStrength <= 75) return '#17a2b8'; // strong - blue
                    return '#28a745'; // very strong - green
                },
                
                getStrengthText() {
                    if (this.passwordStrength <= 25) return 'Weak';
                    if (this.passwordStrength <= 50) return 'Medium';
                    if (this.passwordStrength <= 75) return 'Strong';
                    return 'Very Strong';
                },
                
                // Step validation for continue buttons
                get canProceedFromStep1() {
                    return this.validateUsername() && this.validateEmail();
                },
                
                get canProceedFromStep2() {
                    return this.validatePassword() && this.validateConfirmPassword();
                },
                
                get canProceedFromStep3() {
                    return this.validateTerms();
                },
                
                // Form submission handler
                submitForm() {
                    if (!this.canProceedFromStep3) {
                        this.shakeForm();
                        return;
                    }
                    
                    this.submitting = true;
                    
                    // Simulate form submission with delay for demo purposes
                    setTimeout(() => {
                        // For real implementation, remove this setTimeout and use actual form submission
                        this.submitting = false;
                        this.currentStep = 4; // Show success step
                        this.animateSuccessStep();
                        
                        // Submit the form
                        document.getElementById('registration-form').submit();
                    }, 1500);
                },
                
                // Animation methods
                animateBackgroundShapes() {
                    // Animate background shapes based on current step
                    if (window.gsap) {
                        gsap.to("#shape1", {
                            duration: 1.5,
                            scale: 1 + (this.currentStep * 0.05),
                            rotation: 5 * this.currentStep,
                            ease: "power2.inOut"
                        });
                        
                        gsap.to("#shape2", {
                            duration: 1.5,
                            scale: 1 + (this.currentStep * 0.08),
                            rotation: -8 * this.currentStep,
                            ease: "power2.inOut"
                        });
                        
                        gsap.to("#shape3", {
                            duration: 1.5,
                            x: 10 * this.currentStep,
                            y: -5 * this.currentStep,
                            ease: "power2.inOut"
                        });
                        
                        gsap.to("#shape4", {
                            duration: 1.5,
                            x: -15 * this.currentStep,
                            y: 10 * this.currentStep,
                            ease: "power2.inOut"
                        });
                    }
                },
                
                animateSuccessStep() {
                    if (window.gsap) {
                        // Animate success elements
                        gsap.from(".success-icon", {
                            duration: 0.8,
                            scale: 0.5,
                            opacity: 0,
                            ease: "back.out(1.7)"
                        });
                        
                        gsap.from(".success-title", {
                            duration: 0.8,
                            y: 20,
                            opacity: 0,
                            delay: 0.3,
                            ease: "power3.out"
                        });
                        
                        gsap.from(".success-text", {
                            duration: 0.8,
                            y: 20,
                            opacity: 0,
                            delay: 0.5,
                            ease: "power3.out"
                        });
                        
                        gsap.from(".success-animation .btn", {
                            duration: 0.8,
                            y: 20,
                            opacity: 0,
                            delay: 0.7,
                            ease: "power3.out"
                        });
                        
                        // Also animate background shapes
                        gsap.to([".bg-shape"], {
                            duration: 2,
                            scale: 1.2,
                            opacity: 0.6,
                            stagger: 0.1,
                            ease: "power2.inOut"
                        });
                    }
                },
                
                init() {
                    // Initialize animations
                    this.animateBackgroundShapes();
                    
                    // Add keydown listener for enter key
                    window.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            if (this.currentStep === 1 && this.canProceedFromStep1) {
                                this.goToNextStep();
                            } else if (this.currentStep === 2 && this.canProceedFromStep2) {
                                this.goToNextStep();
                            } else if (this.currentStep === 3 && this.canProceedFromStep3) {
                                this.submitForm();
                            }
                        }
                    });
                }
            };
        }
        
        // Initialize background animations when document is ready
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize GSAP animations if available
            if (window.gsap) {
                // Initial animation for background shapes
                gsap.from(".bg-shape", {
                    duration: 2,
                    scale: 0.8,
                    opacity: 0,
                    stagger: 0.2,
                    ease: "power2.out"
                });
                
                // Continuous subtle animation
                gsap.to(".bg-shape", {
                    duration: 8,
                    rotation: "+=5",
                    scale: 1.05,
                    yoyo: true,
                    repeat: -1,
                    ease: "sine.inOut",
                    stagger: 0.5
                });
                
                // Animate leaf elements for depth
                gsap.to(".leaf1, .leaf3", {
                    duration: 6,
                    rotation: 5,
                    yoyo: true,
                    repeat: -1,
                    ease: "sine.inOut"
                });
                
                gsap.to(".leaf2, .leaf4", {
                    duration: 7,
                    rotation: -8,
                    yoyo: true,
                    repeat: -1,
                    ease: "sine.inOut",
                    delay: 0.5
                });
            }
        });
    </script>
</body>
</html>