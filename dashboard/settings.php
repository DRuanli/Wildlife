<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Account Settings</h1>
        
        <!-- Flash Message -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="bg-<?= $_SESSION['flash_type'] ?? 'blue' ?>-100 border-l-4 border-<?= $_SESSION['flash_type'] ?? 'blue' ?>-500 text-<?= $_SESSION['flash_type'] ?? 'blue' ?>-700 p-4 mb-6" role="alert">
                <p><?= $_SESSION['flash_message']; ?></p>
            </div>
            <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
        <?php endif; ?>
        
        <!-- Change Password Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-blue-600 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Change Password</h2>
            </div>
            
            <form action="<?= $baseUrl ?>/dashboard/settings/password/update" method="POST" class="p-6">
                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                    <input type="password" name="current_password" id="current_password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="new_password" id="new_password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long.</p>
                </div>
                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Password
                </button>
            </form>
        </div>
        
        <!-- Notification Settings Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-green-600 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Notification Settings</h2>
            </div>
            
            <form action="<?= $baseUrl ?>/dashboard/settings/notifications/update" method="POST" class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Email Notifications</h3>
                            <p class="text-sm text-gray-500">Receive emails about your account and focus progress</p>
                        </div>
                        
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="email_notifications" class="rounded text-green-600 focus:ring-green-500 h-4 w-4" checked>
                        </label>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Focus Reminders</h3>
                                <p class="text-sm text-gray-500">Get daily reminders to focus</p>
                            </div>
                            
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="focus_reminders" class="rounded text-green-600 focus:ring-green-500 h-4 w-4" checked>
                            </label>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Achievement Notifications</h3>
                                <p class="text-sm text-gray-500">Get notified when you earn new achievements</p>
                            </div>
                            
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="achievement_notifications" class="rounded text-green-600 focus:ring-green-500 h-4 w-4" checked>
                            </label>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Marketing Emails</h3>
                                <p class="text-sm text-gray-500">Receive updates and promotions</p>
                            </div>
                            
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="marketing_emails" class="rounded text-green-600 focus:ring-green-500 h-4 w-4">
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Save Notification Preferences
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Account Management Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-red-600 text-white px-6 py-4">
                <h2 class="text-xl font-bold">Account Management</h2>
            </div>
            
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Danger Zone</h3>
                
                <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                    <h4 class="text-md font-medium text-red-800 mb-2">Delete Account</h4>
                    <p class="text-sm text-red-700 mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                    
                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" 
                    onclick="document.getElementById('delete-account-modal').classList.remove('hidden')">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="delete-account-modal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg max-w-md w-full">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Account Deletion</h3>
            <p class="text-sm text-gray-500 mb-4">
                Are you sure you want to delete your account? All of your data will be permanently removed. This action cannot be undone.
            </p>
            
            <form action="<?= $baseUrl ?>/dashboard/settings/account/delete" method="POST">
                <div class="mb-4">
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Enter your password to confirm</label>
                    <input type="password" name="password_confirm" id="password_confirm" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    onclick="document.getElementById('delete-account-modal').classList.add('hidden')">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>