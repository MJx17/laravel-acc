@extends('layouts.lms')

@section('title', 'Homework')
@section('page-title', '✏️ Homework')

@section('content')
    <ul class="space-y-3">
        @foreach ($homework as $hw)
            <li class="bg-white p-4 rounded-lg shadow">
                <div class="flex justify-between items-center">
                    <span class="font-medium">{{ $hw->title }}</span>
                    <span class="text-sm text-gray-500">Due: {{ $hw->due }}</span>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
