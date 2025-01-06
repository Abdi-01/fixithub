@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="space-y-5">
    <!-- Hero Section -->
    <section class="">
        <div class="container flex items-center mx-auto px-6">
            <div class="flex-1 pr-4">
                <h1 class="text-5xl font-bold text-blue-600 mb-4">Kolaborasi Efektif untuk Solusi Bersama</h1>
                <p class="font-thin text-lg text-gray-700 mb-6">Hubungkan masyarakat dan pemerintah untuk menyelesaikan masalah sosial melalui diskusi, laporan, dan solusi yang terverifikasi.</p>
                <div class="space-y-4 sm:space-x-4 sm:space-y-0">
                    <a href="/signup" class="block sm:inline-block bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700">Daftar Sekarang</a>
                    <a href="#learn-more" class="block sm:inline-block bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded-lg shadow hover:bg-blue-50">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="flex-1">
                <img src="https://images.unsplash.com/photo-1616259833791-9a8d5529a87c" />
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Apa yang Bisa Dilakukan?</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <img src="https://via.placeholder.com/100" alt="Report" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Lapor Masalah</h3>
                    <p class="text-gray-600">Laporkan masalah di sekitar Anda untuk mendapatkan perhatian dari komunitas dan pemerintah.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <img src="https://via.placeholder.com/100" alt="Discuss" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Diskusikan Solusi</h3>
                    <p class="text-gray-600">Berkolaborasi dengan masyarakat untuk menemukan solusi terbaik.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <img src="https://via.placeholder.com/100" alt="Verify" class="mx-auto mb-4">
                    <h3 class="text-xl font-semibold mb-2">Verifikasi & Implementasi</h3>
                    <p class="text-gray-600">Pemerintah akan memverifikasi laporan dan memastikan solusi diterapkan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-blue-50 py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Tentang Kami</h2>
            <p class="text-lg text-gray-700 text-center max-w-3xl mx-auto">Crowdsourcing System adalah platform yang dirancang untuk menghubungkan masyarakat dan pemerintah dalam menyelesaikan berbagai masalah sosial dengan cara yang efektif, transparan, dan kolaboratif.</p>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section id="signup" class="py-16">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Bergabunglah Sekarang</h2>
            <p class="text-lg text-gray-700 mb-6">Mulai perjalanan Anda untuk berkontribusi dalam menyelesaikan masalah sosial.</p>
            <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700">Daftar Sekarang</a>
        </div>
    </section>

</div>
@endsection