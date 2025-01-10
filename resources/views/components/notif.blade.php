<!-- Notifikasi -->
<div x-data="{ show: false, message: '', type: '' }"
    x-init="
            @if (session('success'))
                message = '{{ session('success') }}';
                type = 'success';
                show = true;
                setTimeout(() => show = false, 3000);
            @endif

            @if ($errors->any())
                message = `{{ $errors->first() }}`;
                type = 'error';
                show = true;
                setTimeout(() => show = false, 3000);
            @endif
        "
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed top-20 right-6 w-80 p-4 rounded-lg shadow-lg text-white z-50"
    :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error' }"
    style="display: none;">
    <span x-text="message"></span>
</div>