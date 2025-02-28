<?php
// Path: resources/views/components/loading.php
$baseUrl = '/Wildlife';
?>

<div class="species-loading-screen fixed inset-0 bg-primary z-50 flex flex-col items-center justify-center overflow-hidden" id="loadingScreen">
    <!-- Conservation Quote -->
    <div class="text-center mb-8 px-6 max-w-md">
        <h2 class="text-white text-lg md:text-xl font-display mb-2 transition-opacity" id="loadingQuote">
            "In the end, we will conserve only what we love. We will love only what we understand."
        </h2>
        <p class="text-secondary text-sm md:text-base italic transition-opacity" id="loadingAuthor">
            - Baba Dioum
        </p>
    </div>

    <!-- SVG Animation Container -->
    <div class="w-64 h-64 md:w-80 md:h-80 relative">
        <!-- Main Circle Background -->
        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 200 200">
            <defs>
                <linearGradient id="circleGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#2D5A3E" />
                    <stop offset="100%" stop-color="#1a3324" />
                </linearGradient>
            </defs>
            <circle cx="100" cy="100" r="95" fill="url(#circleGradient)" />
            
            <!-- Decorative dots orbital -->
            <circle class="orbital-dot" cx="100" cy="5" r="2" fill="#D9C589">
                <animateTransform 
                    attributeName="transform" 
                    type="rotate" 
                    from="0 100 100" 
                    to="360 100 100" 
                    dur="30s" 
                    repeatCount="indefinite"
                />
            </circle>
            
            <!-- More orbital dots with different speeds and sizes -->
            <circle class="orbital-dot" cx="100" cy="10" r="3" fill="#D9C589" opacity="0.8">
                <animateTransform 
                    attributeName="transform" 
                    type="rotate" 
                    from="90 100 100" 
                    to="450 100 100" 
                    dur="20s" 
                    repeatCount="indefinite"
                />
            </circle>
            
            <circle class="orbital-dot" cx="100" cy="8" r="1.5" fill="#D9C589" opacity="0.6">
                <animateTransform 
                    attributeName="transform" 
                    type="rotate" 
                    from="180 100 100" 
                    to="540 100 100" 
                    dur="25s" 
                    repeatCount="indefinite"
                />
            </circle>
        </svg>
        
        <!-- Species Container - Will morph between different endangered species -->
        <div class="absolute inset-0 flex items-center justify-center" id="speciesContainer">
            <!-- Panda SVG - Initial species-->
            <svg class="animal-svg w-40 h-40 md:w-48 md:h-48" viewBox="0 0 100 100" id="pandaSvg">
                <!-- Panda Body -->
                <circle cx="50" cy="50" r="35" fill="white" />
                
                <!-- Panda Black Patches -->
                <ellipse cx="32" cy="38" rx="13" ry="12" fill="black" />
                <ellipse cx="68" cy="38" rx="13" ry="12" fill="black" />
                <ellipse cx="32" cy="70" rx="13" ry="8" fill="black" />
                <ellipse cx="68" cy="70" rx="13" ry="8" fill="black" />
                
                <!-- Panda Ears -->
                <circle cx="28" cy="20" r="8" fill="black" />
                <circle cx="72" cy="20" r="8" fill="black" />
                
                <!-- Panda Face -->
                <circle cx="50" cy="50" r="16" fill="white" />
                <ellipse cx="44" cy="48" rx="3" ry="4" fill="black" />
                <ellipse cx="56" cy="48" rx="3" ry="4" fill="black" />
                <ellipse cx="50" cy="55" rx="4" ry="3" fill="black" />
            </svg>
            
            <!-- Tiger SVG - Hidden initially -->
            <svg class="animal-svg w-40 h-40 md:w-48 md:h-48 hidden" viewBox="0 0 100 100" id="tigerSvg">
                <!-- Tiger Body -->
                <circle cx="50" cy="50" r="35" fill="#FF9800" />
                
                <!-- Tiger Stripes -->
                <path d="M28,30 Q35,40 28,50" stroke="black" stroke-width="2" fill="none" />
                <path d="M38,25 Q45,35 38,45" stroke="black" stroke-width="2" fill="none" />
                <path d="M50,20 Q57,30 50,40" stroke="black" stroke-width="2" fill="none" />
                <path d="M62,25 Q69,35 62,45" stroke="black" stroke-width="2" fill="none" />
                <path d="M72,30 Q79,40 72,50" stroke="black" stroke-width="2" fill="none" />
                
                <path d="M30,60 Q37,70 30,80" stroke="black" stroke-width="2" fill="none" />
                <path d="M45,60 Q52,70 45,80" stroke="black" stroke-width="2" fill="none" />
                <path d="M60,60 Q67,70 60,80" stroke="black" stroke-width="2" fill="none" />
                
                <!-- Tiger Face -->
                <circle cx="50" cy="45" r="16" fill="#FF9800" />
                <circle cx="42" cy="42" r="3" fill="white" />
                <circle cx="42" cy="42" r="1.5" fill="black" />
                <circle cx="58" cy="42" r="3" fill="white" />
                <circle cx="58" cy="42" r="1.5" fill="black" />
                
                <!-- Tiger Ears -->
                <circle cx="33" cy="25" r="5" fill="#FF9800" />
                <circle cx="67" cy="25" r="5" fill="#FF9800" />
                
                <!-- Tiger Nose and Mouth -->
                <circle cx="50" cy="50" r="3" fill="#FFE0B2" />
                <path d="M47,54 L53,54" stroke="black" stroke-width="1" />
                <path d="M44,56 C47,60 53,60 56,56" stroke="black" stroke-width="1" fill="none" />
            </svg>
            
            <!-- Rhino SVG - Hidden initially -->
            <svg class="animal-svg w-40 h-40 md:w-48 md:h-48 hidden" viewBox="0 0 100 100" id="rhinoSvg">
                <!-- Rhino Body -->
                <ellipse cx="50" cy="55" rx="35" ry="28" fill="#9E9E9E" />
                
                <!-- Rhino Head -->
                <path d="M85,55 C95,45 90,25 75,30 C68,32 60,40 50,40 C40,40 25,35 15,45 C10,50 15,65 25,60 C35,55 45,55 50,55" fill="#757575" />
                
                <!-- Rhino Horn -->
                <path d="M55,40 C55,30 55,20 65,15" stroke="#424242" stroke-width="6" stroke-linecap="round" fill="none" />
                
                <!-- Rhino Eyes -->
                <circle cx="38" cy="45" r="2" fill="black" />
                <circle cx="62" cy="45" r="2" fill="black" />
                
                <!-- Rhino Ears -->
                <ellipse cx="30" cy="35" rx="5" ry="7" fill="#9E9E9E" transform="rotate(-20 30 35)" />
                <ellipse cx="70" cy="35" rx="5" ry="7" fill="#9E9E9E" transform="rotate(20 70 35)" />
            </svg>
            
            <!-- Whale SVG - Hidden initially -->
            <svg class="animal-svg w-40 h-40 md:w-48 md:h-48 hidden" viewBox="0 0 100 100" id="whaleSvg">
                <!-- Whale Body -->
                <path d="M15,50 C20,30 40,30 50,40 L50,40 C60,30 80,30 85,50 C90,70 75,80 50,80 C25,80 10,70 15,50 Z" fill="#0277BD" />
                
                <!-- Whale Tail -->
                <path d="M50,80 L50,85 L40,95 M50,85 L60,95" stroke="#0277BD" stroke-width="5" stroke-linecap="round" fill="none" />
                
                <!-- Whale Eye -->
                <circle cx="35" cy="45" r="3" fill="white" />
                <circle cx="35" cy="45" r="1.5" fill="black" />
                
                <!-- Whale Blowhole -->
                <ellipse cx="50" cy="35" rx="3" ry="1" fill="#01579B" />
                
                <!-- Whale Fin -->
                <path d="M75,50 L85,45 L80,55 Z" fill="#01579B" />
            </svg>
            
            <!-- Elephant SVG - Hidden initially -->
            <svg class="animal-svg w-40 h-40 md:w-48 md:h-48 hidden" viewBox="0 0 100 100" id="elephantSvg">
                <!-- Elephant Body -->
                <ellipse cx="50" cy="60" rx="30" ry="25" fill="#78909C" />
                
                <!-- Elephant Head -->
                <circle cx="50" cy="40" r="20" fill="#78909C" />
                
                <!-- Elephant Ears -->
                <ellipse cx="25" cy="40" rx="12" ry="18" fill="#90A4AE" transform="rotate(-10 25 40)" />
                <ellipse cx="75" cy="40" rx="12" ry="18" fill="#90A4AE" transform="rotate(10 75 40)" />
                
                <!-- Elephant Eyes -->
                <circle cx="40" cy="35" r="2" fill="black" />
                <circle cx="60" cy="35" r="2" fill="black" />
                
                <!-- Elephant Trunk -->
                <path d="M50,50 C50,60 50,70 45,75 C40,80 35,80 35,70" stroke="#78909C" stroke-width="6" stroke-linecap="round" fill="none" />
                
                <!-- Elephant Tusks -->
                <path d="M40,50 L30,60" stroke="ivory" stroke-width="3" stroke-linecap="round" fill="none" />
                <path d="M60,50 L70,60" stroke="ivory" stroke-width="3" stroke-linecap="round" fill="none" />
            </svg>
        </div>
        
        <!-- Loading Progress Circular Track -->
        <svg class="absolute inset-0 w-full h-full" viewBox="0 0 200 200">
            <circle 
                cx="100" 
                cy="100" 
                r="90" 
                fill="none" 
                stroke="#D9C589" 
                stroke-width="2.5" 
                stroke-opacity="0.3"
            />
            <circle 
                cx="100" 
                cy="100" 
                r="90" 
                fill="none" 
                stroke="#D9C589" 
                stroke-width="3" 
                stroke-dasharray="565.48" 
                stroke-dashoffset="565.48" 
                stroke-linecap="round" 
                id="loadingCircle"
            >
                <animate 
                    attributeName="stroke-dashoffset" 
                    from="565.48" 
                    to="0" 
                    dur="8s" 
                    repeatCount="indefinite" 
                    id="loadingAnimation"
                />
            </circle>
        </svg>
    </div>

    <!-- Conservation Facts -->
    <div class="mt-8 text-center px-6 max-w-md">
        <div class="h-20">
            <p class="text-white transition-opacity duration-500" id="conservationFact">
                Giant pandas were downgraded from "endangered" to "vulnerable" in 2016 thanks to conservation efforts.
            </p>
        </div>
        
        <!-- Loading Status -->
        <p class="text-secondary text-sm mt-4">
            <span id="loadingStatus">Loading wildlife data</span> <span class="loading-dots">...</span>
        </p>
        
        <!-- Conservation Status Indicator -->
        <div class="flex justify-center items-center mt-4 space-x-1" id="statusIndicator">
            <span class="h-3 w-3 rounded-full bg-red-500"></span>
            <span class="text-xs text-red-300">Critically Endangered</span>
        </div>
    </div>
</div>

<style>
    @keyframes dotsAnimation {
        0% { content: "."; }
        33% { content: ".."; }
        66% { content: "..."; }
        100% { content: "."; }
    }
    
    .loading-dots::after {
        content: "...";
        display: inline-block;
        animation: dotsAnimation 1.5s infinite;
    }
    
    .orbital-dot {
        transform-origin: center;
    }
    
    /* Fade animation for animal morphing */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    .animal-fade-in {
        animation: fadeIn 1s forwards;
    }
    
    .animal-fade-out {
        animation: fadeOut 1s forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Endangered species facts
        const conservationFacts = [
            "Giant pandas were downgraded from "endangered" to "vulnerable" in 2016 thanks to conservation efforts.",
            "There are fewer than 4,000 wild tigers left in the world, down from 100,000 a century ago.",
            "Black rhinos have doubled in number since their low point in 1995, but remain critically endangered.",
            "Blue whales, the largest animals on Earth, are recovering at a rate of about 7% per year since protection.",
            "African elephant populations have declined by 96% in the last century due to poaching and habitat loss.",
            "Your focus time has contributed to planting 12,000 trees for wildlife habitats worldwide.",
            "Wildlife Haven users collectively protect 25 endangered species through conservation donations."
        ];
        
        // Conservation quotes
        const conservationQuotes = [
            {
                quote: "In the end, we will conserve only what we love. We will love only what we understand.",
                author: "Baba Dioum"
            },
            {
                quote: "The greatest threat to our planet is the belief that someone else will save it.",
                author: "Robert Swan"
            },
            {
                quote: "What we are doing to the forests of the world is but a mirror reflection of what we are doing to ourselves.",
                author: "Mahatma Gandhi"
            },
            {
                quote: "Conservation is a state of harmony between men and land.",
                author: "Aldo Leopold"
            }
        ];
        
        // Status indicators by species
        const conservationStatuses = [
            { species: "panda", status: "Vulnerable", color: "#FFC107" },
            { species: "tiger", status: "Endangered", color: "#FF5722" },
            { species: "rhino", status: "Critically Endangered", color: "#F44336" },
            { species: "whale", status: "Endangered", color: "#FF5722" },
            { species: "elephant", status: "Vulnerable", color: "#FFC107" }
        ];
        
        // Loading status messages
        const loadingMessages = [
            "Loading wildlife data",
            "Retrieving conservation stats",
            "Preparing your habitat",
            "Hatching creatures",
            "Almost ready"
        ];
        
        // Current species index
        let currentSpeciesIndex = 0;
        const speciesSvgs = ['pandaSvg', 'tigerSvg', 'rhinoSvg', 'whaleSvg', 'elephantSvg'];
        
        // Function to update the conservation fact
        function updateConservationFact() {
            const factElement = document.getElementById('conservationFact');
            factElement.style.opacity = 0;
            
            setTimeout(() => {
                factElement.textContent = conservationFacts[Math.floor(Math.random() * conservationFacts.length)];
                factElement.style.opacity = 1;
            }, 500);
        }
        
        // Function to update the conservation quote
        function updateConservationQuote() {
            const quoteElement = document.getElementById('loadingQuote');
            const authorElement = document.getElementById('loadingAuthor');
            
            quoteElement.style.opacity = 0;
            authorElement.style.opacity = 0;
            
            setTimeout(() => {
                const randomQuote = conservationQuotes[Math.floor(Math.random() * conservationQuotes.length)];
                quoteElement.textContent = `"${randomQuote.quote}"`;
                authorElement.textContent = `- ${randomQuote.author}`;
                
                quoteElement.style.opacity = 1;
                authorElement.style.opacity = 1;
            }, 500);
        }
        
        // Function to update the loading status
        function updateLoadingStatus() {
            const statusElement = document.getElementById('loadingStatus');
            statusElement.textContent = loadingMessages[Math.floor(Math.random() * loadingMessages.length)];
        }
        
        // Function to update the conservation status indicator
        function updateStatusIndicator(speciesIndex) {
            const statusIndicator = document.getElementById('statusIndicator');
            const status = conservationStatuses[speciesIndex];
            
            statusIndicator.innerHTML = `
                <span class="h-3 w-3 rounded-full" style="background-color: ${status.color}"></span>
                <span class="text-xs" style="color: ${status.color}">${status.status}</span>
            `;
        }
        
        // Function to change the displayed species
        function changeSpecies() {
            // Hide current species
            document.getElementById(speciesSvgs[currentSpeciesIndex]).classList.add('animal-fade-out');
            document.getElementById(speciesSvgs[currentSpeciesIndex]).classList.add('hidden');
            
            // Update index to next species
            currentSpeciesIndex = (currentSpeciesIndex + 1) % speciesSvgs.length;
            
            // Update status indicator
            updateStatusIndicator(currentSpeciesIndex);
            
            // Show new species
            const newSpeciesElement = document.getElementById(speciesSvgs[currentSpeciesIndex]);
            newSpeciesElement.classList.remove('hidden');
            newSpeciesElement.classList.add('animal-fade-in');
            
            // Remove animation classes after animation completes
            setTimeout(() => {
                document.querySelectorAll('.animal-svg').forEach(svg => {
                    svg.classList.remove('animal-fade-in');
                    svg.classList.remove('animal-fade-out');
                });
            }, 1000);
        }
        
        // Restart the loading animation when it completes
        document.getElementById('loadingAnimation').addEventListener('endEvent', function() {
            changeSpecies();
            updateConservationFact();
            updateLoadingStatus();
            
            // Occasionally update the quote
            if (Math.random() < 0.3) {
                updateConservationQuote();
            }
        });
        
        // Function to hide loading screen (called when content is loaded)
        window.hideLoadingScreen = function() {
            const loadingScreen = document.getElementById('loadingScreen');
            loadingScreen.style.opacity = 0;
            
            setTimeout(() => {
                loadingScreen.style.display = 'none';
            }, 1000);
        };
        
        // Simulate loading completion after some time (for demonstration only)
        // In a real implementation, this would be called when the actual content has loaded
        setTimeout(window.hideLoadingScreen, 8000);
        
        // Show the initial species
        document.getElementById(speciesSvgs[currentSpeciesIndex]).classList.remove('hidden');
        updateStatusIndicator(currentSpeciesIndex);
    });
</script>