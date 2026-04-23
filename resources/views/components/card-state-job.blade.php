@props(['color' => 'gray', 'text' => 'En attente'])

<div class="state-card">
    <span class="state-dot dot-{{ $color }}"></span>
    <span class="state-text">{{ $text }}</span>
</div>