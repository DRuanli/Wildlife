<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<main class="bg-green-50">
    <!-- Hero Section with Video Background -->
    <section class="relative h-screen overflow-hidden">
        <!-- Background Video -->
        <video autoplay muted loop class="absolute top-0 left-0 w-full h-full object-cover opacity-50">
            <source src="<?= $baseUrl ?>/videos/hero-bg.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black opacity-25"></div>
        <!-- Hero Content -->
        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center px-4">
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 drop-shadow-lg">
                    Focus on what matters, help wildlife thrive
                </h1>
                <p class="text-xl md:text-2xl text-white mb-8 drop-shadow-md">
                    Transform your focus time into a journey of nurturing mythical creatures and real-world conservation.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="<?= $baseUrl ?>/auth/register" class="px-8 py-4 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition duration-300" aria-label="Get Started">
                        Get Started
                    </a>
                    <a href="#features" class="px-8 py-4 bg-white text-green-600 font-semibold rounded-full hover:bg-green-50 transition duration-300" aria-label="Learn More">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Focus Timer Component -->
    <section class="py-16 bg-white" id="focus-timer">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Interactive Focus Timer</h2>
            <div x-data="timer()" class="max-w-lg mx-auto text-center">
                <div class="text-6xl font-mono text-green-600 mb-6" x-text="displayTime"></div>
                <div class="flex justify-center space-x-4 mb-4">
                    <button @click="start()" class="px-6 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition duration-300">Start</button>
                    <button @click="pause()" class="px-6 py-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition duration-300">Pause</button>
                    <button @click="reset()" class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 transition duration-300">Reset</button>
                </div>
                <p class="text-gray-700">Set your focus session and watch time fly by!</p>
            </div>
        </div>
    </section>

    <!-- Virtual Sanctuary: Creature Gallery -->
    <section class="py-16 bg-green-50" id="creature-gallery">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Virtual Sanctuary</h2>
            <p class="text-center text-gray-700 mb-8">Explore your collection of mythical creatures nurtured by your focus sessions.</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Creature Card 1 -->
                <div class="relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <img src="<?= $baseUrl ?>/images/creature1.jpg" alt="Aurora the Phoenix" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-green-700">Aurora the Phoenix</h3>
                        <p class="text-gray-600 text-sm">Rises from the ashes with every focus session completed.</p>
                    </div>
                </div>
                <!-- Creature Card 2 -->
                <div class="relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <img src="<?= $baseUrl ?>/images/creature2.jpg" alt="Zephyr the Dragon" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-green-700">Zephyr the Dragon</h3>
                        <p class="text-gray-600 text-sm">Guardian of focus and the skies, soaring with your productivity.</p>
                    </div>
                </div>
                <!-- Creature Card 3 -->
                <div class="relative bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                    <img src="<?= $baseUrl ?>/images/creature3.jpg" alt="Luna the Unicorn" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-green-700">Luna the Unicorn</h3>
                        <p class="text-gray-600 text-sm">Brings magic and clarity to your work sessions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel -->
    <section class="py-16 bg-white" id="testimonials">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">What Our Users Say</h2>
            <div x-data="{ current: 0, testimonials: [
                { quote: 'Wildlife Haven transformed my daily routine! I never imagined productivity could be this magical.', name: 'Sarah K.', role: 'Student', avatar: 'S' },
                { quote: 'A perfect blend of work and play. Every session feels like a new adventure.', name: 'John D.', role: 'Designer', avatar: 'J' },
                { quote: 'It keeps me motivated and engaged. My focus sessions are now the highlight of my day!', name: 'Alex R.', role: 'Entrepreneur', avatar: 'A' }
            ] }" class="max-w-2xl mx-auto relative">
                <template x-for="(testimonial, index) in testimonials" :key="index">
                    <div x-show="current === index" class="text-center transition-opacity duration-500" x-transition:enter="opacity-0" x-transition:enter-end="opacity-100">
                        <p class="text-xl text-gray-700 mb-6" x-text="testimonial.quote"></p>
                        <div class="flex items-center justify-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600 font-bold mr-3" x-text="testimonial.avatar"></div>
                            <div>
                                <p class="font-semibold text-green-700" x-text="testimonial.name"></p>
                                <p class="text-sm text-gray-500" x-text="testimonial.role"></p>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="flex justify-center space-x-2 mt-6">
                    <template x-for="(testimonial, index) in testimonials" :key="index">
                        <button @click="current = index" class="w-3 h-3 rounded-full" :class="{'bg-green-600': current === index, 'bg-gray-300': current !== index}"></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section with Accordion -->
    <section class="py-16 bg-green-50" id="faqs">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-12">Frequently Asked Questions</h2>
            <div x-data="{ open: null }" class="max-w-3xl mx-auto">
                <template x-for="(faq, index) in [
                    { question: 'How does the focus timer work?', answer: 'Simply set the timer and start your focus session. The app tracks your time and rewards you with progress.' },
                    { question: 'What are the mythical creatures?', answer: 'They represent your achievements. The more sessions you complete, the more creatures you unlock.' },
                    { question: 'How does this help conservation?', answer: 'A portion of every session contributes to real-world conservation efforts through our trusted partners.' }
                ]" :key="index">
                    <div class="mb-4 border-b border-gray-200">
                        <button @click="open === index ? open = null : open = index" class="w-full text-left py-4 flex justify-between items-center focus:outline-none">
                            <span class="text-xl text-gray-800" x-text="faq.question"></span>
                            <svg x-show="open === index" class="w-6 h-6 transform rotate-180 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                            <svg x-show="open !== index" class="w-6 h-6 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open === index" x-collapse class="pb-4 text-gray-700">
                            <p x-text="faq.answer"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</main>

<!-- AlpineJS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
// AlpineJS Timer Component
function timer() {
    return {
        seconds: 0,
        interval: null,
        get displayTime() {
            let mins = Math.floor(this.seconds / 60);
            let secs = this.seconds % 60;
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        },
        start() {
            if (!this.interval) {
                this.interval = setInterval(() => { this.seconds++; }, 1000);
            }
        },
        pause() {
            clearInterval(this.interval);
            this.interval = null;
        },
        reset() {
            this.pause();
            this.seconds = 0;
        }
    }
}
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
