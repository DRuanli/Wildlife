<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
include('public/loading-component.php');
?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Focus History</h1>
        <div class="flex flex-wrap gap-2">
            <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition">
                <i class="fas fa-clock mr-2"></i> Start New Session
            </a>
            <button id="export-data" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">
                <i class="fas fa-download mr-2"></i> Export Data
            </button>
        </div>
    </div>
    
    <!-- Stats Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Focus Time -->
        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                    <i class="fas fa-hourglass-half text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Focus Time</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= floor($userStats['total_minutes'] / 60) ?> hrs <?= $userStats['total_minutes'] % 60 ?> mins
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Sessions Completed -->
        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Sessions Completed</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= $userStats['total_sessions'] ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Current Streak -->
        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                    <i class="fas fa-fire text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Current Streak</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= $userStats['streak_days'] ?> day<?= $userStats['streak_days'] !== 1 ? 's' : '' ?>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Average Focus Score -->
        <div class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Avg. Focus Score</p>
                    <p class="text-xl font-bold text-gray-800">
                        <?= round($userStats['avg_focus_score']) ?>%
                    </p>
                </div>
                
                <!-- Status Donut Chart -->
                <div class="tab-panel hidden" id="status">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="mb-3 text-center">
                                <p class="text-sm text-gray-500">Session status distribution</p>
                            </div>
                            <div class="h-72 flex items-center justify-center">
                                <canvas id="statusDonutChart"></canvas>
                            </div>
                        </div>
                        <div class="flex flex-col justify-center">
                            <h3 class="font-medium text-lg mb-3">Status Breakdown</h3>
                            <div id="status-stats" class="space-y-4">
                                <!-- Status stats will be filled dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Lollipop Chart -->
                <div class="tab-panel hidden" id="lollipop">
                    <div class="mb-3 text-center">
                        <p class="text-sm text-gray-500">Session duration by status (most recent 30 sessions)</p>
                    </div>
                    <div class="h-72 mb-4">
                        <div id="lollipopContainer" class="w-full h-full"></div>
                    </div>
                    <div class="flex justify-center gap-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-1"></div>
                            <span>Completed</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mr-1"></div>
                            <span>In Progress</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-1"></div>
                            <span>Cancelled</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Panel -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-bold">Focus Analytics</h2>
        </div>
        
        <div class="p-6">
            <!-- Quick Date Selectors -->
            <div class="flex flex-wrap gap-2 mb-6">
                <button data-range="7" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">Last 7 days</button>
                <button data-range="14" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">Last 14 days</button>
                <button data-range="30" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">Last 30 days</button>
                <button data-range="90" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">Last 90 days</button>
                <button data-range="month" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">This Month</button>
                <button data-range="last-month" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">Last Month</button>
                <button data-range="year" class="quick-range px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-full text-sm transition">This Year</button>
            </div>
            
            <!-- Custom Date Range & Filters -->
            <form id="date-range-form" class="md:flex items-end mb-6 space-y-4 md:space-y-0 md:space-x-6">
                <div class="md:flex-1 space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Date Range</label>
                    <div class="flex items-center space-x-2">
                        <div class="flex-1">
                            <label for="start_date" class="sr-only">From</label>
                            <input type="date" id="start_date" name="start_date" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" value="<?= $startDate ?>">
                        </div>
                        <span class="text-gray-500">to</span>
                        <div class="flex-1">
                            <label for="end_date" class="sr-only">To</label>
                            <input type="date" id="end_date" name="end_date" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" value="<?= $endDate ?>">
                        </div>
                    </div>
                </div>
                
                <div class="md:w-48">
                    <label for="duration_filter" class="block text-sm font-medium text-gray-700">Duration</label>
                    <select id="duration_filter" name="duration_filter" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Sessions</option>
                        <option value="short">Short (< 15 min)</option>
                        <option value="medium">Medium (15-30 min)</option>
                        <option value="long">Long (> 30 min)</option>
                    </select>
                </div>
                
                <div class="md:w-48">
                    <label for="score_filter" class="block text-sm font-medium text-gray-700">Focus Score</label>
                    <select id="score_filter" name="score_filter" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Scores</option>
                        <option value="high">High (80-100%)</option>
                        <option value="medium">Medium (60-79%)</option>
                        <option value="low">Low (< 60%)</option>
                    </select>
                </div>
                
                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-filter mr-2"></i> Apply Filters
                    </button>
                </div>
            </form>
            
            <!-- Insights Panel (AI-generated) -->
            <div class="mb-6 bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg p-4 border border-blue-100">
                <h3 class="text-lg font-medium text-indigo-800 mb-2 flex items-center">
                    <i class="fas fa-lightbulb text-yellow-500 mr-2"></i> Focus Insights
                </h3>
                <div class="text-sm text-gray-700 space-y-2">
                    <?php
                    // Generate some basic insights based on the data
                    $insights = [];
                    
                    // Best days
                    $bestDays = [];
                    $dayTotals = [];
                    foreach ($dailyFocusTime as $day) {
                        $date = new DateTime($day['date']);
                        $dayOfWeek = $date->format('N'); // 1 for Monday, 7 for Sunday
                        if (!isset($dayTotals[$dayOfWeek])) {
                            $dayTotals[$dayOfWeek] = ['total' => 0, 'count' => 0];
                        }
                        $dayTotals[$dayOfWeek]['total'] += $day['total_minutes'];
                        $dayTotals[$dayOfWeek]['count']++;
                    }
                    
                    $bestAvg = 0;
                    $bestDay = '';
                    
                    $dayNames = ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    
                    foreach ($dayTotals as $day => $data) {
                        if ($data['count'] > 0) {
                            $avg = $data['total'] / $data['count'];
                            if ($avg > $bestAvg) {
                                $bestAvg = $avg;
                                $bestDay = $dayNames[$day];
                            }
                        }
                    }
                    
                    if ($bestDay) {
                        $insights[] = "<span class='font-medium'>Your most productive day</span> appears to be <span class='text-indigo-700 font-medium'>{$bestDay}</span> with an average of " . round($bestAvg) . " minutes of focus.";
                    }
                    
                    // Streak insights
                    if ($userStats['streak_days'] > 7) {
                        $insights[] = "<span class='font-medium'>Amazing consistency!</span> Your current streak of {$userStats['streak_days']} days shows your commitment to regular focus practice.";
                    } elseif ($userStats['streak_days'] > 3) {
                        $insights[] = "You're building good momentum with a <span class='font-medium'>{$userStats['streak_days']}-day streak</span>. Keep it up!";
                    }
                    
                    // Focus score insights
                    if ($userStats['avg_focus_score'] >= 80) {
                        $insights[] = "Your average focus score of " . round($userStats['avg_focus_score']) . "% is excellent! You're maintaining high-quality focus during your sessions.";
                    } elseif ($userStats['avg_focus_score'] >= 60) {
                        $insights[] = "Your average focus score of " . round($userStats['avg_focus_score']) . "% is good. Try using the breathing exercises before sessions to improve further.";
                    } else {
                        $insights[] = "Consider shorter but more frequent focus sessions to improve your average focus score of " . round($userStats['avg_focus_score']) . "%.";
                    }
                    
                    // Recent trend
                    if (count($dailyFocusTime) >= 7) {
                        $recent = array_slice($dailyFocusTime, -7);
                        $recentTotal = array_sum(array_column($recent, 'total_minutes'));
                        $recentAvg = $recentTotal / 7;
                        
                        $older = array_slice($dailyFocusTime, -14, 7);
                        if (count($older) > 0) {
                            $olderTotal = array_sum(array_column($older, 'total_minutes'));
                            $olderAvg = $olderTotal / count($older);
                            
                            $percentChange = (($recentAvg - $olderAvg) / $olderAvg) * 100;
                            if ($percentChange > 20) {
                                $insights[] = "<span class='text-green-600 font-medium'>Your focus time is trending up!</span> You've improved by " . round($percentChange) . "% in the last week.";
                            } elseif ($percentChange < -20) {
                                $insights[] = "<span class='text-yellow-600 font-medium'>Your focus time has decreased</span> by " . round(abs($percentChange)) . "% in the last week. Is something disrupting your routine?";
                            }
                        }
                    }
                    
                    // Display insights or a default message
                    if (empty($insights)) {
                        echo "<p>Complete more focus sessions to receive personalized insights about your habits and patterns.</p>";
                    } else {
                        // Display random 2-3 insights
                        shuffle($insights);
                        $displayCount = min(3, count($insights));
                        for ($i = 0; $i < $displayCount; $i++) {
                            echo "<p>· {$insights[$i]}</p>";
                        }
                    }
                    ?>
                </div>
            </div>
            
            <!-- Chart Tabs -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="chartTabs" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 active-tab" id="daily-tab" type="button" role="tab" aria-controls="daily" aria-selected="true">
                            <i class="fas fa-calendar-day mr-2"></i>Daily Focus
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="heatmap-tab" type="button" role="tab" aria-controls="heatmap" aria-selected="false">
                            <i class="fas fa-th mr-2"></i>Calendar Heatmap
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="hourly-tab" type="button" role="tab" aria-controls="hourly" aria-selected="false">
                            <i class="fas fa-clock mr-2"></i>Time of Day
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="candlestick-tab" type="button" role="tab" aria-controls="candlestick" aria-selected="false">
                            <i class="fas fa-chart-line mr-2"></i>Focus Trends
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="status-tab" type="button" role="tab" aria-controls="status" aria-selected="false">
                            <i class="fas fa-chart-pie mr-2"></i>Status Overview
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="lollipop-tab" type="button" role="tab" aria-controls="lollipop" aria-selected="false">
                            <i class="fas fa-circle mr-2"></i>Duration Analysis
                        </button>
                    </li>
                </ul>
            </div>
            
            <!-- Chart Content -->
            <div id="chartTabContent">
                <!-- Daily Focus Chart -->
                <div class="tab-panel" id="daily">
                    <div class="h-72 mb-4">
                        <canvas id="focusChart"></canvas>
                    </div>
                    
                    <!-- Chart Legend -->
                    <div class="flex items-center justify-center space-x-8">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-indigo-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Minutes of Focus</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Number of Sessions</span>
                        </div>
                    </div>
                </div>
                
                <!-- Calendar Heatmap -->
                <div class="tab-panel hidden" id="heatmap">
                    <div class="mb-3 text-center">
                        <p class="text-sm text-gray-500">Focus minutes per day over time</p>
                    </div>
                    <div class="h-64 mb-4">
                        <div id="heatmapContainer" class="w-full h-full"></div>
                    </div>
                    <div class="flex justify-center items-center space-x-1 mt-4">
                        <span class="text-xs text-gray-600">Less</span>
                        <div class="w-4 h-4 bg-blue-100"></div>
                        <div class="w-4 h-4 bg-blue-200"></div>
                        <div class="w-4 h-4 bg-blue-300"></div>
                        <div class="w-4 h-4 bg-blue-400"></div>
                        <div class="w-4 h-4 bg-blue-500"></div>
                        <div class="w-4 h-4 bg-blue-600"></div>
                        <div class="w-4 h-4 bg-blue-700"></div>
                        <span class="text-xs text-gray-600">More</span>
                    </div>
                </div>
                
                <!-- Time of Day Chart -->
                <div class="tab-panel hidden" id="hourly">
                    <div class="mb-3 text-center">
                        <p class="text-sm text-gray-500">When you focus throughout the day</p>
                    </div>
                    <div class="h-72 mb-4">
                        <canvas id="hourlyChart"></canvas>
                    </div>
                    <div class="flex justify-center text-sm text-gray-600">
                        This chart shows your most productive hours based on when you start focus sessions
                    </div>
                </div>
                
                <!-- Candlestick Chart -->
                <div class="tab-panel hidden" id="candlestick">
                    <div class="mb-3 text-center">
                        <p class="text-sm text-gray-500">Daily focus score and duration trends</p>
                    </div>
                    <div class="h-72 mb-4">
                        <canvas id="candlestickChart"></canvas>
                    </div>
                    <div class="flex justify-center text-sm text-gray-600">
                        <div class="mr-4 flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-sm mr-1"></div>
                            <span>Increasing trend</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-sm mr-1"></div>
                            <span>Decreasing trend</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Session History Table Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
            <h2 class="text-xl font-bold">Session History</h2>
            <div class="flex items-center">
                <div class="relative mr-2">
                    <select id="session-page-size" class="block w-full pl-3 pr-10 py-1 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-white text-gray-700">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                        <option value="100">100 per page</option>
                    </select>
                </div>
                <div class="relative">
                    <input type="text" id="session-search" placeholder="Search..." class="block w-full pl-3 pr-10 py-1 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md bg-white text-gray-700">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <?php if (empty($sessions)): ?>
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                        <i class="fas fa-history text-2xl"></i>
                    </div>
                    <h3 class="text-gray-700 font-medium mb-2">No sessions found</h3>
                    <p class="text-gray-500 mb-4">No focus sessions were found for the selected date range.</p>
                </div>
            <?php else: ?>
                <!-- Mobile Session Cards (visible on small screens) -->
                <div class="md:hidden space-y-4 mb-4">
                    <?php foreach ($sessions as $index => $session): 
                        if ($index >= 10) break; // Show only first 10 on mobile by default
                    ?>
                        <div class="session-card border rounded-lg overflow-hidden bg-white hover:shadow-md transition">
                            <div class="p-3 border-b flex justify-between items-center <?= $session['completed'] ? 'bg-green-50' : ($session['end_time'] === null ? 'bg-blue-50' : 'bg-red-50') ?>">
                                <div class="font-medium text-gray-800">
                                    <?= date('M j, Y', strtotime($session['start_time'])) ?>
                                </div>
                                <div>
                                    <?php if ($session['end_time'] === null): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            In Progress
                                        </span>
                                    <?php elseif ($session['completed']): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Cancelled
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="p-3">
                                <div class="grid grid-cols-2 gap-2 mb-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Time</p>
                                        <p class="text-sm"><?= date('g:i A', strtotime($session['start_time'])) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Duration</p>
                                        <p class="text-sm"><?= $session['duration_minutes'] ?> mins</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Focus Score</p>
                                        <?php if ($session['focus_score']): ?>
                                            <div class="flex items-center">
                                                <div class="h-2 w-16 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full 
                                                        <?php
                                                        $score = $session['focus_score'];
                                                        if ($score >= 80) echo 'bg-green-500';
                                                        else if ($score >= 60) echo 'bg-blue-500';
                                                        else if ($score >= 40) echo 'bg-yellow-500';
                                                        else echo 'bg-red-500';
                                                        ?>
                                                    " style="width: <?= $score ?>%"></div>
                                                </div>
                                                <span class="ml-1 text-xs"><?= $score ?>%</span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400">--</span>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Coins</p>
                                        <?php if ($session['coins_earned']): ?>
                                            <p class="text-sm text-yellow-600">
                                                <?= $session['coins_earned'] ?> <i class="fas fa-coins text-xs"></i>
                                            </p>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400">--</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($session['completed']): ?>
                                    <a href="<?= $baseUrl ?>/focus/summary/<?= $session['id'] ?>" class="block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm">
                                        View Summary
                                    </a>
                                <?php elseif ($session['end_time'] === null): ?>
                                    <a href="<?= $baseUrl ?>/focus" class="block w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm">
                                        Return to Session
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($sessions) > 10): ?>
                        <button id="load-more-mobile" class="w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm">
                            Load More
                        </button>
                    <?php endif; ?>
                </div>
                
                <!-- Desktop Table (hidden on small screens) -->
                <div class="hidden md:block overflow-x-auto">
                    <table id="sessions-table" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="date">
                                    Date <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="time">
                                    Time <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="duration">
                                    Duration <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="status">
                                    Status <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="score">
                                    Focus Score <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" data-sort="coins">
                                    Coins <i class="fas fa-sort ml-1"></i>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sessions-table-body" class="bg-white divide-y divide-gray-200">
                            <?php foreach ($sessions as $session): ?>
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-date="<?= strtotime($session['start_time']) ?>">
                                        <?= date('M j, Y', strtotime($session['start_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-time="<?= strtotime($session['start_time']) ?>">
                                        <?= date('g:i A', strtotime($session['start_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-duration="<?= $session['duration_minutes'] ?>">
                                        <?= $session['duration_minutes'] ?> mins
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" data-status="<?= $session['end_time'] === null ? 'in_progress' : ($session['completed'] ? 'completed' : 'cancelled') ?>">
                                        <?php if ($session['end_time'] === null): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                In Progress
                                            </span>
                                        <?php elseif ($session['completed']): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Completed
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Cancelled
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" data-score="<?= $session['focus_score'] ?? 0 ?>">
                                        <?php if ($session['focus_score']): ?>
                                            <div class="flex items-center">
                                                <div class="h-2 w-24 bg-gray-200 rounded-full overflow-hidden">
                                                    <div class="h-full 
                                                        <?php
                                                        $score = $session['focus_score'];
                                                        if ($score >= 80) echo 'bg-green-500';
                                                        else if ($score >= 60) echo 'bg-blue-500';
                                                        else if ($score >= 40) echo 'bg-yellow-500';
                                                        else echo 'bg-red-500';
                                                        ?>
                                                    " style="width: <?= $score ?>%"></div>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-600"><?= $score ?>%</span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-400">--</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-coins="<?= $session['coins_earned'] ?? 0 ?>">
                                        <?php if ($session['coins_earned']): ?>
                                            <span class="text-yellow-600">
                                                <?= $session['coins_earned'] ?> <i class="fas fa-coins"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-gray-400">--</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php if ($session['completed']): ?>
                                            <a href="<?= $baseUrl ?>/focus/summary/<?= $session['id'] ?>" class="text-indigo-600 hover:text-indigo-900">
                                                View Summary
                                            </a>
                                        <?php elseif ($session['end_time'] === null): ?>
                                            <a href="<?= $baseUrl ?>/focus" class="text-indigo-600 hover:text-indigo-900">
                                                Return to Session
                                            </a>
                                        <?php else: ?>
                                            <span class="text-gray-400">--</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-gray-500">
                        Showing <span id="showing-start">1</span> to <span id="showing-end">10</span> of <span id="showing-total"><?= count($sessions) ?></span> sessions
                    </div>
                    <div class="flex space-x-2">
                        <button id="prev-page" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md disabled:opacity-50">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div id="pagination-numbers" class="flex space-x-2">
                            <!-- Pagination numbers will be inserted here -->
                        </div>
                        <button id="next-page" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md disabled:opacity-50">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="export-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Export Focus History</h3>
            <p class="mb-4 text-sm text-gray-600">Choose your export format and date range:</p>
            
            <form id="export-form">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="export-format" value="csv" class="h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2">CSV</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="export-format" value="excel" class="h-4 w-4 text-indigo-600">
                            <span class="ml-2">Excel</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="export-format" value="json" class="h-4 w-4 text-indigo-600">
                            <span class="ml-2">JSON</span>
                        </label>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">From</label>
                            <input type="date" id="export-start-date" name="export-start-date" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" value="<?= $startDate ?>">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">To</label>
                            <input type="date" id="export-end-date" name="export-end-date" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500" value="<?= $endDate ?>">
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Include</label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="export-include-sessions" class="h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2 text-sm">Sessions</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="export-include-daily" class="h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2 text-sm">Daily Summary</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="export-include-summary" class="h-4 w-4 text-indigo-600" checked>
                            <span class="ml-2 text-sm">Overall Statistics</span>
                        </label>
                    </div>
                </div>
            </form>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button id="cancel-export" class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </button>
                <button id="confirm-export" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Export Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js and other required libraries -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment"></script>
<script src="https://cdn.jsdelivr.net/npm/d3@7"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ----------------------------------------
    // Chart Initialization
    // ----------------------------------------
    
    // Format data for daily chart
    const dailyFocusData = <?= json_encode($dailyFocusTime) ?>;
    
    function initializeDailyChart() {
        const ctx = document.getElementById('focusChart').getContext('2d');
        
        // Format data for the chart
        const labels = [];
        const focusMinutes = [];
        const sessionCounts = [];
        
        dailyFocusData.forEach(day => {
            labels.push(moment(day.date).format('MMM D'));
            focusMinutes.push(parseInt(day.total_minutes));
            sessionCounts.push(parseInt(day.session_count));
        });
        
        // Create the chart
        window.focusChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Minutes of Focus',
                        data: focusMinutes,
                        backgroundColor: 'rgba(79, 70, 229, 0.7)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Number of Sessions',
                        data: sessionCounts,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1,
                        type: 'line',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Minutes'
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Sessions'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            footer: function(tooltipItems) {
                                const dayData = dailyFocusData[tooltipItems[0].dataIndex];
                                if (dayData && dayData.date) {
                                    return '\nDate: ' + moment(dayData.date).format('dddd, MMMM D, YYYY');
                                }
                                return '';
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Initialize calendar heatmap visualization
    function initializeCalendarHeatmap() {
        const container = document.getElementById('heatmapContainer');
        if (!container) return;
        
        // Clear previous visualization if any
        container.innerHTML = '';
        
        // Prepare data
        const heatmapData = dailyFocusData.map(day => ({
            date: new Date(day.date),
            value: parseInt(day.total_minutes)
        }));
        
        // Find date range
        const dates = heatmapData.map(d => d.date);
        const minDate = dates.length ? new Date(Math.min.apply(null, dates)) : new Date();
        const maxDate = dates.length ? new Date(Math.max.apply(null, dates)) : new Date();
        
        // Ensure we have a reasonable date range (at least 3 months)
        let startDate = new Date(minDate);
        startDate.setDate(1); // Start at the beginning of the month
        
        let endDate = new Date(maxDate);
        // Go to the end of the month
        endDate.setMonth(endDate.getMonth() + 1);
        endDate.setDate(0);
        
        // Ensure we have at least 3 months of context
        if ((endDate - startDate) < (90 * 24 * 60 * 60 * 1000)) {
            startDate = new Date(endDate);
            startDate.setMonth(startDate.getMonth() - 2);
            startDate.setDate(1);
        }
        
        // Calendar dimensions
        const cellSize = 14;
        const cellMargin = 2;
        const weekdays = 7;
        const width = container.clientWidth;
        
        // Calculate number of weeks to display
        const totalDays = Math.round((endDate - startDate) / (24 * 60 * 60 * 1000));
        const totalWeeks = Math.ceil(totalDays / 7);
        
        // Calculate height based on 7 days of the week
        const height = (cellSize + cellMargin) * weekdays + 30; // Add space for labels
        
        // Create SVG element
        const svg = d3.select(container)
            .append('svg')
            .attr('width', width)
            .attr('height', height)
            .attr('class', 'calendar-heatmap');
        
        // Maximum value for color intensity
        const maxValue = d3.max(heatmapData, d => d.value) || 120;
        
        // Color scale for heatmap
        const colorScale = d3.scaleSequential()
            .domain([0, maxValue])
            .interpolator(d3.interpolateBlues);
        
        // Create a lookup map for easy data access
        const dataByDate = {};
        heatmapData.forEach(d => {
            dataByDate[d.date.toISOString().substring(0, 10)] = d.value;
        });
        
        // Generate calendar data
        const calendarData = [];
        let currentDate = new Date(startDate);
        
        while (currentDate <= endDate) {
            const dateKey = currentDate.toISOString().substring(0, 10);
            calendarData.push({
                date: new Date(currentDate),
                value: dataByDate[dateKey] || 0
            });
            currentDate.setDate(currentDate.getDate() + 1);
        }
        
        // Calculate the number of columns (weeks)
        const weeks = Math.ceil(calendarData.length / 7);
        
        // Create a scale for the X axis (weeks)
        const xScale = d3.scaleLinear()
            .domain([0, weeks])
            .range([cellSize, width - cellSize]);
        
        // Create a scale for the Y axis (days of week)
        const yScale = d3.scaleBand()
            .domain([0, 1, 2, 3, 4, 5, 6]) // 0 = Sunday, 6 = Saturday
            .range([cellSize, 7 * (cellSize + cellMargin)]);
        
        // Helper to get the week offset from start date
        function getWeekOffset(date) {
            return Math.floor((date - startDate) / (7 * 24 * 60 * 60 * 1000));
        }
        
        // Add day labels
        const dayLabels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        svg.selectAll('.day-label')
            .data(dayLabels)
            .enter()
            .append('text')
            .attr('class', 'day-label')
            .attr('x', 0)
            .attr('y', (d, i) => cellSize + i * (cellSize + cellMargin))
            .attr('dy', '0.35em')
            .attr('text-anchor', 'start')
            .attr('font-size', '9px')
            .attr('fill', '#888')
            .text(d => d.substring(0, 1));
        
        // Draw calendar cells
        svg.selectAll('.day-cell')
            .data(calendarData)
            .enter()
            .append('rect')
            .attr('class', 'day-cell')
            .attr('width', cellSize)
            .attr('height', cellSize)
            .attr('rx', 2)
            .attr('ry', 2)
            .attr('x', d => {
                const dayOfWeek = d.date.getDay(); // 0 = Sunday, 6 = Saturday
                const weekOffset = getWeekOffset(d.date);
                return cellSize * 1.5 + weekOffset * (cellSize + cellMargin);
            })
            .attr('y', d => {
                const dayOfWeek = d.date.getDay(); // 0 = Sunday, 6 = Saturday
                return cellSize + dayOfWeek * (cellSize + cellMargin);
            })
            .attr('fill', d => d.value > 0 ? colorScale(d.value) : '#eee')
            .style('stroke', '#fff')
            .style('stroke-width', 1)
            .append('title')
            .text(d => {
                const dateStr = d.date.toLocaleDateString();
                const minutes = d.value;
                const hours = Math.floor(minutes / 60);
                const mins = minutes % 60;
                
                let timeStr = "";
                if (hours > 0) timeStr += `${hours}h `;
                if (mins > 0 || hours === 0) timeStr += `${mins}m`;
                
                return `${dateStr}: ${timeStr}`;
            });
        
        // Add month labels
        const monthLabels = [];
        let currentMonth = -1;
        
        calendarData.forEach(d => {
            const month = d.date.getMonth();
            const year = d.date.getFullYear();
            const monthYear = `${month}-${year}`;
            
            if (!monthLabels.some(ml => ml.monthYear === monthYear)) {
                monthLabels.push({
                    date: new Date(d.date),
                    month,
                    year,
                    monthYear
                });
            }
        });
        
        svg.selectAll('.month-label')
            .data(monthLabels)
            .enter()
            .append('text')
            .attr('class', 'month-label')
            .attr('x', d => {
                const weekOffset = getWeekOffset(d.date);
                return cellSize * 1.5 + weekOffset * (cellSize + cellMargin);
            })
            .attr('y', cellSize / 2)
            .attr('text-anchor', 'start')
            .attr('font-size', '10px')
            .attr('font-weight', 'bold')
            .attr('fill', '#666')
            .text(d => {
                const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return `${monthNames[d.month]} ${d.year}`;
            });
    }
    
    // Initialize time of day chart
    function initializeHourlyChart() {
        // Extract start times from session data
        const sessions = <?= json_encode($sessions) ?>;
        const hourCounts = Array(24).fill(0);
        
        // Count sessions starting in each hour
        sessions.forEach(session => {
            const startHour = new Date(session.start_time).getHours();
            hourCounts[startHour]++;
        });
        
        // Create chart
        const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');
        
        new Chart(hourlyCtx, {
            type: 'bar',
            data: {
                labels: Array.from({length: 24}, (_, i) => {
                    // Format as 12-hour time
                    const hour = i % 12 || 12;
                    const ampm = i < 12 ? 'AM' : 'PM';
                    return `${hour} ${ampm}`;
                }),
                datasets: [{
                    label: 'Focus Sessions',
                    data: hourCounts,
                    backgroundColor: (context) => {
                        const index = context.dataIndex;
                        
                        // Morning
                        if (index >= 5 && index < 12) {
                            return 'rgba(252, 211, 77, 0.7)'; // Yellow
                        }
                        // Afternoon
                        else if (index >= 12 && index < 17) {
                            return 'rgba(245, 158, 11, 0.7)'; // Amber
                        }
                        // Evening
                        else if (index >= 17 && index < 22) {
                            return 'rgba(79, 70, 229, 0.7)'; // Indigo
                        }
                        // Night
                        else {
                            return 'rgba(31, 41, 55, 0.7)'; // Gray
                        }
                    },
                    borderColor: (context) => {
                        const index = context.dataIndex;
                        
                        if (index >= 5 && index < 12) return 'rgba(252, 211, 77, 1)';
                        else if (index >= 12 && index < 17) return 'rgba(245, 158, 11, 1)';
                        else if (index >= 17 && index < 22) return 'rgba(79, 70, 229, 1)';
                        else return 'rgba(31, 41, 55, 1)';
                    },
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Sessions'
                        },
                        ticks: {
                            stepSize: 1,
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            afterLabel: function(context) {
                                const timeRanges = [
                                    'Night (10 PM - 5 AM)',
                                    'Morning (5 AM - 12 PM)',
                                    'Afternoon (12 PM - 5 PM)',
                                    'Evening (5 PM - 10 PM)'
                                ];
                                
                                const index = context.dataIndex;
                                let timeOfDay;
                                
                                if (index >= 5 && index < 12) timeOfDay = timeRanges[1];
                                else if (index >= 12 && index < 17) timeOfDay = timeRanges[2];
                                else if (index >= 17 && index < 22) timeOfDay = timeRanges[3];
                                else timeOfDay = timeRanges[0];
                                
                                return `Time of Day: ${timeOfDay}`;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // ----------------------------------------
    // Tab Control
    // ----------------------------------------
    function setupTabControl() {
        const tabs = document.querySelectorAll('#chartTabs [role="tab"]');
        const panels = document.querySelectorAll('.tab-panel');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                tabs.forEach(t => {
                    t.classList.remove('active-tab', 'border-indigo-600', 'text-indigo-600');
                    t.classList.add('border-transparent');
                });
                
                // Add active class to clicked tab
                this.classList.add('active-tab', 'border-indigo-600', 'text-indigo-600');
                this.classList.remove('border-transparent');
                
                // Hide all panels
                panels.forEach(panel => {
                    panel.classList.add('hidden');
                });
                
                // Show corresponding panel
                const panelId = this.getAttribute('aria-controls');
                document.getElementById(panelId).classList.remove('hidden');
                
                // Initialize the specific chart if needed
                if (panelId === 'heatmap' && !window.heatmapInitialized) {
                    initializeCalendarHeatmap();
                    window.heatmapInitialized = true;
                } else if (panelId === 'hourly' && !window.hourlyChartInitialized) {
                    initializeHourlyChart();
                    window.hourlyChartInitialized = true;
                } else if (panelId === 'candlestick' && !window.candlestickChartInitialized) {
                    initializeCandlestickChart();
                    window.candlestickChartInitialized = true;
                } else if (panelId === 'status' && !window.statusChartInitialized) {
                    initializeStatusDonutChart();
                    window.statusChartInitialized = true;
                } else if (panelId === 'lollipop' && !window.lollipopChartInitialized) {
                    initializeLollipopChart();
                    window.lollipopChartInitialized = true;
                }
            });
        });
        
        // Set initial active tab
        document.getElementById('daily-tab').classList.add('active-tab', 'border-indigo-600', 'text-indigo-600');
    }
    
    // ----------------------------------------
    // Table Sorting and Filtering
    // ----------------------------------------
    let sessions = <?= json_encode($sessions) ?>;
    let filteredSessions = [...sessions];
    let sortField = 'date';
    let sortDirection = 'desc';
    let currentPage = 1;
    let pageSize = 10;
    
    // Filter sessions based on search input
    function filterSessions() {
        const searchTerm = document.getElementById('session-search').value.toLowerCase();
        const durationFilter = document.getElementById('duration_filter').value;
        const scoreFilter = document.getElementById('score_filter').value;
        
        filteredSessions = sessions.filter(session => {
            const date = new Date(session.start_time);
            const dateStr = date.toLocaleDateString();
            const timeStr = date.toLocaleTimeString();
            
            // Search filter
            const matchesSearch = searchTerm === '' ||
                dateStr.toLowerCase().includes(searchTerm) ||
                timeStr.toLowerCase().includes(searchTerm) ||
                session.duration_minutes.toString().includes(searchTerm);
            
            // Duration filter
            let matchesDuration = true;
            if (durationFilter === 'short') {
                matchesDuration = session.duration_minutes < 15;
            } else if (durationFilter === 'medium') {
                matchesDuration = session.duration_minutes >= 15 && session.duration_minutes <= 30;
            } else if (durationFilter === 'long') {
                matchesDuration = session.duration_minutes > 30;
            }
            
            // Score filter
            let matchesScore = true;
            if (scoreFilter === 'high') {
                matchesScore = session.focus_score >= 80;
            } else if (scoreFilter === 'medium') {
                matchesScore = session.focus_score >= 60 && session.focus_score < 80;
            } else if (scoreFilter === 'low') {
                matchesScore = session.focus_score < 60;
            }
            
            return matchesSearch && matchesDuration && matchesScore;
        });
        
        // Reset pagination
        currentPage = 1;
        
        // Update table with filtered and sorted data
        sortAndDisplaySessions();
        
        // Update pagination
        updatePagination();
    }
    
    // Sort sessions based on selected field and direction
    function sortSessions() {
        filteredSessions.sort((a, b) => {
            let valA, valB;
            
            switch(sortField) {
                case 'date':
                    valA = new Date(a.start_time).getTime();
                    valB = new Date(b.start_time).getTime();
                    break;
                case 'time':
                    valA = new Date(a.start_time).getHours() * 60 + new Date(a.start_time).getMinutes();
                    valB = new Date(b.start_time).getHours() * 60 + new Date(b.start_time).getMinutes();
                    break;
                case 'duration':
                    valA = a.duration_minutes;
                    valB = b.duration_minutes;
                    break;
                case 'status':
                    // Order: In Progress, Completed, Cancelled
                    valA = a.end_time === null ? 0 : (a.completed ? 1 : 2);
                    valB = b.end_time === null ? 0 : (b.completed ? 1 : 2);
                    break;
                case 'score':
                    valA = a.focus_score || 0;
                    valB = b.focus_score || 0;
                    break;
                case 'coins':
                    valA = a.coins_earned || 0;
                    valB = b.coins_earned || 0;
                    break;
                default:
                    valA = a[sortField];
                    valB = b[sortField];
            }
            
            if (sortDirection === 'asc') {
                return valA > valB ? 1 : -1;
            } else {
                return valA < valB ? 1 : -1;
            }
        });
    }
    
    // Update table display with current page of sorted sessions
    function displaySessions() {
        const tableBody = document.getElementById('sessions-table-body');
        if (!tableBody) return;
        
        tableBody.innerHTML = '';
        
        // Calculate start and end indices for current page
        const startIdx = (currentPage - 1) * pageSize;
        const endIdx = Math.min(startIdx + pageSize, filteredSessions.length);
        
        // Update the counter display
        document.getElementById('showing-start').textContent = filteredSessions.length > 0 ? startIdx + 1 : 0;
        document.getElementById('showing-end').textContent = endIdx;
        document.getElementById('showing-total').textContent = filteredSessions.length;
        
        // Display only sessions for the current page
        for (let i = startIdx; i < endIdx; i++) {
            const session = filteredSessions[i];
            
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition duration-150';
            
            const date = new Date(session.start_time);
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-date="${date.getTime()}">
                    ${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-time="${date.getHours() * 60 + date.getMinutes()}">
                    ${date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-duration="${session.duration_minutes}">
                    ${session.duration_minutes} mins
                </td>
                <td class="px-6 py-4 whitespace-nowrap" data-status="${session.end_time === null ? 'in_progress' : (session.completed ? 'completed' : 'cancelled')}">
                    ${session.end_time === null ? 
                        '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In Progress</span>' :
                        (session.completed ? 
                            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>' :
                            '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>'
                        )
                    }
                </td>
                <td class="px-6 py-4 whitespace-nowrap" data-score="${session.focus_score || 0}">
                    ${session.focus_score ? 
                        `<div class="flex items-center">
                            <div class="h-2 w-24 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full 
                                    ${session.focus_score >= 80 ? 'bg-green-500' : 
                                      session.focus_score >= 60 ? 'bg-blue-500' : 
                                      session.focus_score >= 40 ? 'bg-yellow-500' : 'bg-red-500'}
                                " style="width: ${session.focus_score}%"></div>
                            </div>
                            <span class="ml-2 text-sm text-gray-600">${session.focus_score}%</span>
                        </div>` :
                        '<span class="text-gray-400">--</span>'
                    }
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" data-coins="${session.coins_earned || 0}">
                    ${session.coins_earned ? 
                        `<span class="text-yellow-600">${session.coins_earned} <i class="fas fa-coins"></i></span>` :
                        '<span class="text-gray-400">--</span>'
                    }
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${session.completed ? 
                        `<a href="<?= $baseUrl ?>/focus/summary/${session.id}" class="text-indigo-600 hover:text-indigo-900">View Summary</a>` :
                        (session.end_time === null ? 
                            `<a href="<?= $baseUrl ?>/focus" class="text-indigo-600 hover:text-indigo-900">Return to Session</a>` :
                            '<span class="text-gray-400">--</span>'
                        )
                    }
                </td>
            `;
            
            tableBody.appendChild(row);
        }
        
        // Update mobile cards too
        updateMobileCards();
    }
    
    // Update mobile session cards
    function updateMobileCards() {
        const container = document.querySelector('.md\\:hidden.space-y-4');
        if (!container) return;
        
        container.innerHTML = '';
        
        // Calculate start and end indices for current page
        const startIdx = (currentPage - 1) * pageSize;
        const endIdx = Math.min(startIdx + pageSize, filteredSessions.length);
        
        // Display only sessions for the current page
        for (let i = startIdx; i < endIdx; i++) {
            const session = filteredSessions[i];
            const date = new Date(session.start_time);
            
            const card = document.createElement('div');
            card.className = 'session-card border rounded-lg overflow-hidden bg-white hover:shadow-md transition';
            
            const statusClass = session.end_time === null ? 'bg-blue-50' : 
                                (session.completed ? 'bg-green-50' : 'bg-red-50');
            
            const statusBadge = session.end_time === null ? 
                '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In Progress</span>' :
                (session.completed ? 
                    '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>' :
                    '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>'
                );
            
            card.innerHTML = `
                <div class="p-3 border-b flex justify-between items-center ${statusClass}">
                    <div class="font-medium text-gray-800">
                        ${date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                    </div>
                    <div>
                        ${statusBadge}
                    </div>
                </div>
                <div class="p-3">
                    <div class="grid grid-cols-2 gap-2 mb-2">
                        <div>
                            <p class="text-xs text-gray-500">Time</p>
                            <p class="text-sm">${date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Duration</p>
                            <p class="text-sm">${session.duration_minutes} mins</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Focus Score</p>
                            ${session.focus_score ? 
                                `<div class="flex items-center">
                                    <div class="h-2 w-16 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full 
                                            ${session.focus_score >= 80 ? 'bg-green-500' : 
                                            session.focus_score >= 60 ? 'bg-blue-500' : 
                                            session.focus_score >= 40 ? 'bg-yellow-500' : 'bg-red-500'}
                                        " style="width: ${session.focus_score}%"></div>
                                    </div>
                                    <span class="ml-1 text-xs">${session.focus_score}%</span>
                                </div>` :
                                '<span class="text-xs text-gray-400">--</span>'
                            }
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Coins</p>
                            ${session.coins_earned ? 
                                `<p class="text-sm text-yellow-600">${session.coins_earned} <i class="fas fa-coins text-xs"></i></p>` :
                                '<span class="text-xs text-gray-400">--</span>'
                            }
                        </div>
                    </div>
                    ${session.completed ? 
                        `<a href="<?= $baseUrl ?>/focus/summary/${session.id}" class="block w-full text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm">
                            View Summary
                        </a>` :
                        (session.end_time === null ? 
                            `<a href="<?= $baseUrl ?>/focus" class="block w-full text-center bg-blue-50 hover:bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm">
                                Return to Session
                            </a>` : ''
                        )
                    }
                </div>
            `;
            
            container.appendChild(card);
        }
        
        // Show/hide load more button on mobile
        const loadMoreBtn = document.getElementById('load-more-mobile');
        if (loadMoreBtn) {
            if (filteredSessions.length > pageSize && endIdx < filteredSessions.length) {
                loadMoreBtn.classList.remove('hidden');
            } else {
                loadMoreBtn.classList.add('hidden');
            }
        }
    }
    
    // Update pagination controls
    function updatePagination() {
        const totalPages = Math.ceil(filteredSessions.length / pageSize);
        
        // Update pagination buttons
        document.getElementById('prev-page').disabled = currentPage <= 1;
        document.getElementById('next-page').disabled = currentPage >= totalPages;
        
        // Generate page number buttons
        const paginationNumbers = document.getElementById('pagination-numbers');
        paginationNumbers.innerHTML = '';
        
        // Display limited page numbers with ellipsis for large sets
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }
        
        // First page button
        if (startPage > 1) {
            const firstBtn = document.createElement('button');
            firstBtn.className = 'px-3 py-1 rounded-md ' + (currentPage === 1 ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200');
            firstBtn.textContent = '1';
            firstBtn.addEventListener('click', () => {
                currentPage = 1;
                sortAndDisplaySessions();
                updatePagination();
            });
            paginationNumbers.appendChild(firstBtn);
            
            // Ellipsis if needed
            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'px-3 py-1 text-gray-500';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
        }
        
        // Page number buttons
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = 'px-3 py-1 rounded-md ' + (currentPage === i ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200');
            pageBtn.textContent = i;
            pageBtn.addEventListener('click', () => {
                currentPage = i;
                sortAndDisplaySessions();
                updatePagination();
            });
            paginationNumbers.appendChild(pageBtn);
        }
        
        // Last page button if needed
        if (endPage < totalPages) {
            // Ellipsis if needed
            if (endPage < totalPages - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'px-3 py-1 text-gray-500';
                ellipsis.textContent = '...';
                paginationNumbers.appendChild(ellipsis);
            }
            
            const lastBtn = document.createElement('button');
            lastBtn.className = 'px-3 py-1 rounded-md ' + (currentPage === totalPages ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200');
            lastBtn.textContent = totalPages;
            lastBtn.addEventListener('click', () => {
                currentPage = totalPages;
                sortAndDisplaySessions();
                updatePagination();
            });
            paginationNumbers.appendChild(lastBtn);
        }
    }
    
    // Combine sort and display operations
    function sortAndDisplaySessions() {
        sortSessions();
        displaySessions();
    }
    
    // ----------------------------------------
    // Date Range Selection
    // ----------------------------------------
    function setupDateRangeControls() {
        // Quick range buttons
        document.querySelectorAll('.quick-range').forEach(btn => {
            btn.addEventListener('click', function() {
                const range = this.getAttribute('data-range');
                const startDateInput = document.getElementById('start_date');
                const endDateInput = document.getElementById('end_date');
                
                const today = new Date();
                let startDate = new Date(today);
                
                switch(range) {
                    case '7':
                        startDate.setDate(today.getDate() - 7);
                        break;
                    case '14':
                        startDate.setDate(today.getDate() - 14);
                        break;
                    case '30':
                        startDate.setDate(today.getDate() - 30);
                        break;
                    case '90':
                        startDate.setDate(today.getDate() - 90);
                        break;
                    case 'month':
                        startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                        break;
                    case 'last-month':
                        startDate = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        today.setDate(0); // Last day of previous month
                        break;
                    case 'year':
                        startDate = new Date(today.getFullYear(), 0, 1);
                        break;
                }
                
                startDateInput.value = startDate.toISOString().split('T')[0];
                endDateInput.value = today.toISOString().split('T')[0];
                
                // Auto-submit the form
                document.getElementById('date-range-form').dispatchEvent(new Event('submit'));
            });
        });
        
        // Date range form submission
        document.getElementById('date-range-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const durationFilter = document.getElementById('duration_filter').value;
            const scoreFilter = document.getElementById('score_filter').value;
            
            // Construct URL with parameters
            let url = '<?= $baseUrl ?>/focus/history?start_date=' + startDate + '&end_date=' + endDate;
            
            if (durationFilter) {
                url += '&duration=' + durationFilter;
            }
            
            if (scoreFilter) {
                url += '&score=' + scoreFilter;
            }
            
            // Redirect to the filtered view
            window.location.href = url;
        });
    }
    
    // ----------------------------------------
    // Export Functionality
    // ----------------------------------------
    function setupExportFunctionality() {
        const exportBtn = document.getElementById('export-data');
        const exportModal = document.getElementById('export-modal');
        const cancelExportBtn = document.getElementById('cancel-export');
        const confirmExportBtn = document.getElementById('confirm-export');
        
        // Show export modal
        exportBtn.addEventListener('click', function() {
            exportModal.classList.remove('hidden');
        });
        
        // Hide export modal
        cancelExportBtn.addEventListener('click', function() {
            exportModal.classList.add('hidden');
        });
        
        // Handle click outside modal to close
        exportModal.addEventListener('click', function(e) {
            if (e.target === exportModal) {
                exportModal.classList.add('hidden');
            }
        });
        
        // Handle export action
        confirmExportBtn.addEventListener('click', function() {
            const format = document.querySelector('input[name="export-format"]:checked').value;
            const startDate = document.getElementById('export-start-date').value;
            const endDate = document.getElementById('export-end-date').value;
            
            const includeSessions = document.querySelector('input[name="export-include-sessions"]').checked;
            const includeDaily = document.querySelector('input[name="export-include-daily"]').checked;
            const includeSummary = document.querySelector('input[name="export-include-summary"]').checked;
            
            // Prepare export data
            const exportData = {
                generated: new Date().toISOString(),
                dateRange: {
                    start: startDate,
                    end: endDate
                }
            };
            
            // Include selected data
            if (includeSessions) {
                exportData.sessions = sessions.filter(s => {
                    const sessionDate = new Date(s.start_time).toISOString().split('T')[0];
                    return sessionDate >= startDate && sessionDate <= endDate;
                });
            }
            
            if (includeDaily) {
                exportData.dailySummary = dailyFocusData.filter(d => {
                    return d.date >= startDate && d.date <= endDate;
                });
            }
            
            if (includeSummary) {
                exportData.stats = <?= json_encode($userStats) ?>;
            }
            
            // Generate file based on format
            switch(format) {
                case 'csv':
                    exportAsCSV(exportData);
                    break;
                case 'excel':
                    exportAsExcel(exportData);
                    break;
                case 'json':
                    exportAsJSON(exportData);
                    break;
            }
            
            // Hide modal
            exportModal.classList.add('hidden');
        });
    }
    
    // Export as CSV
    function exportAsCSV(data) {
        let csvContent = '';
        
        // Generate sessions CSV if included
        if (data.sessions && data.sessions.length > 0) {
            csvContent += 'Session Data\n';
            
            // Header row
            const headers = ['Date', 'Time', 'Duration (min)', 'Status', 'Focus Score', 'Coins Earned'];
            csvContent += headers.join(',') + '\n';
            
            // Data rows
            data.sessions.forEach(session => {
                const date = new Date(session.start_time);
                const row = [
                    date.toLocaleDateString(),
                    date.toLocaleTimeString(),
                    session.duration_minutes,
                    session.completed ? 'Completed' : (session.end_time === null ? 'In Progress' : 'Cancelled'),
                    session.focus_score || '',
                    session.coins_earned || ''
                ];
                csvContent += row.join(',') + '\n';
            });
            
            csvContent += '\n\n';
        }
        
        // Generate daily summary CSV if included
        if (data.dailySummary && data.dailySummary.length > 0) {
            csvContent += 'Daily Summary\n';
            
            // Header row
            const headers = ['Date', 'Total Minutes', 'Sessions Count'];
            csvContent += headers.join(',') + '\n';
            
            // Data rows
            data.dailySummary.forEach(day => {
                const row = [
                    day.date,
                    day.total_minutes,
                    day.session_count
                ];
                csvContent += row.join(',') + '\n';
            });
            
            csvContent += '\n\n';
        }
        
        // Generate overall stats if included
        if (data.stats) {
            csvContent += 'Overall Statistics\n';
            
            // Stats data
            csvContent += 'Total Sessions,' + (data.stats.total_sessions || 0) + '\n';
            csvContent += 'Total Focus Time (min),' + (data.stats.total_minutes || 0) + '\n';
            csvContent += 'Average Focus Score,' + (data.stats.avg_focus_score || 0) + '\n';
            csvContent += 'Current Streak (days),' + (data.stats.streak_days || 0) + '\n';
            csvContent += 'Longest Session (min),' + (data.stats.longest_session || 0) + '\n';
            csvContent += 'Total Coins Earned,' + (data.stats.total_coins || 0) + '\n';
        }
        
        // Generate download
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const fileName = 'focus_history_' + data.dateRange.start + '_to_' + data.dateRange.end + '.csv';
        
        // Download file
        saveAs(blob, fileName);
    }
    
    // Export as Excel
    function exportAsExcel(data) {
        const workbook = XLSX.utils.book_new();
        
        // Add sessions sheet if included
        if (data.sessions && data.sessions.length > 0) {
            const sessionsData = data.sessions.map(session => {
                const date = new Date(session.start_time);
                return {
                    Date: date.toLocaleDateString(),
                    Time: date.toLocaleTimeString(),
                    'Duration (min)': session.duration_minutes,
                    Status: session.completed ? 'Completed' : (session.end_time === null ? 'In Progress' : 'Cancelled'),
                    'Focus Score': session.focus_score || '',
                    'Coins Earned': session.coins_earned || ''
                };
            });
            
            const sessionsSheet = XLSX.utils.json_to_sheet(sessionsData);
            XLSX.utils.book_append_sheet(workbook, sessionsSheet, 'Sessions');
        }
        
        // Add daily summary sheet if included
        if (data.dailySummary && data.dailySummary.length > 0) {
            const dailyData = data.dailySummary.map(day => ({
                Date: day.date,
                'Total Minutes': parseInt(day.total_minutes),
                'Sessions Count': parseInt(day.session_count)
            }));
            
            const dailySheet = XLSX.utils.json_to_sheet(dailyData);
            XLSX.utils.book_append_sheet(workbook, dailySheet, 'Daily Summary');
        }
        
        // Add stats sheet if included
        if (data.stats) {
            const statsData = [
                { Statistic: 'Total Sessions', Value: data.stats.total_sessions || 0 },
                { Statistic: 'Total Focus Time (min)', Value: data.stats.total_minutes || 0 },
                { Statistic: 'Average Focus Score', Value: data.stats.avg_focus_score || 0 },
                { Statistic: 'Current Streak (days)', Value: data.stats.streak_days || 0 },
                { Statistic: 'Longest Session (min)', Value: data.stats.longest_session || 0 },
                { Statistic: 'Total Coins Earned', Value: data.stats.total_coins || 0 }
            ];
            
            const statsSheet = XLSX.utils.json_to_sheet(statsData);
            XLSX.utils.book_append_sheet(workbook, statsSheet, 'Statistics');
        }
        
        // Generate and download Excel file
        const fileName = 'focus_history_' + data.dateRange.start + '_to_' + data.dateRange.end + '.xlsx';
        XLSX.writeFile(workbook, fileName);
    }
    
    // Export as JSON
    function exportAsJSON(data) {
        // Generate JSON file
        const jsonData = JSON.stringify(data, null, 2);
        const blob = new Blob([jsonData], { type: 'application/json' });
        const fileName = 'focus_history_' + data.dateRange.start + '_to_' + data.dateRange.end + '.json';
        
        // Download file
        saveAs(blob, fileName);
    }
    
    // Initialize candlestick chart for focus trends
    function initializeCandlestickChart() {
        // Group sessions by day
        const sessions = <?= json_encode($sessions) ?>;
        const sessionsByDay = {};
        
        // Process sessions into daily data points
        sessions.forEach(session => {
            if (!session.completed || !session.focus_score) return;
            
            const date = new Date(session.start_time).toISOString().split('T')[0];
            
            if (!sessionsByDay[date]) {
                sessionsByDay[date] = {
                    date: date,
                    sessions: [],
                    durations: [],
                    scores: []
                };
            }
            
            sessionsByDay[date].sessions.push(session);
            sessionsByDay[date].durations.push(session.duration_minutes);
            sessionsByDay[date].scores.push(session.focus_score);
        });
        
        // Convert to array and calculate OHLC (Open, High, Low, Close) values
        const candlestickData = Object.values(sessionsByDay).map(day => {
            // Sort sessions by time
            day.sessions.sort((a, b) => new Date(a.start_time) - new Date(b.start_time));
            
            // For scores
            const openScore = day.scores[0];
            const highScore = Math.max(...day.scores);
            const lowScore = Math.min(...day.scores);
            const closeScore = day.scores[day.scores.length - 1];
            
            // For durations
            const totalDuration = day.durations.reduce((sum, d) => sum + d, 0);
            const avgDuration = Math.round(totalDuration / day.durations.length);
            
            return {
                date: day.date,
                sessionCount: day.sessions.length,
                // Score data
                o: openScore,
                h: highScore,
                l: lowScore,
                c: closeScore,
                // Duration data
                avgDuration: avgDuration,
                totalDuration: totalDuration
            };
        });
        
        // Sort by date
        candlestickData.sort((a, b) => new Date(a.date) - new Date(b.date));
        
        // Prepare data for Chart.js
        const labels = candlestickData.map(d => d.date);
        const openData = candlestickData.map(d => d.o);
        const highData = candlestickData.map(d => d.h);
        const lowData = candlestickData.map(d => d.l);
        const closeData = candlestickData.map(d => d.c);
        const colorData = candlestickData.map(d => d.c >= d.o ? 'rgba(16, 185, 129, 0.8)' : 'rgba(239, 68, 68, 0.8)');
        const borderColorData = candlestickData.map(d => d.c >= d.o ? 'rgb(16, 185, 129)' : 'rgb(239, 68, 68)');
        
        // Get chart context
        const ctx = document.getElementById('candlestickChart').getContext('2d');
        
        // Create custom candlestick chart
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Focus Score Range',
                        data: candlestickData.map(d => d.h - d.l), // Height of the bar is high-low
                        backgroundColor: colorData,
                        borderColor: borderColorData,
                        borderWidth: 1,
                        barPercentage: 0.3,
                        categoryPercentage: 0.8,
                        barThickness: 15,
                        // Custom data for drawing
                        open: openData,
                        high: highData,
                        low: lowData,
                        close: closeData
                    },
                    {
                        label: 'Average Duration (minutes)',
                        data: candlestickData.map(d => d.avgDuration),
                        type: 'line',
                        borderColor: 'rgba(99, 102, 241, 0.8)',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                        pointRadius: 3,
                        pointHoverRadius: 5,
                        fill: false,
                        tension: 0.1,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    },
                    y: {
                        beginAtZero: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Focus Score'
                        },
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 10
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Duration (min)'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const datasetLabel = context.dataset.label || '';
                                const index = context.dataIndex;
                                
                                if (context.datasetIndex === 0) {
                                    const day = candlestickData[index];
                                    return [
                                        `Date: ${day.date}`,
                                        `Open: ${day.o}%`,
                                        `High: ${day.h}%`,
                                        `Low: ${day.l}%`,
                                        `Close: ${day.c}%`,
                                        `Sessions: ${day.sessionCount}`
                                    ];
                                } else {
                                    return `Avg Duration: ${context.raw} minutes`;
                                }
                            }
                        }
                    },
                    legend: {
                        labels: {
                            usePointStyle: true
                        }
                    }
                }
            },
            plugins: [{
                id: 'candlestickBars',
                beforeDatasetsDraw(chart, args, pluginOptions) {
                    const { ctx, scales } = chart;
                    const dataset = chart.data.datasets[0];
                    const { x, y } = scales;
                    
                    // Draw the high-low line and open-close marks
                    ctx.strokeStyle = 'rgba(0, 0, 0, 0.5)';
                    ctx.lineWidth = 1;
                    
                    for (let i = 0; i < chart.data.labels.length; i++) {
                        const open = dataset.open[i];
                        const high = dataset.high[i];
                        const low = dataset.low[i];
                        const close = dataset.close[i];
                        
                        if (open === undefined || high === undefined || low === undefined || close === undefined) {
                            continue;
                        }
                        
                        const xPos = x.getPixelForValue(i);
                        const yHigh = y.getPixelForValue(high);
                        const yLow = y.getPixelForValue(low);
                        const yOpen = y.getPixelForValue(open);
                        const yClose = y.getPixelForValue(close);
                        
                        const barWidth = chart.getDatasetMeta(0).data[i]?.width || 10;
                        
                        // Draw the high-low line (the wick)
                        ctx.beginPath();
                        ctx.moveTo(xPos, yHigh);
                        ctx.lineTo(xPos, yLow);
                        ctx.stroke();
                        
                        // Draw open tick (horizontal line to the left)
                        ctx.beginPath();
                        ctx.moveTo(xPos - barWidth/2, yOpen);
                        ctx.lineTo(xPos, yOpen);
                        ctx.stroke();
                        
                        // Draw close tick (horizontal line to the right)
                        ctx.beginPath();
                        ctx.moveTo(xPos, yClose);
                        ctx.lineTo(xPos + barWidth/2, yClose);
                        ctx.stroke();
                    }
                }
            }]
        });
    }
    
    // Initialize status donut chart
    function initializeStatusDonutChart() {
        const sessions = <?= json_encode($sessions) ?>;
        
        // Group sessions by status
        const statusCounts = {
            'completed': 0,
            'in_progress': 0,
            'cancelled': 0
        };
        
        sessions.forEach(session => {
            if (session.completed) {
                statusCounts.completed++;
            } else if (session.end_time === null) {
                statusCounts.in_progress++;
            } else {
                statusCounts.cancelled++;
            }
        });
        
        // Calculate percentages
        const total = sessions.length;
        const statusPercentages = {
            'completed': Math.round((statusCounts.completed / total) * 100) || 0,
            'in_progress': Math.round((statusCounts.in_progress / total) * 100) || 0,
            'cancelled': Math.round((statusCounts.cancelled / total) * 100) || 0
        };
        
        // Update stats display
        const statsContainer = document.getElementById('status-stats');
        statsContainer.innerHTML = '';
        
        const statItems = [
            {
                status: 'Completed',
                count: statusCounts.completed,
                percentage: statusPercentages.completed,
                color: 'bg-green-100 text-green-800',
                icon: 'fa-check-circle text-green-500'
            },
            {
                status: 'In Progress',
                count: statusCounts.in_progress,
                percentage: statusPercentages.in_progress,
                color: 'bg-yellow-100 text-yellow-800',
                icon: 'fa-clock text-yellow-500'
            },
            {
                status: 'Cancelled',
                count: statusCounts.cancelled,
                percentage: statusPercentages.cancelled,
                color: 'bg-red-100 text-red-800',
                icon: 'fa-times-circle text-red-500'
            }
        ];
        
        statItems.forEach(item => {
            const statEl = document.createElement('div');
            statEl.className = 'p-3 rounded-lg border ' + item.color.replace('text-', 'border-');
            
            statEl.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas ${item.icon} text-xl mr-3"></i>
                        <div>
                            <h4 class="font-medium">${item.status}</h4>
                            <p class="text-sm opacity-75">${item.count} sessions</p>
                        </div>
                    </div>
                    <div class="text-2xl font-bold">${item.percentage}%</div>
                </div>
                <div class="mt-2 bg-white bg-opacity-30 rounded-full h-2.5">
                    <div class="h-2.5 rounded-full ${item.color.replace('text-', 'bg-')}" style="width: ${item.percentage}%"></div>
                </div>
            `;
            
            statsContainer.appendChild(statEl);
        });
        
        // Additional total info
        const totalInfo = document.createElement('div');
        totalInfo.className = 'p-3 rounded-lg bg-gray-50 border border-gray-200 mt-2';
        totalInfo.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-list-ul text-gray-500 text-xl mr-3"></i>
                    <div>
                        <h4 class="font-medium">Total Sessions</h4>
                        <p class="text-sm text-gray-500">During selected period</p>
                    </div>
                </div>
                <div class="text-2xl font-bold">${total}</div>
            </div>
        `;
        statsContainer.appendChild(totalInfo);
        
        // Create donut chart
        const ctx = document.getElementById('statusDonutChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Cancelled'],
                datasets: [{
                    data: [
                        statusCounts.completed,
                        statusCounts.in_progress,
                        statusCounts.cancelled
                    ],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',  // Green for completed
                        'rgba(245, 158, 11, 0.8)',  // Yellow for in progress
                        'rgba(239, 68, 68, 0.8)'    // Red for cancelled
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 1,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} sessions (${percentage}%)`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                id: 'centerText',
                beforeDraw: function(chart) {
                    const width = chart.width;
                    const height = chart.height;
                    const ctx = chart.ctx;
                    
                    ctx.restore();
                    
                    // Font size based on canvas size
                    const fontSize = (height / 250).toFixed(2) * 16;
                    ctx.font = `bold ${fontSize}px Arial`;
                    ctx.textBaseline = 'middle';
                    
                    const text = total.toString();
                    const textWidth = ctx.measureText(text).width;
                    
                    // Position text in center
                    ctx.fillStyle = '#333';
                    ctx.fillText(text, (width - textWidth) / 2, height / 2 - fontSize / 2);
                    
                    // Add "sessions" text below
                    ctx.font = `${fontSize * 0.5}px Arial`;
                    const sessionsText = 'sessions';
                    const sessionsWidth = ctx.measureText(sessionsText).width;
                    ctx.fillStyle = '#666';
                    ctx.fillText(sessionsText, (width - sessionsWidth) / 2, height / 2 + fontSize / 2);
                    
                    ctx.save();
                }
            }]
        });
    }
    
    // Initialize lollipop chart
    function initializeLollipopChart() {
        const sessions = <?= json_encode($sessions) ?>;
        const container = document.getElementById('lollipopContainer');
        
        if (!container) return;
        
        // Clear previous visualization if any
        container.innerHTML = '';
        
        // Get the most recent 30 sessions
        const recentSessions = [...sessions]
            .sort((a, b) => new Date(b.start_time) - new Date(a.start_time))
            .slice(0, 30)
            .map(session => ({
                id: session.id,
                date: new Date(session.start_time),
                duration: session.duration_minutes,
                status: session.end_time === null ? 'in_progress' : (session.completed ? 'completed' : 'cancelled'),
                score: session.focus_score
            }))
            .reverse(); // Reverse to show oldest to newest (left to right)
        
        // Set up dimensions
        const margin = {top: 20, right: 30, bottom: 40, left: 50};
        const width = container.clientWidth - margin.left - margin.right;
        const height = container.clientHeight - margin.top - margin.bottom;
        
        // Create SVG
        const svg = d3.select(container)
            .append('svg')
            .attr('width', width + margin.left + margin.right)
            .attr('height', height + margin.top + margin.bottom)
            .append('g')
            .attr('transform', `translate(${margin.left},${margin.top})`);
        
        // Create scales
        const x = d3.scaleLinear()
            .domain([0, d3.max(recentSessions, d => d.duration) * 1.1]) // Add 10% padding
            .range([0, width]);
        
        const y = d3.scaleBand()
            .domain(recentSessions.map((d, i) => i))
            .range([0, height])
            .padding(0.3);
        
        // Status color scale
        const colorScale = d => {
            if (d.status === 'completed') return '#10B981'; // Green
            if (d.status === 'in_progress') return '#F59E0B'; // Yellow
            return '#EF4444'; // Red for cancelled
        };
        
        // Add X axis
        svg.append('g')
            .attr('transform', `translate(0,${height})`)
            .call(d3.axisBottom(x).ticks(5))
            .append('text')
            .attr('x', width / 2)
            .attr('y', 35)
            .attr('fill', 'currentColor')
            .attr('text-anchor', 'middle')
            .text('Duration (minutes)');
        
        // Add Y axis labels (session dates)
        svg.append('g')
            .call(d3.axisLeft(y)
                .tickFormat((d, i) => {
                    // Format the date for display
                    const session = recentSessions[d];
                    return session.date.toLocaleDateString(undefined, {
                        month: 'short',
                        day: 'numeric'
                    });
                })
            );
        
        // Add horizontal lines
        svg.selectAll('lines')
            .data(recentSessions)
            .enter()
            .append('line')
            .attr('x1', 0)
            .attr('x2', d => x(d.duration))
            .attr('y1', (d, i) => y(i) + y.bandwidth() / 2)
            .attr('y2', (d, i) => y(i) + y.bandwidth() / 2)
            .attr('stroke', '#CCCCCC')
            .attr('stroke-width', 1.5);
        
        // Add lollipop circles
        svg.selectAll('circles')
            .data(recentSessions)
            .enter()
            .append('circle')
            .attr('cx', d => x(d.duration))
            .attr('cy', (d, i) => y(i) + y.bandwidth() / 2)
            .attr('r', 6)
            .attr('fill', d => colorScale(d))
            .attr('stroke', 'white')
            .attr('stroke-width', 1)
            .on('mouseover', function(event, d) {
                // Enlarge the circle on hover
                d3.select(this)
                    .transition()
                    .duration(200)
                    .attr('r', 9);
                
                // Show tooltip
                tooltip.transition()
                    .duration(200)
                    .style('opacity', 0.9);
                
                // Format date
                const dateStr = d.date.toLocaleDateString(undefined, {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                // Format status
                const statusStr = d.status.charAt(0).toUpperCase() + d.status.slice(1);
                
                // Format score
                const scoreStr = d.score ? `${d.score}%` : 'N/A';
                
                // Set tooltip content
                tooltip.html(`
                    <div class="p-2">
                        <div class="font-medium">${dateStr}</div>
                        <div class="grid grid-cols-2 gap-x-4 text-sm">
                            <div>Duration:</div><div>${d.duration} min</div>
                            <div>Status:</div><div>${statusStr}</div>
                            <div>Focus Score:</div><div>${scoreStr}</div>
                        </div>
                    </div>
                `)
                .style('left', (event.pageX + 10) + 'px')
                .style('top', (event.pageY - 28) + 'px');
            })
            .on('mouseout', function() {
                // Restore circle size
                d3.select(this)
                    .transition()
                    .duration(200)
                    .attr('r', 6);
                
                // Hide tooltip
                tooltip.transition()
                    .duration(500)
                    .style('opacity', 0);
            });
        
        // Add duration labels
        svg.selectAll('labels')
            .data(recentSessions)
            .enter()
            .append('text')
            .attr('x', d => x(d.duration) + 10)
            .attr('y', (d, i) => y(i) + y.bandwidth() / 2)
            .attr('dy', '0.35em')
            .text(d => `${d.duration}`)
            .attr('font-size', '10px')
            .attr('fill', '#666');
        
        // Create tooltip
        const tooltip = d3.select('body').append('div')
            .attr('class', 'lollipop-tooltip')
            .style('opacity', 0)
            .style('position', 'absolute')
            .style('background', 'white')
            .style('border', '1px solid #ddd')
            .style('border-radius', '4px')
            .style('box-shadow', '0 2px 5px rgba(0,0,0,0.1)')
            .style('pointer-events', 'none')
            .style('z-index', 1000);
        
        // Add title
        svg.append('text')
            .attr('x', width / 2)
            .attr('y', -margin.top / 2)
            .attr('text-anchor', 'middle')
            .style('font-size', '14px')
            .style('font-weight', 'bold')
            .text('Session Duration by Date');
    }
    
    // ----------------------------------------
    // Initialize All Components
    // ----------------------------------------
    function initializeAll() {
        // Initialize charts
        initializeDailyChart();
        
        // Set up tab control
        setupTabControl();
        
        // Set up date range controls
        setupDateRangeControls();
        
        // Set up table sorting
        document.querySelectorAll('th[data-sort]').forEach(th => {
            th.addEventListener('click', function() {
                const field = this.getAttribute('data-sort');
                
                // Toggle direction if clicking the same field
                if (field === sortField) {
                    sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    sortField = field;
                    sortDirection = 'desc';
                }
                
                // Update sort indicators
                document.querySelectorAll('th[data-sort] i').forEach(icon => {
                    icon.className = 'fas fa-sort ml-1';
                });
                
                // Update clicked header icon
                const icon = this.querySelector('i');
                icon.className = `fas fa-sort-${sortDirection === 'asc' ? 'up' : 'down'} ml-1`;
                
                // Sort and display data
                sortAndDisplaySessions();
            });
        });
        
        // Set up search filtering
        document.getElementById('session-search').addEventListener('input', function() {
            filterSessions();
        });
        
        document.getElementById('duration_filter').addEventListener('change', function() {
            filterSessions();
        });
        
        document.getElementById('score_filter').addEventListener('change', function() {
            filterSessions();
        });
        
        // Set up pagination controls
        document.getElementById('prev-page').addEventListener('click', function() {
            if (currentPage > 1) {
                currentPage--;
                sortAndDisplaySessions();
                updatePagination();
            }
        });
        
        document.getElementById('next-page').addEventListener('click', function() {
            const totalPages = Math.ceil(filteredSessions.length / pageSize);
            if (currentPage < totalPages) {
                currentPage++;
                sortAndDisplaySessions();
                updatePagination();
            }
        });
        
        // Set up page size change
        document.getElementById('session-page-size').addEventListener('change', function() {
            pageSize = parseInt(this.value);
            currentPage = 1;
            sortAndDisplaySessions();
            updatePagination();
        });
        
        // Setup load more button on mobile
        const loadMoreBtn = document.getElementById('load-more-mobile');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                pageSize += 10;
                sortAndDisplaySessions();
                updatePagination();
            });
        }
        
        // Set up export functionality
        setupExportFunctionality();
        
        // Initial sorting and display
        sortAndDisplaySessions();
        
        // Initial pagination setup
        updatePagination();
    }
    
    // Start everything
    initializeAll();
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>