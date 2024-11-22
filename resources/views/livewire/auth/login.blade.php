<div>
    @section('auth-title')
    Login
    @endsection
    @section('content')
    <form class="mt-8 space-y-6" wire:submit.prevent="login">
        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <label for="login" class="sr-only">Email or Username</label>
                <input wire:model="login" id="login" name="login" type="text" autocomplete="username" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Email or Username">
            </div>
            <div>
                <label for="password" class="sr-only">Password</label>
                <input wire:model="password" id="password" name="password" type="password" autocomplete="current-password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Password">
            </div>
        </div>

        <div>
            <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Sign in
            </button>
        </div>
        @if ($errors->has('login'))
            <div class="text-red-500 text-sm mt-2">
        {{ $errors->first('login') }}
    </div>
@endif
    </form>
    @endsection
</div>
