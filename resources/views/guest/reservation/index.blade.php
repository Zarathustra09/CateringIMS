@extends('layouts.guest')

@section('content')
    <div class="container py-8" style="padding-top: 50px; padding-bottom: 120px;"> <!-- Added padding-top -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Our Services</h2>
            <p class="text-gray-600">Choose from our range of professional services</p>
         @if(session('error'))
             <div class="alert alert-danger">
                 {{ session('error') }}
             </div>
         @endif
        </div>

        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        @if($service->image)
                            <img src="{{ $service->image }}" class="card-img-top" alt="{{ $service->name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="mb-4">
                                <h5 class="card-title font-bold text-xl mb-2">{{ $service->name }}</h5>
                                <p class="card-text text-gray-600">{{ $service->description }}</p>
                            </div>

                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-2xl font-semibold text-primary">₱{{ number_format($service->price, 2) }}</span>
                                    @if($service->duration)
                                        <span class="text-gray-500">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $service->duration }} mins
                                        </span>
                                    @endif
                                </div>

                                <form action="{{ route('reservation.create') }}" method="GET">
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                                    <button type="submit"
                                            class="btn text-white w-100 py-2 transition-all duration-300" style="background-color: #ce1212; border-radius: 0.375rem;">
                                        <i class="fas fa-calendar-plus me-2"></i>Book Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($services->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No services available at the moment.</p>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .card {
                border: none;
                border-radius: 0.5rem;
            }
            .card-img-top {
                height: 200px;
                object-fit: cover;
                border-top-left-radius: 0.5rem;
                border-top-right-radius: 0.5rem;
            }
            .btn {
                border-radius: 0.375rem;
            }
            .card-header {
                background-color: #ce1212;
                color: white;
            }
        </style>
    @endpush
@endsection
