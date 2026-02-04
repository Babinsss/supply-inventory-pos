<!DOCTYPE html>
<html>
<head>
    <title>Supply Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container-fluid">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>🏥 Hospital Supply Inventory</h2>
            <span class="text-muted">Logged in as: <strong>{{ Auth::user()->name ?? 'User' }}</strong></span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('users.index') }}" class="btn btn-dark text-white">👥 Staff</a>

            <a href="{{ route('reports.consumption') }}" class="btn btn-dark text-white">📊 Reports</a>

            <a href="{{ route('requests.index') }}" class="btn btn-warning position-relative">
                🔔 Requests
                @if(isset($pending_count) && $pending_count > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $pending_count }}
                    </span>
                @endif
            </a>

            <a href="{{ route('transactions.index') }}" class="btn btn-info text-white">📜 History</a>

            <a href="{{ route('supplies.create') }}" class="btn btn-primary">+ Register Item</a>

            <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Log Out</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Item Name</th>
                        <th>Current Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($supplies as $supply)
                    <tr>
                        <td class="align-middle">
                            <strong>{{ $supply->name }}</strong>
                            <br>
                            <small class="text-muted">{{ $supply->category }} • {{ $supply->description }}</small>
                        </td>
                        
                        <td class="align-middle" style="font-size: 1.2em; font-weight: bold;">
                            {{ $supply->quantity }} {{ $supply->unit }}
                        </td>
                        
                        <td class="align-middle">
                            @if($supply->quantity == 0)
                                <span class="badge bg-danger">OUT OF STOCK</span>
                            @elseif($supply->quantity <= $supply->reorder_level)
                                <span class="badge bg-warning text-dark">CRITICAL</span>
                            @else
                                <span class="badge bg-success">GOOD</span>
                            @endif
                        </td>
                        
                        <td class="align-middle">
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#restockModal{{ $supply->id }}">
                                + Add Stock
                            </button>

                            <div class="modal fade" id="restockModal{{ $supply->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Restock: {{ $supply->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('supplies.restock', $supply->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <label>Quantity to Add:</label>
                                                <input type="number" name="added_quantity" class="form-control" placeholder="e.g. 50" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Confirm Restock</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>