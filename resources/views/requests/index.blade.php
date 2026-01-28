<!DOCTYPE html>
<html>
<head>
    <title>Pending Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<div class="container">
    <h2>🔔 Pending Requests</h2>
    <a href="{{ route('supplies.index') }}" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Department</th>
                <th>Item</th>
                <th>Qty</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
            <tr>
                <td class="align-middle">{{ $req->department->name ?? 'Unknown' }}</td>

                <td class="align-middle">{{ $req->supply->name ?? 'Unknown' }}</td>

                <td class="align-middle fw-bold">
                    {{ $req->quantity }} {{ $req->unit ?? '' }}
                </td>

                <td class="align-middle">
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $req->id }}">
                        Approve
                    </button>

                    <form action="{{ route('requests.decline', $req->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Decline this request?')">Decline</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">No pending requests.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@foreach($requests as $req)
<div class="modal fade" id="approveModal{{ $req->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('requests.approve', $req->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p><strong>Dept:</strong> {{ $req->department->name }}</p>
                    <p><strong>Item:</strong> {{ $req->supply->name }}</p>
                    <p><strong>Requested:</strong> {{ $req->quantity }} {{ $req->unit }}</p>
                    
                    <hr>
                    <div class="alert alert-info">
                        <strong>Stock Check:</strong><br>
                        Inventory: {{ $req->supply->quantity }} {{ $req->supply->unit }}
                    </div>

                    <label class="form-label fw-bold">Quantity to Deduct (in {{ $req->supply->unit }}):</label>
                    <input type="number" name="deduct_quantity" class="form-control" value="{{ $req->quantity }}" required>
                    <small class="text-muted">Adjust this if 1 {{ $req->unit }} = multiple {{ $req->supply->unit }}s.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Confirm & Deduct</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>