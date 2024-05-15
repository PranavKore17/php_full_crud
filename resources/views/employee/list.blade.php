<!DOCTYPE html>
<html lang="en">

<head>
    <title>List file</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="{{ url('public/assets/js/jquery-3.7.1.min.js') }}"></script>
</head>

<body>

    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">Home Pages</div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees</div>
            <div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">Create</a>
            </div>
        </div>

        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($employees->isNotEmpty())
                            @foreach ($employees as $employee)
                                <tr class="text-center">
                                    <td>{{$loop->index +1}}</td>
                                    <td>
                                        @if ($employee->image != '' && file_exists(public_path() . '/uploads/employees/' . $employee->image))
                                            <img src="{{ url('public/uploads/employees/' . $employee->image) }}"
                                                alt="" width="55px" height="55px">
                                        @else
                                            <img src="{{ url('public\assets\images\no-image3.jpg') }}" alt=""
                                                width="55px" height="55px">
                                        @endif
                                    </td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->address }}</td>
                                    <td>{{ $employee->country }}</td>
                                    <td>{{ $employee->state }}</td>
                                    <td>{{ $employee->city }}</td>
                                    <td>
                                        <a href="{{ route('employees.edit', $employee->id) }}"
                                            class="text-white btn btn-success ml-2 pt-2"><i
                                                class="fa-regular fa-pen-to-square"></i></a>

                                        <a href="#" onclick="deleteEmployee({{ $employee->id }})"
                                            class="text-white btn btn-danger ml-2 pt-2"><i
                                                class="fa-solid fa-trash-can"></i></a>

                                        <a href="{{ route('employees.view', $employee->id) }}"
                                            class="text-white btn btn-warning ml-2 pt-2"><i class="fa-solid fa-eye"></i></a>

                                        <form id="employee-edit-action-{{ $employee->id }}"
                                            action="{{ route('employees.destroy', $employee->id) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">Record not found</td>
                            </tr>
                        @endif

                    </tbody>

                </table>
            </div>

        </div>
        <div class="mt-3">
            {{ $employees->links() }}
        </div>
    </div>
</body>

</html>
<script>
    function deleteEmployee(id) {
        if (confirm("Are you sure you want to delete..")) {
            +document.getElementById('employee-edit-action-' + id).submit();
        }
    }
</script>
