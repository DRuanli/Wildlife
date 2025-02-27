<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wildlife Haven - Support Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <style>
        .animate-gradient {
            background: linear-gradient(270deg, #166534, #16a34a, #22c55e);
            background-size: 600% 600%;
            animation: gradientAnimation 8s ease infinite;
        }
        
        @keyframes gradientAnimation {
            0% { background-position: 0% 50% }
            50% { background-position: 100% 50% }
            100% { background-position: 0% 50% }
        }
        
        .scroll-fade {
            transition: opacity 0.4s ease, transform 0.5s ease;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .scroll-fade.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-green-50 to-green-100 min-h-screen">
    <div class="sticky top-0 z-50">
        <nav class="bg-white shadow-md p-4" x-data="{ isOpen: false }">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold text-xl text-green-800">Wildlife Haven</span>
                </div>
                
                <div class="hidden md:flex space-x-6">
                    <a href="#" class="text-green-700 hover:text-green-900">Home</a>
                    <a href="#" class="text-green-700 hover:text-green-900">FAQ</a>
                    <a href="#" class="text-green-700 hover:text-green-900">Contact</a>
                    <a href="#" class="text-green-700 hover:text-green-900">User Guide</a>
                </div>
                
                <div class="md:hidden">
                    <button @click="isOpen = !isOpen" class="text-green-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div x-show="isOpen" class="md:hidden mt-2">
                <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100">Home</a>
                <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100">FAQ</a>
                <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100">Contact</a>
                <a href="#" class="block py-2 px-4 text-green-700 hover:bg-green-100">User Guide</a>
            </div>
        </nav>
    </div>

    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-12 mt-8">
            <div class="animate-gradient text-white inline-block py-2 px-6 rounded-full mb-6">
                <span class="text-sm font-medium">24/7 Support Available</span>
            </div>
            <h1 class="text-5xl font-bold text-green-800 mb-4">Wildlife Haven Support Center</h1>
            <p class="text-green-600 max-w-2xl mx-auto text-lg">We're here to help you make the most of your Wildlife Haven experience. Find answers to common questions or reach out to our support team.</p>
        </header>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl rounded-xl overflow-hidden mb-12" x-data="{ activeTab: 'faq' }">
                <div class="flex border-b">
                    <button 
                        @click="activeTab = 'faq'" 
                        :class="{ 'bg-green-50 text-green-800 border-b-2 border-green-600': activeTab === 'faq', 'text-green-600': activeTab !== 'faq' }"
                        class="flex-1 py-4 font-medium transition-colors duration-200"
                    >
                        FAQs
                    </button>
                    <button 
                        @click="activeTab = 'contact'" 
                        :class="{ 'bg-green-50 text-green-800 border-b-2 border-green-600': activeTab === 'contact', 'text-green-600': activeTab !== 'contact' }"
                        class="flex-1 py-4 font-medium transition-colors duration-200"
                    >
                        Contact Support
                    </button>
                </div>
                
                <div x-show="activeTab === 'faq'" class="p-8">
                    <div class="flex mb-6">
                        <div class="relative w-full">
                            <input
                                type="text"
                                placeholder="Search FAQs..."
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-green-200 focus:outline-none focus:ring-2 focus:ring-green-500"
                            >
                            <svg class="w-5 h-5 text-green-500 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="space-y-4" x-data="{ openFaq: null }">
                        <div class="border border-green-100 rounded-lg overflow-hidden">
                            <button 
                                @click="openFaq = openFaq === 1 ? null : 1" 
                                class="w-full text-left flex justify-between items-center p-4 bg-green-50 hover:bg-green-100 transition"
                            >
                                <span class="font-medium text-green-800">How do I link my mobile and web accounts?</span>
                                <svg 
                                    :class="{ 'transform rotate-180': openFaq === 1 }"
                                    class="w-5 h-5 text-green-600 transition-transform duration-200" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24" 
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div 
                                x-show="openFaq === 1"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="p-4 bg-white"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-full w-px bg-green-200"></div>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 mb-3">To link your mobile and web accounts:</p>
                                        <ol class="list-decimal list-inside pl-4 space-y-2 text-gray-600">
                                            <li>Log in to your account on the Wildlife Haven website</li>
                                            <li>Navigate to Account Settings</li>
                                            <li>Click on "Link Mobile Account"</li>
                                            <li>Use the QR code or token provided to verify your mobile account</li>
                                        </ol>
                                        <div class="mt-4 bg-blue-50 p-3 rounded-lg">
                                            <p class="text-blue-800 text-sm"><span class="font-semibold">Pro Tip:</span> Make sure you're using the same email address for both accounts to simplify the linking process.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border border-green-100 rounded-lg overflow-hidden">
                            <button 
                                @click="openFaq = openFaq === 2 ? null : 2" 
                                class="w-full text-left flex justify-between items-center p-4 bg-green-50 hover:bg-green-100 transition"
                            >
                                <span class="font-medium text-green-800">Why didn't I get my focus coins?</span>
                                <svg 
                                    :class="{ 'transform rotate-180': openFaq === 2 }"
                                    class="w-5 h-5 text-green-600 transition-transform duration-200" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24" 
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div 
                                x-show="openFaq === 2"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="p-4 bg-white"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-full w-px bg-green-200"></div>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 mb-3">Focus coins are awarded based on successful focus sessions. Make sure you:</p>
                                        <ul class="list-disc list-inside pl-4 space-y-2 text-gray-600">
                                            <li>Complete the entire focus session without interruptions</li>
                                            <li>Stay within the app during the session</li>
                                            <li>Maintain a high Focus Score</li>
                                        </ul>
                                        <div class="mt-4 flex space-x-4">
                                            <div class="flex-1 bg-green-50 p-3 rounded-lg">
                                                <p class="text-green-800 text-sm text-center"><span class="font-semibold block">75%</span> of users see coin issues resolved with app restart</p>
                                            </div>
                                            <div class="flex-1 bg-green-50 p-3 rounded-lg">
                                                <p class="text-green-800 text-sm text-center"><span class="font-semibold block">24 hours</span> maximum reward delay</p>
                                            </div>
                                        </div>
                                        <button class="mt-4 text-green-600 font-medium flex items-center">
                                            <span>View Focus Coin Troubleshooter</span>
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border border-green-100 rounded-lg overflow-hidden">
                            <button 
                                @click="openFaq = openFaq === 3 ? null : 3" 
                                class="w-full text-left flex justify-between items-center p-4 bg-green-50 hover:bg-green-100 transition"
                            >
                                <span class="font-medium text-green-800">How do I use AR features?</span>
                                <svg 
                                    :class="{ 'transform rotate-180': openFaq === 3 }"
                                    class="w-5 h-5 text-green-600 transition-transform duration-200" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24" 
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div 
                                x-show="openFaq === 3"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="p-4 bg-white"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-full w-px bg-green-200"></div>
                                    </div>
                                    <div>
                                        <div class="md:flex md:space-x-6">
                                            <div class="md:w-2/3">
                                                <p class="text-gray-700 mb-3">To use AR features:</p>
                                                <ol class="list-decimal list-inside pl-4 space-y-2 text-gray-600">
                                                    <li>Ensure you have a compatible mobile device</li>
                                                    <li>Open the Wildlife Haven mobile app</li>
                                                    <li>Navigate to a creature or habitat page</li>
                                                    <li>Tap the "View in AR" button</li>
                                                    <li>Allow camera permissions when prompted</li>
                                                    <li>Point your camera at a flat surface to place your creature</li>
                                                </ol>
                                            </div>
                                            <div class="mt-4 md:mt-0 md:w-1/3">
                                                <div class="bg-gray-100 p-4 rounded-lg flex justify-center items-center h-full">
                                                    <img src="/api/placeholder/200/150" alt="AR Feature Demo" class="rounded shadow-md">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 bg-yellow-50 p-3 rounded-lg">
                                            <p class="text-yellow-800 text-sm"><span class="font-semibold">Note:</span> AR features require iOS 12+ or Android 8+ with ARCore support.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border border-green-100 rounded-lg overflow-hidden">
                            <button 
                                @click="openFaq = openFaq === 4 ? null : 4" 
                                class="w-full text-left flex justify-between items-center p-4 bg-green-50 hover:bg-green-100 transition"
                            >
                                <span class="font-medium text-green-800">How can I redeem my animal points?</span>
                                <svg 
                                    :class="{ 'transform rotate-180': openFaq === 4 }"
                                    class="w-5 h-5 text-green-600 transition-transform duration-200" 
                                    fill="none" 
                                    stroke="currentColor" 
                                    viewBox="0 0 24 24" 
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div 
                                x-show="openFaq === 4"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                class="p-4 bg-white"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="h-full w-px bg-green-200"></div>
                                    </div>
                                    <div>
                                        <p class="text-gray-700 mb-3">To redeem your animal points:</p>
                                        <ol class="list-decimal list-inside pl-4 space-y-2 text-gray-600">
                                            <li>Go to the Rewards section in your profile</li>
                                            <li>Select "Redeem Points"</li>
                                            <li>Browse available rewards</li>
                                            <li>Select your desired reward and confirm</li>
                                        </ol>
                                        <div class="mt-4 grid grid-cols-3 gap-2">
                                            <div class="bg-green-50 p-2 rounded text-center">
                                                <p class="text-green-800 text-sm font-semibold">Digital Badges</p>
                                                <p class="text-green-600 text-xs">100-500 pts</p>
                                            </div>
                                            <div class="bg-green-50 p-2 rounded text-center">
                                                <p class="text-green-800 text-sm font-semibold">Premium Habitats</p>
                                                <p class="text-green-600 text-xs">1000-2500 pts</p>
                                            </div>
                                            <div class="bg-green-50 p-2 rounded text-center">
                                                <p class="text-green-800 text-sm font-semibold">Rare Animals</p>
                                                <p class="text-green-600 text-xs">5000+ pts</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 text-center">
                        <a href="#" class="text-green-600 font-medium hover:text-green-800">
                            View All FAQs
                            <svg class="w-4 h-4 inline-block ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div x-show="activeTab === 'contact'" class="p-8">
                    <div class="md:flex md:space-x-8">
                        <div class="md:w-1/3 mb-6 md:mb-0">
                            <div class="bg-green-50 p-5 rounded-lg">
                                <h3 class="font-semibold text-green-800 mb-4">Before You Submit</h3>
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-green-700 text-sm">Check our FAQ section for quick answers</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-green-700 text-sm">Include your username/email for account issues</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-green-700 text-sm">Note your device model and app version</span>
                                    </li>
                                </ul>
                                <div class="mt-6 pt-6 border-t border-green-200">
                                    <h4 class="font-medium text-green-800 mb-2">Response Times</h4>
                                    <div class="flex justify-between text-sm text-green-700">
                                        <span>General Inquiries:</span>
                                        <span>24-48 hours</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-green-700">
                                        <span>Technical Issues:</span>
                                        <span>12-24 hours</span>
                                    </div>
                                    <div class="flex justify-between text-sm text-green-700">
                                        <span>Billing Concerns:</span>
                                        <span>48-72 hours</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-2/3">
                            <form class="space-y-4" x-data="{ isSubmitting: false, isSubmitted: false }">
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="name" class="block text-green-800 mb-2 text-sm font-medium">Your Name</label>
                                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-green-800 mb-2 text-sm font-medium">Email Address</label>
                                        <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>
                                </div>
                                
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="username" class="block text-green-800 mb-2 text-sm font-medium">Wildlife Haven Username</label>
                                        <input type="text" id="username" name="username" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                    </div>
                                    <div>
                                        <label for="issue" class="block text-green-800 mb-2 text-sm font-medium">Issue Type</label>
                                        <select id="issue" name="issue" class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                            <option value="">Select an issue type</option>
                                            <option value="account">Account Issue</option>
                                            <option value="technical">Technical Problem</option>
                                            <option value="billing">Billing Question</option>
                                            <option value="feature">Feature Request</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="subject" class="block text-green-800 mb-2 text-sm font-medium">Subject</label>
                                    <input type="text" id="subject" name="subject" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                
                                <div>
                                    <label for="message" class="block text-green-800 mb-2 text-sm font-medium">Describe Your Issue</label>
                                    <textarea id="message" name="message" rows="5" required class="w-full px-3 py-2 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-green-800 mb-2 text-sm font-medium">Attachments (Optional)</label>
                                    <div class="border-2 border-dashed border-green-300 rounded-lg p-4 text-center">
                                        <svg class="w-8 h-8 text-green-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-sm text-green-700 mb-1">Drag and drop files here or click to browse</p>
                                        <p class="text-xs text-green-600">Max 5 files. PNG, JPG, PDF (10MB max)</p>
                                        <input type="file" class="hidden">
                                        <button type="button" class="mt-2 text-green-600 text-sm font-medium">Select Files</button>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="newsletter" name="newsletter" class="h-4 w-4 text-green-600 focus:ring-green-500 border-green-300 rounded">
                                    <label for="newsletter" class="ml-2 block text-sm text-green-700">Subscribe to our newsletter for updates and tips</label>
                                </div>
                                
                                <div x-show="!isSubmitted">
                                    <button 
                                        type="button"
                                        @click="isSubmitting = true; setTimeout(() => { isSubmitting = false; isSubmitted = true; }, 1500)"
                                        :disabled="isSubmitting"
                                        class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300 font-medium flex items-center justify-center w-full md:w-auto"
                                    >
                                        <span x-show="!isSubmitting">Submit Support Ticket</span>
                                        <span x-show="isSubmitting" class="flex items-center">
    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
    Processing...
</span>
                                    </button>
                                </div>
                                
                                <div x-show="isSubmitted" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                                    <div class="flex">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <div>
                                            <p class="font-medium">Your ticket has been submitted!</p>
                                            <p class="text-sm mt-1">We'll respond to your inquiry within 24-48 hours. Please check your email for updates.</p>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-xl shadow-lg p-6 scroll-fade">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-green-800">Live Chat</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Get real-time help from our support team. Available 24/7 for urgent issues.</p>
                    <button class="w-full bg-green-100 hover:bg-green-200 text-green-800 font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                        <span>Start Live Chat</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6 scroll-fade">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-green-800">Video Tutorials</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Visual guides for common features and troubleshooting steps.</p>
                    <button class="w-full bg-green-100 hover:bg-green-200 text-green-800 font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                        <span>Browse Tutorials</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg p-6 scroll-fade">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-green-800">Community Forums</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Connect with other users, share tips, and find community solutions.</p>
                    <button class="w-full bg-green-100 hover:bg-green-200 text-green-800 font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                        <span>Join Discussion</span>
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-green-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h4 class="font-bold text-lg mb-4">Wildlife Haven</h4>
                    <p class="text-green-200 text-sm">Connecting people with nature through innovative technology and educational experiences.</p>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm text-green-200">
                        <li><a href="#" class="hover:text-white">About Us</a></li>
                        <li><a href="#" class="hover:text-white">Our Mission</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm text-green-200">
                        <li><a href="#" class="hover:text-white">User Guide</a></li>
                        <li><a href="#" class="hover:text-white">Developer API</a></li>
                        <li><a href="#" class="hover:text-white">Conservation Partners</a></li>
                        <li><a href="#" class="hover:text-white">Educational Programs</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4">Connect With Us</h4>
                    <div class="flex space-x-4 mb-4">
                        <a href="#" class="text-green-200 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-green-200 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.1 10.1 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-green-200 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-green-200 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                            </svg>
                        </a>
                    </div>
                    <form class="space-y-2">
                        <label class="text-sm text-green-200">Subscribe to our newsletter</label>
                        <div class="flex">
                            <input type="email" placeholder="Your email" class="px-3 py-2 rounded-l-lg text-gray-800 w-full focus:outline-none">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 rounded-r-lg px-3 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="border-t border-green-700 mt-8 pt-6 text-center text-sm text-green-300">
                <p>&copy; 2025 Wildlife Haven. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.scroll-fade');
            
            function checkScroll() {
                fadeElements.forEach(element => {
                    const elementTop = element.getBoundingClientRect().top;
                    const elementVisible = 150;
                    
                    if (elementTop < window.innerHeight - elementVisible) {
                        element.classList.add('visible');
                    }
                });
            }
            
            window.addEventListener('scroll', checkScroll);
            checkScroll();
        });
    </script>
</body>
</html>