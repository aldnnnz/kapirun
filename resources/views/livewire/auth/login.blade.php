<div class="bg-white shadow-2xl p-8 max-w-md mx-auto rounded-lg">
    <h2 class="text-2xl font-bold text-blue-800 mb-3 text-center">Login</h2>
    <p class="text-gray-600 mb-6 text-center text-sm">Welcome back! Please sign in to your account</p>
    
    <form wire:submit.prevent="login" class="space-y-4">
      <div>
        <label for="login" class="block text-gray-700 font-medium mb-2 text-sm">Email / Username</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
            </svg>
          </span>
          <input type="text" id="login" wire:model="login" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Enter your email or username">
        </div>
      </div>
      <div>
        <label for="password" class="block text-gray-700 font-medium mb-2 text-sm">Password</label>
        <div class="relative">
          <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          <input type="password" id="password" wire:model="password" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Enter your password">
        </div>
        @error('login') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        @if (session()->has('error'))
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
      </div>
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input type="checkbox" id="remember"  class="h-3 w-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
          <label for="remember" class="ml-2 block text-xs text-gray-700">Remember me</label>
        </div>
        <a href="#" class="text-xs text-blue-600 hover:text-blue-800 hover:underline">Forgot password?</a>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition duration-300 font-medium shadow-lg hover:shadow-xl text-sm mt-6 transform hover:-translate-y-0.5 hover:scale-[1.02]">
        Sign in
      </button>
      <button type="button" wire:click="testDebug">Debug Livewire</button>
    </form>
    
  </div>