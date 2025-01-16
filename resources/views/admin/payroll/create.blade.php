@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Payroll</h1>
    <form action="{{ route('admin.payroll.store') }}" method="POST" id="payrollForm">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Employee</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="" disabled selected>Select Employee</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="pay_period">Pay Period</label>
            <select name="pay_period_id" id="pay_period" class="form-control" required>
                <option value="" disabled selected>Select Pay Period</option>
                @foreach($payPeriods as $payPeriod)
                    <option value="{{ $payPeriod->id }}">{{ $payPeriod->name }}</option>
                @endforeach
            </select>
            
        </div>

        
        <div class="mb-3">
            <label for="deductions" class="form-label">Deductions</label>
            <input type="number" name="deductions" id="deductions" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fetch salary when an employee is selected
    $('#user_id').change(function() {
        var userId = $(this).val();
        
        // Make sure the user is selected
        if (userId) {
            $.ajax({
                url: '/admin/payroll/employee/' + userId + '/salary',
                method: 'GET',
                success: function(response) {
                    // Update the gross salary input
                    $('#gross_salary').val(response.salary);
                },
                error: function() {
                    alert("Error fetching salary data.");
                }
            });
        } else {
            $('#gross_salary').val(''); // Clear salary if no user selected
        }
    });

    // Form submission with SweetAlert for confirmation
    $('#payrollForm').on('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to add a new payroll record.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Save it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    @if ($errors->any())
        // SweetAlert for validation errors
        Swal.fire({
            title: 'Error!',
            text: 'Please fix the errors in the form.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    @endif
</script>
@endsection
