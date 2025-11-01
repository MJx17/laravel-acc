@extends('layouts.lms')

@section('title', 'Classes')
@section('page-title', '📚 Classes')

@section('content')
    <ul class="space-y-4">
        @foreach ($classes as $class)
            <li class="bg-white shadow p-4 rounded-lg">
                <h3 class="text-lg font-semibold text-indigo-600">{{ $class->name }}</h3>
                <p class="text-gray-600">👩‍🏫 Teacher: <span class="font-medium">{{ $class->teacher }}</span></p>
                <p class="text-gray-600">🕒 Schedule: <span class="font-medium">{{ $class->schedule }}</span></p>
            </li>
        @endforeach
    </ul>
@endsection
