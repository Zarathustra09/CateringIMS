@extends('layouts.guest')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Available Services</h2>
        <div class="row">
            @foreach($services as $service)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->name }}</h5>
                            <p class="card-text">{{ $service->description }}</p>
                            <p class="card-text"><strong>Price:</strong> ${{ $service->price }}</p>
                            <form action="{{ route('reservation.create') }}" method="GET">
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <button type="submit" class="btn btn-primary">Book Now</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
