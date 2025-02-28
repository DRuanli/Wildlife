// Initialize GSAP and plugins
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Global variables
let isLoaded = false;
let currentTestimonial = 0;
const testimonials = [
    {
        id: "testimonial1",
        name: "Sarah K.",
        role: "Graphic Designer",
        avatar: "<?= $baseUrl ?>/assets/images/testimonials/user1.jpg",
        quote: "Wildlife Haven transformed my work habits. The focus timer keeps me productive, and watching my creatures grow while knowing I'm helping real conservation efforts makes it meaningful. It's so much more than just another productivity app."
    },
    {
        id: "testimonial2",
        name: "Michael T.",
        role: "University Student",
        avatar: "<?= $baseUrl ?>/assets/images/testimonials/user2.jpg",
        quote: "As a student, I struggle with staying focused during long study sessions. Wildlife Haven makes it fun - each focused session helps my creatures grow and contributes to real-world conservation. It's the perfect blend of productivity and purpose."
    },
    {
        id: "testimonial3",
        name: "Elena R.",
        role: "Software Developer",
        avatar: "<?= $baseUrl ?>/assets/images/testimonials/user3.jpg",
        quote: "I've tried dozens of productivity apps, but Wildlife Haven is the only one that keeps me coming back. The connection to conservation gives my daily work deeper meaning, and the creatures are absolutely beautiful. Highly recommended!"
    }
];

// DOM elements
const loadingScreen = document.getElementById('loadingScreen');
const loadingBar = document.getElementById('loadingBar');
const smoothScroll = document.getElementById('smoothScroll');
const scrollContent = document.getElementById('scrollContent');
const customCursor = document.getElementById('customCursor');
const cursorFollower = document.getElementById('cursorFollower');

// Loading animation
function simulateLoading() {
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 10;
        if (progress > 100) progress = 100;

        loadingBar.style.width = `${progress}%`;

        if (progress === 100) {
            clearInterval(interval);
            setTimeout(() => {
                loadingScreen.style.opacity = '0';
                setTimeout(() => {
                    loadingScreen.style.display = 'none';
                    isLoaded = true;
                    initPage();
                }, 500);
            }, 500);
        }
    }, 200);
}

// Initialize page animations
function initPage() {
    initSmoothScroll();
    initCursor();
    initHeroSection();
    initRevealAnimations();
    initParallaxElements();
    initFeatureCards();
    initTimerSection();
    initCreatures();
    initTestimonials();
    initConservationSection();
    initCtaSection();
    initMagneticButtons();
    createParticles();
    initMorphingBlobs();
}

// Standard scrolling with enhanced animations
function initSmoothScroll() {
    // Convert smooth scroll containers to standard layout
    const smoothScrollContainer = document.getElementById('smoothScroll');
    const scrollContentElement = document.getElementById('scrollContent');

    if (smoothScrollContainer && scrollContentElement) {
        // Remove fixed positioning to enable normal scrolling
        smoothScrollContainer.style.position = 'static';
        scrollContentElement.style.position = 'static';
        document.body.style.overflow = 'auto';
    }

    // Setup scroll triggers for animations without pinning
    ScrollTrigger.defaults({
        toggleActions: "play none none reverse",
        markers: false
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        setTimeout(() => {
            ScrollTrigger.refresh();
        }, 100);
    });

    // Add error handling
    window.addEventListener('error', function (e) {
        console.error('Animation error:', e);
        // Force enable normal scrolling if an error occurs
        document.body.style.overflow = 'auto';
        if (smoothScrollContainer) smoothScrollContainer.style.position = 'static';
        if (scrollContentElement) scrollContentElement.style.position = 'static';
    });
}

// Custom cursor
function initCursor() {
    const cursor = document.getElementById('customCursor');
    const follower = document.getElementById('cursorFollower');

    // Variables for cursor position
    let mouseX = 0;
    let mouseY = 0;
    let cursorX = 0;
    let cursorY = 0;
    let followerX = 0;
    let followerY = 0;

    // Update cursor position on mouse move
    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        // Set custom cursor color based on background
        const elementUnderCursor = document.elementFromPoint(mouseX, mouseY);
        if (elementUnderCursor) {
            const bgColor = window.getComputedStyle(elementUnderCursor).backgroundColor;
            if (bgColor.includes('rgb(77, 114, 77)') || bgColor.includes('rgb(58, 90, 58)')) {
                cursor.style.backgroundColor = 'white';
                follower.style.backgroundColor = 'white';
            } else {
                cursor.style.backgroundColor = 'var(--primary-color)';
                follower.style.backgroundColor = 'white';
            }
        }
    });

    // Add hover effect on interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .feature-card, .creature-card, .timer-btn, .testimonial-btn, .testimonial-dot');
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', () => {
            cursor.classList.add('cursor-hover');
        });
        element.addEventListener('mouseleave', () => {
            cursor.classList.remove('cursor-hover');
        });
    });

    // Animate cursor with requestAnimationFrame
    function animateCursor() {
        // Smoothly move main cursor with easing
        cursorX += (mouseX - cursorX) * 0.1;
        cursorY += (mouseY - cursorY) * 0.1;

        // Smoothly move follower with different easing
        followerX += (mouseX - followerX) * 0.2;
        followerY += (mouseY - followerY) * 0.2;

        // Update cursor positions
        cursor.style.transform = `translate(${cursorX}px, ${cursorY}px)`;
        follower.style.transform = `translate(${followerX}px, ${followerY}px)`;

        // Continue animation loop
        requestAnimationFrame(animateCursor);
    }

    // Start cursor animation
    animateCursor();
}

// Hero section animations
function initHeroSection() {
    const heroTimeline = gsap.timeline();

    // Reveal hero elements
    heroTimeline
        .to('#heroOverlay', {opacity: 1, duration: 1.5, ease: "power2.out"})
        .to('.headline .reveal-text', {
            y: 0,
            opacity: 1,
            duration: 1.2,
            stagger: 0.2,
            ease: "power3.out"
        }, "-=1")
        .to('#heroSubtitle', {y: 0, opacity: 1, duration: 1, ease: "power2.out"}, "-=0.8")
        .to('#heroButtons', {y: 0, opacity: 1, duration: 1, ease: "power2.out"}, "-=0.6")
        .to('#scrollIndicator', {opacity: 0.8, duration: 1, ease: "power2.out"}, "-=0.6");

    // Animate scroll dot
    gsap.to('#scrollDot', {
        y: 15,
        repeat: -1,
        yoyo: true,
        duration: 1.5,
        ease: "power2.inOut"
    });

    // Parallax effect for hero content on mouse move
    document.addEventListener('mousemove', (e) => {
        const xPos = (e.clientX / window.innerWidth - 0.5) * 20;
        const yPos = (e.clientY / window.innerHeight - 0.5) * 20;

        gsap.to('#heroContent', {
            rotationY: xPos * 0.5,
            rotationX: -yPos * 0.5,
            transformPerspective: 1000,
            duration: 0.6,
            ease: "power1.out"
        });

        // Subtle video movement
        gsap.to('#heroVideo', {
            x: xPos * 0.5,
            y: yPos * 0.5,
            duration: 1,
            ease: "power1.out"
        });
    });

    // Video blur effect on scroll
    ScrollTrigger.create({
        trigger: "#hero",
        start: "top top",
        end: "bottom top",
        scrub: true,
        onUpdate: (self) => {
            const blur = self.progress * 10;
            gsap.to('#heroVideo', {filter: `blur(${blur}px)`, ease: "none"});
        }
    });
}

// Text reveal animations
function initRevealAnimations() {
    // Split text into words for animated reveal
    const revealTexts = document.querySelectorAll('.headline .reveal-text');

    revealTexts.forEach(text => {
        // Create scroll trigger for each headline
        ScrollTrigger.create({
            trigger: text.parentElement,
            start: "top 80%",
            once: true,
            onEnter: () => {
                gsap.to(text, {
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: "power3.out"
                });
            }
        });
    });

    // Animate body text
    const bodyTexts = document.querySelectorAll('.body-text');

    bodyTexts.forEach(text => {
        ScrollTrigger.create({
            trigger: text,
            start: "top 85%",
            once: true,
            onEnter: () => {
                gsap.to(text, {
                    y: 0,
                    opacity: 1,
                    duration: 1,
                    ease: "power2.out"
                });
            }
        });
    });
}

// Parallax background elements
function initParallaxElements() {
    const parallaxElements = document.querySelectorAll('.parallax-element');

    parallaxElements.forEach(element => {
        const speed = element.getAttribute('data-speed') || 0.1;

        gsap.to(element, {
            y: `${speed * 100}%`,
            ease: "none",
            scrollTrigger: {
                trigger: element.parentElement,
                start: "top bottom",
                end: "bottom top",
                scrub: true
            }
        });
    });
}

// Feature cards animation
function initFeatureCards() {
    const featureCards = document.querySelectorAll('.feature-card');

    featureCards.forEach(card => {
        const delay = parseFloat(card.getAttribute('data-delay')) || 0;

        ScrollTrigger.create({
            trigger: card,
            start: "top 85%",
            once: true,
            onEnter: () => {
                gsap.to(card, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: delay,
                    ease: "power2.out"
                });
            }
        });

        // 3D tilt effect
        card.addEventListener('mousemove', (e) => {
            const cardRect = card.getBoundingClientRect();
            const cardCenterX = cardRect.left + cardRect.width / 2;
            const cardCenterY = cardRect.top + cardRect.height / 2;
            const angleY = (e.clientX - cardCenterX) / 10;
            const angleX = (cardCenterY - e.clientY) / 10;

            gsap.to(card, {
                rotationY: angleY,
                rotationX: angleX,
                transformPerspective: 1000,
                duration: 0.3,
                ease: "power1.out"
            });
        });

        card.addEventListener('mouseleave', () => {
            gsap.to(card, {
                rotationY: 0,
                rotationX: 0,
                y: 0,
                duration: 0.5,
                ease: "power1.out"
            });
        });
    });
}

// Timer section animations
function initTimerSection() {
    // Animate timer container
    ScrollTrigger.create({
        trigger: "#timerContainer",
        start: "top 75%",
        once: true,
        onEnter: () => {
            gsap.to("#timerContainer", {
                scale: 1,
                opacity: 1,
                duration: 1,
                ease: "elastic.out(1, 0.5)"
            });
        }
    });

    // Animate timer controls and settings
    ScrollTrigger.create({
        trigger: "#timerControls",
        start: "top 85%",
        once: true,
        onEnter: () => {
            gsap.to("#timerControls", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power2.out"
            });

            gsap.to("#timerSettings", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                delay: 0.2,
                ease: "power2.out"
            });
        }
    });
}

// Creatures section animations
function initCreatures() {
    const creatureCards = document.querySelectorAll('.creature-card');

    creatureCards.forEach(card => {
        const delay = parseFloat(card.getAttribute('data-delay')) || 0;

        ScrollTrigger.create({
            trigger: card,
            start: "top 85%",
            once: true,
            onEnter: () => {
                gsap.to(card, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: delay,
                    ease: "power2.out"
                });
            }
        });
    });

    // Interactive pattern background
    const pattern = document.getElementById('creaturesPattern');
    if (pattern) {
        document.addEventListener('mousemove', (e) => {
            const xPos = (e.clientX / window.innerWidth - 0.5) * 20;
            const yPos = (e.clientY / window.innerHeight - 0.5) * 20;

            gsap.to(pattern, {
                x: xPos,
                y: yPos,
                duration: 1,
                ease: "power1.out"
            });
        });
    }
}

// Testimonials section
function initTestimonials() {
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dots = document.querySelectorAll('.testimonial-dot');

    // Show initial testimonial
    setTimeout(() => {
        gsap.to(testimonialCards[0], {
            opacity: 1,
            duration: 1,
            ease: "power2.out"
        });
    }, 500);

    // Navigation buttons
    prevBtn.addEventListener('click', () => {
        navigateTestimonial('prev');
    });

    nextBtn.addEventListener('click', () => {
        navigateTestimonial('next');
    });

    // Indicator dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToTestimonial(index);
        });
    });

    // Auto rotate testimonials
    const autoRotate = setInterval(() => {
        navigateTestimonial('next');
    }, 8000);

    // Stop auto-rotation on hover
    const testimonialsContainer = document.querySelector('.testimonials-container');
    testimonialsContainer.addEventListener('mouseenter', () => {
        clearInterval(autoRotate);
    });
}

// Navigate testimonials
function navigateTestimonial(direction) {
    const totalTestimonials = testimonials.length;
    let newIndex;

    if (direction === 'next') {
        newIndex = (currentTestimonial + 1) % totalTestimonials;
    } else {
        newIndex = (currentTestimonial - 1 + totalTestimonials) % totalTestimonials;
    }

    goToTestimonial(newIndex);
}

// Go to specific testimonial
function goToTestimonial(index) {
    if (index === currentTestimonial) return;

    const prevIndex = currentTestimonial;
    currentTestimonial = index;

    // Update testimonial cards
    const cards = document.querySelectorAll('.testimonial-card');

    // Set classes based on position
    cards.forEach((card, i) => {
        card.classList.remove('active', 'prev', 'next');

        if (i === currentTestimonial) {
            card.classList.add('active');
        } else if (i === (currentTestimonial - 1 + cards.length) % cards.length) {
            card.classList.add('prev');
        } else if (i === (currentTestimonial + 1) % cards.length) {
            card.classList.add('next');
        }
    });

    // Update indicator dots
    const dots = document.querySelectorAll('.testimonial-dot');
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentTestimonial);
    });
}

// Conservation section animations
function initConservationSection() {
    // Animate description
    ScrollTrigger.create({
        trigger: "#conservationDesc",
        start: "top 85%",
        once: true,
        onEnter: () => {
            gsap.to("#conservationDesc", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power2.out"
            });
        }
    });

    // Animate stat cards
    const statCards = document.querySelectorAll('.conservation-stat');

    statCards.forEach(card => {
        const delay = parseFloat(card.getAttribute('data-delay')) || 0;

        ScrollTrigger.create({
            trigger: card,
            start: "top 85%",
            once: true,
            onEnter: () => {
                gsap.to(card, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: delay,
                    ease: "power2.out"
                });

                // Animate the count after card appears
                setTimeout(() => {
                    const countElement = card.querySelector('.count');
                    if (countElement) {
                        animateCount(countElement);
                    }
                }, delay * 1000 + 500);
            }
        });
    });

    // Parallax background
    const bg = document.getElementById('conservationBg');
    if (bg) {
        ScrollTrigger.create({
            trigger: "#conservation",
            start: "top bottom",
            end: "bottom top",
            scrub: true,
            onUpdate: (self) => {
                const yPos = self.progress * 20;
                gsap.to(bg, {y: -yPos + '%', ease: "none"});
            }
        });
    }
}

// Animated counting for stats
function animateCount(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const duration = 2500;
    const frameDuration = 1000 / 60;
    const totalFrames = Math.round(duration / frameDuration);
    let frame = 0;

    const counter = setInterval(() => {
        frame++;
        const progress = frame / totalFrames;
        const easedProgress = 1 - Math.pow(1 - progress, 3); // Cubic ease out
        const currentCount = Math.round(easedProgress * target);

        el.textContent = currentCount.toLocaleString();

        if (frame === totalFrames) {
            clearInterval(counter);
        }
    }, frameDuration);
}

// CTA section animations
function initCtaSection() {
    // Animate CTA elements
    ScrollTrigger.create({
        trigger: "#cta",
        start: "top 75%",
        once: true,
        onEnter: () => {
            gsap.to(".cta-title", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                ease: "power2.out"
            });

            gsap.to("#ctaDesc", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                delay: 0.2,
                ease: "power2.out"
            });

            gsap.to("#ctaForm", {
                y: 0,
                opacity: 1,
                duration: 0.8,
                delay: 0.4,
                ease: "power2.out"
            });
        }
    });
}

// Magnetic buttons effect
function initMagneticButtons() {
    const magneticBtns = document.querySelectorAll('.magnetic-btn');

    magneticBtns.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const btnRect = btn.getBoundingClientRect();
            const btnCenterX = btnRect.left + btnRect.width / 2;
            const btnCenterY = btnRect.top + btnRect.height / 2;

            // Calculate distance from center
            const distanceX = e.clientX - btnCenterX;
            const distanceY = e.clientY - btnCenterY;

            // Max movement range
            const maxMovement = 15;

            // Calculate movement based on distance from center
            const moveX = (distanceX / btnRect.width) * maxMovement;
            const moveY = (distanceY / btnRect.height) * maxMovement;

            // Apply magnetic effect
            gsap.to(btn, {
                x: moveX,
                y: moveY,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, {
                x: 0,
                y: 0,
                duration: 0.5,
                ease: "elastic.out(1, 0.5)"
            });
        });

        // Ripple effect on click
        btn.addEventListener('click', (e) => {
            const btnRect = btn.getBoundingClientRect();
            const liquid = btn.querySelector('.liquid');

            if (liquid) {
                // Position liquid at click position
                const x = e.clientX - btnRect.left;
                const y = e.clientY - btnRect.top;

                gsap.set(liquid, {
                    left: x + 'px',
                    top: y + 'px',
                    scale: 0
                });

                gsap.to(liquid, {
                    scale: 3,
                    opacity: 0,
                    duration: 0.8,
                    ease: "power2.out",
                    onComplete: () => {
                        gsap.set(liquid, {opacity: 1, scale: 0});
                    }
                });
            }
        });
    });
}

// Create floating particles
function createParticles() {
    const container = document.getElementById('particles');
    if (!container) return;

    const particleCount = Math.min(50, Math.floor(window.innerWidth / 20));

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');

        // Random size
        const size = Math.random() * 8 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;

        // Random position
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;

        // Random opacity
        particle.style.opacity = Math.random() * 0.2 + 0.05;

        // Add to container
        container.appendChild(particle);

        // Animate particle
        gsap.to(particle, {
            x: `${(Math.random() - 0.5) * 50}%`,
            y: `${(Math.random() - 0.5) * 50}%`,
            duration: Math.random() * 10 + 10,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            delay: Math.random() * 5
        });
    }
}

// Initialize morphing blobs
function initMorphingBlobs() {
    const blobs = [
        document.getElementById('blob1'),
        document.getElementById('blob2'),
        document.getElementById('ctaBlob1'),
        document.getElementById('ctaBlob2')
    ].filter(blob => blob);

    blobs.forEach(blob => {
        // Get initial size
        const initialWidth = parseInt(blob.style.width);
        const initialHeight = parseInt(blob.style.height);

        // Animate blob morphing
        gsap.to(blob, {
            width: initialWidth * (0.8 + Math.random() * 0.4),
            height: initialHeight * (0.8 + Math.random() * 0.4),
            x: `${(Math.random() - 0.5) * 20}%`,
            y: `${(Math.random() - 0.5) * 20}%`,
            borderRadius: `${30 + Math.random() * 40}% ${30 + Math.random() * 40}% ${30 + Math.random() * 40}% ${30 + Math.random() * 40}%`,
            duration: 8 + Math.random() * 7,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });
    });
}

// Scroll to section (simplified version)
function scrollToSection(selector) {
    const section = document.querySelector(selector);
    if (!section) return;

    // Use a simpler scroll method that's more reliable
    section.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });

    // Fallback for browsers that don't support smooth scrolling
    if (typeof window.scrollTo === 'function' && !('scrollBehavior' in document.documentElement.style)) {
        const sectionPosition = section.getBoundingClientRect().top + window.scrollY;
        window.scrollTo({
            top: sectionPosition,
            behavior: 'smooth'
        });
    }
}

// Focus Timer Functionality
let timerInterval;
let remainingSeconds = 0;
let totalSeconds = 0;
let isPaused = false;

function startTimer() {
    if (timerInterval) return;

    // Get timer duration in seconds
    const timerInput = document.getElementById('timerInput');
    totalSeconds = parseInt(timerInput.value) * 60;
    remainingSeconds = totalSeconds;

    // Update display
    updateTimerDisplay();

    // Update button states
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    startBtn.disabled = true;
    pauseBtn.disabled = false;
    isPaused = false;

    // Play start sound
    playSound('start');

    // Start interval
    timerInterval = setInterval(() => {
        if (!isPaused) {
            remainingSeconds--;
            updateTimerDisplay();

            if (remainingSeconds <= 0) {
                clearInterval(timerInterval);
                timerInterval = null;
                timerComplete();
            }
        }
    }, 1000);
}

function updateTimerDisplay() {
    const timerDisplay = document.getElementById('timerDisplay');
    const timerCircle = document.querySelector('.timer-circle');

    // Update time display
    const minutes = Math.floor(remainingSeconds / 60);
    const seconds = remainingSeconds % 60;
    timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    // Update circle progress
    const circumference = 2 * Math.PI * 130;
    const progress = (totalSeconds - remainingSeconds) / totalSeconds;
    const dashoffset = circumference * (1 - progress);
    timerCircle.style.strokeDashoffset = dashoffset;

    // Add pulse effect when almost done
    if (remainingSeconds <= 10 && remainingSeconds > 0) {
        timerCircle.classList.add('pulse');
    } else {
        timerCircle.classList.remove('pulse');
    }
}

function togglePause() {
    isPaused = !isPaused;

    // Update button
    const pauseBtn = document.getElementById('pauseBtn');
    pauseBtn.innerHTML = isPaused ? '<i class="fas fa-play"></i>' : '<i class="fas fa-pause"></i>';

    // Play sound
    playSound(isPaused ? 'pause' : 'resume');
}

function resetTimer() {
    // Clear timer
    clearInterval(timerInterval);
    timerInterval = null;

    // Reset timer state
    const timerInput = document.getElementById('timerInput');
    totalSeconds = parseInt(timerInput.value) * 60;
    remainingSeconds = totalSeconds;
    isPaused = false;

    // Update display
    updateTimerDisplay();

    // Reset buttons
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    startBtn.disabled = false;
    pauseBtn.disabled = true;
    pauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
}

function timerComplete() {
    // Play completion sound
    playSound('complete');

    // Reset button states
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    startBtn.disabled = false;
    pauseBtn.disabled = true;

    // Show celebration animation
    const timerContainer = document.getElementById('timerContainer');

    gsap.to(timerContainer, {
        scale: 1.05,
        duration: 0.3,
        yoyo: true,
        repeat: 3,
        ease: "elastic.out(1, 0.3)"
    });
}

function playSound(action) {
    const soundSelect = document.getElementById('soundSelect');
    const soundType = soundSelect.value;
    const audio = document.getElementById(`${soundType}Audio`);

    if (audio) {
        audio.currentTime = 0;

        if (action === 'complete') {
            audio.volume = 1.0;
            audio.play();
        } else if (action === 'start' || action === 'pause' || action === 'resume') {
            audio.volume = 0.5;
            audio.play();
        }
    }
}

// Detect devices without hover capability
function isTouchDevice() {
    return ('ontouchstart' in window) ||
        (navigator.maxTouchPoints > 0) ||
        (navigator.msMaxTouchPoints > 0);
}

// Initialize everything on document load
document.addEventListener('DOMContentLoaded', function () {
    // First simulate loading
    simulateLoading();

    // Add class for touch devices
    if (isTouchDevice()) {
        document.body.classList.add('touch-device');

        // Hide custom cursor on touch devices
        const cursor = document.getElementById('customCursor');
        const follower = document.getElementById('cursorFollower');
        if (cursor) cursor.style.display = 'none';
        if (follower) follower.style.display = 'none';
    }

    // Add fallback for scrolling issues
    document.body.style.overflow = 'auto';
    window.addEventListener('load', function () {
        setTimeout(function () {
            // Force enable scrolling after slight delay to ensure page is fully loaded
            document.body.style.overflow = 'auto';
            const scrollContent = document.getElementById('scrollContent');
            if (scrollContent) {
                scrollContent.style.position = 'relative';
                scrollContent.style.height = 'auto';
            }
            // Refresh scroll triggers
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }

            // Add Chungi Yoo inspired floating cards section
            addFloatingCardsSection();
        }, 500);
    });
});

// Improved Animation System
// Enable hardware acceleration for smoother animations
gsap.config({
    force3D: true,
    autoSleep: 60,
    nullTargetWarn: false
});

// Smoother animation timing and easing
const smoother = {
    easeOut: "power2.out",
    easeInOut: "power3.inOut",
    elastic: "elastic.out(0.8, 0.3)",
    bounce: "bounce.out",
    duration: {
        short: 0.5,
        medium: 0.8,
        long: 1.2
    }
};