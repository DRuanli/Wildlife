<?php
// Path: app/routes.php

/**
 * Define application routes
 * 
 * Format: 'route' => 'ControllerName@methodName'
 * 
 * @return array
 */
function getRoutes() {
    return [
        // Homepage routes
        '/' => 'HomeController@index',
        
        // Authentication routes
        '/auth/login' => 'AuthController@showLogin',
        '/auth/login/process' => 'AuthController@login',
        '/auth/register' => 'AuthController@showRegister',
        '/auth/register/process' => 'AuthController@register',
        '/auth/logout' => 'AuthController@logout',
        '/auth/verify/:token' => 'AuthController@verifyEmail',
        
        // OAuth routes
        '/auth/google' => 'AuthController@googleLogin',
        '/auth/google/callback' => 'AuthController@googleCallback',
        '/auth/apple' => 'AuthController@appleLogin',
        '/auth/apple/callback' => 'AuthController@appleCallback',
        
        // Dashboard routes
        '/dashboard' => 'DashboardController@index',
        '/dashboard/profile' => 'DashboardController@profile',
        '/dashboard/settings' => 'DashboardController@settings',
        '/dashboard/profile/update' => 'DashboardController@updateProfile',
        '/dashboard/password/update' => 'DashboardController@updatePassword',
        
        // Focus routes
        '/focus' => 'FocusController@index',
        '/focus/session/start' => 'FocusController@startSession',
        '/focus/session/complete' => 'FocusController@completeSession',
        '/focus/session/cancel' => 'FocusController@cancelSession',
        '/focus/session/:id/summary' => 'FocusController@summary',
        '/focus/history' => 'FocusController@history',
        '/focus/stats' => 'FocusController@getStats',
        
        // Creature routes
        '/creatures' => 'CreatureController@index',
        '/creatures/view/:id' => 'CreatureController@view',
        '/creatures/:id/hatch' => 'CreatureController@hatch',
        '/creatures/hatch' => 'CreatureController@hatchEgg',
        '/creatures/evolve' => 'CreatureController@evolveCreature',
        '/creatures/feed' => 'CreatureController@feedCreature',
        '/creatures/play' => 'CreatureController@playWithCreature',
        '/creatures/move' => 'CreatureController@moveToHabitat',
        '/creatures/rename' => 'CreatureController@renameCreature',
        
        // Shop routes
        '/shop' => 'ShopController@index',
        '/shop/item/:id' => 'ShopController@view',
        '/shop/purchase' => 'ShopController@purchase',
        '/shop/wishlist' => 'ShopController@wishlist',
        '/shop/wishlist/add' => 'ShopController@addToWishlist',
        '/shop/wishlist/remove' => 'ShopController@removeFromWishlist',
        '/shop/history' => 'ShopController@history',
        '/shop/get-coins' => 'ShopController@getCurrency',
        '/shop/conservation' => 'ShopController@conservation',
        '/shop/model-preview/:id' => 'ShopController@modelPreview',
        
        // Gallery routes (new)
        '/gallery' => 'GalleryController@index',
        '/gallery/creature-details' => 'GalleryController@getCreatureDetails',
        
        // Learn routes
        '/learn/support' => 'LearnController@support',
        '/learn/faq/:category' => 'LearnController@faq'
    ];
}