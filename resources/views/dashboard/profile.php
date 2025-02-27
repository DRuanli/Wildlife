<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; ?>

<div class="container mx-auto px-4 py-8">
  <div class="max-w-3xl mx-auto">
    <!-- Page Title -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Profile</h1>
    
    <!-- Flash Message -->
    <?php if (isset($_SESSION['flash_message'])): ?>
      <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
           class="bg-<?= $_SESSION['flash_type'] ?? 'blue' ?>-100 border-l-4 border-<?= $_SESSION['flash_type'] ?? 'blue' ?>-500 text-<?= $_SESSION['flash_type'] ?? 'blue' ?>-700 p-4 mb-6" role="alert">
        <p><?= $_SESSION['flash_message']; ?></p>
      </div>
      <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    <?php endif; ?>
    
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
      <div class="bg-green-600 text-white px-6 py-4">
        <h2 class="text-xl font-bold">User Profile</h2>
      </div>
      
      <form action="<?= $baseUrl ?>/dashboard/profile/update" method="POST" enctype="multipart/form-data" class="p-6">
        <div class="flex flex-col md:flex-row">
          <!-- Avatar Upload with Interactive Preview -->
          <div class="w-full md:w-1/3 mb-6 md:mb-0 flex flex-col items-center" x-data="{ avatarUrl: '<?= !empty($user['avatar_url']) ? htmlspecialchars($user['avatar_url']) : '' ?>' }">
            <div class="w-32 h-32 rounded-full bg-gray-200 overflow-hidden mb-4">
              <template x-if="avatarUrl">
                <img :src="avatarUrl" alt="Profile Avatar" class="w-full h-full object-cover">
              </template>
              <template x-if="!avatarUrl">
                <div class="w-full h-full bg-green-600 flex items-center justify-center text-white text-4xl font-bold">
                  <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                </div>
              </template>
            </div>
            
            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
            <input type="file" name="avatar" accept="image/*"
                   @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { avatarUrl = e.target.result }; reader.readAsDataURL(file); }"
                   class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            <p class="mt-1 text-xs text-gray-500">PNG, JPG, or GIF. Max 2MB.</p>
          </div>
          
          <!-- Profile Info -->
          <div class="w-full md:w-2/3 md:pl-6">
            <div class="mb-4">
              <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <input type="text" name="username" id="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                     class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                     class="w-full rounded-md border-gray-300 shadow-sm bg-gray-50" readonly>
              <p class="mt-1 text-xs text-gray-500">Email cannot be changed.</p>
            </div>
            
            <div class="mb-4">
              <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
              <textarea name="bio" id="bio" rows="4"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
              <p class="mt-1 text-xs text-gray-500">Tell others about yourself (maximum 200 characters).</p>
            </div>
            
            <div class="mt-6">
              <button type="submit"
                      class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Save Changes
              </button>
            </div>
          </div>
        </div>
      </form>
    </div>
    
    <!-- Achievements Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
      <div class="bg-purple-600 text-white px-6 py-4">
        <h2 class="text-xl font-bold">Achievements</h2>
      </div>
      
      <?php if (empty($achievements)): ?>
        <div class="p-6 text-center">
          <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
            <i class="fas fa-trophy text-2xl"></i>
          </div>
          <h3 class="text-gray-700 font-medium mb-2">No achievements yet!</h3>
          <p class="text-gray-500 mb-4">Keep focusing to earn your first achievement.</p>
        </div>
      <?php else: ?>
        <div class="p-4 grid grid-cols-2 md:grid-cols-3 gap-4">
          <?php foreach ($achievements as $achievement): ?>
            <div class="bg-gray-50 rounded-lg p-4 text-center transition transform hover:scale-105">
              <div class="w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-2 
                <?php if ($achievement['earned']): ?>
                  bg-yellow-100 text-yellow-600
                <?php else: ?>
                  bg-gray-200 text-gray-400
                <?php endif; ?>
              ">
                <i class="<?= $achievement['icon'] ?> text-xl"></i>
              </div>
              <h4 class="font-medium text-sm"><?= htmlspecialchars($achievement['name']) ?></h4>
              <p class="text-xs text-gray-500"><?= htmlspecialchars($achievement['description']) ?></p>
              <?php if ($achievement['earned']): ?>
                <p class="text-xs text-green-600 mt-1">Earned on <?= date('M j, Y', strtotime($achievement['earned_at'])) ?></p>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    
    <!-- Focus Stats Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="bg-blue-600 text-white px-6 py-4">
        <h2 class="text-xl font-bold">Focus Statistics</h2>
      </div>
      
      <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-600">Total Focus Time</p>
            <p class="text-xl font-bold text-gray-800">
              <?= floor(($user['total_focus_time'] ?? 0) / 60) ?> hrs <?= ($user['total_focus_time'] ?? 0) % 60 ?> mins
            </p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-600">Current Streak</p>
            <p class="text-xl font-bold text-gray-800">
              <?= $user['streak_days'] ?? 0 ?> days
            </p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-600">Coins Earned</p>
            <p class="text-xl font-bold text-gray-800">
              <?= $user['coins_balance'] ?? 0 ?>
            </p>
          </div>
          
          <div class="bg-gray-50 rounded-lg p-4 text-center">
            <p class="text-sm text-gray-600">Avg. Focus Score</p>
            <p class="text-xl font-bold text-gray-800">
              0
            </p>
          </div>
        </div>
        
        <!-- Toggleable Focus Chart -->
        <div x-data="{ showChart: false }" class="mt-6">
          <button @click="showChart = !showChart" class="btn btn-secondary">
            <span x-text="showChart ? 'Hide Focus Chart' : 'Show Focus Chart'"></span>
          </button>
          <div x-show="showChart" x-transition class="mt-4 bg-gray-50 rounded-lg p-4 flex items-center justify-center h-64">
            <div class="text-center">
              <i class="fas fa-chart-line text-4xl text-gray-300 mb-2"></i>
              <p class="text-gray-500">Focus history charts coming soon</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
