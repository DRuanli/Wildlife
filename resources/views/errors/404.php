<?php
// Path: resources/views/errors/404.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Not Found - Wildlife Haven</title>
  
  <!-- Favicon -->
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
  <div class="min-h-screen flex flex-col items-center justify-center">
    <div class="max-w-3xl w-full mx-auto text-center p-8">
      <!-- Header Icon & Title -->
      <div class="mb-8">
        <i class="fas fa-paw text-green-600 text-8xl animate-bounce"></i>
      </div>
      <h1 class="text-5xl font-bold text-gray-800 mb-4">404 - Page Not Found</h1>
      <p class="text-xl text-gray-600 mb-8">
        Oops! It seems the wildlife you're looking for has wandered off.
      </p>
      
      <!-- Interactive Search & Random Fact Section -->
      <div class="mb-12">
        <!-- Search form -->
        <form id="search-form" class="flex justify-center mb-4" action="/search" method="GET">
          <input type="text" name="query" id="search-input" class="w-2/3 px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none" placeholder="Search for wildlife...">
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition">Search</button>
        </form>
        
        <!-- Random Fact Button -->
        <button id="fact-button" class="mb-4 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
          Show a Wildlife Fact
        </button>
        <div id="fact-display" class="text-lg text-gray-700 mt-2"></div>
      </div>
      
      <!-- Explore Animals Section -->
      <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Explore Animals</h2>
        <div id="animal-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-6">
          <!-- Each animal item uses a data attribute to identify the animal -->
          <div class="animal-item cursor-pointer p-4 bg-white rounded-lg shadow hover:shadow-lg transition" data-animal="cat">
            <i class="fas fa-cat text-5xl text-gray-700 mb-2"></i>
            <p class="font-semibold text-gray-800">Cat</p>
          </div>
          <div class="animal-item cursor-pointer p-4 bg-white rounded-lg shadow hover:shadow-lg transition" data-animal="dog">
            <i class="fas fa-dog text-5xl text-gray-700 mb-2"></i>
            <p class="font-semibold text-gray-800">Dog</p>
          </div>
          <div class="animal-item cursor-pointer p-4 bg-white rounded-lg shadow hover:shadow-lg transition" data-animal="crow">
            <i class="fas fa-crow text-5xl text-gray-700 mb-2"></i>
            <p class="font-semibold text-gray-800">Crow</p>
          </div>
          <div class="animal-item cursor-pointer p-4 bg-white rounded-lg shadow hover:shadow-lg transition" data-animal="fish">
            <i class="fas fa-fish text-5xl text-gray-700 mb-2"></i>
            <p class="font-semibold text-gray-800">Fish</p>
          </div>
          <div class="animal-item cursor-pointer p-4 bg-white rounded-lg shadow hover:shadow-lg transition" data-animal="paw">
            <i class="fas fa-paw text-5xl text-gray-700 mb-2"></i>
            <p class="font-semibold text-gray-800">Paw</p>
          </div>
        </div>
      </div>
      
      <a href="/" class="inline-block px-8 py-3 bg-green-600 text-white font-medium rounded-lg text-center hover:bg-green-700 transition">
        Return to Home
      </a>
    </div>
  </div>
  
  <!-- Modal for Animal Information -->
  <div id="animal-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 relative">
      <button id="modal-close" class="absolute top-2 right-2 text-gray-600 hover:text-gray-800">
        <i class="fas fa-times"></i>
      </button>
      <div id="modal-content">
        <i id="modal-icon" class="fas text-6xl text-gray-700 mb-4"></i>
        <h3 id="modal-title" class="text-2xl font-bold text-gray-800 mb-2"></h3>
        <p id="modal-fact" class="text-gray-600"></p>
      </div>
    </div>
  </div>
  
  <!-- JavaScript for Interactive Features -->
  <script>
    // Random wildlife facts array
    const wildlifeFacts = [
      "A group of flamingos is called a 'flamboyance'.",
      "Elephants are the only animals that can't jump.",
      "A snail can sleep for three years.",
      "Koala fingerprints are nearly identical to human fingerprints.",
      "A rhinoceros' horn is made entirely of keratin."
    ];
    
    // Display a random fact when the fact button is clicked
    document.getElementById('fact-button').addEventListener('click', function() {
      const randomIndex = Math.floor(Math.random() * wildlifeFacts.length);
      document.getElementById('fact-display').textContent = wildlifeFacts[randomIndex];
    });
    
    // Data for each animal (keyed by the data-animal attribute)
    const animalData = {
      cat: {
        name: "Cat",
        icon: "fas fa-cat",
        fact: "Cats are independent and mysterious creatures known for their agility and graceful movements."
      },
      dog: {
        name: "Dog",
        icon: "fas fa-dog",
        fact: "Dogs are loyal and friendly companions, known for their unconditional love and protective nature."
      },
      crow: {
        name: "Crow",
        icon: "fas fa-crow",
        fact: "Crows are highly intelligent birds known for their problem-solving skills and adaptability."
      },
      fish: {
        name: "Fish",
        icon: "fas fa-fish",
        fact: "Fish come in a wide variety of species and display fascinating adaptations to aquatic life."
      },
      paw: {
        name: "Paw",
        icon: "fas fa-paw",
        fact: "Animal paws are uniquely designed for balance, agility, and exploring their surroundings."
      }
    };
    
    // When an animal item is clicked, show the modal with that animal's information
    document.querySelectorAll('.animal-item').forEach(item => {
      item.addEventListener('click', function() {
        const animalKey = this.getAttribute('data-animal');
        const animal = animalData[animalKey];
        if (animal) {
          document.getElementById('modal-icon').className = animal.icon + " text-6xl text-gray-700 mb-4";
          document.getElementById('modal-title').textContent = animal.name;
          document.getElementById('modal-fact').textContent = animal.fact;
          document.getElementById('animal-modal').classList.remove('hidden');
        }
      });
    });
    
    // Close the modal when the close button is clicked
    document.getElementById('modal-close').addEventListener('click', function() {
      document.getElementById('animal-modal').classList.add('hidden');
    });
    
    // Close the modal if the user clicks outside the modal content
    window.addEventListener('click', function(e) {
      const modal = document.getElementById('animal-modal');
      if (e.target == modal) {
        modal.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
