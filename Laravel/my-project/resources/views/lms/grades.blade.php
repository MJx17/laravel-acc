@extends('layouts.lms')

@section('title', 'Grades')
@section('page-title', '📊 Grades')

@section('content')
    <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
        <thead class="bg-indigo-100 text-indigo-800">
            <tr>
                <th class="py-3 px-4 text-left">Subject</th>
                <th class="py-3 px-4 text-left">Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($grades as $grade)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $grade->subject }}</td>
                    <td class="py-3 px-4 font-semibold text-indigo-600">{{ $grade->grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
