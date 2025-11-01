@extends('layouts.lms')

@section('title', 'Dashboard')
@section('page-title', 'Welcome back 👋')

@section('content')
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="text-lg font-semibold text-indigo-600">My Classes</h3>
            <p class="text-gray-600">{{ $classCount }} classes enrolled</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="text-lg font-semibold text-indigo-600">Homework</h3>
            <p class="text-gray-600">{{ $pendingHomework }} pending assignments</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-5">
            <h3 class="text-lg font-semibold text-indigo-600">Messages</h3>
            <p class="text-gray-600">{{ $unreadMessages }} unread messages</p>
        </div>
    </div>
@endsection
