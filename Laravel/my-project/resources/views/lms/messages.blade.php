@extends('layouts.lms')

@section('title', 'Messages')
@section('page-title', '💌 Messages')

@section('content')
    <div class="space-y-4">
        @foreach ($messages as $message)
            <div class="bg-white shadow p-4 rounded-lg">
                <h3 class="text-indigo-600 font-semibold">From: {{ $message->from }}</h3>
                <p class="text-gray-700 mt-1">{{ $message->body }}</p>
            </div>
        @endforeach
    </div>
@endsection
