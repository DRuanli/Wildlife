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

// Detect low-performance devices
const isLowPerformance = () => {
    // Simple detection based on device memory API or user agent
    if (navigator.deviceMemory && navigator.deviceMemory < 4) return true;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        return true;
    }
    return false;
};

// If low performance, add class to body
if (isLowPerformance()) {
    document.documentElement.classList.add('low-performance');
}

// Function for throttling high-frequency events
function throttle(fn, delay) {
    let lastCall = 0;
    return function (...args) {
        const now = Date.now();
        if (now - lastCall >= delay) {
            lastCall = now;
            fn.apply(this, args);
        }
    };
}

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
    // Apply hardware acceleration to key elements
    applyHardwareAcceleration();
    
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

// Apply hardware acceleration
function applyHardwareAcceleration() {
    const acceleratedElements = document.querySelectorAll(
        '.hero-content, .feature-card, .creature-card, .testimonial-card, ' +
        '.conservation-stat, .timer-container, .parallax-element, .floating-card'
    );
    
    acceleratedElements.forEach(el => {
        el.style.willChange = 'transform';
        el.style.backfaceVisibility = 'hidden';
        el.style.transform = 'translateZ(0)';
    });
}

// Improved smooth scrolling implementation
class SmoothScroller {
    constructor() {
        this.DOM = {
            scroll: document.querySelector('#scrollContent') || document.documentElement
        };
        
        this.current = 0;
        this.target = 0;
        this.ease = 0.12; // Adjust for smoothness (0.05-0.15 is good)
        this.rafID = null;
        
        // Skip on mobile or Safari (causes issues)
        if (this.isMobile() || this.isSafari()) {
            document.documentElement.classList.add('native-scroll');
            return;
        }
        
        this.init();
    }
    
    isMobile() {
        return /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || 
               (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
    }
    
    isSafari() {
        return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    }
    
    init() {
        this.createSmoothScrollStructure();
        this.setHeight();
        this.addListeners();
        this.render();
    }
    
    createSmoothScrollStructure() {
        // Set up the DOM for smooth scrolling
        document.documentElement.classList.add('smooth-scroll');
        
        const scrollContent = document.getElementById('scrollContent');
        if (!scrollContent) return;
        
        // Create wrapper if not exists
        let wrapper = document.getElementById('smooth-wrapper');
        if (!wrapper) {
            wrapper = document.createElement('div');
            wrapper.id = 'smooth-wrapper';
            wrapper.style.position = 'fixed';
            wrapper.style.width = '100%';
            wrapper.style.height = '100%';
            wrapper.style.top = '0';
            wrapper.style.left = '0';
            wrapper.style.overflow = 'hidden';
            wrapper.style.zIndex = '1';
            
            // Move the content to the wrapper
            document.body.insertBefore(wrapper, scrollContent);
            wrapper.appendChild(scrollContent);
            
            // Adjust content styles
            scrollContent.style.willChange = 'transform';
            scrollContent.style.transform = 'translateZ(0)';
        }
    }
    
    setHeight() {
        const content = document.getElementById('scrollContent');
        if (!content) return;
        
        // Measure content height
        const contentHeight = content.scrollHeight;
        
        // Set document height to enable scrolling
        document.body.style.height = `${contentHeight}px`;
    }
    
    addListeners() {
        // Refresh height on window resize
        window.addEventListener('resize', throttle(() => {
            this.setHeight();
        }, 100));
        
        // Update scroll position
        window.addEventListener('scroll', throttle(() => {
            this.target = window.scrollY;
            document.documentElement.classList.add('is-scrolling');
            
            // Remove scrolling class after delay
            clearTimeout(this.scrollTimeout);
            this.scrollTimeout = setTimeout(() => {
                document.documentElement.classList.remove('is-scrolling');
            }, 100);
        }, 16), { passive: true });
    }
    
    render() {
        // Use lerp for smooth scrolling effect
        this.current = this.lerp(this.current, this.target, this.ease);
        
        // Apply transform
        const scrollContent = document.getElementById('scrollContent');
        if (scrollContent) {
            scrollContent.style.transform = `translate3d(0, ${-this.current}px, 0)`;
        }
        
        // Continue the animation loop
        this.rafID = requestAnimationFrame(() => this.render());
    }
    
    lerp(start, end, factor) {
        // Linear interpolation for smooth movement
        return (1 - factor) * start + factor * end;
    }
}

// Standard scrolling with enhanced animations
function initSmoothScroll() {
    // Initialize smooth scroller
    const smoother = new SmoothScroller();
    
    // Configure ScrollTrigger for better performance
    if (typeof ScrollTrigger !== 'undefined') {
        ScrollTrigger.config({
            limitCallbacks: true,
            ignoreMobileResize: true
        });
        
        // Optimize marker rendering
        ScrollTrigger.defaults({
            markers: false,
            preventOverlaps: true,
            toggleActions: "play none none reverse"
        });
        
        // Batch ScrollTrigger refreshes
        const debouncedRefresh = throttle(() => {
            ScrollTrigger.refresh();
        }, 200);
        
        window.addEventListener('resize', debouncedRefresh);
    }
    
    // Use Intersection Observer for simpler animations
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const animateOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                
                // Only observe once if it has data-once attribute
                if (entry.target.dataset.once === 'true') {
                    animateOnScroll.unobserve(entry.target);
                }
            } else if (entry.target.dataset.once !== 'true') {
                entry.target.classList.remove('in-view');
            }
        });
    }, observerOptions);
    
    // Apply to elements that don't need complex GSAP animations
    document.querySelectorAll('.body-text, .conservation-description').forEach(el => {
        el.dataset.once = 'true';
        animateOnScroll.observe(el);
    });
}

// Custom cursor
function initCursor() {
    // Skip for touch devices
    if (isTouchDevice()) {
        return;
    }
    
    const cursor = document.getElementById('customCursor');
    const follower = document.getElementById('cursorFollower');
    
    if (!cursor || !follower) return;

    // Variables for cursor position with better performance
    let mouseX = 0;
    let mouseY = 0;
    let cursorX = 0;
    let cursorY = 0;
    let followerX = 0;
    let followerY = 0;

    // Update cursor position on mouse move (throttled)
    document.addEventListener('mousemove', throttle((e) => {
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
    }, 16));

    // Add hover effect on interactive elements (with delegated events)
    document.addEventListener('mouseover', (e) => {
        const target = e.target;
        if (target.matches('a, button, .feature-card, .creature-card, .timer-btn, .testimonial-btn, .testimonial-dot')) {
            cursor.classList.add('cursor-hover');
        }
    });
    
    document.addEventListener('mouseout', (e) => {
        const target = e.target;
        if (target.matches('a, button, .feature-card, .creature-card, .timer-btn, .testimonial-btn, .testimonial-dot')) {
            cursor.classList.remove('cursor-hover');
        }
    });

    // Animate cursor with requestAnimationFrame for better performance
    function animateCursor() {
        // Smoothly move main cursor with easing
        cursorX += (mouseX - cursorX) * 0.15;
        cursorY += (mouseY - cursorY) * 0.15;

        // Smoothly move follower with different easing
        followerX += (mouseX - followerX) * 0.08;
        followerY += (mouseY - followerY) * 0.08;

        // Use transform instead of direct top/left for better performance
        cursor.style.transform = `translate3d(${cursorX}px, ${cursorY}px, 0) translate(-50%, -50%)`;
        follower.style.transform = `translate3d(${followerX}px, ${followerY}px, 0) translate(-50%, -50%)`;

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

    // More efficient parallax implementation
    if (!isLowPerformance()) {
        // Use throttled event handler for better performance
        document.addEventListener('mousemove', throttle((e) => {
            const xPos = (e.clientX / window.innerWidth - 0.5) * 20;
            const yPos = (e.clientY / window.innerHeight - 0.5) * 20;
    
            gsap.to('#heroContent', {
                rotationY: xPos * 0.5,
                rotationX: -yPos * 0.5,
                transformPerspective: 1000,
                duration: 0.6,
                ease: "power1.out",
                force3D: true
            });
    
            // Subtle video movement - only if not scrolling
            if (!document.documentElement.classList.contains('is-scrolling')) {
                gsap.to('#heroVideo', {
                    x: xPos * 0.5,
                    y: yPos * 0.5,
                    duration: 1,
                    ease: "power1.out"
                });
            }
        }, 40));
    }

    // Video blur effect on scroll - only on higher performance devices
    if (!isLowPerformance()) {
        ScrollTrigger.create({
            trigger: "#hero",
            start: "top top",
            end: "bottom top",
            scrub: true,
            onUpdate: (self) => {
                // Only apply blur during pauses in scrolling
                if (!document.documentElement.classList.contains('is-scrolling')) {
                    const blur = Math.min(self.progress * 5, 5); // Cap at 5px blur
                    gsap.to('#heroVideo', {filter: `blur(${blur}px)`, ease: "none", duration: 0.5});
                }
            }
        });
    }
}

// Text reveal animations with IntersectionObserver for better performance
function initRevealAnimations() {
    // Use IntersectionObserver instead of scroll triggers for better performance
    const textObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                
                // Handle reveal text animations
                if (element.classList.contains('reveal-text')) {
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "power3.out"
                    });
                }
                // Handle body text animations
                else if (element.classList.contains('body-text')) {
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 1,
                        ease: "power2.out"
                    });
                }
                
                textObserver.unobserve(element);
            }
        });
    }, {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    });

    // Observe reveal text elements
    document.querySelectorAll('.headline .reveal-text, .body-text').forEach(text => {
        textObserver.observe(text);
    });
}

// Parallax background elements with improved performance
function initParallaxElements() {
    // Skip for low performance devices
    if (isLowPerformance()) {
        return;
    }
    
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
                scrub: 0.5, // More responsive scrubbing
                preventOverlaps: true
            }
        });
    });
}

// Feature cards animation with better performance
function initFeatureCards() {
    const featureCards = document.querySelectorAll('.feature-card');
    
    // Use a single IntersectionObserver for all cards
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const card = entry.target;
                const delay = parseFloat(card.getAttribute('data-delay')) || 0;
                
                gsap.to(card, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: delay,
                    ease: "power2.out"
                });
                
                cardObserver.unobserve(card);
            }
        });
    }, {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    });

    featureCards.forEach(card => {
        // Pre-set initial state for performance
        gsap.set(card, {
            y: 50,
            opacity: 0
        });
        
        cardObserver.observe(card);

        // Use more efficient 3D tilt effect if not on a low performance device
        if (!isLowPerformance()) {
            // Use throttled function for performance
            card.addEventListener('mousemove', throttle((e) => {
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
                    ease: "power1.out",
                    force3D: true
                });
            }, 40));

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    rotationY: 0,
                    rotationX: 0,
                    y: 0,
                    duration: 0.5,
                    ease: "power1.out",
                    force3D: true
                });
            });
        }
    });
}

// Timer section animations with performance improvements
function initTimerSection() {
    // Use IntersectionObserver for animation triggers
    const timerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.id === 'timerContainer') {
                    gsap.to("#timerContainer", {
                        scale: 1,
                        opacity: 1,
                        duration: 1,
                        ease: "elastic.out(1, 0.5)",
                        force3D: true
                    });
                }
                else if (entry.target.id === 'timerControls') {
                    gsap.to("#timerControls", {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        ease: "power2.out",
                        force3D: true
                    });

                    gsap.to("#timerSettings", {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        delay: 0.2,
                        ease: "power2.out",
                        force3D: true
                    });
                }
                
                timerObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.3
    });
    
    // Observe timer elements
    const timerElements = document.querySelectorAll('#timerContainer, #timerControls');
    timerElements.forEach(el => timerObserver.observe(el));
}

// Creatures section animations with improved performance
function initCreatures() {
    const creatureCards = document.querySelectorAll('.creature-card');
    
    // Use a single IntersectionObserver for all cards
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const card = entry.target;
                const delay = parseFloat(card.getAttribute('data-delay')) || 0;
                
                gsap.to(card, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: delay,
                    ease: "power2.out",
                    force3D: true
                });
                
                cardObserver.unobserve(card);
            }
        });
    }, {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    });

    creatureCards.forEach(card => {
        cardObserver.observe(card);
    });

    // Interactive pattern background - only for higher performance devices
    if (!isLowPerformance()) {
        const pattern = document.getElementById('creaturesPattern');
        if (pattern) {
            document.addEventListener('mousemove', throttle((e) => {
                // Skip if scrolling
                if (document.documentElement.classList.contains('is-scrolling')) return;
                
                const xPos = (e.clientX / window.innerWidth - 0.5) * 20;
                const yPos = (e.clientY / window.innerHeight - 0.5) * 20;

                gsap.to(pattern, {
                    x: xPos,
                    y: yPos,
                    duration: 1,
                    ease: "power1.out",
                    force3D: true
                });
            }, 50));
        }
    }
}

// Testimonials section with optimized animations
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

    // Batch DOM operations for navigation
    function updateTestimonialCards() {
        // Update all cards in a single batch
        testimonialCards.forEach((card, i) => {
            card.classList.remove('active', 'prev', 'next');
            
            if (i === currentTestimonial) {
                card.classList.add('active');
            } else if (i === (currentTestimonial - 1 + testimonialCards.length) % testimonialCards.length) {
                card.classList.add('prev');
            } else if (i === (currentTestimonial + 1) % testimonialCards.length) {
                card.classList.add('next');
            }
        });

        // Update indicator dots
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentTestimonial);
        });
    }

    // Navigation buttons with debounce for performance
    let isAnimating = false;
    
    prevBtn.addEventListener('click', () => {
        if (isAnimating) return;
        isAnimating = true;
        
        currentTestimonial = (currentTestimonial - 1 + testimonialCards.length) % testimonialCards.length;
        updateTestimonialCards();
        
        setTimeout(() => {
            isAnimating = false;
        }, 600);
    });

    nextBtn.addEventListener('click', () => {
        if (isAnimating) return;
        isAnimating = true;
        
        currentTestimonial = (currentTestimonial + 1) % testimonialCards.length;
        updateTestimonialCards();
        
        setTimeout(() => {
            isAnimating = false;
        }, 600);
    });

    // Indicator dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            if (isAnimating || index === currentTestimonial) return;
            isAnimating = true;
            
            currentTestimonial = index;
            updateTestimonialCards();
            
            setTimeout(() => {
                isAnimating = false;
            }, 600);
        });
    });

    // Auto rotate testimonials - disable during scroll
    let autoRotateInterval;
    
    function startAutoRotate() {
        clearInterval(autoRotateInterval);
        autoRotateInterval = setInterval(() => {
            if (!document.documentElement.classList.contains('is-scrolling') && !isAnimating) {
                currentTestimonial = (currentTestimonial + 1) % testimonialCards.length;
                updateTestimonialCards();
            }
        }, 8000);
    }
    
    // Start auto-rotation
    startAutoRotate();

    // Stop auto-rotation on hover
    const testimonialsContainer = document.querySelector('.testimonials-container');
    testimonialsContainer.addEventListener('mouseenter', () => {
        clearInterval(autoRotateInterval);
    });
    
    testimonialsContainer.addEventListener('mouseleave', () => {
        startAutoRotate();
    });
}

// Conservation section animations with performance improvements
function initConservationSection() {
    // Use IntersectionObserver for animations
    const conservationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                
                if (element.id === 'conservationDesc') {
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        ease: "power2.out"
                    });
                }
                else if (element.classList.contains('conservation-stat')) {
                    const delay = parseFloat(element.getAttribute('data-delay')) || 0;
                    
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        delay: delay,
                        ease: "power2.out"
                    });
                    
                    // Animate count after card appears
                    setTimeout(() => {
                        const countElement = element.querySelector('.count');
                        if (countElement) {
                            animateCount(countElement);
                        }
                    }, delay * 1000 + 500);
                }
                
                conservationObserver.unobserve(element);
            }
        });
    }, {
        threshold: 0.2
    });
    
    // Observe conservation elements
    conservationObserver.observe(document.getElementById('conservationDesc'));
    
    document.querySelectorAll('.conservation-stat').forEach(stat => {
        conservationObserver.observe(stat);
    });

    // Use more efficient parallax for background
    if (!isLowPerformance()) {
        const bg = document.getElementById('conservationBg');
        if (bg) {
            ScrollTrigger.create({
                trigger: "#conservation",
                start: "top bottom",
                end: "bottom top",
                scrub: 0.3,
                onUpdate: (self) => {
                    // Only update during pauses in scrolling
                    if (!document.documentElement.classList.contains('is-scrolling')) {
                        const yPos = self.progress * 20;
                        gsap.to(bg, {y: -yPos + '%', ease: "none", duration: 0.3});
                    }
                }
            });
        }
    }
}

// Animated counting for stats with performance optimizations
function animateCount(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const duration = 2000; // Shorter duration for better performance
    
    // Use requestAnimationFrame for smoother counting
    const startTime = performance.now();
    const startValue = 0;
    
    function updateCount(currentTime) {
        const elapsedTime = currentTime - startTime;
        const progress = Math.min(elapsedTime / duration, 1);
        
        // Cubic ease out for smoother animation
        const easedProgress = 1 - Math.pow(1 - progress, 3);
        const currentCount = Math.round(startValue + easedProgress * (target - startValue));
        
        el.textContent = currentCount.toLocaleString();
        
        if (progress < 1) {
            requestAnimationFrame(updateCount);
        }
    }
    
    requestAnimationFrame(updateCount);
}

// CTA section animations with performance improvements
function initCtaSection() {
    // Use IntersectionObserver for animations
    const ctaObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const element = entry.target;
                
                if (element.classList.contains('cta-title')) {
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        ease: "power2.out"
                    });
                }
                else if (element.id === 'ctaDesc') {
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        delay: 0.2,
                        ease: "power2.out"
                    });
                }
                else if (element.id === 'ctaForm') {
                    gsap.to(element, {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        delay: 0.4,
                        ease: "power2.out"
                    });
                }
                
                ctaObserver.unobserve(element);
            }
        });
    }, {
        threshold: 0.2
    });
    
    // Observe CTA elements
    ctaObserver.observe(document.querySelector('.cta-title'));
    ctaObserver.observe(document.getElementById('ctaDesc'));
    ctaObserver.observe(document.getElementById('ctaForm'));
}

// Magnetic buttons effect with performance improvements
function initMagneticButtons() {
    // Skip for low performance devices
    if (isLowPerformance()) {
        return;
    }
    
    const magneticBtns = document.querySelectorAll('.magnetic-btn');

    magneticBtns.forEach(btn => {
        btn.addEventListener('mousemove', throttle((e) => {
            const btnRect = btn.getBoundingClientRect();
            const btnCenterX = btnRect.left + btnRect.width / 2;
            const btnCenterY = btnRect.top + btnRect.height / 2;

            // Calculate distance from center
            const distanceX = e.clientX - btnCenterX;
            const distanceY = e.clientY - btnCenterY;

            // Max movement range
            const maxMovement = 10; // Reduced range for better performance

            // Calculate movement based on distance from center
            const moveX = (distanceX / btnRect.width) * maxMovement;
            const moveY = (distanceY / btnRect.height) * maxMovement;

            // Apply magnetic effect
            gsap.to(btn, {
                x: moveX,
                y: moveY,
                duration: 0.3,
                ease: "power2.out",
                force3D: true
            });
        }, 40));

        btn.addEventListener('mouseleave', () => {
            gsap.to(btn, {
                x: 0,
                y: 0,
                duration: 0.5,
                ease: "elastic.out(1, 0.5)",
                force3D: true
            });
        });

        // Ripple effect on click with better performance
        btn.addEventListener('click', throttle((e) => {
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
                    force3D: true,
                    onComplete: () => {
                        gsap.set(liquid, {opacity: 1, scale: 0});
                    }
                });
            }
        }, 100));
    });
}

// Create floating particles with performance optimizations
function createParticles() {
    // Skip for low performance devices
    if (isLowPerformance()) {
        return;
    }
    
    const container = document.getElementById('particles');
    if (!container) return;

    // Reduce particle count for better performance
    const particleCount = Math.min(30, Math.floor(window.innerWidth / 30));

    // Create all particles in a single document fragment
    const fragment = document.createDocumentFragment();

    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');

        // Random size - smaller particles for better performance
        const size = Math.random() * 6 + 2;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;

        // Random position
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;

        // Random opacity
        particle.style.opacity = Math.random() * 0.15 + 0.05;

        // Enable hardware acceleration
        particle.style.transform = 'translateZ(0)';
        particle.style.willChange = 'transform';

        // Add to fragment
        fragment.appendChild(particle);
    }

    // Add all particles at once
    container.appendChild(fragment);

    // Animate in batches for better performance
    const particles = container.querySelectorAll('.particle');
    
    for (let i = 0; i < particles.length; i += 5) {
        const batch = Array.from(particles).slice(i, i + 5);
        
        batch.forEach(particle => {
            gsap.to(particle, {
                x: `${(Math.random() - 0.5) * 40}%`,
                y: `${(Math.random() - 0.5) * 40}%`,
                duration: Math.random() * 10 + 15, // Longer duration for better performance
                repeat: -1,
                yoyo: true,
                ease: "sine.inOut",
                delay: Math.random() * 5,
                force3D: true
            });
        });
    }
}

// Initialize morphing blobs with better performance
function initMorphingBlobs() {
    // Skip for low performance devices or reduce complexity
    if (isLowPerformance()) {
        const blobs = document.querySelectorAll('.morphing-blob');
        blobs.forEach(blob => {
            blob.style.opacity = '0.02';
        });
        return;
    }
    
    const blobs = [
        document.getElementById('blob1'),
        document.getElementById('blob2'),
        document.getElementById('ctaBlob1'),
        document.getElementById('ctaBlob2')
    ].filter(blob => blob);

    blobs.forEach(blob => {
        // Get initial size
        const initialWidth = parseInt(blob.style.width) || 300;
        const initialHeight = parseInt(blob.style.height) || 300;

        // Simpler blob animation for better performance
        gsap.to(blob, {
            width: initialWidth * (0.9 + Math.random() * 0.2),
            height: initialHeight * (0.9 + Math.random() * 0.2),
            x: `${(Math.random() - 0.5) * 10}%`,
            y: `${(Math.random() - 0.5) * 10}%`,
            borderRadius: `${40 + Math.random() * 20}% ${40 + Math.random() * 20}% ${40 + Math.random() * 20}% ${40 + Math.random() * 20}%`,
            duration: 10 + Math.random() * 10,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut",
            force3D: true
        });
    });
}

// Optimized scroll to section
function scrollToSection(selector) {
    const section = document.querySelector(selector);
    if (!section) return;

    // Mark scrolling for animation performance
    document.documentElement.classList.add('is-scrolling');

    // Use ScrollToPlugin for smoother scrolling
    gsap.to(window, {
        duration: 1,
        scrollTo: {
            y: section,
            offsetY: 0
        },
        ease: "power2.inOut",
        onComplete: () => {
            // Remove scrolling class after completion
            setTimeout(() => {
                document.documentElement.classList.remove('is-scrolling');
            }, 100);
        }
    });
}

// Focus Timer Functionality - Optimized
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

    // Start interval - use more efficient timing
    const startTime = Date.now();
    
    timerInterval = setInterval(() => {
        if (!isPaused) {
            // Calculate elapsed time more accurately
            const elapsed = Math.floor((Date.now() - startTime) / 1000);
            remainingSeconds = Math.max(0, totalSeconds - elapsed);
            
            updateTimerDisplay();

            if (remainingSeconds <= 0) {
                clearInterval(timerInterval);
                timerInterval = null;
                timerComplete();
            }
        }
    }, 500); // Reduced update frequency for better performance
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
        ease: "elastic.out(1, 0.3)",
        force3D: true
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

// Improved Animation System with performance optimizations
gsap.config({
    force3D: true,
    autoSleep: 60,
    nullTargetWarn: false
});

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

    // Add floating cards section after a delay to ensure page is fully loaded
    window.addEventListener('load', function () {
        setTimeout(function () {
            // Ensure smooth scrolling is working
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.refresh();
            }

            // Add Chungi Yoo inspired floating cards section
            try {
                if (typeof addFloatingCardsSection === 'function') {
                    addFloatingCardsSection();
                }
            } catch (e) {
                console.warn('Could not initialize floating cards section:', e);
            }
        }, 500);
    });
});