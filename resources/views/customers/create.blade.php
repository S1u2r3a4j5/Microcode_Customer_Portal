@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Customer</h1>
    <form id="create-customer-form">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" id="age" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" id="dob" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Customer</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('create-customer-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const customerData = {
            first_name: document.getElementById('first_name').value,
            last_name: document.getElementById('last_name').value,
            age: document.getElementById('age').value,
            dob: document.getElementById('dob').value,
            email: document.getElementById('email').value
        };

        const token = localStorage.getItem('access_token');

        axios.post('/api/customers', customerData, {
            headers: {
                Authorization: `Bearer ${token}`
            }
        }).then(response => {
            alert('Customer created successfully!');
            window.location.href = '/customers'; // Redirect to customer list page
        }).catch(error => {
            console.error('Error creating customer:', error);
            alert('Failed to create customer!');
        });
    });
</script>

@endsection
