<?php
/**
 * Wildlife Haven - Enhanced Login Page
 * Advanced interactive design with immersive animations
 */

// Ensure this page is not cached
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

include('public/loading-component.php');

// Base URL for consistent path references
$baseUrl = '/Wildlife';

// Check if there's a redirect URL in the query string
$redirectUrl = isset($_GET['redirect']) ? htmlspecialchars($_GET['redirect']) : $baseUrl . '/dashboard';

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
    <title>Sign In - Wildlife Haven</title>
    
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
    
    <!-- Three.js for background animation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    
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
        
        /* Canvas background */
        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to bottom right, var(--color-background), #eae7df);
        }
        
        /* Animated particles */
        .particles {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(79, 114, 79, 0.2);
            pointer-events: none;
        }
        
        /* Main container */
        .container {
            width: 100%;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
        }
        
        /* Auth card */
        .auth-card {
            width: 100%;
            max-width: 450px;
            background-color: var(--color-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            position: relative;
            z-index: 1;
            transform: translateY(0);
            opacity: 1;
            transition: transform 0.6s ease, opacity 0.6s ease;
        }
        
        .auth-card.loading {
            transform: translateY(20px);
            opacity: 0.7;
        }
        
        /* Card top decoration */
        .card-decoration {
            height: 6px;
            background: linear-gradient(to right, var(--color-primary), var(--color-accent));
        }
        
        /* Card body padding */
        .card-body {
            padding: 2.5rem;
        }
        
        /* Logo and branding */
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(-10px);
            animation: fade-in-down 0.8s ease forwards;
        }
        
        @keyframes fade-in-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
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
        
        /* Typography */
        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 500;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-align: center;
            color: var(--color-text);
            opacity: 0;
            animation: fade-in 0.8s ease forwards 0.2s;
        }
        
        .welcome-text {
            text-align: center;
            font-size: 1.05rem;
            color: var(--color-text-light);
            margin-bottom: 2rem;
            opacity: 0;
            animation: fade-in 0.8s ease forwards 0.4s;
        }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Animated form elements */
        .form-group {
            margin-bottom: 1.75rem;
            position: relative;
            opacity: 0;
            transform: translateY(10px);
        }
        
        .form-group:nth-child(1) {
            animation: fade-in-up 0.6s ease forwards 0.5s;
        }
        
        .form-group:nth-child(2) {
            animation: fade-in-up 0.6s ease forwards 0.7s;
        }
        
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Floating label style */
        .form-floating {
            position: relative;
        }
        
        .form-floating input {
            width: 100%;
            height: 60px;
            padding: 1.5rem 1rem 0.5rem;
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            color: var(--color-text);
            background-color: transparent;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        
        .form-floating input:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(77, 114, 77, 0.15);
        }
        
        .form-floating label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            font-size: 1rem;
            color: var(--color-text-muted);
            pointer-events: none;
            transition: all 0.2s ease;
        }
        
        .form-floating input:focus ~ label,
        .form-floating input:not(:placeholder-shown) ~ label {
            top: 30%;
            font-size: 0.75rem;
            color: var(--color-primary);
        }
        
        /* Form field icons */
        .input-icon {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            color: var(--color-text-muted);
            transition: color 0.2s ease;
        }
        
        .form-floating input:focus ~ .input-icon {
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
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            transition: color 0.2s ease;
        }
        
        .toggle-password:hover {
            color: var(--color-primary);
        }
        
        /* Remember me and forgot password */
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fade-in 0.6s ease forwards 0.9s;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
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
            position: relative;
            width: 20px;
            height: 20px;
            margin-right: 8px;
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
            color: var(--color-text-light);
            cursor: pointer;
        }
        
        .forgot-password {
            font-size: 0.9rem;
            color: var(--color-primary);
            text-decoration: none;
            position: relative;
        }
        
        .forgot-password::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background-color: var(--color-primary);
            transition: width 0.3s ease;
        }
        
        .forgot-password:hover::after {
            width: 100%;
        }
        
        /* Submit button with animation */
        .submit-button {
            width: 100%;
            background-color: var(--color-primary);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            padding: 0.85rem 1.5rem;
            font-size: 1.05rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: fade-in 0.6s ease forwards 1.1s;
        }
        
        .submit-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.5s ease;
        }
        
        .submit-button:hover {
            background-color: var(--color-primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .submit-button:active::before {
            transform: translate(-50%, -50%) scale(3);
        }
        
        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 0.8s ease infinite;
            margin-right: 8px;
            display: none;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .submit-button.loading .loading-spinner {
            display: inline-block;
        }
        
        .submit-button.loading .button-text {
            opacity: 0.7;
        }
        
        /* Social login section */
        .social-login {
            margin-top: 2.5rem;
            opacity: 0;
            animation: fade-in 0.6s ease forwards 1.3s;
        }
        
        .social-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 1.5rem;
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
            padding: 0.85rem 1rem;
            background-color: var(--color-surface);
            border: 1.5px solid var(--color-border);
            border-radius: var(--radius-md);
            color: var(--color-text);
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-button::before {
            content: '';
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.03);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .social-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .social-button:hover::before {
            opacity: 1;
        }
        
        .social-button svg {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        
        .social-button.google:hover {
            border-color: #DB4437;
        }
        
        .social-button.apple:hover {
            border-color: #000000;
        }
        
        /* Registration link */
        .register-link {
            margin-top: 2.5rem;
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--color-border);
            font-size: 0.95rem;
            opacity: 0;
            animation: fade-in 0.6s ease forwards 1.5s;
        }
        
        .register-link a {
            color: var(--color-primary);
            font-weight: 500;
            text-decoration: none;
            position: relative;
        }
        
        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1.5px;
            background-color: var(--color-primary);
            transition: width 0.3s ease;
        }
        
        .register-link a:hover::after {
            width: 100%;
        }
        
        /* Alert/flash message styling */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 2rem;
            display: flex;
            align-items: flex-start;
            transform: translateY(-10px);
            opacity: 0;
            animation: fade-in-down 0.5s ease forwards 0.3s;
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
        
        /* Decoration leaves */
        .leaf {
            position: absolute;
            width: 40px;
            height: 40px;
            opacity: 0.1;
            pointer-events: none;
            z-index: -1;
        }
        
        .leaf-1 {
            top: 10%;
            left: 10%;
            transform: rotate(45deg);
            animation: float 20s ease-in-out infinite;
        }
        
        .leaf-2 {
            bottom: 20%;
            right: 10%;
            transform: rotate(-15deg);
            animation: float 25s ease-in-out infinite reverse;
        }
        
        .leaf-3 {
            top: 40%;
            right: 15%;
            transform: rotate(30deg);
            animation: float 22s ease-in-out infinite 2s;
        }
        
        .leaf-4 {
            bottom: 10%;
            left: 15%;
            transform: rotate(-30deg);
            animation: float 18s ease-in-out infinite 1s reverse;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(var(--rotation, 0deg));
            }
            50% {
                transform: translateY(-20px) rotate(var(--rotation, 0deg));
            }
        }
        
        /* Password strength indicator */
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            border-radius: 2px;
            background-color: #eee;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: width 0.3s ease, background-color 0.3s ease;
        }
        
        .strength-weak {
            background-color: var(--color-error);
            width: 25%;
        }
        
        .strength-medium {
            background-color: var(--color-warning);
            width: 50%;
        }
        
        .strength-strong {
            background-color: var(--color-success);
            width: 75%;
        }
        
        .strength-very-strong {
            background-color: #43A047;
            width: 100%;
        }
        
        .strength-text {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            text-align: right;
            color: var(--color-text-muted);
        }
        
        /* Fingerprint animation */
        .fingerprint-container {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            opacity: 0.15;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }
        
        .fingerprint-container:hover {
            opacity: 0.5;
        }
        
        .fingerprint {
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234D724D'%3E%3Cpath d='M18,15.5V13a6,6,0,0,0-6-6h0a6,6,0,0,0-6,6v2.5a.5.5,0,0,1-1,0V13a7,7,0,0,1,7-7h0a7,7,0,0,1,7,7v2.5a.5.5,0,0,1-1,0ZM16.5,13V15A4.5,4.5,0,0,1,12,19.5h0A4.5,4.5,0,0,1,7.5,15V13a4.5,4.5,0,0,1,9,0Zm-1,0a3.5,3.5,0,0,0-7,0v2a3.5,3.5,0,0,0,7,0Zm-2,2V13a1.5,1.5,0,0,0-3,0v2a1.5,1.5,0,0,0,3,0Zm-1,0a.5.5,0,0,1-1,0V13a.5.5,0,0,1,1,0Z'/%3E%3C/svg%3E");
            animation: fingerprint-scan 4s ease-in-out infinite;
        }
        
        @keyframes fingerprint-scan {
            0%, 100% {
                opacity: 0.6;
                transform: scale(0.95);
            }
            50% {
                opacity: 1;
                transform: scale(1.05);
            }
        }
        
        /* Responsive styles */
        @media (max-width: 480px) {
            .card-body {
                padding: 2rem 1.5rem;
            }
            
            h2 {
                font-size: 1.75rem;
            }
            
            .welcome-text {
                font-size: 0.95rem;
            }
            
            .form-floating input {
                height: 55px;
            }
            
            .form-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .social-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Background Canvas for Three.js -->
    <canvas id="bg-canvas"></canvas>
    
    <!-- Background particles -->
    <div class="particles" id="particles"></div>
    
    <!-- Decorative leaves -->
    <svg class="leaf leaf-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M12 22c-4.97 0-9-4.03-9-9 0-4.418 2.865-8 7-8 5 0 9 4.582 9 9s-4.03 8-7 8zm0-5c2.206 0 4-1.794 4-4s-1.794-4-4-4-4 1.794-4 4 1.794 4 4 4z" fill="#4D724D"/>
    </svg>
    <svg class="leaf leaf-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M17 8C8 10 5.9 16.17 3.82 21.34l1.89.66A20.5 20.5 0 0 1 9.5 15C16 13 19 14.5 21 17c-2-2.5-5-6-9.9-9.95L9.5 5.5a37.07 37.07 0 0 0-3.43 4.22 8.65 8.65 0 0 1 4.18-2.94L12 6.5c1.82 0 4.05.33 6.07.55a44.62 44.62 0 0 0-8.37-4.24A18.81 18.81 0 0 1 17 8z" fill="#4D724D"/>
    </svg>
    <svg class="leaf leaf-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M21 7c-1.5-2-5.6-5-12-5 2.5 3.5 3 5 3 9.1 0 3.5-.5 5.9-1.5 7.9H6c0-4-1-7-2-9.5-.6 1.5-1 3.2-1 4.5C3 17.6 6.4 21 10.5 21c.5 0 2.5-.1 3-.2-1.3-1.2-2-3.3-2-5.8 0-2 3-5 6.5-5v-1c-1.8 0-3 .5-4 1 1-2.5 5-3 5-3z" fill="#4D724D"/>
    </svg>
    <svg class="leaf leaf-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M12 3C8.5 3 5 4 3 7c.6 1 1.4 2 2.8 2.8.6.4 1.2.7 2 1-.7.4-1.4 1-2 1.7-.6.7-.9 1.6-.8 2.5 0 1 .3 2 1 2.7.7.8 1.8 1.3 3 1.3l-2 2H5v3h3v-1.5h3v1h3V22h3v-3.5L15 17h1v-1c0-1-.2-2-.6-3 .6.2 1.2.5 1.7 1 .8.8 1.4 2 1.7 3.5l1.4-1.4c-.2-.8-.5-1.5-1-2.3-.5-.8-1.3-1.7-2-2.3-.8-.6-1.7-1-2.7-1.5 2-1 3.3-2 4-3.5.7-1.4 1-3 .7-4.7-1.8.3-3.4 1-4.7 2.3-1.3 1.2-2.3 3-2.5 4.8 0-.3-.2-.5-.4-.7-.2-.2-.4-.3-.6-.3-.3 0-.5.1-.7.3-.2.2-.3.4-.3.7 0 .3.1.5.3.7.2.2.4.3.7.3.3 0 .5-.1.7-.3.2-.2.3-.4.4-.7z" fill="#4D724D"/>
    </svg>
    
    <div class="container">
        <div class="auth-card" 
             x-data="{
                loading: false,
                showPassword: false,
                passwordStrength: 0,
                email: '',
                password: '',
                rememberMe: false,
                
                checkPasswordStrength() {
                    const password = this.password;
                    let strength = 0;
                    
                    if (password.length >= 8) strength += 25;
                    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 25;
                    if (password.match(/\d+/)) strength += 25;
                    if (password.match(/[^a-zA-Z0-9]/)) strength += 25;
                    
                    this.passwordStrength = strength;
                },
                
                getStrengthClass() {
                    if (this.passwordStrength <= 25) return 'strength-weak';
                    if (this.passwordStrength <= 50) return 'strength-medium';
                    if (this.passwordStrength <= 75) return 'strength-strong';
                    return 'strength-very-strong';
                },
                
                getStrengthText() {
                    if (this.passwordStrength <= 25) return 'Weak';
                    if (this.passwordStrength <= 50) return 'Medium';
                    if (this.passwordStrength <= 75) return 'Strong';
                    return 'Very Strong';
                },
                
                submitForm() {
                    if(!this.validateForm()) return;
                    
                    this.loading = true;
                    
                    // Simulate network delay for visual feedback (remove in production)
                    setTimeout(() => {
                        document.getElementById('login-form').submit();
                    }, 800);
                },
                
                validateForm() {
                    // Simple validation - can be expanded
                    if(!this.email.trim() || !this.password.trim()) {
                        alert('Please fill in all fields');
                        return false;
                    }
                    return true;
                }
             }"
             :class="{ 'loading': loading }">
            
            <!-- Top decoration line -->
            <div class="card-decoration"></div>
            
            <div class="card-body">
                <!-- Logo and branding -->
                <div class="auth-logo">
                    <img src="<?= $baseUrl ?>/assets/images/logo.svg" alt="Wildlife Haven Logo">
                    <h1>Wildlife Haven</h1>
                </div>
                
                <!-- Page title -->
                <h2>Welcome Back</h2>
                <p class="welcome-text">Sign in to continue your mindful journey</p>
                
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
                
                <!-- Login form -->
                <form id="login-form" action="<?= $baseUrl ?>/auth/login/process" method="POST" @submit.prevent="submitForm">
                    <!-- Hidden redirect URL -->
                    <input type="hidden" name="redirect" value="<?= $redirectUrl ?>">
                    
                    <div class="form-group">
                        <div class="form-floating">
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                placeholder=" " 
                                x-model="email"
                                required 
                                autofocus
                            >
                            <label for="email">Email Address</label>
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-floating">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                id="password" 
                                name="password" 
                                placeholder=" "
                                x-model="password"
                                @input="checkPasswordStrength()"
                                required
                            >
                            <label for="password">Password</label>
                            <button 
                                type="button" 
                                class="toggle-password" 
                                @click="showPassword = !showPassword"
                                aria-label="Toggle password visibility"
                            >
                                <template x-if="!showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </template>
                                <template x-if="showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                        <line x1="1" y1="1" x2="23" y2="23"></line>
                                    </svg>
                                </template>
                            </button>
                        </div>
                        
                        <!-- Password strength indicator (only visible when typing) -->
                        <div class="password-strength" x-show="password.length > 0">
                            <div class="password-strength-bar" :class="getStrengthClass()"></div>
                        </div>
                        <div class="strength-text" x-show="password.length > 0" x-text="getStrengthText()"></div>
                    </div>
                    
                    <div class="form-footer">
                        <div class="checkbox-container">
                            <input type="checkbox" id="remember" name="remember" x-model="rememberMe">
                            <span class="checkbox-mark"></span>
                            <label for="remember">Remember me</label>
                        </div>
                        
                        <a href="<?= $baseUrl ?>/auth/forgot-password" class="forgot-password">Forgot password?</a>
                    </div>
                    
                    <button type="submit" class="submit-button" :class="{ 'loading': loading }" :disabled="loading">
                        <span class="loading-spinner"></span>
                        <span class="button-text">Sign In</span>
                    </button>
                </form>
                
                <!-- Social login options -->
                <div class="social-login">
                    <div class="social-divider">
                        <span class="social-divider-text">Or continue with</span>
                    </div>
                    
                    <div class="social-buttons">
                        <a href="<?= $baseUrl ?>/auth/google" class="social-button google">
                            <svg viewBox="0 0 24 24">
                                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#4285F4"/>
                            </svg>
                            <span>Google</span>
                        </a>
                        
                        <a href="<?= $baseUrl ?>/auth/apple" class="social-button apple">
                            <svg viewBox="0 0 24 24">
                                <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 8.42 7.31c1.33.07 2.25.8 3.06.85.83 0 2.13-.84 3.59-.71 1.85.19 3.24 1.05 3.96 2.69-3.14 1.93-2.2 5.55.59 6.75-.62 1.53-1.42 3-2.57 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.26 2.31-2.14 4.2-3.74 4.25z" fill="#000000"/>
                            </svg>
                            <span>Apple</span>
                        </a>
                    </div>
                </div>
                
                <!-- Registration link -->
                <div class="register-link">
                    <p>Don't have an account? <a href="<?= $baseUrl ?>/auth/register">Sign up</a></p>
                </div>
                
                <!-- Fingerprint decoration -->
                <div class="fingerprint-container" title="Biometric login (demo only)">
                    <div class="fingerprint"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for visual effects -->
    <script>
        // 1. Background Canvas with Three.js
        function initThreeBackground() {
            const canvas = document.getElementById('bg-canvas');
            const renderer = new THREE.WebGLRenderer({ canvas, alpha: true });
            renderer.setSize(window.innerWidth, window.innerHeight);
            
            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.z = 5;
            
            // Create a subtly animated gradient background
            const geometry = new THREE.PlaneGeometry(20, 20);
            const colors = [
                new THREE.Color(0xF9F8F2), // Light cream
                new THREE.Color(0xECEAE0)  // Slightly darker cream
            ];
            
            const material = new THREE.ShaderMaterial({
                uniforms: {
                    color1: { value: colors[0] },
                    color2: { value: colors[1] },
                    time: { value: 0 }
                },
                vertexShader: `
                    varying vec2 vUv;
                    void main() {
                        vUv = uv;
                        gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
                    }
                `,
                fragmentShader: `
                    uniform vec3 color1;
                    uniform vec3 color2;
                    uniform float time;
                    varying vec2 vUv;
                    
                    void main() {
                        float noise = sin(vUv.x * 5.0 + time) * sin(vUv.y * 5.0 + time) * 0.05;
                        vec3 color = mix(color1, color2, vUv.y + noise);
                        gl_FragColor = vec4(color, 1.0);
                    }
                `
            });
            
            const plane = new THREE.Mesh(geometry, material);
            scene.add(plane);
            
            // Animation loop
            function animate(time) {
                requestAnimationFrame(animate);
                
                // Update time uniform
                material.uniforms.time.value = time * 0.0005;
                
                // Render the scene
                renderer.render(scene, camera);
            }
            
            // Handle window resize
            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
            
            // Start animation
            animate();
        }
        
        // 2. Create floating particles
        function createParticles() {
            const container = document.getElementById('particles');
            const particleCount = Math.min(50, Math.floor(window.innerWidth / 20));
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random position
                const posX = Math.random() * 100;
                const posY = Math.random() * 100;
                particle.style.left = `${posX}%`;
                particle.style.top = `${posY}%`;
                
                // Random size
                const size = Math.random() * 8 + 2;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random opacity
                particle.style.opacity = Math.random() * 0.2 + 0.05;
                
                // Random animation
                const duration = Math.random() * 40 + 20;
                const delay = Math.random() * 20;
                
                particle.style.animation = `float ${duration}s ease-in-out ${delay}s infinite alternate`;
                particle.style.setProperty('--rotation', `${Math.random() * 360}deg`);
                
                container.appendChild(particle);
            }
        }
        
        // Run on page load
        document.addEventListener('DOMContentLoaded', () => {
            if (window.THREE) {
                initThreeBackground();
            }
            createParticles();
        });
        
        // Add keydown event for form submission
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                const submitButton = document.querySelector('.submit-button');
                if (submitButton && !submitButton.disabled) {
                    submitButton.click();
                }
            }
        });
    </script>
</body>
</html>