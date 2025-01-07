<button
    id="openModalBtn"
    class="block sm:inline-block bg-blue-600 text-white px-4 py-1.5 rounded shadow hover:bg-blue-700">Berikan Solusi</button>

<!-- Modal -->
<div
    id="modal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg max-w-md w-full">
        <h2 class="text-lg font-bold mb-4">Modal Title</h2>
        <p class="mb-4">This is a modal content.</p>
        <div class="flex justify-end space-x-2">
            <button
                id="closeModalBtn"
                class="px-4 py-2 bg-gray-300 rounded">
                Close
            </button>
            <button
                id="saveModalBtn"
                class="px-4 py-2 bg-blue-500 text-white rounded">
                Save
            </button>
        </div>
    </div>
</div>
<script>
    // Ambil elemen
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const modal = document.getElementById('modal');

    // Fungsi buka modal
    openModalBtn.addEventListener('click', () => {
        modal.classList.remove('hidden'); // Tampilkan modal
    });

    // Fungsi tutup modal
    closeModalBtn.addEventListener('click', () => {
        modal.classList.add('hidden'); // Sembunyikan modal
    });

    // Tutup modal jika pengguna mengklik di luar konten modal
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>