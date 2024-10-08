@extends('layouts.app')

@section('content')
<div class="container wholealign">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <h1 class="logtitle">Log Hours</h1>
            <div class="card wcard">
                <div class="card-body wtitles" >
                    <form method="POST" action="{{ route('store-service') }}">
                    @if(session('success'))
                      <div class="alert alert-success">
                          {{ session('success') }}
                      </div>
                    @endif

                        @csrf

                        <!-- Include jQuery -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <!-- Include Select2 CSS -->
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

                        <!-- Include Select2 JS -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

                        <!-- Dropdown for Client Selection -->
                        <div class="form-group row rowstyle">
                            <label for="client_id" class="col-lg-4 col-md-4 col-sm-12 col-form-label text-md-end">{{ __('Select Client') }}</label>

                            <div class="col-lg-6 col-md-8 col-sm-12">
                                <select id="client_id" class="form-control @error('client_id') is-invalid @enderror" name="client_id" required>
                                    <option value="" class="titlesc">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>

                                @error('client_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <script>
                            $(document).ready(function() {
                                $('#client_id').select2({
                                    width: '100%',  // Ensures full-width scaling
                                    placeholder: "",
                                    allowClear: true
                                });
                            });
                        </script>

                        <!-- Hours Worked -->
                        <div class="form-group row rowstyle">
                            <label for="hours_worked" class="col-lg-4 col-md-4 col-sm-12 col-form-label text-md-end">{{ __('Hours Worked') }}</label>

                            <div class="col-lg-6 col-md-8 col-sm-12">
                                <input id="hours_worked" type="number" step="0.01" class="form-control @error('hours_worked') is-invalid @enderror droptry" name="hours_worked" value="{{ old('hours_worked') }}" required>

                                @error('hours_worked')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Description -->
                        <div class="form-group row rowstyle">
                            <label for="description" class="col-lg-4 col-md-4 col-sm-12 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-lg-6 col-md-8 col-sm-12">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror droptry descript" name="description" rows="4">{{ old('description') }}</textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="subpad">
                            <div class="form-group row mb-0 justify-content-center">
                                <div class="col-md-8 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary subbutton">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
