<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        //echo 'this is just for testing...';
        $employees = Employee::orderBy('id', 'ASC')->paginate(5);
        return view('employee.list', ['employees' => $employees]);
    }

    public function create()
    {
        // echo 'craete form';
        $countries = DB::table('countries')->orderBy('name', 'ASC')->get();
        $data['countries'] = $countries;
        return view('employee.create', $data);
    }

    public function fetchStates($country_id = null)
    {
        $states = DB::table('states')->where('country_id', $country_id)->get();

        return response()->json([
            'status' => 1,
            'states' => $states
        ]);
    }

    public function fetchCities($state_id = null)
    {
        $cities = DB::table('cities')->where('state_id', $state_id)->get();

        return response()->json([
            'status' => 1,
            'cities' => $cities
        ]);
    }

    public function  store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg'
        ]);
        if ($validator->passes()) {
            //save data here
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->country = $request->country;
            $employee->state = $request->state;
            $employee->city = $request->city;
            $employee->save();

            //uplode image here
            if ($request->image) {
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $ext;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName);

                $employee->image = $newFileName;
                $employee->save();
            }

            return redirect()->route('employees.index')->with('success', 'Employee added successfully');
        } else {
            //return with errors
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);

        //dd($employee);

        return view('employee.edit', ['employee' => $employee]);
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg',
        ]);

        if ($validator->passes()) {
            //save data here
            $employee = Employee::find($id);

            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->country = $request->country;
            $employee->state = $request->state;
            $employee->city = $request->city;
            $employee->save();

            //uplode image here
            if ($request->image) {
                $oldImage = $employee->image;

                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $ext;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName);

                $employee->image = $newFileName;
                $employee->save();

                File::delete(public_path() . '/uploads/employees/' . $oldImage);
            }

            return redirect()->route('employees.index')->with('success', 'Employee updates successfully');
        } else {
            //return with errors
            return redirect()->route('employees.edit', $id)->withErrors($validator)->withInput();
        }
    }
    public function destroy($id, Request $request)
    {
        $employee = Employee::findOrFail($id);

        File::delete(public_path().'/uploads/employees/'.$employee->image);
        
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee delete successfully');
    }
    public function view($id){
        $employee = Employee::findOrFail($id);

        //dd($employee);

        return view('employee.view', ['employee' => $employee]);        
    }

}
