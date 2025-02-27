<?php require_once ROOT_PATH . '/resources/views/layouts/header.php'; 
// Path: resources/views/auth/register.php
?>

<!-- Inline Styles & Font Imports: Move to your CSS file as desired -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@500&display=swap');

  :root {
    --anthropic-bg: #F9F8F2;
    --anthropic-text-dark: #111;
    --anthropic-text-gray: #333;
    --anthropic-accent: #CE6246;
  }

  body {
    background-color: var(--anthropic-bg);
    font-family: 'Inter', Arial, sans-serif;
    color: var(--anthropic-text-gray);
  }

  /* Container & Card Layout */
  .auth-container {
    max-width: 480px;
    margin: 2rem auto;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  }
  .auth-header {
    padding: 2rem 2rem 1rem;
    text-align: center;
    background: linear-gradient(to bottom, #fff, #f3f1ec);
  }
  .auth-body {
    padding: 2rem;
  }
  .auth-footer {
    padding: 1rem 2rem;
    background: #f7f6f3;
    border-top: 1px solid #e2e2e2;
    text-align: center;
  }

  /* Headings & Text */
  .auth-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.75rem;
    margin-bottom: 0.5rem;
    color: var(--anthropic-text-dark);
  }
  .auth-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1.5rem;
  }
  .auth-label {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 0.25rem;
    display: block;
  }
  .auth-hint {
    font-size: 0.75rem;
    color: #999;
    margin-top: 0.25rem;
  }

  /* Form Inputs & Buttons */
  .auth-input {
    width: 100%;
    padding: 0.65rem 0.75rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 0.95rem;
    color: var(--anthropic-text-gray);
    transition: border-color 0.3s;
  }
  .auth-input:focus {
    outline: none;
    border-color: var(--anthropic-accent);
    box-shadow: 0 0 0 2px rgba(206,98,70,0.2);
  }
  .auth-checkbox {
    width: 1rem;
    height: 1rem;
    margin-right: 0.5rem;
    accent-color: var(--anthropic-accent);
  }
  .auth-btn {
    display: inline-block;
    width: 100%;
    padding: 0.75rem 1rem;
    background: var(--anthropic-accent);
    color: #fff;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
    text-align: center;
    margin-top: 1rem;
  }
  .auth-btn:hover {
    background: #b55a3f;
  }

  /* Flash Messages */
  .flash-message {
    padding: 1rem;
    margin-bottom: 1rem;
    border-left: 4px solid;
    border-radius: 4px;
    font-size: 0.9rem;
  }
  .flash-danger {
    background: #fde2e2;
    border-color: #fda4a4;
    color: #b91c1c;
  }
  .flash-success {
    background: #e2fbe2;
    border-color: #99e699;
    color: #15803d;
  }
  .flash-warning {
    background: #fef9c3;
    border-color: #fef08a;
    color: #854d0e;
  }

  /* Divider */
  .auth-divider {
    display: flex;
    align-items: center;
    text-align: center;
    margin: 1.5rem 0;
  }
  .auth-divider::before,
  .auth-divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #ddd;
  }
  .auth-divider:not(:empty)::before {
    margin-right: 0.75em;
  }
  .auth-divider:not(:empty)::after {
    margin-left: 0.75em;
  }
  .auth-divider-text {
    font-size: 0.75rem;
    color: #999;
  }

  /* OAuth Button Styles */
  .oauth-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 0.65rem;
    font-size: 0.9rem;
    transition: background 0.2s;
    margin-bottom: 0.5rem;
    color: #444;
    background: #fff;
  }
  .oauth-btn:hover {
    background: #f3f1ec;
  }
  .oauth-btn svg {
    margin-right: 0.5rem;
    width: 1rem;
    height: 1rem;
  }

  /* Toggle button for password visibility */
  .toggle-btn {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #999;
  }

  /* Multi-Step Transitions */
  [x-cloak] { display: none !important; }
  .step-enter { opacity: 0; transform: translateY(10px); }
  .step-enter-active { transition: all 0.3s ease; opacity: 1; transform: translateY(0); }
</style>

<!-- AlpineJS for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
  function registerForm() {
    return {
      currentStep: 1,
      username: '',
      email: '',
      password: '',
      confirmPassword: '',
      terms: false,
      passwordVisible: false,
      confirmPasswordVisible: false,
      strength: 0,
      updateStrength() {
        let score = 0;
        if (this.password.length >= 8) score += 30;
        if (/[A-Z]/.test(this.password)) score += 20;
        if (/[0-9]/.test(this.password)) score += 20;
        if (/[^A-Za-z0-9]/.test(this.password)) score += 20;
        if (this.password.length >= 12) score += 10;
        this.strength = score;
      },
      nextStep() {
        if(this.currentStep === 1) {
          if(this.username.trim().length >= 3 && this.email.trim().length > 0) {
            this.currentStep = 2;
          } else {
            alert('Please enter a valid username and email.');
          }
        }
      },
      prevStep() {
        if(this.currentStep > 1) this.currentStep--;
      },
      togglePassword() {
        this.passwordVisible = !this.passwordVisible;
      },
      toggleConfirmPassword() {
        this.confirmPasswordVisible = !this.confirmPasswordVisible;
      },
      canSubmit() {
        return (
          this.password.length >= 8 &&
          this.password === this.confirmPassword &&
          this.terms
        );
      }
    }
  }
</script>

<div class="container mx-auto px-6 py-12" x-data="registerForm()">
  <div class="auth-container" x-cloak>
    <!-- Header Section -->
    <div class="auth-header">
      <h2 class="auth-title">Join Wildlife Haven</h2>
      <p class="auth-subtitle">Create an account to start your mindful focus journey</p>
    </div>
    
    <!-- Flash Messages -->
    <div class="auth-body">
      <?php if (isset($_SESSION['flash_message'])): ?>
        <div class="flash-message <?php 
            if ($_SESSION['flash_type'] == 'danger') echo 'flash-danger';
            elseif ($_SESSION['flash_type'] == 'success') echo 'flash-success';
            else echo 'flash-warning';
          ?>">
          <?= $_SESSION['flash_message']; ?>
        </div>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
      <?php endif; ?>
      
      <!-- Multi-Step Form -->
      <form action="<?= $baseUrl ?>/auth/register/process" method="POST" class="space-y-6">
        <!-- Step 1: Basic Details -->
        <div x-show="currentStep === 1" x-transition:enter="step-enter" x-transition:enter-active="step-enter-active">
          <div>
            <label for="username" class="auth-label">Username</label>
            <input type="text" name="username" id="username" 
                   x-model="username"
                   class="auth-input" placeholder="Enter username" required>
            <p class="auth-hint">3–50 characters, letters &amp; digits</p>
          </div>
          <div>
            <label for="email" class="auth-label">Email</label>
            <input type="email" name="email" id="email" 
                   x-model="email"
                   class="auth-input" placeholder="your@email.com" required>
          </div>
          <div class="mt-4">
            <button type="button" @click="nextStep()" class="auth-btn">
              Next &raquo;
            </button>
          </div>
        </div>
        
        <!-- Step 2: Security & Terms -->
        <div x-show="currentStep === 2" x-transition:enter="step-enter" x-transition:enter-active="step-enter-active">
          <div class="relative">
            <label for="password" class="auth-label">Password</label>
            <input :type="passwordVisible ? 'text' : 'password'" 
                   x-model="password" 
                   @input="updateStrength()"
                   name="password" id="password" 
                   class="auth-input" placeholder="••••••••" required>
            <span class="toggle-btn" @click="togglePassword()">
              <template x-if="!passwordVisible">
                <!-- Eye closed icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10 0-1.073.175-2.099.5-3M6.18 6.18A9.956 9.956 0 0112 5c5.523 0 10 4.477 10 10 0 .864-.105 1.705-.305 2.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </template>
              <template x-if="passwordVisible">
                <!-- Eye open icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                  <circle cx="12" cy="12" r="2.5"/>
                </svg>
              </template>
            </span>
            <p class="auth-hint">Must be at least 8 characters</p>
            <!-- Password Strength Meter -->
            <div class="mt-2 h-2 rounded" style="background:#eee;">
              <div class="strength-bar rounded" :style="`width: ${strength}%; background: ${strength > 80 ? 'green' : strength > 50 ? 'orange' : (strength > 30 ? '#FF7B7B' : '#ddd')};`"></div>
            </div>
          </div>

          <div class="relative mt-4">
            <label for="password_confirm" class="auth-label">Confirm Password</label>
            <input :type="confirmPasswordVisible ? 'text' : 'password'" 
                   x-model="confirmPassword"
                   name="password_confirm" id="password_confirm" 
                   class="auth-input" placeholder="Re-enter password" required>
            <span class="toggle-btn" @click="toggleConfirmPassword()">
              <template x-if="!confirmPasswordVisible">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10 0-1.073.175-2.099.5-3M6.18 6.18A9.956 9.956 0 0112 5c5.523 0 10 4.477 10 10 0 .864-.105 1.705-.305 2.5M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </template>
              <template x-if="confirmPasswordVisible">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 5c-7.633 0-11 7-11 7s3.367 7 11 7 11-7 11-7-3.367-7-11-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                  <circle cx="12" cy="12" r="2.5"/>
                </svg>
              </template>
            </span>
          </div>
          
          <!-- Terms Checkbox -->
          <div class="flex items-center mt-4">
            <input type="checkbox" name="terms" id="terms" class="auth-checkbox" x-model="terms" required>
            <label for="terms" class="text-sm text-stone-700">
              I agree to the 
              <a href="<?= $baseUrl ?>/terms" class="underline text-stone-600 hover:text-stone-800">Terms of Service</a> and 
              <a href="<?= $baseUrl ?>/privacy" class="underline text-stone-600 hover:text-stone-800">Privacy Policy</a>
            </label>
          </div>
          
          <!-- Navigation Buttons -->
          <div class="mt-6 flex justify-between">
            <button type="button" @click="prevStep()" class="auth-btn" style="width:45%; background:#ccc; color:#333;">
              &laquo; Back
            </button>
            <button type="submit" :disabled="!canSubmit()" class="auth-btn" style="width:45%;" 
                    :class="{'opacity-50 cursor-not-allowed': !canSubmit()}">
              Create Account
            </button>
          </div>
        </div>
      </form>

      <!-- Divider -->
      <div class="auth-divider">
        <span class="auth-divider-text">Or sign up with</span>
      </div>

      <!-- OAuth Buttons -->
      <div class="grid grid-cols-2 gap-4">
        <a href="<?= $baseUrl ?>/auth/google" class="oauth-btn">
          <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032 c0-3.331,2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12 s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
          </svg>
          <span class="ml-2">Google</span>
        </a>
        <a href="<?= $baseUrl ?>/auth/apple" class="oauth-btn">
          <svg fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.543,11.971c-0.019-2.116,1.731-3.136,1.809-3.186c-0.988-1.444-2.524-1.643-3.063-1.662
            c-1.294-0.134-2.542,0.765-3.201,0.765c-0.666,0-1.679-0.75-2.771-0.729c-1.401,0.021-2.714,0.825-3.437,2.082
            c-1.485,2.574-0.377,6.368,1.047,8.45c0.711,1.017,1.541,2.156,2.629,2.116c1.063-0.043,1.461-0.682,2.741-0.682
            c1.269,0,1.639,0.682,2.741,0.658c1.135-0.018,1.851-1.021,2.532-2.047c0.812-1.163,1.139-2.303,1.153-2.362
            C19.705,15.291,17.564,14.506,17.543,11.971z M15.061,4.4c0.571-0.7,0.96-1.659,0.852-2.625c-0.826,0.034-1.854,0.556-2.447,1.245
            c-0.53,0.616-1.002,1.611-0.879,2.552C13.557,5.647,14.48,5.094,15.061,4.4z"/>
          </svg>
          <span class="ml-2">Apple</span>
        </a>
      </div>
    </div>

    <!-- Footer -->
    <div class="auth-footer">
      <p class="text-sm text-stone-600">
        Already have an account? 
        <a href="<?= $baseUrl ?>/auth/login" class="underline text-stone-800 hover:text-stone-900">
          Sign in
        </a>
      </p>
    </div>
  </div>
</div>

<?php require_once ROOT_PATH . '/resources/views/layouts/footer.php'; ?>
