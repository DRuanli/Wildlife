<?php
// Path: app/Services/Auth/OAuthService.php

namespace App\Services\Auth;

/**
 * OAuth Service
 * 
 * Handles OAuth authentication for Google and Apple
 */
class OAuthService
{
    /**
     * Google OAuth client ID from environment
     * @var string
     */
    private $googleClientId;
    
    /**
     * Google OAuth client secret from environment
     * @var string
     */
    private $googleClientSecret;
    
    /**
     * Google OAuth redirect URI
     * @var string
     */
    private $googleRedirectUri;
    
    /**
     * Apple OAuth client ID from environment
     * @var string
     */
    private $appleClientId;
    
    /**
     * Apple OAuth client secret from environment
     * @var string
     */
    private $appleClientSecret;
    
    /**
     * Apple OAuth redirect URI
     * @var string
     */
    private $appleRedirectUri;
    
    /**
     * Base URL for application
     * @var string
     */
    private $appUrl;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->appUrl = $_ENV['APP_URL'] ?? 'http://localhost';
        
        // Google OAuth configuration
        $this->googleClientId = $_ENV['GOOGLE_CLIENT_ID'] ?? '';
        $this->googleClientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
        $this->googleRedirectUri = $this->appUrl . '/auth/google/callback';
        
        // Apple OAuth configuration
        $this->appleClientId = $_ENV['APPLE_CLIENT_ID'] ?? '';
        $this->appleClientSecret = $_ENV['APPLE_CLIENT_SECRET'] ?? '';
        $this->appleRedirectUri = $this->appUrl . '/auth/apple/callback';
    }
    
    /**
     * Get Google OAuth authorization URL
     * 
     * @return string Authorization URL
     */
    public function getGoogleAuthUrl()
    {
        $params = [
            'client_id' => $this->googleClientId,
            'redirect_uri' => $this->googleRedirectUri,
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
            'access_type' => 'online',
            'prompt' => 'select_account'
        ];
        
        return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);
    }
    
    /**
     * Handle Google OAuth callback
     * 
     * @param string $code Authorization code
     * @return array User information
     * @throws \Exception If token exchange fails
     */
    public function handleGoogleCallback($code)
    {
        // Exchange authorization code for tokens
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $tokenData = [
            'code' => $code,
            'client_id' => $this->googleClientId,
            'client_secret' => $this->googleClientSecret,
            'redirect_uri' => $this->googleRedirectUri,
            'grant_type' => 'authorization_code'
        ];
        
        $tokenResponse = $this->makePostRequest($tokenUrl, $tokenData);
        
        if (!isset($tokenResponse['access_token'])) {
            throw new \Exception('Failed to exchange code for tokens.');
        }
        
        // Get user info using the access token
        $userInfoUrl = 'https://www.googleapis.com/oauth2/v3/userinfo';
        $userInfo = $this->makeGetRequest($userInfoUrl, [
            'Authorization: Bearer ' . $tokenResponse['access_token']
        ]);
        
        if (!isset($userInfo['sub'])) {
            throw new \Exception('Failed to get user information.');
        }
        
        return $userInfo;
    }
    
    /**
     * Get Apple OAuth authorization URL
     * 
     * @return string Authorization URL
     */
    public function getAppleAuthUrl()
    {
        $params = [
            'client_id' => $this->appleClientId,
            'redirect_uri' => $this->appleRedirectUri,
            'response_type' => 'code',
            'scope' => 'name email',
            'response_mode' => 'form_post'
        ];
        
        return 'https://appleid.apple.com/auth/authorize?' . http_build_query($params);
    }
    
    /**
     * Handle Apple OAuth callback
     * 
     * @param string $code Authorization code
     * @return array User information
     * @throws \Exception If token exchange fails
     */
    public function handleAppleCallback($code)
    {
        // Exchange authorization code for tokens
        $tokenUrl = 'https://appleid.apple.com/auth/token';
        $tokenData = [
            'code' => $code,
            'client_id' => $this->appleClientId,
            'client_secret' => $this->generateAppleClientSecret(),
            'redirect_uri' => $this->appleRedirectUri,
            'grant_type' => 'authorization_code'
        ];
        
        $tokenResponse = $this->makePostRequest($tokenUrl, $tokenData);
        
        if (!isset($tokenResponse['id_token'])) {
            throw new \Exception('Failed to exchange code for tokens.');
        }
        
        // Decode the ID token (JWT)
        $userData = $this->decodeAppleIdToken($tokenResponse['id_token']);
        
        // If user data was included in the initial request (first time login)
        if (isset($_POST['user']) && !empty($_POST['user'])) {
            $userJson = json_decode($_POST['user'], true);
            
            if (isset($userJson['name'])) {
                $userData['name'] = $userJson['name']['firstName'] . ' ' . $userJson['name']['lastName'];
            }
        }
        
        return $userData;
    }
    
    /**
     * Generate client secret for Apple OAuth
     * 
     * @return string Generated client secret (JWT)
     */
    private function generateAppleClientSecret()
    {
        // In a real implementation, this would generate a JWT token
        // using the private key and team ID from Apple Developer account
        // For simplicity, we're assuming the client secret is already generated
        // and stored in the environment variable
        
        return $this->appleClientSecret;
    }
    
    /**
     * Decode Apple ID token (JWT)
     * 
     * @param string $idToken ID token from Apple
     * @return array Decoded token data
     * @throws \Exception If token is invalid
     */
    private function decodeAppleIdToken($idToken)
    {
        $tokenParts = explode('.', $idToken);
        
        if (count($tokenParts) !== 3) {
            throw new \Exception('Invalid ID token format.');
        }
        
        $payload = $tokenParts[1];
        $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);
        
        if (!$payload) {
            throw new \Exception('Invalid token payload.');
        }
        
        return $payload;
    }
    
    /**
     * Make a POST request
     * 
     * @param string $url URL to send request to
     * @param array $data POST data
     * @param array $headers Additional headers
     * @return array Response data
     * @throws \Exception If request fails
     */
    private function makePostRequest($url, $data, $headers = [])
    {
        $ch = curl_init($url);
        
        $defaultHeaders = [
            'Content-Type: application/x-www-form-urlencoded'
        ];
        
        $allHeaders = array_merge($defaultHeaders, $headers);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_HTTPHEADER => $allHeaders,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new \Exception('cURL Error: ' . $error);
        }
        
        $result = json_decode($response, true);
        
        if (!$result) {
            throw new \Exception('Invalid response: ' . $response);
        }
        
        return $result;
    }
    
    /**
     * Make a GET request
     * 
     * @param string $url URL to send request to
     * @param array $headers Request headers
     * @return array Response data
     * @throws \Exception If request fails
     */
    private function makeGetRequest($url, $headers = [])
    {
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => true
        ]);
        
        $response = curl_exec($ch);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            throw new \Exception('cURL Error: ' . $error);
        }
        
        $result = json_decode($response, true);
        
        if (!$result) {
            throw new \Exception('Invalid response: ' . $response);
        }
        
        return $result;
    }
}