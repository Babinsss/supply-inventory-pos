<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\Department;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB; // Needed for database transactions

class TransactionController extends Controller
{
    // 1. Show the Form
    public function create()
    {
        $supplies = Supply::all();
        $departments = Department::all();
        return view('transactions.issue', compact('supplies', 'departments'));
    }

    // 2. Process the Issuance
    public function store(Request $request)
    {
        $request->validate([
            'supply_id' => 'required',
            'department_id' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        // Use a Database Transaction for safety
        DB::transaction(function () use ($request) {
            
            // A. Find the supply
            $supply = Supply::findOrFail($request->supply_id);

            // B. Check if we have enough stock
            if ($supply->quantity < $request->quantity) {
                // If not enough, throw an error back to the user
                throw new \Exception("Not enough stock! Available: " . $supply->quantity);
            }

            // C. Deduct the stock
            $supply->decrement('quantity', $request->quantity);

            // D. Log the Transaction
            Transaction::create([
                'type' => 'OUT',
                'supply_id' => $supply->id,
                'department_id' => $request->department_id,
                'quantity' => $request->quantity,
                'user_id' => 1, // hardcoded for now (since we don't have login yet)
                'remarks' => 'Issued to department'
            ]);
        });

        return redirect()->route('supplies.index')->with('success', 'Stocks issued successfully!');
    }
    // 3. Show the History Log
    public function index()
    {
        // Get all transactions, ordered by newest first
        // We use 'with' to eagerly load the related names (Supply, Dept, User) to avoid slow queries
        $transactions = Transaction::with(['supply', 'department', 'user'])->latest()->get();

        return view('transactions.index', compact('transactions'));
    }
}