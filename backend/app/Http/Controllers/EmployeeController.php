<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $response = Employee::with('departament_id')->get();

        return response()->json($response);
    }

    public function store(Request $request)
    {
     try {
        $request->validate([
            'departament_id' => 'required|integer',
            'level' => 'required|integer',
            'name' => 'nullable|string'
        ]);

        $existingDepartament = Departament::where('id', $request->departament_id)->first();

        if (!$existingDepartament) {
            return response()->json(['error' => 'Departamento no encontrado.'], 404);
        }

        if($request->level < 0 || $request->level > 3){
            return response()->json(['error' => 'El nivel del empleado debe estar entre 0 y 3.'], 400);
        }

        $data = new Employee();
        $data->departament_id = $request->departament_id;
        $data->level = $request->level;
        $data->name = $request->name;
        $data->save();

        return response()->json($data);
     } catch (\Throwable $th) {
        throw $th;
     }
    }

    public function show($id)
    {
        $response = Employee::with('departament')->find($id);

        if (!$response) {
            return response()->json(['error' => 'Empleado no encontrado.'], 404);
        }

        return response()->json($response);
    }
}
