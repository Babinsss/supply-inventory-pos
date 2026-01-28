<!DOCTYPE html>
<html>
<head>
    <title>Issue Supplies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h4>📤 Issue Supplies (Stock Out)</h4>
        </div>
        <div class="card-body">
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('issue.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Select Item</label>
                    <select name="supply_id" class="form-select" required>
                        <option value="">-- Choose Item --</option>
                        @foreach($supplies as $supply)
                            <option value="{{ $supply->id }}">
                                {{ $supply->name }} (Available: {{ $supply->quantity }} {{ $supply->unit }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Requesting Department</label>
                    <select name="department_id" class="form-select" required>
                        <option value="">-- Choose Department --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Quantity to Issue</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
                </div>

                <button type="submit" class="btn btn-danger">Confirm Issuance</button>
                <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>

</body>
</html>