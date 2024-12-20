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
                title: 'Create Employee',
                html: `
            <input id="swal-input1" class="swal2-input" placeholder="Name">
            <input id="swal-input2" class="swal2-input" placeholder="Email">
            <input id="swal-input3" class="swal2-input" placeholder="Phone Number">
            <input id="swal-input4" class="swal2-input" type="password" placeholder="Password">
            <input id="swal-input5" class="swal2-input" type="password" placeholder="Confirm Password">
            <input id="swal-input6" class="swal2-input" placeholder="Position">
            <input id="swal-input7" class="swal2-input" placeholder="Department">
            <input id="swal-input8" class="swal2-input" placeholder="Salary">
            <input id="swal-input9" class="swal2-input" type="date" placeholder="Hired At">
        `,
                showConfirmButton: true,
                confirmButtonText: 'Create',
                showCloseButton: true,
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
                        hired_at: document.getElementById('swal-input9').value
                    }
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
                            hired_at: data.hired_at
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
    </script>
@endpush
