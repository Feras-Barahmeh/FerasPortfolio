<form  method="post" action="{{ route('settings.update.main.info') }}" class="">
    @csrf
    @method('patch')
    <div class="p-20 bg-white rad-10 h-full">
        <x-alerts.alert :success="session('update-main-info-success')"/>

        <h2 class="mt-0 mb-10 text-capitalize">main info</h2>
        <p class="mt-0 mb-20 c-grey fs-15 text-capitalize">update your account's profile information and email address.</p>
        <div class="mb-15">
            <x-input-label for="name" :value="__('name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $admin->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="mb-15">
            <x-input-label for="username" :value="__('username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $admin->username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $admin->email)" required autocomplete="admin name" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $admin->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4 mt-10">
            <x-primary-button>{{ __('save') }}</x-primary-button>
        </div>
    </div>

</form>
