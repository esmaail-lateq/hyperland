@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 border-t-4 border-blue-600">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 mb-4">
                    {{ __('Language Settings') }}
                </h1>
                <p class="text-gray-600">
                    {{ __('Choose your preferred language for the application') }}
                </p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('language.update-settings') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-800 mb-4">
                            {{ __('Select Language') }}
                        </label>
                        
                        <div class="grid gap-4">
                            @foreach($supportedLocales as $locale => $language)
                                <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200 {{ $currentLocale === $locale ? 'ring-2 ring-blue-500 bg-blue-50' : '' }}">
                                    <input 
                                        type="radio" 
                                        name="locale" 
                                        value="{{ $locale }}" 
                                        class="sr-only"
                                        {{ $currentLocale === $locale ? 'checked' : '' }}
                                    >
                                    
                                    <div class="flex items-center h-5">
                                        <div class="w-4 h-4 border-2 rounded-full {{ $currentLocale === $locale ? 'border-blue-500 bg-blue-500' : 'border-gray-300' }}">
                                            @if($currentLocale === $locale)
                                                <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center">
                                            <span class="text-2xl mr-3">{{ $language['flag'] }}</span>
                                            <div>
                                                <p class="text-lg font-semibold text-gray-900">
                                                    {{ $language['name'] }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $language['native'] }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $language['direction'] === 'rtl' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $language['direction'] === 'rtl' ? 'Right-to-Left' : 'Left-to-Right' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($currentLocale === $locale)
                                        <div class="absolute top-4 right-4">
                                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                        
                        @error('locale')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">
                            {{ __('Language Information') }}
                        </h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• {{ __('The selected language will be applied to all pages') }}</li>
                            <li>• {{ __('Your preference will be saved for future visits') }}</li>
                            <li>• {{ __('You can change the language at any time') }}</li>
                            <li>• {{ __('Arabic language includes RTL (Right-to-Left) support') }}</li>
                        </ul>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            {{ __('Back') }}
                        </a>
                        
                        <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Save Settings') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 