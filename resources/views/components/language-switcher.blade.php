@php
    $currentLocale = app()->getLocale();
    $isRTL = $currentLocale === 'ar';
    
    $languages = [
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'flag' => '🇺🇸',
            'direction' => 'ltr'
        ],
        'ar' => [
            'name' => 'Arabic',
            'native' => 'العربية',
            'flag' => '🇸🇦',
            'direction' => 'rtl'
        ]
    ];
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }">
    <div class="flex items-center space-x-2">
        <button 
            type="button" 
            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200" 
            id="language-menu-button" 
            aria-expanded="true" 
            aria-haspopup="true"
            @click="open = !open"
        >
            <span class="mr-2">{{ $languages[$currentLocale]['flag'] }}</span>
            <span class="hidden sm:inline">{{ $languages[$currentLocale]['native'] }}</span>
            <svg class="-mr-0.5 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" 
        role="menu" 
        aria-orientation="vertical" 
        aria-labelledby="language-menu-button" 
        tabindex="-1"
        @click.away="open = false"
    >
        <div class="py-1" role="none">
            @foreach($languages as $locale => $language)
                <a 
                    href="{{ route('language.switch', $locale) }}" 
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentLocale === $locale ? 'bg-gray-100' : '' }} transition-colors duration-150" 
                    role="menuitem" 
                    tabindex="-1"
                >
                    <span class="mr-3 text-lg">{{ $language['flag'] }}</span>
                    <div class="flex flex-col">
                        <span class="font-medium">{{ $language['name'] }}</span>
                        <span class="text-xs text-gray-500">{{ $language['native'] }}</span>
                    </div>
                    @if($currentLocale === $locale)
                        <svg class="ml-auto h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- Mobile Language Switcher --}}
<div class="sm:hidden">
    <div class="flex items-center space-x-2">
        @foreach($languages as $locale => $language)
            <a 
                href="{{ route('language.switch', $locale) }}" 
                class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md {{ $currentLocale === $locale ? 'bg-indigo-600 text-white border-indigo-600' : 'text-gray-700 bg-white hover:bg-gray-50' }} transition-colors duration-200"
            >
                <span class="mr-2">{{ $language['flag'] }}</span>
                <span class="text-xs">{{ $language['native'] }}</span>
            </a>
        @endforeach
    </div>
</div> 