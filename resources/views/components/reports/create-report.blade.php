<!-- Place the first <script> tag in your HTML's <head> -->
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
<div class="space-y-5">
    <div class="max-w-xl m-auto p-3 md:p-6 bg-gray-800 border-gray-700 rounded-lg shadow-md">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Sampaikan Laporan Anda</h5>
        <!-- Notifikasi -->
        @include('components.notification')
        <form action="{{ route('report.submit') }}" method="POST" enctype="multipart/form-data" class="mx-auto">
            @csrf
            <x-form-input type="text" label="Judul" name="title" placeholder="Ketik Judul Laporan" classLabel="text-white" required />
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-white">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                    placeholder="Jelaskan laporan anda...."></textarea>
            </div>
            <div class="flex justify-between mb-5 gap-5">
                <div class="flex-1">
                    <label for="location" class="block mb-2 text-sm font-medium text-white">Lokasi</label>
                    <input type="text" id="location" name="location"
                        class="rounded-md bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="Info lokasi" required />
                </div>
                <div class="flex-1">
                    <label for="category" class="block mb-2 text-sm font-medium text-white">Kategori</label>
                    <select id="category" name="category"
                        class="rounded-md bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                            <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">SVG, PNG, JPG, GIF, or PDF (MAX. 800x400px)</p>
                        </div>
                        <input id="mediafile" type="file" name="mediafile" class="hidden" onchange="previewFile(event)" />
                    </label>
                    <div id="preview-container" class="hidden flex flex-col items-center gap-2 mt-2">
                        <img id="image-preview" src="" alt="Preview" class="max-w-full max-h-64 rounded-md" />
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center ">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewFile(event) {
        const fileInput = event.target;
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        const file = fileInput.files[0]; // Ambil file yang diunggah

        // Reset tampilan preview
        previewContainer.classList.add('hidden');
        imagePreview.src = '';

        if (file) {
            if (file.type.startsWith('image/') || file.type === 'application/pdf') {
                const reader = new FileReader();

                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        // Jika file adalah gambar, tampilkan di elemen img
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block'; // Pastikan img terlihat
                    } else if (file.type === 'application/pdf') {
                        // Jika file adalah PDF, buat link untuk unduh atau tampilkan pesan
                        imagePreview.src = ''; // Kosongkan src untuk img
                        const pdfMessage = `<p class="text-center text-sm text-gray-50">PDF file selected. Use it in your form or upload.</p>`;
                        previewContainer.innerHTML = pdfMessage;
                    }

                    // Tampilkan kontainer preview
                    previewContainer.classList.remove('hidden');
                };

                // Baca file sebagai Data URL
                reader.readAsDataURL(file);
            } else {
                alert('File yang dipilih harus berupa gambar (SVG, PNG, JPG, GIF) atau PDF!');
                fileInput.value = ''; // Reset input file
            }
        }
    }
</script>