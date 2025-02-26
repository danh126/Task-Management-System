<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Bạn quên mật khẩu? Nhập vào Email đã đăng ký trước đó, để lấy lại mật khẩu.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 space-x-2">
            <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition duration-300">
                Đăng nhập
            </a>                                   
            <x-primary-button >
                {{ __('Lấy lại mật khẩu') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
