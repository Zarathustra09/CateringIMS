@extends('layouts.guest')

@section('content')
    <div class="container my-5" style="margin-bottom: 120px;">
        <div class="card shadow-lg border-0 rounded-3 mb-4">
            <div class="card-header text-center py-3" style="background-color: #ce1212; color: white;">
                <h2 class="mb-0 fw-bold">Create Reservation</h2>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <form id="reservationForm" action="{{ route('reservation.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ request('service_id') }}">

                            <div class="mb-3">
                                <label for="event_name" class="form-label fw-semibold" style="color: black;">Event Name</label>
                                <input type="text" class="form-control form-control-lg shadow-sm" id="event_name" name="event_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="event_type" class="form-label fw-semibold" style="color: black;">Event Type</label>
                                <select class="form-control form-control-lg shadow-sm" id="event_type" name="event_type" required>
                                    <option value="">Select Event Type</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label fw-semibold" style="color: black;">Start Date</label>
                                        <input type="datetime-local" class="form-control form-control-lg shadow-sm" id="start_date" name="start_date" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label fw-semibold" style="color: black;">End Date</label>
                                        <input type="datetime-local" class="form-control form-control-lg shadow-sm" id="end_date" name="end_date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold" style="color: black;">Message</label>
                                <textarea class="form-control shadow-sm" id="message" name="message" rows="4"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="color: black;">Message</label>
                                <textarea class="form-control shadow-sm" id="message" name="message" rows="4"></textarea>
                            </div>

                            <!-- Add payment type selection here -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold" style="color: black;">Payment Option</label>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card payment-option shadow-sm h-100">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_type" id="fullPayment" value="full" checked>
                                                    <label class="form-check-label w-100" for="fullPayment">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="fw-bold">Full Payment</span>
                                                            <span class="badge" style="background-color: #ce1212;">100%</span>
                                                        </div>
                                                        <p class="text-muted small mb-0">Pay the total amount now</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card payment-option shadow-sm h-100">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="payment_type" id="downPayment" value="downpayment">
                                                    <label class="form-check-label w-100" for="downPayment">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="fw-bold">Down Payment</span>
                                                            <span class="badge" style="background-color: #ce1212;">50%</span>
                                                        </div>
                                                        <p class="text-muted small mb-0">Pay half now, half later</p>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <p id="menuCounter" class="mb-2">0 of 1-3 menus selected</p>
                                <button type="button" id="submitReservation" class="btn btn-danger px-5 py-2 fw-bold" style="background-color: #ce1212;" onclick="submitReservationForm()" disabled>Submit Reservation</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div id="calendar" class="shadow-sm rounded border p-2 h-100"></div>
                    </div>
                </div>

                <!-- Menu Cards Section -->
                <h3 class="mt-5 mb-4 fw-bold text-center" style="color: #ce1212;">Available Menus</h3>
                <div class="row g-4 mt-2">
                    @foreach($menus as $menu)
                        <div class="col-md-4 mb-3">
                            <div id="menu-card-{{ $menu->id }}" class="card h-100 shadow-sm hover-shadow border-0 rounded-3 overflow-hidden">
                                @if($menu->menuItems->first())
                                    <div style="height: 200px; overflow: hidden;">
                                        <img src="{{ Storage::url($menu->menuItems->first()->image) }}"
                                             class="card-img-top h-100 w-100"
                                             style="object-fit: cover; cursor: pointer; transition: transform 0.3s;"
                                             alt="{{ $menu->name }}"
                                             onclick="showMenuItems({{ $menu->id }}, '{{ Storage::url($menu->menuItems->first()->image) }}')"
                                             onmouseover="this.style.transform='scale(1.05)'"
                                             onmouseout="this.style.transform='scale(1)'">
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold" style="color: #ce1212;">{{ $menu->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ $menu->description }}</p>
                                    <button class="btn btn-sm btn-outline-danger mt-2"
                                            style="color: #ce1212; border-color: #ce1212;"
                                            data-menu-id="{{ $menu->id }}"
                                            onclick="toggleMenuSelection({{ $menu->id }})">
                                        Select Menu
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: rgba(206, 18, 18, 0.4);
            box-shadow: 0 0 0 0.25rem rgba(206, 18, 18, 0.25);
        }

        .selected {
            border: 2px solid #ce1212;
            box-shadow: 0 0 10px rgba(206, 18, 18, 0.5);
        }
    </style>
@endsection

@push('scripts')
    <script>
        let selectedMenus = [];

        function toggleMenuSelection(menuId) {
            const index = selectedMenus.indexOf(menuId);
            const card = document.getElementById(`menu-card-${menuId}`);
            const button = document.querySelector(`button[data-menu-id="${menuId}"]`);

            if (index > -1) {
                selectedMenus.splice(index, 1);
                card.classList.remove('selected');
                button.innerText = 'Select Menu';
            } else {
                if (selectedMenus.length >= 3) {
                    Swal.fire({
                        title: 'Maximum Menus Selected',
                        text: 'You can select a maximum of 3 menus. Please deselect one before selecting another.',
                        icon: 'warning',
                    });
                    return;
                }

                selectedMenus.push(menuId);
                card.classList.add('selected');
                button.innerText = 'Selected ✓';
            }

            document.getElementById('submitReservation').disabled = selectedMenus.length < 1;
            document.getElementById('menuCounter').innerText = `${selectedMenus.length} of 1-3 menus selected`;
        }

        function submitReservationForm() {
            const form = document.getElementById('reservationForm');
            selectedMenus.forEach(menuId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_menus[]';
                input.value = menuId;
                form.appendChild(input);
            });
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: function(fetchInfo, successCallback, failureCallback) {
                    fetch('{{ route('api.reservation.index') }}', {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            var events = data.map(function(res) {
                                return {
                                    title: 'Occupied',
                                    start: res.start_date,
                                    end: res.end_date,
                                    extendedProps: {
                                        status: res.status,
                                        message: res.message
                                    }
                                };
                            });
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Error fetching reservations:', error);
                            failureCallback(error);
                        });
                }
            });

            calendar.render();
        });

        function showMenuItems(menuId, imageUrl) {
            $.get(`/api/menus/${menuId}/showSingle`, function(response) {
                if (Array.isArray(response.menu_items)) {
                    let menuItemsHtml = `
                        <div class="container-fluid px-0">
                            <div class="row g-4">
                    `;

                    response.menu_items.forEach(item => {
                        const imagePath = item.image ? '{{ Storage::url('') }}' + item.image : '';

                        menuItemsHtml += `
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 shadow-sm">
                                    ${imagePath ? `<div class="card-img-container" style="height: 180px; overflow: hidden;">
                                        <img src="${imagePath}" class="card-img-top" alt="${item.name}" style="object-fit: cover; height: 100%; width: 100%;">
                                    </div>` : ''}
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-bold mb-3">${item.name}</h5>
                                        <p class="card-text flex-grow-1">${item.description}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    menuItemsHtml += `
                            </div>
                        </div>
                    `;

                    Swal.fire({
                        title: 'Menu Items',
                        html: menuItemsHtml,
                        icon: 'info',
                        width: '80%',
                        showCloseButton: true,
                        showConfirmButton: false,
                        customClass: {
                            container: 'swal-menu-container',
                            popup: 'rounded-3',
                            header: 'border-bottom pb-3',
                            content: 'pt-4'
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to fetch menu items.',
                        icon: 'error',
                    });
                }
            }).fail(function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to fetch menu items.',
                    icon: 'error',
                });
            });
        }
    </script>
@endpush
