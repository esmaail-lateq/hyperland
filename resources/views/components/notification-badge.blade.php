@props(['count' => 0])

@if($count > 0)
    <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center animate-pulse shadow-lg shadow-red-500/50">
        {{ $count > 99 ? '99+' : $count }}
    </div>
@endif