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
    id="openModalRatingBtn"
    class="w-full block sm:inline-block border border-yellow-400  text-yellow-500 px-4 py-1.5 rounded shadow hover:bg-gray-100">
    Rating and Feedback
</button>

<!-- Modal -->
<div
    id="modalRating"
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <!-- Modal Content -->
    <div class="bg-white p-6 rounded shadow-lg max-w-xl w-full">
        <h2 class="text-lg font-bold mb-4">Berikan Feedback</h2>
        <div>
            <!-- Notifikasi -->
            @include('components.notification')
            <!-- Form -->
            <form class="mx-auto">
                @csrf
                <div class="overflow-y-auto">
                    <!-- Rating Section -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Rating</label>
                        <div class="w-fit m-auto flex flex-row-reverse items-center space-x-1">
                            <!-- Rating 1 Star -->
                            <input type="radio" id="rating-1" name="rating" value="1" class="hidden" />
                            <label for="rating-1" class="star cursor-pointer text-gray-400 hover:text-yellow-400">★</label>

                            <!-- Rating 2 Stars -->
                            <input type="radio" id="rating-2" name="rating" value="2" class="hidden" />
                            <label for="rating-2" class="star cursor-pointer text-gray-400 hover:text-yellow-400">★</label>

                            <!-- Rating 3 Stars -->
                            <input type="radio" id="rating-3" name="rating" value="3" class="hidden" />
                            <label for="rating-3" class="star cursor-pointer text-gray-400 hover:text-yellow-400">★</label>

                            <!-- Rating 4 Stars -->
                            <input type="radio" id="rating-4" name="rating" value="4" class="hidden" />
                            <label for="rating-4" class="star cursor-pointer text-gray-400 hover:text-yellow-400">★</label>

                            <!-- Rating 5 Stars -->
                            <input type="radio" id="rating-5" name="rating" value="5" class="hidden" />
                            <label for="rating-5" class="star cursor-pointer text-gray-400 hover:text-yellow-400">★</label>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="comment" class="block mb-2 text-sm font-medium">Comment</label>
                        <textarea id="comment" name="comment" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                            placeholder="Berikan komentar"></textarea>
                    </div>

                </div>
                <div class="flex justify-end space-x-2">
                    <button
                        id="closeModalRatingBtn"
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
    const openModalRatingBtn = document.getElementById('openModalRatingBtn');
    const closeModalRatingBtn = document.getElementById('closeModalRatingBtn');
    const modalRating = document.getElementById('modalRating');

    // Fungsi buka modalRating
    openModalRatingBtn.addEventListener('click', () => {
        modalRating.classList.remove('hidden'); // Tampilkan modalRating
    });

    // Fungsi tutup modalRating
    closeModalRatingBtn.addEventListener('click', () => {
        modalRating.classList.add('hidden'); // Sembunyikan modalRating
    });

    // Tutup modalRating jika pengguna mengklik di luar konten modalRating
    modalRating.addEventListener('click', (event) => {
        if (event.target === modalRating) {
            modalRating.classList.add('hidden');
        }
    });

    // rating
    // Ambil nilai rating yang dipilih
    // const ratingInputs = document.querySelectorAll('input[name="rating"]');
    // let selectedRating = null;

    // ratingInputs.forEach(input => {
    //     input.addEventListener('change', (event) => {
    //         selectedRating = event.target.value;
    //     });
    // });

    // // Kirim rating ke controller saat form disubmit
    // const form = document.querySelector('form');
    // form.addEventListener('submit', (event) => {
    //     if (!selectedRating) {
    //         event.preventDefault();
    //         alert('Pilih rating terlebih dahulu');
    //     } else {
    //         // Tambahkan rating ke dalam form sebelum dikirim
    //         const ratingField = document.createElement('input');
    //         ratingField.type = 'hidden';
    //         ratingField.name = 'rating';
    //         ratingField.value = selectedRating;
    //         form.appendChild(ratingField);
    //     }
    // });
</script>