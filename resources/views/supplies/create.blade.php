<!DOCTYPE html>
<html>
<head>
    <title>Register New Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<div class="container" style="max-width: 600px;">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">📝 Register New Supply</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('supplies.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Item Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Epson Ink 003" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category" class="form-select">
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Medical Supplies">Medical Supplies</option>
                            <option value="Cleaning">Cleaning / Janitorial</option>
                            <option value="IT Equipment">IT / Computer</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Color / Description</label>
                        <input type="text" name="description" class="form-control" placeholder="e.g. Black, Blue, A4">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Initial Quantity</label>
                        <input type="number" name="quantity" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Unit</label>
                        <select name="unit" class="form-select">
                            <option value="pcs">Pieces</option>
                            <option value="boxes">Boxes</option>
                            <option value="reams">Reams</option>
                            <option value="bottles">Bottles</option>
                            <option value="packs">Packs</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-danger">Reorder Alert Level</label>
                    <input type="number" name="reorder_level" class="form-control border-danger" value="10" required>
                    <small class="text-muted">System will warn you when stock goes below this number.</small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg">Save Item</button>
                    <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>