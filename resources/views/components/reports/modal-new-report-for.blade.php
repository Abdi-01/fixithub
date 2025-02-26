@props([
'slugReportId'
])

<script src="https://cdn.tiny.cloud/1/v8ys1t6tqub2h9uaz7osyblyceriapagz7i8j5hlj3f0732g/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
    tinymce.init({
        selector: '#description',
        menubar: false,
        // plugins: [
        //     // Core editing features
        //     'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        //     // Your account includes a free trial of TinyMCE premium features
        //     // Try the most popular premium features until Jan 21, 2025:
        //     'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
        // ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [{
                value: 'First.Name',
                title: 'First Name'
            },
            {
                value: 'Email',
                title: 'Email'
            },
        ],
        // ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
    });
</script>

<style>
    .star {
        font-size: 1.5rem;
        transition: color 0.2s;
    }

    input[type="radio"]:checked~.star {
        color: #ffcc00;
        /* Warna bintang yang dipilih */
    }

    input[type="radio"]:checked~.star:hover {
        color: #f1a100;
        /* Warna saat hover bintang yang dipilih */
    }

    input[type="radio"]:not(:checked)~.star:hover {
        color: #ffcc00;
        /* Warna hover saat belum dipilih */
    }
</style>
<button
    id="openModalNewReportFor"
    class="w-full block sm:inline-block border border-blue-400  text-blue-500 px-4 py-1.5 rounded shadow hover:bg-gray-100">
    Buat Laporan Dari Ini
</button>

<!-- Modal -->
<div
    id="modalNewReportFor"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg max-w-xl w-full">
        <h2 class="text-lg font-bold mb-4">Berikan Laporan Baru dari Masalah ini</h2>
        <div>
            <!-- Notifikasi -->
            @include('components.notification')
            <!-- Form -->
            <form action="{{ route('report.for', ['slug' => $slugReportId])  }}" method="POST" enctype="multipart/form-data" class="mx-auto">
                @csrf
                <div class="h-[40rem] overflow-y-auto">

                    <!-- New report by problem  -->
                    <x-form-input type="text" label="Judul" name="title" placeholder="Ketik Judul Laporan" required />
                    <div class="mb-5">
                        <label for="description" class="block mb-2 text-sm font-medium">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                            placeholder="Jelaskan laporan anda...."></textarea>
                    </div>
                    <div class="flex justify-between mb-5 gap-5">
                        <div class="flex-1">
                            <x-form-input type="text" label="Lokasi" name="location" placeholder="Info lokasi" required />
                        </div>
                        <div class="flex-1">
                            <label for="category" class="block mb-2 text-sm font-medium">Kategori</label>
                            <select id="category" name="category"
                                class="shadow-sm bg-gray-50 border border-gray-300 rounded-md placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                                <option selected disabled>Pilih kategori laporan</option>
                                <option value="Kependudukan">Kependudukan</option>
                                <option value="Lingkungan">Lingkungan</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Transportasi">Transportasi</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Digital">Digital</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-5">
                        <div class="flex items-center gap-2">
                            <label for="mediafile"
                                class="flex flex-col items-center justify-center w-full h-fit border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                                </div>
                                <input id="mediafile" type="file" name="mediafile" class="hidden" onchange="previewImage(event)" />
                            </label>
                            <div id="preview-container" class="hidden">
                                <img id="image-preview" src="" alt="Preview Gambar" class="max-w-full max-h-64 rounded-md" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button
                        id="closeModalNewReportFor"
                        class="px-4 py-2 bg-gray-300 rounded">
                        Close
                    </button>
                    <button
                        id="saveModalBtn"
                        type="submit"
                        class="px-4 py-2 bg-blue-500 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Ambil elemen
    const openModalNewReportFor = document.getElementById('openModalNewReportFor');
    const closeModalNewReportFor = document.getElementById('closeModalNewReportFor');
    const modalNewReportFor = document.getElementById('modalNewReportFor');

    // Fungsi buka modalNewReportFor
    openModalNewReportFor.addEventListener('click', () => {
        modalNewReportFor.classList.remove('hidden'); // Tampilkan modalNewReportFor
    });

    // Fungsi tutup modalNewReportFor
    closeModalNewReportFor.addEventListener('click', () => {
        modalNewReportFor.classList.add('hidden'); // Sembunyikan modalNewReportFor
    });

    // Tutup modalNewReportFor jika pengguna mengklik di luar konten modalNewReportFor
    modalNewReportFor.addEventListener('click', (event) => {
        if (event.target === modalNewReportFor) {
            modalNewReportFor.classList.add('hidden');
        }
    });


    function previewImage(event) {
        const fileInput = event.target;
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');

        // Pastikan file yang dipilih adalah gambar
        if (fileInput.files && fileInput.files[0]) {
            const file = fileInput.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Set URL gambar ke src elemen img
                    imagePreview.src = e.target.result;
                    // Tampilkan kontainer preview
                    previewContainer.classList.remove('hidden');
                };

                // Baca file sebagai Data URL
                reader.readAsDataURL(file);
            } else {
                alert('File yang dipilih bukan gambar!');
                fileInput.value = ''; // Reset input file
                previewContainer.classList.add('hidden');
            }
        }
    }
</script>