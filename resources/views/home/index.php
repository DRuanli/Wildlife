<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="bg-green-50">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16 md:py-24">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight mb-4">
                    Focus on what matters, help wildlife thrive
                </h1>
                <p class="text-xl text-gray-700 mb-8">
                    Wildlife Haven turns your focused time into a fun, nurturing experience for virtual mythical creatures. 
                    Stay on task, grow your collection, and contribute to real-world conservation.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="/auth/register" class="inline-block px-6 py-3 bg-green-600 text-white font-medium rounded-lg text-center hover:bg-green-700 transition">
                        Get Started
                    </a>
                    <a href="#how-it-works" class="inline-block px-6 py-3 bg-white text-green-600 font-medium rounded-lg text-center border border-green-600 hover:bg-green-50 transition">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="/images/landing-hero.png" alt="Wildlife Haven App" class="rounded-lg shadow-xl">
            </div>
        </div>
    </div>
    <!-- Testimonials Section -->
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">What Our Users Say</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "Wildlife Haven has transformed my work habits. I've doubled my productivity, and it feels amazing to know my focus time is helping real conservation efforts."
                    </p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">S</div>
                        <div>
                            <p class="font-medium">Sarah K.</p>
                            <p class="text-sm text-gray-500">Student</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "As a software developer, I need long periods of uninterrupted focus. Wildlife Haven makes it fun to stay on task, and I love watching my creatures grow with each coding session."
                    </p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">M</div>
                        <div>
                            <p class="font-medium">Michael T.</p>
                            <p class="text-sm text-gray-500">Software Developer</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 mb-4">
                        "I've tried many focus apps but none as engaging as Wildlife Haven. My kids love seeing the mythical creatures, and it's teaching them about real wildlife conservation too."
                    </p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3">J</div>
                        <div>
                            <p class="font-medium">Jamie R.</p>
                            <p class="text-sm text-gray-500">Parent & Teacher</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- How It Works Section -->
    <div id="how-it-works" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-12">How It Works</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-green-50 rounded-lg p-6 text-center">
                    <div class="bg-green-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-leaf text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Make Real Impact</h3>
                    <p class="text-gray-700">
                        Your focus time contributes to real-world conservation efforts. Grow your virtual sanctuary while helping protect actual wildlife.
                    </p>center justify-center mb-4">
                        <i class="fas fa-clock text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Set Focus Time</h3>
                    <p class="text-gray-700">
                        Start a focus session to incubate a mysterious egg. Choose your work duration and stay on task without distractions.
                    </p>
                </div>
                
                <div class="bg-green-50 rounded-lg p-6 text-center">
                    <div class="bg-green-100 w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-dragon text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Hatch Creatures</h3>
                    <p class="text-gray-700">
                        Complete focus sessions to hatch and raise mythical creatures inspired by real wildlife. Each focus session helps them grow.
                    </p>
                </div>
                
                <div class="bg-green-50 rounded-lg p-6 text-center">
                    <div class="bg-green-100 w-16 h-16 mx-auto rounded-full flex items-