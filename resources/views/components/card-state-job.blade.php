@props(['color' => 'gray', 'text' => 'En attente'])

<div class="state-card">
    <span class="state-dot" style="background-color: {{ $color }};"></span>
    <span class="state-text" style="color: {{ $color }};">
        {{ $text }}
    </span>
</div>


