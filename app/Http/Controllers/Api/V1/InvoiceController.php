<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Your logic to retrieve and return invoices
    }

    public function show(Request $request, $id)
    {
        // Your logic to retrieve and return a specific invoice
    }

    public function store(Request $request)
    {
        // Your logic to create a new invoice
    }

    public function update(Request $request, $id)
    {
        // Your logic to update an existing invoice
    }

    public function destroy(Request $request, $id)
    {
        // Your logic to delete an invoice
    }
}