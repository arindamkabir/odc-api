<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::query()
            ->paginate(10);

        return response()->json($customers);
    }

    public function show()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
