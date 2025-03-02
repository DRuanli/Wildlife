<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
include('public/loading-component.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Focus Analytics - Wildlife Haven</title>
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <!-- Custom Styles -->
  <style>
    :root {
      --font-sans: 'Inter', sans-serif;
      --font-display: 'Playfair Display', serif;
      
      /* Core palette */
      --color-bg: #F9F8F2;
      --color-text: #1A1A1A;
      --color-text-muted: #666666;
      --color-primary: #4D724D;
      --color-primary-light: #C4D7C4;
      --color-primary-dark: #2F4F2F;
      --color-accent: #CE6246;
      
      /* Status colors */
      --color-focus: #4A6FA5;
      --color-streak: #CE8550;
      --color-coins: #C9A227;
      --color-conservation: #4E8D89;
    }
    
    body {
      font-family: var(--font-sans);
      background-color: var(--color-bg);
      color: var(--color-text);
      line-height: 1.5;
    }
    
    .headline {
      font-family: var(--font-display);
      font-weight: 500;
    }
    
    .card {
      border-radius: 16px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .chart-container {
      position: relative;
      height: 300px;
    }
    
    /* Tab styling */
    .tab-item {
      position: relative;
      transition: all 0.3s ease;
    }
    
    .tab-item::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 3px;
      background-color: var(--color-primary);
      transform: scaleX(0);
      transition: transform 0.3s ease;
    }
    
    .tab-item.active {
      color: var(--color-primary);
    }
    
    .tab-item.active::after {
      transform: scaleX(1);
    }
  </style>
</head>

<body>
  <div class="min-h-screen">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-emerald-800 to-emerald-700 text-white pt-16 pb-8">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div>
            <h1 class="headline text-3xl mb-2">Focus Analytics</h1>
            <p class="opacity-90">Track your focus journey and measure your progress</p>
          </div>
          
          <a href="<?= $baseUrl ?>/dashboard" class="mt-4 md:mt-0 px-4 py-2 bg-white text-emerald-700 rounded-lg flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Dashboard
          </a>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
      <!-- Focus Analytics Overview -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Focus Time -->
        <div class="card bg-white p-6">
          <div class="flex items-center mb-2">
            <div class="p-3 rounded-full mr-4" style="background-color: var(--color-focus-light);">
              <i class="fas fa-hourglass-half text-xl" style="color: var(--color-focus);"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500">Total Focus Time</p>
              <p class="text-2xl font-bold">
                <?= floor(($user['total_focus_time'] ?? 0) / 60) ?> hrs <?= ($user['total_focus_time'] ?? 0) % 60 ?> mins
              </p>
            </div>
          </div>
        </div>
        
        <!-- Current Streak -->
        <div class="card bg-white p-6">
          <div class="flex items-center mb-2">
            <div class="p-3 rounded-full mr-4" style="background-color: var(--color-streak-light);">
              <i class="fas fa-fire text-xl" style="color: var(--color-streak);"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500">Current Streak</p>
              <p class="text-2xl font-bold">
                <?= $user['streak_days'] ?? 0 ?> days
              </p>
            </div>
          </div>
        </div>
        
        <!-- Average Focus Score -->
        <div class="card bg-white p-6">
          <div class="flex items-center mb-2">
            <div class="p-3 rounded-full mr-4" style="background-color: rgba(79, 70, 229, 0.1);">
              <i class="fas fa-chart-line text-xl" style="color: rgb(79, 70, 229);"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500">Average Focus Score</p>
              <p class="text-2xl font-bold">87%</p>
            </div>
          </div>
        </div>
        
        <!-- Completed Sessions -->
        <div class="card bg-white p-6">
          <div class="flex items-center mb-2">
            <div class="p-3 rounded-full mr-4" style="background-color: rgba(236, 72, 153, 0.1);">
              <i class="fas fa-check-circle text-xl" style="color: rgb(236, 72, 153);"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500">Completed Sessions</p>
              <p class="text-2xl font-bold">42</p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Analytics Tabs -->
      <div class="mb-8 bg-white rounded-2xl shadow-sm overflow-hidden" x-data="{ activeTab: 'weekly' }">
        <!-- Tab Navigation -->
        <div class="flex border-b border-gray-200 bg-gray-50 px-2">
          <button @click="activeTab = 'weekly'" 
                  :class="{ 'active': activeTab === 'weekly' }" 
                  class="tab-item py-4 px-6 font-medium text-sm focus:outline-none transition-colors duration-200">
            Weekly Analysis
          </button>
          <button @click="activeTab = 'monthly'" 
                  :class="{ 'active': activeTab === 'monthly' }" 
                  class="tab-item py-4 px-6 font-medium text-sm focus:outline-none transition-colors duration-200">
            Monthly Trends
          </button>
          <button @click="activeTab = 'progress'" 
                  :class="{ 'active': activeTab === 'progress' }" 
                  class="tab-item py-4 px-6 font-medium text-sm focus:outline-none transition-colors duration-200">
            Progress & Goals
          </button>
          <button @click="activeTab = 'heatmap'" 
                  :class="{ 'active': activeTab === 'heatmap' }" 
                  class="tab-item py-4 px-6 font-medium text-sm focus:outline-none transition-colors duration-200">
            Focus Heatmap
          </button>
        </div>
        
        <!-- Tab Content -->
        <div class="p-6">
          <!-- Weekly Analysis Tab -->
          <div x-show="activeTab === 'weekly'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="space-y-6">
            
            <!-- Weekly Focus Chart -->
            <div class="bg-white p-6">
              <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Weekly Focus Time</h3>
                <div class="flex space-x-2">
                  <button class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-600 focus:outline-none">This Week</button>
                  <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none">Last Week</button>
                </div>
              </div>
              <div class="chart-container">
                <canvas id="weeklyFocusChart"></canvas>
              </div>
            </div>
            
            <!-- Daily Breakdown -->
            <div class="bg-white p-6 border-t border-gray-100">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Daily Focus Breakdown</h3>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sessions</th>
                      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Time</th>
                      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg. Score</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Monday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">75 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">85%</td>
                    </tr>
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Tuesday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">95 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">92%</td>
                    </tr>
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Wednesday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">5</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">120 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">88%</td>
                    </tr>
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Thursday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">85 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">75%</td>
                    </tr>
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Friday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">50 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">80%</td>
                    </tr>
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Saturday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">90 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">87%</td>
                    </tr>
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Sunday</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">110 mins</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">91%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <!-- Monthly Trends Tab -->
          <div x-show="activeTab === 'monthly'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="space-y-6">
            
            <!-- Monthly Focus Chart -->
            <div class="bg-white p-6">
              <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-800">Monthly Focus Trends</h3>
                <div class="flex space-x-2">
                  <button class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-600 focus:outline-none">Last 3 Months</button>
                  <button class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 focus:outline-none">Last 6 Months</button>
                </div>
              </div>
              <div class="chart-container">
                <canvas id="monthlyFocusChart"></canvas>
              </div>
            </div>
            
            <!-- Monthly Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="bg-white p-6 rounded-lg border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Average Daily Focus</h3>
                <p class="text-2xl font-bold text-gray-800">42 mins</p>
                <p class="text-sm text-green-600 mt-1"><i class="fas fa-arrow-up"></i> 15% vs. previous</p>
              </div>
              
              <div class="bg-white p-6 rounded-lg border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Longest Session</h3>
                <p class="text-2xl font-bold text-gray-800">90 mins</p>
                <p class="text-sm text-gray-400 mt-1">March 15, 2024</p>
              </div>
              
              <div class="bg-white p-6 rounded-lg border border-gray-100">
                <h3 class="text-sm font-medium text-gray-500 mb-1">Most Productive Day</h3>
                <p class="text-2xl font-bold text-gray-800">Wednesday</p>
                <p class="text-sm text-gray-400 mt-1">120 mins average</p>
              </div>
            </div>
          </div>
          
          <!-- Progress & Goals Tab -->
          <div x-show="activeTab === 'progress'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="space-y-6">
            
            <!-- Current Goals -->
            <div class="bg-white p-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Focus Goals</h3>
              
              <div class="space-y-4">
                <div class="border-l-4 border-emerald-500 pl-4 pb-4">
                  <div class="flex justify-between items-center">
                    <div>
                      <h4 class="font-medium">Daily Focus Goal</h4>
                      <p class="text-sm text-gray-500">45 minutes per day</p>
                    </div>
                    <div class="text-right">
                      <p class="font-medium">Today: 25/45 mins</p>
                      <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-emerald-500 h-2 rounded-full" style="width: 55%"></div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="border-l-4 border-blue-500 pl-4 pb-4">
                  <div class="flex justify-between items-center">
                    <div>
                      <h4 class="font-medium">Weekly Focus Goal</h4>
                      <p class="text-sm text-gray-500">5 hours per week</p>
                    </div>
                    <div class="text-right">
                      <p class="font-medium">This week: 3.5/5 hrs</p>
                      <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 70%"></div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="border-l-4 border-purple-500 pl-4 pb-4">
                  <div class="flex justify-between items-center">
                    <div>
                      <h4 class="font-medium">Monthly Focus Goal</h4>
                      <p class="text-sm text-gray-500">25 hours per month</p>
                    </div>
                    <div class="text-right">
                      <p class="font-medium">This month: 18/25 hrs</p>
                      <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-purple-500 h-2 rounded-full" style="width: 72%"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Progress Chart -->
            <div class="bg-white p-6">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Focus Progress Over Time</h3>
              <div class="chart-container">
                <canvas id="progressChart"></canvas>
              </div>
            </div>
          </div>
          
          <!-- Focus Heatmap Tab -->
          <div x-show="activeTab === 'heatmap'" 
               x-transition:enter="transition ease-out duration-300"
               x-transition:enter-start="opacity-0 transform -translate-y-4"
               x-transition:enter-end="opacity-100 transform translate-y-0"
               class="space-y-6">
            
            <!-- Focus Insights -->
            <div class="bg-white p-6 rounded-lg border border-gray-100">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">Focus Insights</h3>
              
              <div class="space-y-4">
                <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                  <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-lightbulb"></i>
                  </div>
                  <div>
                    <h4 class="font-medium">Peak Focus Time</h4>
                    <p class="text-sm text-gray-600">Your focus score is highest between 9-11 AM. Consider scheduling important work during this time.</p>
                  </div>
                </div>
                
                <div class="flex items-center p-4 bg-green-50 rounded-lg">
                  <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <div>
                    <h4 class="font-medium">Consistency Improvement</h4>
                    <p class="text-sm text-gray-600">Your focus consistency has improved by 22% compared to last month. Great job!</p>
                  </div>
                </div>
                
                <div class="flex items-center p-4 bg-purple-50 rounded-lg">
                  <div class="flex items-center justify-center h-10 w-10 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-trophy"></i>
                  </div>
                  <div>
                    <h4 class="font-medium">Achievement Unlocked</h4>
                    <p class="text-sm text-gray-600">You've maintained a 90%+ focus score for 5 consecutive sessions. Keep it up!</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Initialization Scripts -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Weekly Focus Chart
      const weeklyFocusCtx = document.getElementById('weeklyFocusChart')?.getContext('2d');
      
      if (weeklyFocusCtx) {
        new Chart(weeklyFocusCtx, {
          type: 'bar',
          data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [
              {
                label: 'Duration (minutes)',
                data: [75, 95, 120, 85, 50, 90, 110],
                backgroundColor: 'rgba(45, 106, 79, 0.8)',
                borderRadius: 6
              },
              {
                label: 'Focus Score',
                data: [85, 92, 88, 75, 80, 87, 91],
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                borderColor: 'rgba(99, 102, 241, 0.8)',
                type: 'line',
                yAxisID: 'y1',
                tension: 0.3,
                pointBackgroundColor: 'rgba(99, 102, 241, 1)'
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
              intersect: false,
              mode: 'index'
            },
            plugins: {
              legend: {
                position: 'top',
                labels: {
                  usePointStyle: true,
                  boxWidth: 6,
                  font: {
                    size: 12
                  }
                }
              },
              tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#111827',
                bodyColor: '#374151',
                borderColor: '#E5E7EB',
                borderWidth: 1,
                cornerRadius: 8,
                boxPadding: 4,
                usePointStyle: true
              }
            },
            scales: {
              x: {
                grid: {
                  display: false
                },
                ticks: {
                  font: {
                    size: 12
                  }
                }
              },
              y: {
                position: 'left',
                grid: {
                  color: 'rgba(156, 163, 175, 0.1)'
                },
                ticks: {
                  font: {
                    size: 12
                  }
                },
                title: {
                  display: true,
                  text: 'Duration (minutes)',
                  color: '#2D6A4F',
                  font: {
                    size: 12,
                    weight: 'normal'
                  }
                }
              },
              y1: {
                position: 'right',
                grid: {
                  drawOnChartArea: false
                },
                min: 0,
                max: 100,
                ticks: {
                  font: {
                    size: 12
                  },
                  callback: function(value) {
                    return value + '%';
                  }
                },
                title: {
                  display: true,
                  text: 'Focus Score',
                  color: '#6366F1',
                  font: {
                    size: 12,
                    weight: 'normal'
                  }
                }
              }
            }
          }
        });
      }
      
      // Monthly Focus Chart
      const monthlyFocusCtx = document.getElementById('monthlyFocusChart')?.getContext('2d');
      
      if (monthlyFocusCtx) {
        new Chart(monthlyFocusCtx, {
          type: 'line',
          data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
              {
                label: 'Total Hours',
                data: [22, 28, 32, 30, 35, 42],
                borderColor: 'rgba(45, 106, 79, 0.8)',
                backgroundColor: 'rgba(45, 106, 79, 0.1)',
                tension: 0.3,
                fill: true
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top'
              }
            },
            scales: {
              x: {
                grid: {
                  display: false
                }
              },
              y: {
                grid: {
                  color: 'rgba(156, 163, 175, 0.1)'
                },
                title: {
                  display: true,
                  text: 'Focus Hours'
                }
              }
            }
          }
        });
      }
      
      // Progress Chart
      const progressCtx = document.getElementById('progressChart')?.getContext('2d');
      
      if (progressCtx) {
        new Chart(progressCtx, {
          type: 'line',
          data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6', 'Week 7', 'Week 8'],
            datasets: [
              {
                label: 'Actual Focus Hours',
                data: [5, 8, 7, 12, 11, 14, 15, 18],
                borderColor: 'rgba(45, 106, 79, 0.8)',
                backgroundColor: 'rgba(45, 106, 79, 0.1)',
                tension: 0.3,
                fill: true
              },
              {
                label: 'Goal',
                data: [5, 5, 10, 10, 10, 15, 15, 15],
                borderColor: 'rgba(156, 163, 175, 0.5)',
                borderDash: [5, 5],
                fill: false,
                tension: 0
              }
            ]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'top'
              }
            },
            scales: {
              x: {
                grid: {
                  display: false
                }
              },
              y: {
                grid: {
                  color: 'rgba(156, 163, 175, 0.1)'
                },
                title: {
                  display: true,
                  text: 'Hours'
                }
              }
            }
          }
        });
      }
    });
  </script>
</body>
</html>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>