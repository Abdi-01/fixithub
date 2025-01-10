@extends('layouts.app')

@section('title', 'Sign In')

@section('content')
<div class="py-24">
    <!-- Notifikasi -->
    <x-notif />
    <!-- Form -->
    <form action="{{ route('signin') }}" method="POST" class="max-w-sm px-10 py-6 bg-gray-800 border-gray-700 rounded-lg shadow-md mx-auto">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-white">Selamat Datang</h5>
        @csrf
        <x-form-input type="email" label="Email" name="email" placeholder="email@example.com" required />
        <x-form-input type="password" label="Password" name="password" required />
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Masuk
        </button>
    </form>
</div>
@endsection