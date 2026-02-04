<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\SupplyRequest;
use App\Models\Transaction; 
class SupplyController extends Controller
{
    // 1. Show all supplies (Dashboard)
    public function index()
    {
        $supplies = Supply::all();
        
        // Count pending requests for the red badge notification
        $pending_count = SupplyRequest::where('status', 'pending')->count();

        return view('supplies.index', compact('supplies', 'pending_count'));
    }

    // 2. Show the "Add New Supply" Form
    public function create()
    {
        return view('supplies.create');
    }

    // 3. Save the new supply
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'unit' => 'required',
            'reorder_level' => 'required|integer',
            // category and description are optional, so we don't need 'required' here
        ]);

        Supply::create([
            'name' => $request->name,
            'category' => $request->category,        // <--- NEW LINE
            'description' => $request->description,  // <--- NEW LINE
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'reorder_level' => $request->reorder_level
        ]);

        return redirect()->route('supplies.index')->with('success', 'Item added successfully!');
    }
    public function restock(Request $request, $id)
    {
        $request->validate([
            'added_quantity' => 'required|integer|min:1'
        ]);

        $supply = Supply::findOrFail($id);

        // 1. Increase the stock
        $supply->increment('quantity', $request->added_quantity);

        // 2. Log the transaction (Stock In)
        Transaction::create([
            'type' => 'IN',
            'supply_id' => $supply->id,
            'department_id' => null, // Restocking doesn't involve a department
            'quantity' => $request->added_quantity,
            'user_id' => auth()->id() ?? 1, // Uses logged in user or ID 1
            'remarks' => 'Restock / Delivery Received'
        ]);

        return back()->with('success', 'Stock added successfully!');
    }
}