<!DOCTYPE html>
<html>
<head>
    <title>Request Supplies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info p-5"> <div class="container">
    <div class="card shadow-lg" style="max-width: 600px; margin: auto;">
        <div class="card-header bg-white text-center">
            <h3>🏥 Supply Request Form</h3>
            <p class="text-muted">Select your department and item needed.</p>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('requests.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Your Department</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">-- Who are you? --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Item Needed</label>
                    <select name="supply_id" class="form-select" required>
                        <option value="">-- Select Item --</option>
                        @foreach($supplies as $supply)
                            <option value="{{ $supply->id }}">{{ $supply->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label>Unit (e.g. Box, Ream, Pc)</label>
                        <select name="unit" class="form-select" required>
                            <option value="Pc">Piece</option>
                            <option value="Ream">Ream</option>
                            <option value="Box">Box</option>
                            <option value="Pack">Pack</option>
                            <option value="Bottle">Bottle</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Send Request</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>