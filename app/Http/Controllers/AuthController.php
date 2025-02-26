<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Services\Auth\EmailVerification;
use App\Services\Auth\OAuthService;

/**
 * AuthController
 * 
 * Handles user authentication, registration, and OAuth integration
 */
class AuthController extends Controller
{
    /**
     * @var User $userModel
     */
    private $userModel;
    
    /**
     * @var EmailVerification $emailVerification
     */
    private $emailVerification;
    
    /**
     * @var OAuthService $oauthService
     */
    private $oauthService;
    
    /**
     * Constructor
     * 
     * @param \PDO $db Database connection
     */
    public function __construct($db)
    {
        parent::__construct($db);
        $this->userModel = new User($db);
        $this->emailVerification = new EmailVerification();
        $this->oauthService = new OAuthService();
    }
    
    /**
     * Display login form
     * 
     * @return void
     */
    public function showLogin()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }
        
        $this->render('auth/login');
    }
    
    /**
     * Process login form submission
     * 
     * @return void
     */
    public function login()
    {
        // Validate input
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);
        
        if (!$email) {
            $this->setFlashMessage('Please enter a valid email address.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        // Check if user exists
        $user = $this->userModel->findByEmail($email);
        
        if (!$user) {
            // Use a generic error message for security
            $this->setFlashMessage('Invalid email or password.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        // Verify password
        if (!password_verify($password, $user['password_hash'])) {
            $this->setFlashMessage('Invalid email or password.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        // Check if email is verified
        if (!$user['email_verified_at']) {
            $this->setFlashMessage('Please verify your email address before logging in.', 'warning');
            $this->redirect('/auth/login');
            return;
        }
        
        // Login successful - create session
        $this->createUserSession($user);
        
        // Set remember cookie if requested
        if ($remember) {
            $this->setRememberMeCookie($user['id']);
        }
        
        // Update last login time
        $this->userModel->updateLastLogin($user['id']);
        
        // Redirect to dashboard
        $this->redirect('/dashboard');
    }
    
    /**
     * Process logout request
     * 
     * @return void
     */
    public function logout()
    {
        // Remove session variables
        session_unset();
        
        // Remove remember cookie if exists
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to login page
        $this->redirect('/auth/login');
    }
    
    /**
     * Display registration form
     * 
     * @return void
     */
    public function showRegister()
    {
        // If user is already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
            return;
        }
        
        $this->render('auth/register');
    }
    
    /**
     * Process registration form submission
     * 
     * @return void
     */
    public function register()
    {
        // Validate input
        $username = trim($_POST['username'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';
        
        // Validate username, email, and password
        if (strlen($username) < 3 || strlen($username) > 50) {
            $this->setFlashMessage('Username must be between 3 and 50 characters.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        if (!$email) {
            $this->setFlashMessage('Please enter a valid email address.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        if (strlen($password) < 8) {
            $this->setFlashMessage('Password must be at least 8 characters.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        if ($password !== $password_confirm) {
            $this->setFlashMessage('Passwords do not match.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        // Check if email already exists
        if ($this->userModel->findByEmail($email)) {
            $this->setFlashMessage('Email address is already registered.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        // Check if username already exists
        if ($this->userModel->findByUsername($username)) {
            $this->setFlashMessage('Username is already taken.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        // Create user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $verificationToken = bin2hex(random_bytes(32));
        
        $userData = [
            'username' => $username,
            'email' => $email,
            'password_hash' => $hashedPassword,
            'email_verification_token' => $verificationToken
        ];
        
        $userId = $this->userModel->create($userData);
        
        if (!$userId) {
            $this->setFlashMessage('Error creating account. Please try again.', 'danger');
            $this->redirect('/auth/register');
            return;
        }
        
        // Send verification email
        $this->emailVerification->sendVerificationEmail($email, $verificationToken);
        
        // Redirect to login with success message
        $this->setFlashMessage('Registration successful! Please check your email to verify your account.', 'success');
        $this->redirect('/auth/login');
    }
    
    /**
     * Process email verification
     * 
     * @param array $params URL parameters
     * @return void
     */
    public function verifyEmail($params)
    {
        $token = $params['token'] ?? '';
        
        if (empty($token)) {
            $this->setFlashMessage('Invalid verification link.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        // Find user by verification token
        $user = $this->userModel->findByVerificationToken($token);
        
        if (!$user) {
            $this->setFlashMessage('Invalid verification link or account already verified.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        // Mark email as verified
        $this->userModel->verifyEmail($user['id']);
        
        // Redirect to login with success message
        $this->setFlashMessage('Email verified successfully! You can now log in.', 'success');
        $this->redirect('/auth/login');
    }
    
    /**
     * Initiate Google OAuth login
     * 
     * @return void
     */
    public function googleLogin()
    {
        $redirectUrl = $this->oauthService->getGoogleAuthUrl();
        $this->redirect($redirectUrl);
    }
    
    /**
     * Process Google OAuth callback
     * 
     * @return void
     */
    public function googleCallback()
    {
        $code = $_GET['code'] ?? '';
        
        if (empty($code)) {
            $this->setFlashMessage('Authentication failed.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        try {
            // Exchange code for tokens and get user info
            $userData = $this->oauthService->handleGoogleCallback($code);
            
            // Check if user exists
            $user = $this->userModel->findByEmail($userData['email']);
            
            if ($user) {
                // User exists - log them in
                $this->createUserSession($user);
                $this->userModel->updateLastLogin($user['id']);
                $this->redirect('/dashboard');
                return;
            }
            
            // User doesn't exist - register them
            $username = $this->generateUsername($userData['name']);
            
            $newUser = [
                'username' => $username,
                'email' => $userData['email'],
                'password_hash' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                'email_verified_at' => date('Y-m-d H:i:s'),
                'avatar_url' => $userData['picture'] ?? null,
                'oauth_provider' => 'google',
                'oauth_id' => $userData['sub']
            ];
            
            $userId = $this->userModel->create($newUser);
            
            if (!$userId) {
                $this->setFlashMessage('Error creating account. Please try again.', 'danger');
                $this->redirect('/auth/login');
                return;
            }
            
            // Get the created user and log them in
            $user = $this->userModel->findById($userId);
            $this->createUserSession($user);
            $this->redirect('/dashboard');
            
        } catch (\Exception $e) {
            $this->setFlashMessage('Authentication failed: ' . $e->getMessage(), 'danger');
            $this->redirect('/auth/login');
        }
    }
    
    /**
     * Initiate Apple OAuth login
     * 
     * @return void
     */
    public function appleLogin()
    {
        $redirectUrl = $this->oauthService->getAppleAuthUrl();
        $this->redirect($redirectUrl);
    }
    
    /**
     * Process Apple OAuth callback
     * 
     * @return void
     */
    public function appleCallback()
    {
        $code = $_POST['code'] ?? '';
        
        if (empty($code)) {
            $this->setFlashMessage('Authentication failed.', 'danger');
            $this->redirect('/auth/login');
            return;
        }
        
        try {
            // Exchange code for tokens and get user info
            $userData = $this->oauthService->handleAppleCallback($code);
            
            // Check if user exists
            $user = $this->userModel->findByOAuthId('apple', $userData['sub']);
            
            if ($user) {
                // User exists - log them in
                $this->createUserSession($user);
                $this->userModel->updateLastLogin($user['id']);
                $this->redirect('/dashboard');
                return;
            }
            
            // Apple doesn't always provide email and name in subsequent logins
            // So we need to check if user exists by email if available
            if (isset($userData['email']) && !empty($userData['email'])) {
                $user = $this->userModel->findByEmail($userData['email']);
                
                if ($user) {
                    // Update user with Apple OAuth ID
                    $this->userModel->updateOAuthInfo($user['id'], 'apple', $userData['sub']);
                    
                    $this->createUserSession($user);
                    $this->userModel->updateLastLogin($user['id']);
                    $this->redirect('/dashboard');
                    return;
                }
            }
            
            // User doesn't exist - register them
            $username = $this->generateUsername($userData['name'] ?? 'User');
            
            $newUser = [
                'username' => $username,
                'email' => $userData['email'] ?? null,
                'password_hash' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT),
                'email_verified_at' => date('Y-m-d H:i:s'), // Apple verifies emails
                'oauth_provider' => 'apple',
                'oauth_id' => $userData['sub']
            ];
            
            $userId = $this->userModel->create($newUser);
            
            if (!$userId) {
                $this->setFlashMessage('Error creating account. Please try again.', 'danger');
                $this->redirect('/auth/login');
                return;
            }
            
            // Get the created user and log them in
            $user = $this->userModel->findById($userId);
            $this->createUserSession($user);
            $this->redirect('/dashboard');
            
        } catch (\Exception $e) {
            $this->setFlashMessage('Authentication failed: ' . $e->getMessage(), 'danger');
            $this->redirect('/auth/login');
        }
    }
    
    /**
     * Create user session after successful login
     * 
     * @param array $user User data
     * @return void
     */
    private function createUserSession($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['logged_in'] = true;
    }
    
    /**
     * Set remember me cookie
     * 
     * @param int $userId User ID
     * @return void
     */
    private function setRememberMeCookie($userId)
    {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (30 * 24 * 60 * 60); // 30 days
        
        // Store token in database
        $this->userModel->setRememberToken($userId, $token, date('Y-m-d H:i:s', $expires));
        
        // Set cookie
        setcookie('remember_token', $token, $expires, '/', '', true, true);
    }
    
    /**
     * Generate a unique username based on name
     * 
     * @param string $name Full name
     * @return string Unique username
     */
    private function generateUsername($name)
    {
        // Convert name to lowercase and replace spaces with underscores
        $baseUsername = strtolower(str_replace(' ', '_', $name));
        $baseUsername = preg_replace('/[^a-z0-9_]/', '', $baseUsername);
        
        // Ensure username is between 3 and 50 characters
        if (strlen($baseUsername) < 3) {
            $baseUsername .= '_user';
        }
        
        if (strlen($baseUsername) > 50) {
            $baseUsername = substr($baseUsername, 0, 50);
        }
        
        // Check if username exists
        $username = $baseUsername;
        $i = 1;
        
        while ($this->userModel->findByUsername($username)) {
            $suffix = (string) $i++;
            $username = substr($baseUsername, 0, 50 - strlen($suffix)) . $suffix;
        }
        
        return $username;
    }
    
    /**
     * Check if user is already logged in
     * 
     * @return bool
     */
    private function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    /**
     * Set flash message for the next request
     * 
     * @param string $message Message text
     * @param string $type Message type (success, danger, warning, info)
     * @return void
     */
    protected function setFlashMessage($message, $type = 'info')
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
}