@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Attendance Record</h1>
    <form action="{{ route('admin.attendance.store') }}" method="POST">
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

       

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
