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
        '/dashboard/settings' => 'DashboardController@settings',
        
        // Focus controller routes
        '/focus' => 'FocusController@index',
        '/focus/start' => 'FocusController@startSession',
        '/focus/complete' => 'FocusController@completeSession',
        '/focus/cancel' => 'FocusController@cancelSession',
        '/focus/summary/:id' => 'FocusController@summary',
        '/focus/history' => 'FocusController@history',
        '/focus/stats' => 'FocusController@getStats',

        // Creature controller routes
        '/creatures' => 'CreatureController@index',
        '/creatures/view/:id' => 'CreatureController@view',
        '/creatures/hatch/:id' => 'CreatureController@hatch',
        '/creatures/hatch' => 'CreatureController@hatchEgg',
        '/creatures/evolve' => 'CreatureController@evolveCreature',
        '/creatures/feed' => 'CreatureController@feedCreature',
        '/creatures/play' => 'CreatureController@playWithCreature',
        '/creatures/rename' => 'CreatureController@renameCreature',
        '/creatures/habitat' => 'CreatureController@moveToHabitat',

        // Shop controller routes
        '/shop' => 'ShopController@index',
        '/shop/history' => 'ShopController@history',
        '/shop/wishlist' => 'ShopController@wishlist',
        '/shop/conservation' => 'ShopController@conservation',

        // Creature gallery routes
        '/gallery' => 'GalleryController@index',
    ];
}