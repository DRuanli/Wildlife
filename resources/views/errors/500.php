<?php
// Path: resources/views/errors/500.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - Wildlife Haven</title>
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md mx-auto text-center p-8">
            <div class="mb-8">
                <i class="fas fa-exclamation-circle text-red-600 text-6xl"></i>
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-4">500 - Server Error</h1>
            <p class="text-lg text-gray-600 mb-8">
                Oops! Our virtual wildlife is experiencing some technical difficulties.
                Please try again later.
            </p>
            <a href="/" class="inline-block px-6 py-3 bg-green-600 text-white font-medium rounded-lg text-center hover:bg-green-700 transition">
                Return to Home
            </a>
        </div>
    </div>
</body> 
</html>