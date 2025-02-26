<?php
// Path: app/Services/Auth/EmailVerification.php

namespace App\Services\Auth;

/**
 * Email Verification Service
 * 
 * Handles sending verification emails to users
 */
class EmailVerification
{
    /**
     * Send a verification email to a new user
     * 
     * @param string $email User's email address
     * @param string $token Verification token
     * @return bool Success status
     */
    public function sendVerificationEmail($email, $token)
    {
        $appName = $_ENV['APP_NAME'] ?? 'Wildlife Haven';
        $appUrl = $_ENV['APP_URL'] ?? 'http://localhost';
        
        $verificationLink = "{$appUrl}/auth/verify/{$token}";
        
        $subject = "Verify your email address for {$appName}";
        
        $message = "
        <html>
        <head>
            <title>Verify Your Email</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #4CAF50; color: white; padding: 10px; text-align: center; }
                .content { padding: 20px; background-color: #f9f9f9; }
                .button { display: inline-block; background-color: #4CAF50; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px; }
                .footer { padding: 10px; text-align: center; font-size: 12px; color: #777; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>{$appName}</h1>
                </div>
                <div class='content'>
                    <h2>Verify Your Email Address</h2>
                    <p>Thank you for registering! Please click the button below to verify your email address.</p>
                    <p style='text-align: center; margin: 25px 0;'>
                        <a href='{$verificationLink}' class='button'>Verify Email</a>
                    </p>
                    <p>Or copy and paste the following link into your browser:</p>
                    <p style='word-break: break-all;'>{$verificationLink}</p>
                    <p>This link will expire in 24 hours.</p>
                    <p>If you did not sign up for an account, please ignore this email.</p>
                </div>
                <div class='footer'>
                    <p>This is an automated message, please do not reply to this email.</p>
                    <p>&copy; " . date('Y') . " {$appName}. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Set email headers
        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            "From: {$appName} <noreply@" . parse_url($appUrl, PHP_URL_HOST) . ">",
            'X-Mailer: PHP/' . phpversion()
        ];
        
        // Send email
        return mail($email, $subject, $message, implode("\r\n", $headers));
    }
}