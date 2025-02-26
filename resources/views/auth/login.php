<?php
/**
 * Wildlife Haven - Login Page
 * 
 * This login page follows Japandi aesthetic principles:
 * - Clean, minimalist layout with ample whitespace
 * - Neutral, nature-inspired color palette
 * - Simple, functional elements with organic touches
 * - Focus on user experience with calm visual hierarchy
 */

// Ensure this page is not cached
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

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
    
    <!-- Google Fonts - Noto Sans and Noto Serif for Japandi aesthetic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600&family=Noto+Serif:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <style>
        /* Japandi-inspired color palette */
        :root {
            --color-primary: #6A8D73;       /* Muted sage green */
            --color-primary-light: #8FAD97; /* Lighter sage */
            --color-primary-dark: #4D6B54;  /* Darker sage */
            --color-secondary: #F4F0E6;     /* Warm off-white */
            --color-accent: #D7C0AE;        /* Warm wood */
            --color-text: #2D2D2A;          /* Soft charcoal */
            --color-text-light: #6B6B67;    /* Lighter text */
            --color-subtle: #E8E4DC;        /* Light neutral */
            --color-error: #B9716F;         /* Muted red */
            --color-success: #84A59D;       /* Muted teal */
            --color-warning: #D9B779;       /* Muted gold */
            --color-info: #8EAEC5;          /* Muted blue */
        }
        
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans', sans-serif;
            background-color: var(--color-secondary);
            color: var(--color-text);
            line-height: 1.6;
            display: flex;
            min-height: 100vh;
        }
        
        /* Left panel - decorative nature image */
        .auth-image {
            display: none; /* Hidden on mobile */
            background-image: url('<?= $baseUrl ?>/assets/images/auth-nature.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        /* Semi-transparent overlay with subtle texture */
        .auth-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(106, 141, 115, 0.2); /* Sage green with opacity */
            background-image: url('<?= $baseUrl ?>/assets/images/texture-light.png');
            background-blend-mode: overlay;
            z-index: 1;
        }
        
        /* Right panel - form container */
        .auth-form-container {
            flex: 1;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #FFFFFF;
        }
        
        /* Auth form */
        .auth-form {
            width: 100%;
            max-width: 400px;
        }
        
        /* Logo and branding */
        .auth-logo {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .auth-logo img {
            height: 60px;
            width: auto;
        }
        
        .auth-logo h1 {
            font-family: 'Noto Serif', serif;
            font-weight: 500;
            font-size: 1.5rem;
            margin-top: 0.5rem;
            color: var(--color-primary-dark);
        }
        
        /* Typography */
        h2 {
            font-family: 'Noto Serif', serif;
            font-weight: 500;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
            color: var(--color-text);
        }
        
        /* Form elements with Japandi aesthetic */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: var(--color-text-light);
        }
        
        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--color-subtle);
            border-radius: 4px;
            background-color: #FFFFFF;
            font-family: 'Noto Sans', sans-serif;
            font-size: 1rem;
            color: var(--color-text);
            transition: border-color 0.2s ease;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: var(--color-primary);
            box-shadow: 0 0 0 2px rgba(106, 141, 115, 0.1);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-top: 0.25rem;
        }
        
        input[type="checkbox"] {
            margin-right: 0.5rem;
            width: 18px;
            height: 18px;
            accent-color: var(--color-primary);
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .form-footer a {
            color: var(--color-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        .form-footer a:hover {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }
        
        /* Buttons with natural, organic feel */
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-family: 'Noto Sans', sans-serif;
            font-size: 1rem;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
            width: 100%;
        }
        
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
        }
        
        /* Social login buttons - subtle styling */
        .social-login {
            margin-top: 2rem;
            text-align: center;
        }
        
        .social-login-divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }
        
        .social-login-divider::before,
        .social-login-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--color-subtle);
        }
        
        .social-login-divider span {
            padding: 0 1rem;
            color: var(--color-text-light);
            font-size: 0.9rem;
        }
        
        .social-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
            background-color: white;
            border: 1px solid var(--color-subtle);
            border-radius: 4px;
            color: var(--color-text);
        }
        
        .btn-social:hover {
            background-color: var(--color-secondary);
        }
        
        .btn-social svg {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
        }
        
        /* Registration link */
        .auth-alt {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--color-subtle);
            font-size: 0.9rem;
            color: var(--color-text-light);
        }
        
        .auth-alt a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
        }
        
        .auth-alt a:hover {
            text-decoration: underline;
        }
        
        /* Alert/flash message styling - with gentle colors */
        .alert {
            padding: 1rem;
            border-radius: 4px;
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
            background-color: rgba(132, 165, 157, 0.1);
            border-left: 3px solid var(--color-success);
            color: var(--color-success);
        }
        
        .alert-danger {
            background-color: rgba(185, 113, 111, 0.1);
            border-left: 3px solid var(--color-error);
            color: var(--color-error);
        }
        
        .alert-warning {
            background-color: rgba(217, 183, 121, 0.1);
            border-left: 3px solid var(--color-warning);
            color: var(--color-warning);
        }
        
        .alert-info {
            background-color: rgba(142, 174, 197, 0.1);
            border-left: 3px solid var(--color-info);
            color: var(--color-info);
        }
        
        /* Natural leaf-inspired decoration element */
        .nature-decoration {
            position: absolute;
            width: 120px;
            height: 120px;
            background-image: url('<?= $baseUrl ?>/assets/images/leaf-decoration.svg');
            background-repeat: no-repeat;
            background-size: contain;
            opacity: 0.15;
            z-index: -1;
        }
        
        .decoration-top-right {
            top: 2rem;
            right: 2rem;
            transform: rotate(45deg);
        }
        
        .decoration-bottom-left {
            bottom: 2rem;
            left: 2rem;
            transform: rotate(-135deg);
        }
        
        /* Responsive styles */
        @media (min-width: 768px) {
            body {
                flex-direction: row;
            }
            
            .auth-image {
                display: block;
                flex: 1;
            }
            
            .auth-form-container {
                flex: 1;
            }
        }
        
        @media (min-width: 1024px) {
            .auth-image {
                flex: 1.2;
            }
            
            .auth-form-container {
                flex: 0.8;
            }
        }
    </style>
</head>
<body>
    <!-- Left panel with nature image -->
    <div class="auth-image"></div>
    
    <!-- Right panel with login form -->
    <div class="auth-form-container">
        <!-- Natural decorative elements - leaf motifs -->
        <div class="nature-decoration decoration-top-right"></div>
        <div class="nature-decoration decoration-bottom-left"></div>
        
        <div class="auth-form">
            <!-- Logo and branding -->
            <div class="auth-logo">
                <img src="<?= $baseUrl ?>/assets/images/logo.svg" alt="Wildlife Haven Logo">
                <h1>Wildlife Haven</h1>
            </div>
            
            <!-- Page title -->
            <h2>Welcome Back</h2>
            
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
            <form action="<?= $baseUrl ?>/auth/login/process" method="POST">
                <!-- Hidden redirect URL -->
                <input type="hidden" name="redirect" value="<?= $redirectUrl ?>">
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-footer">
                    <div class="checkbox-group">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    
                    <a href="<?= $baseUrl ?>/auth/forgot-password">Forgot password?</a>
                </div>
                
                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>
            
            <!-- Social login options -->
            <div class="social-login">
                <div class="social-login-divider">
                    <span>Or continue with</span>
                </div>
                
                <div class="social-buttons">
                    <a href="<?= $baseUrl ?>/auth/google" class="btn-social">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#4285F4"/>
                        </svg>
                        Google
                    </a>
                    
                    <a href="<?= $baseUrl ?>/auth/apple" class="btn-social">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 8.42 7.31c1.33.07 2.25.8 3.06.85.83 0 2.13-.84 3.59-.71 1.85.19 3.24 1.05 3.96 2.69-3.14 1.93-2.2 5.55.59 6.75-.62 1.53-1.42 3-2.57 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.26 2.31-2.14 4.2-3.74 4.25z" fill="#000000"/>
                        </svg>
                        Apple
                    </a>
                </div>
            </div>
            
            <!-- Registration link -->
            <div class="auth-alt">
                <p>Don't have an account? <a href="<?= $baseUrl ?>/auth/register">Sign up</a></p>
            </div>
        </div>
    </div>
</body>
</html>