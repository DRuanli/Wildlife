<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
include('public/loading-component.php');
?>

<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Focus History</h1>
        <a href="<?= $baseUrl ?>/focus" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition">
            <i class="fas fa-clock mr-2"></i> Start New Session
        </a>
    </div>
    
    <!-- Stats Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Focus Time -->
        <div class="bg-white rounded-lg shadow-md p-4">
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
        <div class="bg-white rounded-lg shadow-md p-4">
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
        <div class="bg-white rounded-lg shadow-md p-4">
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
        <div class="bg-white rounded-lg shadow-md p-4">
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
            </div>
        </div>
    </div>
    
    <!-- Focus Chart -->
    <div class="bg-white rounded-lg shadow-md mb-8">
        <div class="bg-indigo-600 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Focus Analytics</h2>
            
            <!-- Date Range Selector -->
            <form id="date-range-form" class="flex items-center space-x-3">
                <div class="flex items-center space-x-2">
                    <label for="start_date" class="text-sm text-indigo-100">From</label>
                    <input type="date" id="start_date" name="start_date" class="bg-indigo-700 text-white border border-indigo-500 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" value="<?= $startDate ?>">
                </div>
                <div class="flex items-center space-x-2">
                    <label for="end_date" class="text-sm text-indigo-100">To</label>
                    <input type="date" id="end_date" name="end_date" class="bg-indigo-700 text-white border border-indigo-500 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400" value="<?= $endDate ?>">
                </div>
                <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white px-3 py-1 rounded text-sm">Apply</button>
            </form>
        </div>
        
        <div class="p-6">
            <!-- Chart Canvas -->
            <div class="h-64 mb-6">
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
    </div>
    
    <!-- Session History Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-green-600 text-white px-6 py-4">
            <h2 class="text-xl font-bold">Session History</h2>
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
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Focus Score</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coins Earned</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($sessions as $session): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('M j, Y', strtotime($session['start_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('g:i A', strtotime($session['start_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= $session['duration_minutes'] ?> mins
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the chart
    const ctx = document.getElementById('focusChart').getContext('2d');
    
    // Convert PHP data to JavaScript
    const dailyFocusData = <?= json_encode($dailyFocusTime) ?>;
    
    // Format data for the chart
    const labels = [];
    const focusMinutes = [];
    const sessionCounts = [];
    
    dailyFocusData.forEach(day => {
        labels.push(formatDate(day.date));
        focusMinutes.push(parseInt(day.total_minutes));
        sessionCounts.push(parseInt(day.session_count));
    });
    
    // Create the chart
    const focusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Minutes of Focus',
                    data: focusMinutes,
                    backgroundColor: 'rgba(79, 70, 229, 0.7)', // Indigo
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    yAxisID: 'y-axis-1'
                },
                {
                    label: 'Number of Sessions',
                    data: sessionCounts,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)', // Green
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    type: 'line',
                    yAxisID: 'y-axis-2'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    id: 'y-axis-1',
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Minutes'
                    }
                },
                y1: {
                    id: 'y-axis-2',
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: 'Sessions'
                    },
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            }
        }
    });
    
    // Helper function to format date
    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }
    
    // Date range form submission
    const dateRangeForm = document.getElementById('date-range-form');
    if (dateRangeForm) {
        dateRangeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            
            if (!startDate || !endDate) {
                alert('Please select both start and end dates.');
                return;
            }
            
            // Redirect to the same page with date range parameters
            window.location.href = `<?= $baseUrl ?>/focus/history?start_date=${startDate}&end_date=${endDate}`;
        });
    }
});
</script>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>