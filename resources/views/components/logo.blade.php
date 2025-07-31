<div class="shrink-0 flex items-center">
    <a href="{{ route('home') }}" class="flex items-center space-x-4 group transition-all duration-500 hover:scale-110">
        <div class="relative">
            <!-- Large Logo without Background -->
            <img src="{{ asset('images/logo.svg') }}" alt="HybridLand Logo" class="w-20 h-20 lg:w-24 lg:h-24 group-hover:scale-110 transition-all duration-500">
            <!-- Animated Status Dot -->
            <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full animate-pulse shadow-lg shadow-emerald-400/50 border-2 border-white dark:border-slate-800"></div>
        </div>
        <div class="flex flex-col">
            <span class="text-2xl lg:text-3xl font-black text-slate-800 dark:text-slate-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-all duration-500">
                HybridLand
            </span>
            <span class="text-sm lg:text-base text-slate-600 dark:text-slate-400 font-medium group-hover:text-slate-700 dark:group-hover:text-slate-300 transition-colors duration-500">
                Auto Market
            </span>
        </div>
    </a>
</div> 