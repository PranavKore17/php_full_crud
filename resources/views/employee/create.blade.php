<!DOCTYPE html>
<html lang="en">

<head>
    <title>List file</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ url('public/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <meta name="_token" content="{{ csrf_token() }}">
</head>

<body>

    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">Create Pages</div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees</div>
            <div>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>

        <form action="{{ route('employees.store') }}" id="frm" name="frm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card border-0 shadow-lg">
                <div class="card-body">

                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" placeholder="Enter name"
                            name="name"class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">
                        @error('name')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" placeholder="Enter email" name="email"
                            class="form-control @error('email') is-invalid @enderror"value="{{ old('email') }}">
                        @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="email" class="form-label">Address:</label>
                        <textarea cols="30" rows="4" id="address" placeholder="Enter address" name="address" class="form-control">{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <select name="country" id="country" class="form-control">
                            <option value="">Select Country</option>
                            @if (!empty($countries))
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-3">
                        <select name="state" id="state" class="form-control">
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <select name="city" id="city" class="form-control">
                            <option value="">Select City</option>
                        </select>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="image" class="form-label" >Image:</label>
                        <input type="file" id="image" name="image"
                            class="@error('image') is-invalid @enderror">
                        @error('image')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
            <button class="btn btn-primary mt-3">Save Employee</button>
        </form>

    </div>

</body>

</html>
<script src="{{ url('public/assets/js/jquery-3.7.1.min.js') }}"></script>
<script>
    $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
         }
   });

   $(document).ready(function(){
        $("#country").change(function(){
            var country_id = $(this).val();
            //console.log(country_id);

            if (country_id == "") {
                var country_id = 0;
            } 

            $.ajax({
                url: '{{ url("/fetch-states/") }}/'+country_id,
                type: 'post',
                dataType: 'json',
                success: function(response) {   
                    // console.log(response);               
                    $('#state').find('option:not(:first)').remove();
                    $('#city').find('option:not(:first)').remove();

                    if (response['states'].length > 0) {
                        $.each(response['states'], function(key,value){
                            $("#state").append("<option value='"+value['id']+"'>"+value['name']+"</option>")
                        });
                    } 
                }
            });            
        });


        $("#state").change(function(){
            var state_id = $(this).val();

            console.log(state_id);

            if (state_id == "") {
                var state_id = 0;
            } 

            $.ajax({
                url: '{{ url("/fetch-cities/") }}/'+state_id,
                type: 'post',
                dataType: 'json',
                success: function(response) {                    
                    $('#city').find('option:not(:first)').remove();

                    if (response['cities'].length > 0) {
                        $.each(response['cities'], function(key,value){
                            $("#city").append("<option value='"+value['id']+"'>"+value['name']+"</option>")
                        });
                    } 
                }
            });            
        });

   });

//    $("#frm").submit(function(event)
//    {
//         event.preventDefault();
//         $.ajax({
//             url: '{{ url("/save") }}',
//             type: 'post',
//             data: $("#frm").serializeArray(),
//             dataType: 'json',
//             success: function(response) {                    
//                 if(response['status'] == 1) {
//                     window.location.href="{{ url('list') }}";
//                 } else {
//                     if (response['errors']['name']) {
//                         $("#name").addClass('is-invalid');
//                         $("#name-error").html(response['errors']['name']);
//                     } else {
//                         $("#name").removeClass('is-invalid');
//                         $("#name-error").html("");
//                     }

//                     if (response['errors']['email']) {
//                         $("#email").addClass('is-invalid');
//                         $("#email-error").html(response['errors']['email']);
//                     } else {
//                         $("#email").removeClass('is-invalid');
//                         $("#email-error").html("");
//                     }
//                 }
//             }
//         }); 
//    })
</script>

