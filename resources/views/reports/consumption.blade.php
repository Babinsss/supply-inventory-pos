<!DOCTYPE html>
<html>
<head>
    <title>Consumption Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* This hides the filter form when printing */
        @media print {
            .no-print { display: none; }
            .container { max-width: 100%; }
        }
    </style>
</head>
<body class="p-4">

<div class="container">
    
    <div class="card bg-light mb-4 no-print">
        <div class="card-body">
            <form action="{{ route('reports.consumption') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ $start_date }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ $end_date }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <button type="button" onclick="window.print()" class="btn btn-success">🖨️ Print Report</button>
                    <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mb-4">
        <h3>ROXAS MEMORIAL PROVINCIAL HOSPITAL</h3>
        <h4>Report of Supplies Issued</h4>
        <p>Period: {{ \Carbon\Carbon::parse($start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('M d, Y') }}</p>
    </div>

    <table class="table table-bordered border-dark">
        <thead>
            <tr class="table-secondary">
                <th>Department / Item</th>
                <th class="text-center">Unit</th>
                <th class="text-end">Qty Issued</th>
                <th>Remarks</th> 
            </tr>
        </thead>
        <tbody>
            @php 
                $current_dept = null; 
            @endphp

            @forelse($report_data as $data)
                
                {{-- Group Header: Only show Department Name if it changes --}}
                @if($current_dept != $data->department_id)
                    <tr class="table-light">
                        <td colspan="4" class="fw-bold text-uppercase text-primary pt-3">
                            {{ $data->department->name ?? 'Unassigned Department' }}
                        </td>
                    </tr>
                    @php $current_dept = $data->department_id; @endphp
                @endif

                {{-- Item Row --}}
                <tr>
                    <td class="ps-4">{{ $data->supply->name }}</td>
                    <td class="text-center">{{ $data->supply->unit }}</td>
                    <td class="text-end fw-bold">{{ $data->total_quantity }}</td>
                    <td class="small text-muted">Total Usage</td>
                </tr>

            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">No issuances found for this period.</td>
                </tr>
            @endforelse
            
            {{-- Grand Total Row --}}
            @if($report_data->count() > 0)
                <tr class="table-dark">
                    <td colspan="2" class="text-end fw-bold">OVERALL TOTAL ITEMS ISSUED:</td>
                    <td class="text-end fw-bold">{{ $grand_total }}</td>
                    <td></td> </tr>
            @endif
        </tbody>
    </table>

    <div class="row mt-5">
        <div class="col-6 text-center">
            <p>Prepared by:</p>
            <br><br>
            <p><strong>{{ Auth::user()->name ?? 'Mrs. Mia Barrera' }}</strong><br>Supply Officer</p>
        </div>
        <div class="col-6 text-center">
            <p>Noted by:</p>
            <br><br>
            <p><strong>DR. FLORENCIO O. LUCHING JR., MD.,FPCS</strong><br>Chief of Hospital I</p>
        </div>
    </div>

</div>

</body>
</html>