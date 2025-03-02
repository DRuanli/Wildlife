<?php
// Path: resources/views/leaderboard/index.php
$baseUrl = '/Wildlife';
?>

<?php include ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<!-- Hero Section -->
<section class="bg-primary text-white py-12 relative overflow-hidden">
  <!-- Nature-inspired background patterns -->
  <div class="absolute inset-0 opacity-10">
    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
      <pattern id="leaf-pattern" x="0" y="0" width="100" height="100" patternUnits="userSpaceOnUse">
        <path d="M30,50 Q50,20 70,50 Q50,80 30,50 Z" fill="currentColor"/>
      </pattern>
      <rect width="100%" height="100%" fill="url(#leaf-pattern)"/>
    </svg>
  </div>
  
  <div class="container mx-auto px-4 relative z-10">
    <div class="text-center">
      <h1 class="text-4xl md:text-5xl font-display font-bold mb-4">Focus Leaderboard</h1>
      <p class="text-xl max-w-3xl mx-auto">Track your progress, compete with the community, and celebrate the collective impact of our mindful focus.</p>
      
      <!-- User's Current Rank Summary -->
      <div class="mt-8 bg-white bg-opacity-10 rounded-xl p-6 max-w-3xl mx-auto backdrop-blur-sm">
        <div class="flex flex-col md:flex-row items-center justify-between">
          <div class="flex items-center mb-4 md:mb-0">
            <div class="h-16 w-16 bg-secondary rounded-full flex items-center justify-center mr-4 text-primary font-bold text-xl border-2 border-white">
              #14
            </div>
            <div class="text-left">
              <p class="text-gray-200">Your Current Rank</p>
              <h3 class="text-2xl font-bold">Getting Started!</h3>
              <p class="text-sm text-gray-200">Focus more to climb the ranks</p>
            </div>
          </div>
          <div class="flex items-center gap-6">
            <div class="text-center">
              <p class="text-xl font-bold">120</p>
              <p class="text-sm text-gray-200">Focus Minutes</p>
            </div>
            <div class="text-center">
              <p class="text-xl font-bold">3</p>
              <p class="text-sm text-gray-200">Creatures</p>
            </div>
            <div class="text-center">
              <p class="text-xl font-bold">5</p>
              <p class="text-sm text-gray-200">Day Streak</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Leaderboard Filter Section -->
<section class="py-6 bg-light border-b border-gray-200 sticky top-16 z-40">
  <div class="container mx-auto px-4">
    <div class="flex flex-wrap justify-between items-center">
      <!-- Time Period Tabs -->
      <div class="flex overflow-x-auto hide-scrollbar mb-4 md:mb-0">
        <button class="px-6 py-2 bg-primary text-white rounded-full text-sm font-medium mr-2">Today</button>
        <button class="px-6 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium mr-2 hover:bg-gray-100 transition">This Week</button>
        <button class="px-6 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium mr-2 hover:bg-gray-100 transition">This Month</button>
        <button class="px-6 py-2 bg-white border border-gray-300 rounded-full text-sm font-medium hover:bg-gray-100 transition">All Time</button>
      </div>
      
      <!-- Category and Search -->
      <div class="flex items-center space-x-3">
        <div class="relative">
          <select class="appearance-none bg-white border border-gray-300 rounded-full pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-primary text-sm">
            <option value="focus_score">Focus Score</option>
            <option value="creatures">Creatures Raised</option>
            <option value="streak">Focus Streak</option>
            <option value="conservation">Conservation Impact</option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
            <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
          </div>
        </div>
        
        <div class="relative">
          <input type="text" placeholder="Search players..." class="bg-white border border-gray-300 rounded-full pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary w-full md:w-48 text-sm">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3">
            <i class="fas fa-search text-gray-400"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Main Leaderboard Section -->
<section class="py-8">
  <div class="container mx-auto px-4">
    <!-- Top 3 Podium (Desktop) -->
    <div class="hidden md:flex justify-center items-end mb-12 mt-4">
      <!-- 2nd Place -->
      <div class="text-center px-6">
        <div class="relative">
          <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-gray-300 overflow-hidden">
            <img src="<?= $baseUrl ?>/assets/images/avatars/user2.jpg" alt="2nd Place" class="w-full h-full object-cover">
          </div>
          <div class="absolute -top-2 -right-2 w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center border-2 border-white">
            <span class="text-gray-800 font-bold">2</span>
          </div>
          <div class="absolute -bottom-1 left-0 right-0 flex justify-center">
            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Silver</span>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-lg">NatureNinja</h3>
          <p class="text-gray-600">4,750 Focus Score</p>
          <div class="mt-2 flex justify-center space-x-1">
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Focus Expert</span>
          </div>
        </div>
        <div class="h-40 w-24 mx-auto mt-4 bg-gray-200 rounded-t-lg relative overflow-hidden">
          <div class="absolute bottom-0 w-full h-3/4 bg-gray-300"></div>
        </div>
      </div>
      
      <!-- 1st Place -->
      <div class="text-center px-6 -mb-8">
        <div class="relative">
          <div class="w-32 h-32 mx-auto bg-white rounded-full border-4 border-yellow-500 overflow-hidden">
            <img src="<?= $baseUrl ?>/assets/images/avatars/user1.jpg" alt="1st Place" class="w-full h-full object-cover">
          </div>
          <div class="absolute -top-4 -right-2 w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center border-2 border-white">
            <span class="text-white font-bold">1</span>
          </div>
          <div class="absolute -bottom-1 left-0 right-0 flex justify-center">
            <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">Gold</span>
          </div>
          <div class="absolute -top-8 left-0 right-0 flex justify-center">
            <span class="text-yellow-500"><i class="fas fa-crown text-2xl"></i></span>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-xl">FocusMaster</h3>
          <p class="text-gray-600">5,120 Focus Score</p>
          <div class="mt-2 flex justify-center space-x-1">
            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Focus Master</span>
            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">30d Streak</span>
          </div>
        </div>
        <div class="h-56 w-32 mx-auto mt-4 bg-gray-200 rounded-t-lg relative overflow-hidden">
          <div class="absolute bottom-0 w-full h-4/5 bg-yellow-300"></div>
        </div>
      </div>
      
      <!-- 3rd Place -->
      <div class="text-center px-6">
        <div class="relative">
          <div class="w-24 h-24 mx-auto bg-white rounded-full border-4 border-yellow-800 overflow-hidden">
            <img src="<?= $baseUrl ?>/assets/images/avatars/user3.jpg" alt="3rd Place" class="w-full h-full object-cover">
          </div>
          <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-800 rounded-full flex items-center justify-center border-2 border-white">
            <span class="text-white font-bold">3</span>
          </div>
          <div class="absolute -bottom-1 left-0 right-0 flex justify-center">
            <span class="bg-yellow-800 text-white text-xs px-2 py-1 rounded-full">Bronze</span>
          </div>
        </div>
        <div class="mt-4">
          <h3 class="font-bold text-lg">WildGuardian</h3>
          <p class="text-gray-600">4,320 Focus Score</p>
          <div class="mt-2 flex justify-center space-x-1">
            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Streak Master</span>
          </div>
        </div>
        <div class="h-32 w-24 mx-auto mt-4 bg-gray-200 rounded-t-lg relative overflow-hidden">
          <div class="absolute bottom-0 w-full h-2/3 bg-yellow-700"></div>
        </div>
      </div>
    </div>
    
    <!-- Mobile Top 3 -->
    <div class="md:hidden mb-8">
      <h3 class="font-bold text-lg mb-4">Top Performers</h3>
      
      <!-- 1st Place -->
      <div class="bg-white rounded-lg shadow-md p-4 mb-3 border-l-4 border-yellow-500">
        <div class="flex items-center">
          <div class="relative mr-4">
            <div class="w-16 h-16 bg-white rounded-full border-2 border-yellow-500 overflow-hidden">
              <img src="<?= $baseUrl ?>/assets/images/avatars/user1.jpg" alt="1st Place" class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center border-2 border-white">
              <span class="text-white font-bold">1</span>
            </div>
          </div>
          <div class="flex-grow">
            <h3 class="font-bold">FocusMaster</h3>
            <p class="text-gray-600 text-sm">5,120 Focus Score</p>
            <div class="mt-1 flex flex-wrap gap-1">
              <span class="bg-purple-100 text-purple-800 text-xs px-1.5 py-0.5 rounded-full">Focus Master</span>
              <span class="bg-green-100 text-green-800 text-xs px-1.5 py-0.5 rounded-full">30d Streak</span>
            </div>
          </div>
          <div class="text-yellow-500"><i class="fas fa-crown text-xl"></i></div>
        </div>
      </div>
      
      <!-- 2nd Place -->
      <div class="bg-white rounded-lg shadow-md p-4 mb-3 border-l-4 border-gray-300">
        <div class="flex items-center">
          <div class="relative mr-4">
            <div class="w-16 h-16 bg-white rounded-full border-2 border-gray-300 overflow-hidden">
              <img src="<?= $baseUrl ?>/assets/images/avatars/user2.jpg" alt="2nd Place" class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center border-2 border-white">
              <span class="text-gray-800 font-bold">2</span>
            </div>
          </div>
          <div class="flex-grow">
            <h3 class="font-bold">NatureNinja</h3>
            <p class="text-gray-600 text-sm">4,750 Focus Score</p>
            <div class="mt-1 flex flex-wrap gap-1">
              <span class="bg-blue-100 text-blue-800 text-xs px-1.5 py-0.5 rounded-full">Focus Expert</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- 3rd Place -->
      <div class="bg-white rounded-lg shadow-md p-4 mb-3 border-l-4 border-yellow-800">
        <div class="flex items-center">
          <div class="relative mr-4">
            <div class="w-16 h-16 bg-white rounded-full border-2 border-yellow-800 overflow-hidden">
              <img src="<?= $baseUrl ?>/assets/images/avatars/user3.jpg" alt="3rd Place" class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-800 rounded-full flex items-center justify-center border-2 border-white">
              <span class="text-white font-bold">3</span>
            </div>
          </div>
          <div class="flex-grow">
            <h3 class="font-bold">WildGuardian</h3>
            <p class="text-gray-600 text-sm">4,320 Focus Score</p>
            <div class="mt-1 flex flex-wrap gap-1">
              <span class="bg-red-100 text-red-800 text-xs px-1.5 py-0.5 rounded-full">Streak Master</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Leaderboard Table -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Rank</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Score</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Streak</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Creatures</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <!-- Skip 1-3 as they're in the podium section -->
          
          <!-- 4th Place -->
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-700">4</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 overflow-hidden">
                  <img src="<?= $baseUrl ?>/assets/images/avatars/user4.jpg" alt="" class="h-full w-full object-cover">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">EcoWatcher</div>
                  <div class="text-xs text-gray-500">Joined Apr 2024</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">4,105</div>
              <div class="flex items-center text-xs text-gray-500">
                <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M12 7a1 1 0 01-1 1H9a1 1 0 01-1-1V6a1 1 0 011-1h2a1 1 0 011 1v1zm-6 6a1 1 0 01-1-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 01-1 1H6zm6 0a1 1 0 01-1-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 01-1 1h-2zm-6 6a1 1 0 01-1-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 01-1 1H6zm6 0a1 1 0 01-1-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 01-1 1h-2z" clip-rule="evenodd"></path>
                </svg>
                +105 today
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">21 days</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">15</div>
              <div class="flex">
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-green-100 mr-1">
                  <span class="text-xs font-medium text-green-800">5</span>
                </span>
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-100 mr-1">
                  <span class="text-xs font-medium text-blue-800">8</span>
                </span>
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-purple-100">
                  <span class="text-xs font-medium text-purple-800">2</span>
                </span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 80%"></div>
              </div>
              <div class="text-xs text-gray-500 mt-1">215 pts to next rank</div>
            </td>
          </tr>
          
          <!-- 5th Place -->
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-700">5</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 overflow-hidden">
                  <img src="<?= $baseUrl ?>/assets/images/avatars/user5.jpg" alt="" class="h-full w-full object-cover">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">BioDreamer</div>
                  <div class="text-xs text-gray-500">Joined Feb 2024</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">3,950</div>
              <div class="flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                +250 today
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">18 days</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">12</div>
              <div class="flex">
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-green-100 mr-1">
                  <span class="text-xs font-medium text-green-800">4</span>
                </span>
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-100 mr-1">
                  <span class="text-xs font-medium text-blue-800">6</span>
                </span>
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-purple-100">
                  <span class="text-xs font-medium text-purple-800">2</span>
                </span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 78%"></div>
              </div>
              <div class="text-xs text-gray-500 mt-1">155 pts to next rank</div>
            </td>
          </tr>
          
          <!-- Highlighted User (14th Place) -->
          <tr class="bg-yellow-50 hover:bg-yellow-100 transition">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center font-bold text-white">14</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 overflow-hidden border-2 border-primary">
                  <img src="<?= $baseUrl ?>/assets/images/avatars/you.jpg" alt="" class="h-full w-full object-cover">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">You</div>
                  <div class="text-xs text-gray-500">Joined Mar 2025</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">1,850</div>
              <div class="flex items-center text-xs text-green-600">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                +120 today
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">5 days</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">3</div>
              <div class="flex">
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-green-100 mr-1">
                  <span class="text-xs font-medium text-green-800">2</span>
                </span>
                <span class="inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-100 mr-1">
                  <span class="text-xs font-medium text-blue-800">1</span>
                </span>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-primary h-2.5 rounded-full" style="width: 45%"></div>
              </div>
              <div class="text-xs text-gray-500 mt-1">200 pts to rank 13</div>
            </td>
          </tr>
          
          <!-- Continue with more rows (6-13 and 15-20) -->
          <!-- For brevity, I'm including just a few more rows -->
          
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-700">15</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-100 overflow-hidden">
                  <img src="<?= $baseUrl ?>/assets/images/avatars/user15.jpg" alt="" class="h-full w-full object-cover">
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">GreenThumb</div>
                  <div class="text-xs text-gray-500">Joined Feb 2025</div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">1,720</div>
              <div class="flex items-center text-xs text-red-600">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                -50 today
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">3 days</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
              <div class="text-sm font-medium text-gray-900">5</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 40%"></div>
              </div>
              <div class="text-xs text-gray-500 mt-1">130 pts to next rank</div>
            </td>
          </tr>
          
          <!-- Add more rows as needed -->
        </tbody>
      </table>
      
      <!-- Pagination -->
      <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
          <div>
            <p class="text-sm text-gray-700">
              Showing <span class="font-medium">1</span> to <span class="font-medium">20</span> of <span class="font-medium">156</span> users
            </p>
          </div>
          <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
              <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Previous</span>
                <i class="fas fa-chevron-left text-xs"></i>
              </a>
              <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary text-sm font-medium text-white">
                1
              </a>
              <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                2
              </a>
              <a href="#" class="relative hidden md:inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                3
              </a>
              <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                ...
              </span>
              <a href="#" class="relative hidden md:inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                8
              </a>
              <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">Next</span>
                <i class="fas fa-chevron-right text-xs"></i>
              </a>
            </nav>
          </div>
        </div>
        
        <!-- Mobile Pagination -->
        <div class="flex items-center justify-between w-full sm:hidden">
          <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Previous
          </button>
          <span class="text-sm text-gray-500">Page 1 of 8</span>
          <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Upcoming Challenges -->
<section class="py-12 bg-gray-50">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl font-display font-bold mb-6">Upcoming Challenges</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Challenge Card 1 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-gradient-to-r from-green-500 to-blue-500 h-3"></div>
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">Weekend Focus Sprint</h3>
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Starting Tomorrow</span>
          </div>
          <p class="text-gray-600 mb-4">Compete with the community to accumulate the most focus minutes in a weekend. Top 3 winners receive exclusive mythical creatures!</p>
          <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
              <i class="far fa-clock mr-1"></i> 48 hours
            </div>
            <div class="text-sm text-gray-500">
              <i class="fas fa-users mr-1"></i> 86 participants
            </div>
            <button class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-opacity-90 transition">
              Join Challenge
            </button>
          </div>
        </div>
      </div>
      
      <!-- Challenge Card 2 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3"></div>
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">30-Day Streak Challenge</h3>
            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Ongoing</span>
          </div>
          <p class="text-gray-600 mb-4">Maintain a daily focus streak for 30 days to unlock an exclusive habitat and earn conservation impact points.</p>
          <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
              <i class="far fa-calendar-alt mr-1"></i> 30 days
            </div>
            <div class="text-sm text-gray-500">
              <i class="fas fa-users mr-1"></i> 215 participants
            </div>
            <button class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-opacity-90 transition">
              Join Challenge
            </button>
          </div>
        </div>
      </div>
      
      <!-- Challenge Card 3 -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
        <div class="bg-gradient-to-r from-yellow-500 to-red-500 h-3"></div>
        <div class="p-6">
          <div class="flex justify-between items-start mb-4">
            <h3 class="text-xl font-bold">Conservation Impact Challenge</h3>
            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Starts in 3 days</span>
          </div>
          <p class="text-gray-600 mb-4">Contribute to real-world conservation efforts through your focus time. Every minute counts towards saving endangered species!</p>
          <div class="flex justify-between items-center">
            <div class="text-sm text-gray-500">
              <i class="far fa-calendar-alt mr-1"></i> 14 days
            </div>
            <div class="text-sm text-gray-500">
              <i class="fas fa-users mr-1"></i> 42 participants
            </div>
            <button class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-opacity-90 transition">
              Join Challenge
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Global Statistics -->
<section class="bg-primary text-white py-12">
  <div class="container mx-auto px-4">
    <h2 class="text-2xl font-display font-bold mb-8 text-center">Global Impact</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div class="text-center">
        <div class="text-4xl font-bold mb-2">14,586,320</div>
        <p class="text-gray-200">Focus Minutes Today</p>
      </div>
      
      <div class="text-center">
        <div class="text-4xl font-bold mb-2">245,738</div>
        <p class="text-gray-200">Creatures Raised</p>
      </div>
      
      <div class="text-center">
        <div class="text-4xl font-bold mb-2">42,586</div>
        <p class="text-gray-200">Trees Planted</p>
      </div>
      
      <div class="text-center">
        <div class="text-4xl font-bold mb-2">8,450</div>
        <p class="text-gray-200">Hectares Protected</p>
      </div>
    </div>
    
    <div class="mt-12 text-center">
      <a href="<?= $baseUrl ?>/conservation" class="inline-flex items-center bg-white text-primary px-6 py-3 rounded-full font-medium hover:bg-gray-100 transition">
        <i class="fas fa-leaf mr-2"></i> Learn About Our Conservation Efforts
      </a>
    </div>
  </div>
</section>

<!-- User Profile Modal (Hidden by default) -->
<div id="userProfileModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
  <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full mx-4 overflow-hidden">
    <div class="bg-primary h-24 relative">
      <button id="closeProfileModal" class="absolute top-4 right-4 text-white hover:text-gray-200">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>
    
    <div class="px-6 py-8 -mt-12">
      <div class="flex flex-col md:flex-row">
        <!-- User Info -->
        <div class="text-center md:text-left md:flex-shrink-0 mb-6 md:mb-0 md:mr-8">
          <div class="w-24 h-24 rounded-full bg-white border-4 border-white shadow-md overflow-hidden mx-auto md:mx-0">
            <img src="<?= $baseUrl ?>/assets/images/avatars/user1.jpg" alt="User Profile" class="w-full h-full object-cover">
          </div>
          <h3 class="text-xl font-bold mt-3">FocusMaster</h3>
          <p class="text-gray-600 text-sm">Joined January 2025</p>
          <div class="mt-2 flex flex-wrap justify-center md:justify-start gap-1">
            <span class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full">Focus Master</span>
            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">30d Streak</span>
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Conservation Hero</span>
          </div>
          <div class="mt-4">
            <button class="px-4 py-2 bg-primary text-white rounded-md text-sm font-medium hover:bg-opacity-90 transition w-full">
              <i class="fas fa-user-plus mr-1"></i> Add Friend
            </button>
          </div>
        </div>
        
        <!-- User Stats -->
        <div class="flex-grow">
          <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-2xl font-bold text-primary">5,120</div>
              <p class="text-sm text-gray-600">Focus Score</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-2xl font-bold text-primary">18</div>
              <p class="text-sm text-gray-600">Creatures</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-2xl font-bold text-primary">30</div>
              <p class="text-sm text-gray-600">Day Streak</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-2xl font-bold text-primary">125</div>
              <p class="text-sm text-gray-600">Trees Planted</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-2xl font-bold text-primary">84h</div>
              <p class="text-sm text-gray-600">Total Focus</p>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg text-center">
              <div class="text-2xl font-bold text-primary">12</div>
              <p class="text-sm text-gray-600">Achievements</p>
            </div>
          </div>
          
          <!-- Focus Progress Chart -->
          <div class="bg-gray-50 p-4 rounded-lg mb-4">
            <h4 class="font-medium mb-3">Focus Progress (Last 7 Days)</h4>
            <div class="h-40 bg-white rounded-md p-2">
              <!-- Placeholder for chart - would be implemented with a library like Chart.js -->
              <div class="flex items-end h-32 pt-4">
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 40%"></div>
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 60%"></div>
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 45%"></div>
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 75%"></div>
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 65%"></div>
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 90%"></div>
                <div class="bg-primary w-full mx-1 rounded-t-sm" style="height: 80%"></div>
              </div>
              <div class="flex justify-between text-xs text-gray-500 mt-1">
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
                <div>Sun</div>
              </div>
            </div>
          </div>
          
          <!-- Top Creatures -->
          <div>
            <h4 class="font-medium mb-3">Top Creatures</h4>
            <div class="grid grid-cols-3 gap-2">
              <div class="bg-white border border-gray-200 rounded-md p-2 text-center hover:shadow-md transition cursor-pointer">
                <div class="h-12 w-12 mx-auto mb-1">
                  <img src="<?= $baseUrl ?>/assets/images/creatures/creature1.png" alt="Creature" class="w-full h-full object-contain">
                </div>
                <p class="text-xs font-medium truncate">Phoenix</p>
                <p class="text-xs text-gray-500">Mythical</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-md p-2 text-center hover:shadow-md transition cursor-pointer">
                <div class="h-12 w-12 mx-auto mb-1">
                  <img src="<?= $baseUrl ?>/assets/images/creatures/creature2.png" alt="Creature" class="w-full h-full object-contain">
                </div>
                <p class="text-xs font-medium truncate">Sea Dragon</p>
                <p class="text-xs text-gray-500">Mythical</p>
              </div>
              <div class="bg-white border border-gray-200 rounded-md p-2 text-center hover:shadow-md transition cursor-pointer">
                <div class="h-12 w-12 mx-auto mb-1">
                  <img src="<?= $baseUrl ?>/assets/images/creatures/creature3.png" alt="Creature" class="w-full h-full object-contain">
                </div>
                <p class="text-xs font-medium truncate">Spirit Fox</p>
                <p class="text-xs text-gray-500">Legendary</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="px-6 pb-6 flex justify-end">
      <button id="closeProfileButton" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-medium hover:bg-gray-300 transition">
        Close
      </button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Modal Functionality
    const modal = document.getElementById('userProfileModal');
    const closeModalButton = document.getElementById('closeProfileModal');
    const closeProfileButton = document.getElementById('closeProfileButton');
    
    // Open modal when clicking on usernames or avatars
    const userElements = document.querySelectorAll('tr');
    userElements.forEach(row => {
      if (!row.classList.contains('bg-yellow-50')) { // Don't open modal for current user
        row.addEventListener('click', function() {
          modal.classList.remove('hidden');
          document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
      }
    });
    
    // Close modal functions
    function closeModal() {
      modal.classList.add('hidden');
      document.body.style.overflow = '';
    }
    
    closeModalButton.addEventListener('click', closeModal);
    closeProfileButton.addEventListener('click', closeModal);
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
      if (e.target === modal) {
        closeModal();
      }
    });
    
    // Time period tabs
    const timeButtons = document.querySelectorAll('button[class*="px-6 py-2"]');
    timeButtons.forEach(button => {
      button.addEventListener('click', function() {
        // Remove primary class from all buttons
        timeButtons.forEach(btn => {
          btn.classList.remove('bg-primary', 'text-white');
          btn.classList.add('bg-white', 'border', 'border-gray-300', 'hover:bg-gray-100');
        });
        
        // Add primary class to clicked button
        this.classList.remove('bg-white', 'border', 'border-gray-300', 'hover:bg-gray-100');
        this.classList.add('bg-primary', 'text-white');
      });
    });
    
    // Animation for rank changes
    function animateRankChanges() {
      const rows = document.querySelectorAll('tr');
      rows.forEach(row => {
        // Random animation to simulate rank changes
        if (Math.random() > 0.8) {
          const rankIndicator = document.createElement('div');
          rankIndicator.classList.add('text-xs', 'font-medium', 'ml-1');
          
          if (Math.random() > 0.5) {
            // Up animation
            rankIndicator.classList.add('text-green-600');
            rankIndicator.innerHTML = '<i class="fas fa-arrow-up"></i> 1';
            row.classList.add('animate-pulse');
            
            setTimeout(() => {
              row.classList.remove('animate-pulse');
            }, 1000);
          } else {
            // Down animation
            rankIndicator.classList.add('text-red-600');
            rankIndicator.innerHTML = '<i class="fas fa-arrow-down"></i> 1';
            row.classList.add('animate-pulse');
            
            setTimeout(() => {
              row.classList.remove('animate-pulse');
            }, 1000);
          }
          
          // Add then remove the indicator after a few seconds
          const rankCell = row.querySelector('td:first-child div');
          if (rankCell) {
            rankCell.appendChild(rankIndicator);
            
            setTimeout(() => {
              rankIndicator.remove();
            }, 3000);
          }
        }
      });
    }
    
    // Simulate occasional rank changes
    setInterval(animateRankChanges, 30000);
  });
</script>

<?php include ROOT_PATH . '/resources/views/layouts/footer.php'; ?>