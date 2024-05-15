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
            <div class="h4 text-white">Edit Pages</div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees</div>
            <div>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <form action="{{ route('employees.update',$employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card border-0 shadow-lg">
                <div class="card-body">

                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" placeholder="Enter name"
                            name="name"class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $employee->name) }}">
                        @error('name')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" placeholder="Enter email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $employee->email) }}">
                        @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Address:</label>
                        <textarea cols="30" rows="4" id="address" placeholder="Enter address" name="address" class="form-control">{{ old('address', $employee->address) }}</textarea>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="image" class="form-label">Image:</label>
                        <input type="file" id="image" name="image"
                            class="@error('image') is-invalid @enderror">

                        @error('image')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror

                        <div class="pt-3">
                            @if ($employee->image != '' && file_exists(public_path().'/uploads/employees/'.$employee->image))
                            <img src="{{ url('public/uploads/employees/'.$employee->image) }}" alt="" width="100" height="100">
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <button class="btn btn-primary my-3">Update Employee</button>
        </form>

    </div>

</body>

</html>
