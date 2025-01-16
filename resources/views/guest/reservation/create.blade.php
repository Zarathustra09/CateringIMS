@extends('layouts.guest')

@section('content')
    <div class="container mt-5" style="margin-bottom: 120px;">
        <div class="card mb-4">
            <div class="card-header text-center" style="background-color: #ce1212; color: white;">
                <h2 class="mb-0">Create Reservation</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('reservation.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ request('service_id') }}">

                    <!-- Event Type Dropdown -->
                    <div class="mb-3">
                        <label for="event_type" class="form-label" style="color: black;">Event Type</label>
                        <select class="form-control" id="event_type" name="event_type" required>
                            <option value="">Select Event Type</option>
                            @foreach($categories as $category)
                                <!-- Save the category name instead of the id -->
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Start Date -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label" style="color: black;">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <!-- End Date -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label" style="color: black;">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label for="message" class="form-label" style="color: black;">Message</label>
                        <textarea class="form-control" id="message" name="message"></textarea>
                    </div>

                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-light">Submit</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
