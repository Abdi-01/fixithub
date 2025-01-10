<div id="notification"
    class="fixed top-20 right-6 w-80 p-4 rounded-lg shadow-lg text-white z-50 transition-all duration-300 opacity-0 transform translate-y-2"
    style="display: none;">
    <span id="notification-message"></span>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notification-message');

        // Mengambil notifikasi dari PHP session
        const successMessage = "{{ session('success') }}";
        const errorMessage = "{{ $errors->any() ? $errors->first() : '' }}";

        if (successMessage || errorMessage) {
            // Tampilkan notifikasi
            notificationMessage.textContent = successMessage || errorMessage;
            notification.classList.add(successMessage ? 'bg-green-500' : 'bg-red-500');
            notification.style.display = 'block';

            // Tambahkan animasi
            setTimeout(() => {
                notification.classList.remove('opacity-0', 'translate-y-2');
                notification.classList.add('opacity-100', 'translate-y-0');
            }, 50);

            // Sembunyikan setelah 3 detik
            setTimeout(() => {
                notification.classList.remove('opacity-100', 'translate-y-0');
                notification.classList.add('opacity-0', 'translate-y-2');

                // Hapus elemen setelah animasi selesai
                setTimeout(() => {
                    notification.style.display = 'none';
                }, 300);
            }, 3000);
        }
    });
</script>