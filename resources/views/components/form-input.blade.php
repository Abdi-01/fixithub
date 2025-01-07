@props([
'name',
'label'=>null,
'type'=>'text',
'id'=> null,
'value'=> null,
])

<div class="mb-4">
    @if($label ?? false)
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-white">
        {{$label}}
    </label>
    @endif
    <input
        type="{{ $type ?? 'text' }}"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        value="{{ old($name, $value ?? '')}}"
        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
        {{ $attributes }} />
    @error($name)
    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
    @enderror
</div>