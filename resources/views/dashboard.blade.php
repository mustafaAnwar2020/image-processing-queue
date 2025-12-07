@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="text-[#706f6c] dark:text-[#A1A09A]">Upload and manage your images</p>
    </div>

    @include('assets.upload')
    
    @include('assets.preview')
</div>
@endsection

