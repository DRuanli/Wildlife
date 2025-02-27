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
    <div class="max-w-md mx-auto text-center p-8">
      <div class="mb-8">
        <i class="fas fa-paw text-green-600 text-6xl animate-bounce"></i>
      </div>
      <h1 class="text-4xl font-bold text-gray-800 mb-4">404 - Page Not Found</h1>
      <p class="text-lg text-gray-600 mb-8">
        Oops! It seems the wildlife you're looking for has wandered off.
      </p>
      
      <!-- Interactive Search and Fact Section -->
      <div class="mb-8">
        <!-- Search form -->
        <form id="search-form" class="flex justify-center mb-4" action="/search" method="GET">
          <input type="text" name="query" id="search-input" class="w-full px-4 py-2 border rounded-l-lg focus:outline-none" placeholder="Search for wildlife...">
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition">Search</button>
        </form>
        
        <!-- Random Fact Button -->
        <button id="fact-button" class="mb-4 px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
          Show a Wildlife Fact
        </button>
        <div id="fact-display" class="text-lg text-gray-700 mt-2"></div>
      </div>
      
      <a href="/" class="inline-block px-6 py-3 bg-green-600 text-white font-medium rounded-lg text-center hover:bg-green-700 transition">
        Return to Home
      </a>
    </div>
  </div>
  
  <!-- JavaScript for interactive features -->
  <script>
    // Array of wildlife facts
    const wildlifeFacts = [
      "A group of flamingos is called a 'flamboyance'.",
      "Elephants are the only animals that can't jump.",
      "A snail can sleep for three years.",
      "Koala fingerprints are nearly identical to human fingerprints.",
      "A rhinoceros' horn is made entirely of keratin."
    ];
    
    // Display a random fact when the button is clicked
    document.getElementById('fact-button').addEventListener('click', function() {
      const randomIndex = Math.floor(Math.random() * wildlifeFacts.length);
      document.getElementById('fact-display').textContent = wildlifeFacts[randomIndex];
    });
  </script>
</body>
</html>
