<div class="bg-white shadow-2xl p-6 mx-auto rounded-lg max-w-2xl">
    <h2 class="text-2xl font-bold text-blue-800 mb-2 text-center">Register</h2>
    <p class="text-gray-600 mb-6 text-center text-sm font-medium">✨ Create your account and start your journey with us! ✨</p>    
    <form wire:submit.prevent="register" class="space-y-4">
      <div class="grid grid-cols-2 gap-x-4 gap-y-4">
        <div class="group">
          <label for="nama" class="block text-gray-700 font-medium mb-1 text-sm">Full Name</label>
          <input type="text" id="nama" wire:model="nama" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your full name">
          @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="username" class="block text-gray-700 font-medium mb-1 text-sm">Username</label>
          <input type="text" id="username" wire:model="username" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your username">
          @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="email" class="block text-gray-700 font-medium mb-1 text-sm">Email</label>
          <input type="email" id="email" wire:model="email" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your email">
          @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="nama_toko" class="block text-gray-700 font-medium mb-1 text-sm">Store Name</label>
          <input type="text" id="nama_toko" wire:model="nama_toko" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your store name">
          @error('nama_toko') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="telepon_toko" class="block text-gray-700 font-medium mb-1 text-sm">Phone Number</label>
          <input type="tel" id="telepon_toko" wire:model="telepon_toko" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your phone number">
          @error('telepon_toko') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="alamat_toko" class="block text-gray-700 font-medium mb-1 text-sm">Address</label>
          <input type="text" id="alamat_toko" wire:model="alamat_toko" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your address">
          @error('alamat_toko') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="password" class="block text-gray-700 font-medium mb-1 text-sm">Password</label>
          <input type="password" id="password" wire:model="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Enter your password">
          @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div class="group">
          <label for="password_confirmation" class="block text-gray-700 font-medium mb-1 text-sm">Confirm Password</label>
          <input type="password" id="password_confirmation" wire:model="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm transition duration-200 group-hover:border-blue-400" placeholder="Confirm your password">
        </div>
      </div>
      
      <button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 transition duration-300 font-medium shadow-lg hover:shadow-xl text-sm mt-6 transform hover:-translate-y-0.5 hover:scale-[1.02]">
        Register
      </button>
    </form>
    
  </div>