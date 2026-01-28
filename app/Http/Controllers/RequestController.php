<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supply;
use App\Models\Department;
use App\Models\SupplyRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    // 1. Show the Form to the Departments (Public View)
    public function create() {
        $supplies = Supply::where('quantity', '>', 0)->get(); // Only show available items
        $departments = Department::all();
        return view('requests.create', compact('supplies', 'departments'));
    }

    // 2. Save their request
    public function store(Request $request) {
        $request->validate([
            'department_id' => 'required',
            'supply_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required' // <--- Validate the new field
        ]);

        SupplyRequest::create($request->all());

        return back()->with('success', 'Request sent successfully!');
    }

    // 3. Admin View: See all pending requests
    public function index() {
        $requests = SupplyRequest::where('status', 'pending')->with(['supply', 'department'])->get();
        return view('requests.index', compact('requests'));
    }

    // 4. Admin Action: Approve the Request
    public function approve(Request $request, $id) { // <--- Add $request here
        $req = SupplyRequest::findOrFail($id);
        
        // Use the quantity YOU typed in the modal, not just what they asked for
        $deduction_amount = $request->input('deduct_quantity', $req->quantity);

        DB::transaction(function() use ($req, $deduction_amount) {
            
            // 1. Check if we have enough stock based on your deduction amount
            if($req->supply->quantity < $deduction_amount) {
                throw new \Exception("Not enough stock! You have " . $req->supply->quantity . " but tried to deduct " . $deduction_amount);
            }

            // 2. Deduct Stock
            $req->supply->decrement('quantity', $deduction_amount);

            // 3. Log Transaction
            Transaction::create([
                'type' => 'OUT',
                'supply_id' => $req->supply_id,
                'department_id' => $req->department_id,
                'quantity' => $deduction_amount, // We log the actual deducted amount
                'user_id' => auth()->id() ?? 1,
                'remarks' => 'Approved: ' . $req->quantity . ' ' . $req->unit
            ]);

            // 4. Update Request Status
            $req->update(['status' => 'approved']);
        });

        return back()->with('success', 'Request Approved & Stock Deducted');
    }
    
    // 5. Admin Action: Decline
    public function decline($id) {
        SupplyRequest::where('id', $id)->update(['status' => 'declined']);
        return back()->with('success', 'Request Declined');
    }
}