@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-600 space-y-1']) }}>
        @if (is_array($messages))
            @foreach ($messages as $message)
                <li>{{ htmlspecialchars($message, ENT_QUOTES, 'UTF-8', false) }}</li>
            @endforeach
        @else
            <li>{{ htmlspecialchars($messages, ENT_QUOTES, 'UTF-8', false) }}</li>
        @endif
    </ul>
@endif
