<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/dropdown.css'])
</head>

@props(['label', 'name', 'options', 'selected' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-start gap-2']) }}>
    <label for="{{ $name }}" class="text-white">
        {{ $label }}
    </label>
    <select name="{{ $name }}" id="{{ $name }}" class="dropdown-menu">
        @foreach ($options as $value => $display)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $display }}
            </option>
        @endforeach
    </select>
</div>
