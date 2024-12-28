@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div>
    <h1 class="text-4xl font-bold text-center text-blue-600">About Us</h1>
    <p class="mt-4 text-lg text-gray-700">
        Welcome to the About page. This is built with Laravel and Tailwind CSS.
    </p>
    <a href="/" class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Back to Home
    </a>
</div>
@endsection