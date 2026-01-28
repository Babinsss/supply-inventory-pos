<!DOCTYPE html>
<html>
<head>
    <title>Add New Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4>Register New Supply Item</h4>
        </div>
        <div class="card-body">
            
            <form action="{{ route('supplies.store') }}" method="POST">
                @csrf <div class="mb-3">
                    <label>Item Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Alcohol 70% 500ml" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Unit of Measurement</label>
                        <select name="unit" class="form-select">
                            <option value="Pc">Piece</option>
                            <option value="Box">Box</option>
                            <option value="Ream">Ream</option>
                            <option value="Bottle">Bottle</option>
                            <option value="Gallon">Gallon</option>
                            <option value="Pack">Pack</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Initial Quantity</label>
                        <input type="number" name="quantity" class="form-control" placeholder="0" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Critical Level (Alert Limit)</label>
                        <input type="number" name="reorder_level" class="form-control" value="10" required>
                        <small class="text-muted">Alert me when stock drops below this.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Save Item</button>
                <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>