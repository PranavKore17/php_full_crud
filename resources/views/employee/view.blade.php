<!DOCTYPE html>
<html lang="en">

<head>
    <title>List file</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ url('public/assets/js/jquery-3.7.1.min.js') }}"></script>
</head>

<body>

    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">View Pages</div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees</div>
            <div>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <form action="">
            <div class="card border-0 shadow-lg">
                <div class="card-body">

                    <div class="mb-3 mt-3">
                        <label class="form-label">Name:</label>
                        <input id="name" name="name"class="form-control"
                            value="{{ old('name', $employee->name) }}">
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Email:</label>
                        <input id="email" name="email" class="form-control"
                            value="{{ old('email', $employee->email) }}">
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Address:</label>
                        <textarea id="address" name="address" class="form-control">{{ old('address', $employee->address) }}</textarea>
                    </div>

                    <div class="mb-3 mt-3">
                        <label class="form-label">Image</label>

                        <div class="pt-3">
                            <img src="{{ url('public/uploads/employees/' .$employee->image) }}" alt=""
                                width="100" height="100">
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>

</body>

</html>
