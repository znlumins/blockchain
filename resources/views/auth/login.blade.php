<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-black text-black tracking-tighter">SIPPD LOGIN</h2>
        <p class="text-xs text-gray-500 uppercase tracking-widest">Portal Transparansi Dana Daerah</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-gray-600 hover:text-indigo-600 font-bold" href="{{ route('register') }}">
                Belum punya akun? Daftar
            </a>

            <x-primary-button>
                {{ __('Masuk Sistem') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>