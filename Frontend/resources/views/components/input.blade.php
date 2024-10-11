@props([
    'type' => 'text',
    'name',
    'id' => null,
    'label' => null,
    'value' => '',
    'required' => false,
    'class' => 'form-control',
])

<div class="form-group">
    @if($label)
        <label for="{{ $id ?? $name }}">{{ $label }}</label>
    @endif
    <input 
        type="{{ $type }}" 
        class="{{ $class }}" 
        id="{{ $id ?? $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        {{ $required ? 'required' : '' }}
        {{ $attributes }}
    >
</div>
