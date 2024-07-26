<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    public function index()
    {
        // $departments = Department::whereNull('parent_id')->with('departments')->get();
        $departments = Department::whereNull('parent_id')
            ->with(['departments', 'mancom', 'head'])
            ->get();
        // dd($departments);
        // $newDepartments = reFormatDepartments($departments);

        return response()->json($departments);
    }

    public function store(Request $request)
    {
        // Define the validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);

        }
        if ($request->id != 0) {
            $department = Department::find($request->id);
            if (!$department) {
                return response()->json(['message' => 'Department not found'], 404);
            }
            $department->update($request->all());
            return response()->json($department);
        } else {
            $department = Department::create($request->all());
            return response()->json($department, 201);
        }

        // Return a response
        // return response()->json(['message' => 'Department created successfully', 'data' => $department], 201);
    }

    public function show($id)
    {
        $department = Department::with(['departments', 'mancom', 'head'])->find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }
        return response()->json($department);
    }

    public function addEmployees(Request $request, $departmentId)
    {
        $employeeIds = $request->input('employeeIds');
        // Assuming you have a Department model with many-to-many relationship setup
        $department = Department::find($departmentId);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        // Syncing employees to the department, this will add new and remove unselected
        $department->employees()->sync($employeeIds);

        return response()->json(['message' => 'Employees updated successfully'], 200);
    }

    public function toggleMainDepartment(Request $request, $departmentId)
    {
        $employeeIds = $request->employeeIds; // Expecting an array of employee IDs from the request
        try {
            foreach ($employeeIds as $employeeId) {
                $pivot = DB::table('employee_department')
                    ->where('employee_id', $employeeId)
                    ->where('department_id', $departmentId)
                    ->first();
    
                if ($pivot) {
                    DB::table('employee_department')
                        ->where('employee_id', $employeeId)
                        ->where('department_id', $departmentId)
                        ->update(['is_main_department' => !$pivot->is_main_department]);
                }
            }
    
            return response()->json(['message' => 'Main department statuses toggled successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error toggling statuses', 'error' => $e->getMessage()], 500);
        }
    }
}
