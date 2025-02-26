<?php
// Path: app/routes.php

/**
 * Application Routes
 * 
 * Define all application routes here
 */
function getRoutes() {
    return [
        '/' => 'HomeController@index',
        '/auth/login' => 'AuthController@showLogin',
        '/auth/login/process' => 'AuthController@login',
        '/auth/register' => 'AuthController@showRegister',
        '/auth/register/process' => 'AuthController@register',
        '/auth/logout' => 'AuthController@logout',
        '/auth/verify/:token' => 'AuthController@verifyEmail',
        '/auth/google' => 'AuthController@googleLogin',
        '/auth/google/callback' => 'AuthController@googleCallback',
        '/auth/apple' => 'AuthController@appleLogin',
        '/auth/apple/callback' => 'AuthController@appleCallback',
        '/dashboard' => 'DashboardController@index',
        '/dashboard/profile' => 'DashboardController@profile',
        '/dashboard/settings' => 'DashboardController@settings'
    ];
}