@extends('layouts.lms')

@section('title', 'Dashboard')
@section('page-title', '📊 LMS Dashboard')

@section('content')
    <div class="grid grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold">My Classes</h3>
            <p class="text-2xl">{{ $classCount }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold">Pending Homework</h3>
            <p class="text-2xl">{{ $pendingHomework }}</p>
        </div>

        <div class="bg-white shadow rounded-xl p-6">
            <h3 class="text-lg font-bold">Unread Messages</h3>
            <p class="text-2xl">{{ $unreadMessages }}</p>
        </div>
    </div>
@endsection
