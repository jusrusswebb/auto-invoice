<!-- resources/views/admin/add_client.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Client</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('add-client') }}">
        @csrf

        <div class="form-group">
            <label for="name">Client Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="payroll_fee">Payroll Fee</label>
            <input type="number" class="form-control @error('payroll_fee') is-invalid @enderror" id="payroll_fee" name="payroll_fee" value="{{ old('payroll_fee') }}">
            @error('payroll_fee')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="book_rate">Book Rate</label>
            <input type="number" class="form-control @error('book_rate') is-invalid @enderror" id="book_rate" name="book_rate" value="{{ old('book_rate') }}">
            @error('book_rate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="is_book_flat_rate">Is Book Flat Rate?</label>
            <input type="checkbox" id="is_book_flat_rate" name="is_book_flat_rate" value="1">
        </div>

        <button type="submit" class="btn btn-primary">Add Client</button>
    </form>
</div>
@endsection