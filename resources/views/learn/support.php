<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wildlife Haven - Support Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Simple FAQ toggle functionality
        function toggleFAQ(id) {
            const answer = document.getElementById(id);
            answer.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-green-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Wildlife Haven Support Center</h1>
            <p class="text-green-600 max-w-2xl mx-auto">We're here to help you make the most of your Wildlife Haven experience. Find answers to common questions or reach out to our support team.</p>
        </header>

        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <section class="mb-12">
                <h2 class="text-2xl font-semibold text-green-700 mb-6">Frequently Asked Questions</h2>
                
                <div class="space-y-4">
                    <div class="border-b pb-4">
                        <button 
                            onclick="toggleFAQ('account-linking')" 
                            class="w-full text-left flex justify-between items-center text-green-600 hover:text-green-800"
                        >
                            <span class="font-medium">How do I link my mobile and web accounts?</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="account-linking" class="mt-2 text-gray-600 hidden">
                            <p>To link your mobile and web accounts:</p>
                            <ol class="list-decimal list-inside pl-4">
                                <li>Log in to your account on the Wildlife Haven website</li>
                                <li>Navigate to Account Settings</li>
                                <li>Click on "Link Mobile Account"</li>
                                <li>Use the QR code or token provided to verify your mobile account</li>
                            </ol>
                        </div>
                    </div>

                    <div class="border-b pb-4">
                        <button 
                            onclick="toggleFAQ('focus-coins')" 
                            class="w-full text-left flex justify-between items-center text-green-600 hover:text-green-800"
                        >
                            <span class="font-medium">Why didn't I get my focus coins?</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="focus-coins" class="mt-2 text-gray-600 hidden">
                            <p>Focus coins are awarded based on successful focus sessions. Make sure you:</p>
                            <ul class="list-disc list-inside pl-4">
                                <li>Complete the entire focus session without interruptions</li>
                                <li>Stay within the app during the session</li>
                                <li>Maintain a high Focus Score</li>
                            </ul>
                            <p class="mt-2">If you believe you've completed a valid session, please contact support.</p>
                        </div>
                    </div>

                    <div class="border-b pb-4">
                        <button 
                            onclick="toggleFAQ('ar-features')" 
                            class="w-full text-left flex justify-between items-center text-green-600 hover:text-green-800"
                        >
                            <span class="font-medium">How do I use AR features?</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="ar-features" class="mt-2 text-gray-600 hidden">
                            <p>To use AR features:</p>
                            <ol class="list-decimal list-inside pl-4">
                                <li>Ensure you have a compatible mobile device</li>
                                <li>Open the Wildlife Haven mobile app</li>
                                <li>Navigate to a creature or habitat page</li>
                                <li>Tap the "View in AR" button</li>
                                <li>Allow camera permissions when prompted</li>
                                <li>Point your camera at a flat surface to place your creature</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-2xl font-semibold text-green-700 mb-6">Contact Support</h2>
                <form class="bg-green-50 p-6 rounded-lg">
                    <div class="mb-4">
                        <label for="name" class="block text-green-800 mb-2">Your Name</label>
                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-green-800 mb-2">Email Address</label>
                        <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div class="mb-4">
                        <label for="issue" class="block text-green-800 mb-2">Issue Type</label>
                        <select id="issue" name="issue" class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="account">Account Issue</option>
                            <option value="technical">Technical Problem</option>
                            <option value="billing">Billing Question</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-green-800 mb-2">Describe Your Issue</label>
                        <textarea id="message" name="message" rows="4" required class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition duration-300">
                        Submit Support Ticket
                    </button>
                </form>
            </section>
        </div>

        <footer class="text-center mt-12 text-green-600">
            <p>Need more help? Email us at support@wildlifehaven.com</p>
            <p class="mt-2 text-sm">Hours of Operation: Monday-Friday, 9 AM - 5 PM EST</p>
        </footer>
    </div>
</body>
</html>