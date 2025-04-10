<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Picture') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Update your profile picture. Maximum size: 1MB') }}
                            </p>
                        </header>

                        <div class="mt-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ auth()->user()->avatar_url }}" 
                                         alt="{{ auth()->user()->name }}" 
                                         class="w-20 h-20 rounded-full object-cover">
                                    @if(auth()->user()->avatar)
                                        <form method="post" action="{{ route('profile.avatar.destroy') }}" class="absolute -top-2 -right-2">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="bg-red-100 text-red-600 rounded-full p-1 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <form method="post" action="{{ route('profile.avatar.update') }}" class="flex-1" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="flex items-center gap-4">
                                        <input type="file" 
                                               name="avatar" 
                                               id="avatar" 
                                               class="block w-full text-sm text-gray-500
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-full file:border-0
                                                      file:text-sm file:font-semibold
                                                      file:bg-blue-50 file:text-blue-700
                                                      hover:file:bg-blue-100"
                                               accept="image/*"
                                               required>
                                        <x-primary-button>{{ __('Update') }}</x-primary-button>
                                    </div>
                                    @error('avatar')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
