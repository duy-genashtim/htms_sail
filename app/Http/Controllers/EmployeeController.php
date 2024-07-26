<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmergencyContact;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index()
    {
        // $employees = Employee::all();
        $employees = Employee::with(['departments' => function($query) {
            $query->select('departments.id', 'name', 'description', 'current_status', 'parent_id')->with('parent');
        }])->get();
        // $employees =[];
        return response()->json($employees);
    }

    public function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'email' => 'required|string|email|unique:employees,email',
            'personal_email' => 'required|string|email',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'hire_date' => 'nullable|date',
            'country' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'core_folder' => 'nullable|string|max:255',
            'current_status' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 400);
        }

         // Create a new Employee instance and save the data
        $employee = new Employee([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'extension_name' => $request->extension_name,
            'nick_name' => $request->nick_name,
            'email' => $request->email,
            'job_title' => $request->job_title,
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'hire_date' => $request->hire_date,
            'country' => $request->country,
            'gender' => $request->gender,
            'marital_status' => $request->marital_status,
            'core_folder' => $request->core_folder,
            'time_zone' => $request->time_zone,
            'member_category' => $request->member_category,
            'current_status' => $request->current_status,
            'address' => $request->address,
            'personal_email' => $request->personal_email,
        ]);

        $employee->save();
        // $employee = Employee::create($request->all());
        // return response()->json($employee, 201);
        // Return a response
        return response()->json(['message' => 'Employee created successfully', 'data' => $employee], 201);
    }

    public function show($id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }
        return response()->json($employee);
    }
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        if (!$employee ) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'personal_email' => 'required|string|email',
            'phone_number' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'hire_date' => 'nullable|date',
            'country' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'marital_status' => 'nullable|string|max:255',
            'core_folder' => 'nullable|string|max:255',
            'current_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $employee->update($request->all());
        logActivity('Employee updated', $request->all(),'Old employee data');
        return response()->json($employee);
    }

    public function getEmployeesByDepartment($departmentId)
    {
        // Fetch all employees in the specified department including their other department affiliations
        $employeesInDepartment = Employee::whereHas('departments', function ($query) use ($departmentId) {
            $query->where('department_id', $departmentId);
        })->with(['departments'])->get();

        // Fetch all employees not in the specified department
        // $employeesNotInDepartment = Employee::whereDoesntHave('departments', function ($query) use ($departmentId) {
        //     $query->where('department_id', $departmentId);
        // })->get();

        // Fetch all employees
        $employees = Employee::with(['departments' => function($query) {
            $query->select('departments.id', 'name', 'description', 'current_status', 'parent_id');
        }])->get();

        return response()->json([
            'in_department' => $employeesInDepartment,
            // 'not_in_department' => $employeesNotInDepartment,
            'all_employee' => $employees,
        ]);
    }

    public function storeEmergencyContact(Request $request, $id)
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string',
            'relationship' => 'required|string',
            'phone_number' => 'required|string',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);
        // Check if validation fails
        if ($validator->fails() || $id == 0) {
            return response()->json($validator->errors(), 400);

        }
       
        if ($request->id != 0) {
            $contact = EmergencyContact::find($request->id);
            if (!$contact) {
                return response()->json(['message' => 'Emergency contact information not found'], 404);
            }
            $contact->update($request->all());
            return response()->json($contact);
        } else {
            $contact = EmergencyContact::create($request->all());
            return response()->json($contact, 201);
        }
    }

    public function getEmergencyContact($id){
        
        $contacts = EmergencyContact::where('employee_id', $id)->get();
        // dd($contacts);
        return response()->json($contacts);
    }

    public function deleteEmergencyContact($id){

        $contact = EmergencyContact::find($id);
        if (!$contact) {
            return response()->json(['message' => 'Emergency contact information not found'], 404);
        }
        $contact->delete();
        return response()->json(['message' => 'Emergency contact deleted successfully']);
    }

}
