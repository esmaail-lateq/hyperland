        @php
            $currentLocale = app()->getLocale();
    $availableLocales = ['en' => 'EN', 'ar' => 'عربي'];
        @endphp
        
<div class="flex items-center bg-white/20 dark:bg-slate-800/20 backdrop-blur-xl rounded-full p-1 shadow-lg shadow-black/10 dark:shadow-black/20 border border-white/30 dark:border-slate-600/30">
        @foreach($availableLocales as $locale => $name)
            <a href="{{ route('language.switch', $locale) }}" 
           class="px-4 py-2 text-sm font-bold rounded-full transition-all duration-300 {{ $currentLocale === $locale ? 'bg-white/80 dark:bg-slate-700/80 text-slate-800 dark:text-slate-200 shadow-md' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-white/40 dark:hover:bg-slate-700/40' }}">
            <div class="flex items-center space-x-1">
                <div class="w-2.5 h-2.5 rounded-full {{ $currentLocale === $locale ? 'bg-blue-500 dark:bg-blue-400' : 'bg-slate-400 dark:bg-slate-500' }}"></div>
                    <span>{{ $name }}</span>
                </div>
            </a>
        @endforeach
</div> 