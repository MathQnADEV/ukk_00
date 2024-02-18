@extends('layouts.error')

@section('title', '403')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="page-error">
        <div class="page-inner">
            <h1>Only Admin</h1>
            <div class="page-description">
                You do not have access to this page.
            </div>
            <div class="page-search">
                <div class="mt-3">
                    <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
