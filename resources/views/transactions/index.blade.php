<!DOCTYPE html>
<html>
<head>
    <title>Transaction History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📜 Stock Movement Log</h2>
        <a href="{{ route('supplies.index') }}" class="btn btn-secondary">← Back to Inventory</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Department / Remarks</th>
                        <th>Quantity</th>
                        <th>Processed By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $log)
                    <tr>
                        <td>{{ $log->created_at->format('M d, Y h:i A') }}</td>
                        <td>
                            @if($log->type == 'IN')
                                <span class="badge bg-success">STOCK IN</span>
                            @else
                                <span class="badge bg-danger">ISSUANCE</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $log->supply->name }}</td>
                        <td>
                            @if($log->department)
                                <span class="text-primary">{{ $log->department->name }}</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                            <br>
                            <small class="text-muted"><em>{{ $log->remarks }}</em></small>
                        </td>
                        <td class="fw-bold fs-5">
                            {{ $log->type == 'OUT' ? '-' : '+' }}{{ $log->quantity }}
                        </td>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>