@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span> Staff</h4>

        <button type="button" class="btn btn-primary mb-3" onclick="createEmployee()">
            <span class="tf-icons bx bx-plus"></span>&nbsp; Add Employee
        </button>

        <table id="employeeTable" class="table table-hover">
            <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->employee_id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone_number }}</td>
                    <td>
                        <a href="{{ route('admin.employee_detail.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                        <button class="btn btn-warning btn-sm" onclick="editUser({{ $user->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function() {
            $('#employeeTable').DataTable();
        });

        async function createEmployee() {
            await Swal.fire({
                title: 'Create New Employee',
                width: '800px',
                html: `
                    <div style="text-align: left; padding: 20px;">
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Personal Information</h4>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Name</label>
                                <input id="swal-input1" class="swal2-input" style="width: 100%; margin: 0;" placeholder="Enter full name">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Email Address</label>
                                <input id="swal-input2" class="swal2-input" style="width: 100%; margin: 0;" placeholder="Enter email address">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Phone Number</label>
                                <input id="swal-input3" class="swal2-input" style="width: 100%; margin: 0;" placeholder="Enter phone number">
                            </div>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Security</h4>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Password</label>
                                <input id="swal-input4" class="swal2-input" type="password" style="width: 100%; margin: 0;" placeholder="Enter password">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Confirm Password</label>
                                <input id="swal-input5" class="swal2-input" type="password" style="width: 100%; margin: 0;" placeholder="Confirm password">
                            </div>
                        </div>
                        <div style="margin-bottom: 25px;">
                            <h4 style="color: #333; margin-bottom: 15px; font-weight: 600;">Employment Details</h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Position</label>
                                    <input id="swal-input6" class="swal2-input" style="width: 100%; margin: 0;" placeholder="Enter position">
                                </div>
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Department</label>
                                    <input id="swal-input7" class="swal2-input" style="width: 100%; margin: 0;" placeholder="Enter department">
                                </div>
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Salary</label>
                                    <input id="swal-input8" class="swal2-input" style="width: 100%; margin: 0;" placeholder="Enter salary">
                                </div>
                                <div class="form-group">
                                    <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Hire Date</label>
                                    <input id="swal-input9" class="swal2-input" type="date" style="width: 100%; margin: 0;">
                                </div>
                                <div>
                               <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Pay Period</label>
                                <select id="swal-input10" class="swal2-input" style="width: 100%; margin: 0;">
                                    <option value="" disabled selected>Select Pay Period</option>
                                    @foreach($payPeriods as $payPeriod)
                                        <option value="{{ $payPeriod->id }}">{{ $payPeriod->name }}</option>
                                    @endforeach
                                </select>
                                 </div>
                `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Create',
                preConfirm: () => {
                    return {
                        name: document.getElementById('swal-input1').value,
                        email: document.getElementById('swal-input2').value,
                        phone_number: document.getElementById('swal-input3').value,
                        password: document.getElementById('swal-input4').value,
                        password_confirmation: document.getElementById('swal-input5').value,
                        position: document.getElementById('swal-input6').value,
                        department: document.getElementById('swal-input7').value,
                        salary: document.getElementById('swal-input8').value,
                        hired_at: document.getElementById('swal-input9').value,
                        pay_period: document.getElementById('swal-input10').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    storeEmployee(result.value);
                }
            });
        }
        function storeEmployee(data) {
            $.ajax({
                url: '/admin/employee',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: data.name,
                    email: data.email,
                    phone_number: data.phone_number,
                    password: data.password,
                    password_confirmation: data.password_confirmation
                },
                success: function(response) {
                    const userId = response.user.id;
                    $.ajax({
                        url: '/admin/employee-detail',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            user_id: userId,
                            position: data.position,
                            department: data.department,
                            salary: data.salary,
                            hired_at: data.hired_at,
                            pay_period_id: data.pay_period
                        },
                        success: function(response) {
                            Swal.fire('Created!', 'Employee has been created successfully.', 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function(response) {
                            Swal.fire('Error!', 'There was an error creating the employee details.', 'error');
                        }
                    });
                },
                error: function(response) {
                    if (response.status === 422) {
                        let errors = response.responseJSON.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            errorMessages += `${errors[field].join(', ')}<br>`;
                        }
                        Swal.fire('Error!', errorMessages, 'error');
                    } else {
                        Swal.fire('Error!', 'There was an error creating the employee.', 'error');
                    }
                }
            });
        }




        function editUser(userId) {
            $.get('/admin/employee/' + userId, function(user) {
                Swal.fire({
                    title: 'Edit Employee Information',
                    width: '800px',
                    html: `
                        <div style="text-align: left; padding: 20px;">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Full Name</label>
                                <input id="swal-input1" class="swal2-input" style="width: 100%; margin: 0;" value="${user.name}" placeholder="Enter full name">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Email Address</label>
                                <input id="swal-input2" class="swal2-input" style="width: 100%; margin: 0;" value="${user.email}" placeholder="Enter email address">
                            </div>
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label style="display: block; margin-bottom: 5px; color: #555; font-weight: 500;">Phone Number</label>
                                <input id="swal-input3" class="swal2-input" style="width: 100%; margin: 0;" value="${user.phone_number}" placeholder="Enter phone number">
                            </div>
                        </div>
                    `,
                    customClass: {
                        container: 'custom-swal-container',
                        popup: 'custom-swal-popup',
                        header: 'custom-swal-header',
                        title: 'custom-swal-title',
                        closeButton: 'custom-swal-close',
                        content: 'custom-swal-content',
                        confirmButton: 'custom-swal-confirm',
                        cancelButton: 'custom-swal-cancel'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Update Employee',
                    cancelButtonText: 'Cancel',
                    buttonsStyling: true,
                    reverseButtons: true,
                    preConfirm: () => {
                        return {
                            name: document.getElementById('swal-input1').value,
                            email: document.getElementById('swal-input2').value,
                            phone_number: document.getElementById('swal-input3').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/employee/' + userId,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ...result.value
                            },
                            success: function(response) {
                                Swal.fire('Updated!', response.success, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });
        }

      

        function editUser(userId) {
            $.get('/admin/employee/' + userId, function(user) {
                Swal.fire({
                    title: 'Edit User',
                    html: `
                        <input id="swal-input1" class="swal2-input" value="${user.name}" placeholder="Name">
                        <input id="swal-input2" class="swal2-input" value="${user.email}" placeholder="Email">
                        <input id="swal-input3" class="swal2-input" value="${user.phone_number}" placeholder="Phone Number">
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        return {
                            name: document.getElementById('swal-input1').value,
                            email: document.getElementById('swal-input2').value,
                            phone_number: document.getElementById('swal-input3').value
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/admin/employee/' + userId,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ...result.value
                            },
                            success: function(response) {
                                Swal.fire('Updated!', response.success, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });
        }

        function deleteUser(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/admin/employee/' + userId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', response.success, 'success').then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        const style = document.createElement('style');
        style.textContent = `
            .custom-swal-popup {
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 0 20px rgba(0,0,0,0.1);
            }
            .custom-swal-header {
                border-bottom: 1px solid #eee;
                padding: 20px;
            }
            .custom-swal-title {
                color: #2c3e50;
                font-size: 24px;
                font-weight: 600;
            }
            .swal2-input {
                height: 40px;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 0 12px;
                font-size: 14px;
                box-shadow: none !important;
            }
            .swal2-input:focus {
                border-color: #3085d6;
            }
            .custom-swal-confirm {
                background: #3085d6 !important;
                border-radius: 4px !important;
                font-weight: 500 !important;
                padding: 12px 24px !important;
            }
            .custom-swal-cancel {
                background: #6c757d !important;
                border-radius: 4px !important;
                font-weight: 500 !important;
                padding: 12px 24px !important;
            }
        `;
        document.head.appendChild(style);
    </script>
@endpush
