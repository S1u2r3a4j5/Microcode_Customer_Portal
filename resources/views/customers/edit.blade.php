@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Customer</h2>

        <form id="edit-customer-form">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" value="{{ $customer->first_name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" value="{{ $customer->last_name }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Age</label>
                <input type="number" class="form-control" id="age" value="{{ $customer->age }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="dob" value="{{ $customer->dob }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ $customer->email }}">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('edit-customer-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const token = localStorage.getItem('access_token');

            axios.put('/api/customers/{{ $customer->id }}', {
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                age: document.getElementById('age').value,
                dob: document.getElementById('dob').value,
                email: document.getElementById('email').value
            }, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
                .then(response => {
                    alert('Customer updated successfully!');
                    window.location.href = "{{ route('customers.index') }}";
                })
                .catch(error => {
                    alert('Update failed!');
                    console.error(error);
                });
        });
    </script>
@endsection