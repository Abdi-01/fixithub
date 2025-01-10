@props([
'slugReportId'
])
<button
    id="openModalBtn"
    class="block sm:inline-block bg-blue-600 text-white px-4 py-1.5 rounded shadow hover:bg-blue-700">Berikan Solusi</button>

<!-- Modal -->
<div
    id="modal"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg max-w-xl w-full">
        <h2 class="text-lg font-bold mb-4">Berikan Masukan</h2>
        <div>
            <!-- Notifikasi -->
            @include('components.notification')
            <!-- Form -->
            <form action="{{ route('solution.submit', ['slug' => $slugReportId]) }}" method="POST" enctype="multipart/form-data" class="mx-auto">
                <x-solutions.create-solution />
                <div class="flex justify-end space-x-2">
                    <button
                        id="closeModalBtn"
                        class="px-4 py-2 bg-gray-300 rounded">
                        Close
                    </button>
                    <button
                        id="saveModalBtn"
                        type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded">
                        Save
                    </button>
                </div>
            </form>
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