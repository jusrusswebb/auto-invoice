@extends('layouts.app')

@section('content')
<div class="container-fluid"> <!-- Use container-fluid for full width scaling -->

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-12"> <!-- Adjust for larger screens and mobile -->
            <h1 class="logtitle addtitle text-center">Add New Client</h1> <!-- Centered title for mobile friendliness -->
            
            <form method="POST" class="wcard wtitles" action="{{ route('add-client') }}">
                @csrf

                <div class="form-group pb-4">
                    <label for="name">Client Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror droptry2" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group pb-4">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror droptry2" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group pb-4">
                    <label for="payroll_fee">Payroll Fee</label>
                    <input type="number" class="form-control @error('payroll_fee') is-invalid @enderror droptry2" id="payroll_fee" name="payroll_fee" value="{{ old('payroll_fee') }}">
                    @error('payroll_fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group pb-4">
                    <label for="book_rate">Book Rate</label>
                    <input type="number" class="form-control @error('book_rate') is-invalid @enderror droptry2" id="book_rate" name="book_rate" value="{{ old('book_rate') }}">
                    @error('book_rate')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group pb-4">
                    <label for="is_book_flat_rate">Is Book Flat Rate?</label>
                    <input type="checkbox" class="form-check-input pinkcheck me-2" id="is_book_flat_rate" name="is_book_flat_rate" value="1">
                </div>

                <div class="form-group row mb-0 justify-content-center">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary subbutton">Add Client</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
