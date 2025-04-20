@extends('layouts.app')

@section('content')


    <h2>Customer Management</h2>
    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Import Form --}}
    <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <input type="file" name="file" required>
        <button type="submit" class="btn btn-success">Import Customers</button>
    </form>

    {{-- Export Button --}}
    <a href="{{ route('customers.export') }}" class="btn btn-primary mb-4">Export Customers</a>

    <div class="container mt-5">
        <div class="card shadow rounded">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Customer List</h4>
            </div>



            <div class="card-body">
                <!-- 👇 Add New Customer Button -->
                <div class="mb-3 text-end">
                    <a href="{{ route('customers.form') }}" class="btn btn-primary">+ Add New Customer</a>
                </div>

                <div id="loading" class="text-center my-3">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading customers...</p>
                </div>

                <div id="error" class="alert alert-danger d-none" role="alert">
                    Failed to load customer data. Please try again later.
                </div>

                <table id="customer-table" class="table table-bordered table-hover d-none">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = localStorage.getItem('access_token');
            const loading = document.getElementById('loading');
            const error = document.getElementById('error');
            const table = document.getElementById('customer-table');
            const tbody = table.querySelector('tbody');

            axios.get('/api/customers', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }).then(response => {
                const customers = response.data;

                if (customers.length === 0) {
                    loading.innerHTML = '<p class="text-muted">No customers found.</p>';
                    return;
                }

                customers.forEach((customer, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                                            <td>${index + 1}</td>
                                            <td>${customer.first_name}</td>
                                            <td>${customer.last_name}</td>
                                            <td>${customer.email}</td>
                                            <td>
                                                <a href="/api/customers/${customer.id}/edit" class="btn btn-sm btn-primary">Edit</a>

                                                <button onclick="deleteCustomer(${customer.id})" class="btn btn-danger btn-sm">Delete</button>
                                            </td>

                                        `;
                    tbody.appendChild(row);
                });

                loading.classList.add('d-none');
                table.classList.remove('d-none');
            }).catch(errorResponse => {
                console.error('Error fetching customers:', errorResponse);
                loading.classList.add('d-none');
                error.classList.remove('d-none');
            });
        });
    </script>
    <script>
        function deleteCustomer(id) {
            if (confirm("Are you sure you want to delete this customer?")) {
                const token = localStorage.getItem('access_token');

                axios.delete(`/api/customers/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                })
                    .then(response => {
                        alert('Customer deleted successfully!');
                        location.reload(); // Refresh the list
                    })
                    .catch(error => {
                        console.error('Delete error:', error);
                        alert('Failed to delete customer.');
                    });
            }
        }
    </script>


@endsection