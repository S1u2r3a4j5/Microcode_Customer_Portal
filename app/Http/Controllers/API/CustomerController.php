<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;

use OpenApi\Annotations as OA;


class CustomerController extends Controller
{



    public function customerList()
    {
        return view('customers.index'); // Blade view for customer listing
    }

    public function createForm()
    {
        return view('customers.create'); // Blade view for customer creation
    }

    public function editForm($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', ['customer' => $customer]);
    }


    /**
     * @OA\Get(
     *     path="/customers",
     *     summary="Get all customers",
     *     @OA\Response(
     *         response=200,
     *         description="A list of customers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Customer")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return Customer::all();
    }
    /**
     * @OA\Post(
     *     path="/customers",
     *     summary="Create a new customer",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer created"
     *     )
     * )
     */

    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'age' => 'required|integer',
            'dob' => 'required|date',
            'email' => 'required|email|unique:customers,email',
        ]);

        // Create new customer record
        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'age' => $request->age,
            'dob' => $request->dob,
            'email' => $request->email,
        ]);

        return response()->json($customer, 201); // Return created customer
    }

     /**
     * @OA\Get(
     *     path="/api/customers/{id}",
     *     summary="Get a customer by ID",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A single customer",
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        return response()->json($customer);
    }

    
    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     summary="Update a customer's information",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Customer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'age' => 'required|integer|min:18|max:100',
            'dob' => 'required|date',
            'email' => 'required|email|max:100|unique:customers,email,' . $id,
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        return response()->json($customer);
    }

      /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     summary="Delete a customer",
     *     tags={"Customer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Customer ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found"
     *     )
     * )
     */
    public function destroy($id)
    {

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }

    
    /**
     * @OA\Post(
     *     path="/api/customers/export",
     *     summary="Export customers to Excel",
     *     tags={"Customer"},
     *     @OA\Response(
     *         response=200,
     *         description="Customers exported successfully"
     *     )
     * )
     */
    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');

    }

      /**
     * @OA\Post(
     *     path="/api/customers/import",
     *     summary="Import customers from Excel",
     *     tags={"Customer"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object", required={"file"}, @OA\Property(property="file", type="file"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customers imported successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid file format"
     *     )
     * )
     */

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new CustomersImport, $request->file('file'));

        return redirect()->back()->with('success', 'Customers imported successfully!');
    }


}
