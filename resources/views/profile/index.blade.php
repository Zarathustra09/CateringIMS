@extends(auth()->user()->role_id == 2 ? 'layouts.app' : (auth()->user()->role_id == 1 ? 'layouts.staff.app' : 'layouts.guest'))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Profile</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Profile Details</h5>
                            </div>
                            <div class="card-body text-center">
<div class="position-relative d-inline-block mb-3">
                                 <img src="{{ auth()->user()->profile_image ? Storage::url(auth()->user()->profile_image) : 'https://placehold.co/128x128' }}"
                                      alt="{{ auth()->user()->name }}"
                                      class="rounded-circle profile-image shadow-sm"
                                      width="128"
                                      height="128" />
                                 <label for="profile-image-upload" class="position-absolute bottom-0 end-0 btn btn-sm btn-primary rounded-circle profile-image-upload-btn">
                                     <i class="bx bx-camera"></i>

                                 </label>
                             </div>                                <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                <p class="text-muted mb-3">{{ auth()->user()->role_id == 0 ? 'Employee' : 'Admin' }}</p>

                                <div class="d-flex justify-content-center gap-2">
                                    <form method="POST" action="{{ route('profile.uploadImage') }}" enctype="multipart/form-data" id="upload-form" class="d-inline">
                                        @csrf
                                        <input type="file" id="profile-image-upload" name="profile_image" class="d-none" accept="image/*" onchange="document.getElementById('upload-form').submit()" />
                                    </form>

                                    <form method="POST" action="{{ route('profile.resetImage') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning btn-sm">
                                            <i class="bx bx-undo me-1"></i>Reset Image
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <hr class="my-0" />
                            <div class="card-body">
                                <h5 class="h6 card-title">About</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1">
                                        <span data-feather="phone" class="feather-sm me-1"></span>
                                        Contact Number: <a href="#">{{ auth()->user()->phone_number }}</a>
                                    </li>
                                    <li class="mb-1">
                                        <span data-feather="mail" class="feather-sm me-1"></span>
                                        Email: <a href="#">{{ auth()->user()->email }}</a>
                                    </li>
                                    <li class="mb-1">
                                        <span data-feather="user" class="feather-sm me-1"></span>
                                        Position: <a href="#">{{ auth()->user()->role_id == 0 ? 'Employee' : 'Admin' }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-xl-9">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Edit Profile</h5>
                            </div>
                            <div class="card-body h-100">
                                <form method="POST" action="{{ route('profile.update') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" value="{{ auth()->user()->phone_number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" placeholder="New Password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->role_id == 2 ? 'Admin' : 'Employee' }}" readonly>
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                        <button type="reset" class="btn btn-warning">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .profile-image {
            object-fit: cover;
            width: 128px;
            height: 128px;
            border: 3px solid white;
        }

        .profile-image-upload-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .profile-image-upload-btn i {
            font-size: 14px;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('profile-image-upload').addEventListener('change', function() {
                document.getElementById('upload-form').submit();
            });

            @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            @endif

            @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'OK'
            });
            @endif
        });
    </script>
@endpush
