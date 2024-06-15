<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use App\Models\Employee;
use Illuminate\Http\Request;
use \Illuminate\Support\Collection;

class DepartamentController extends Controller
{

    public function index()
    {
        $data = Departament::with(['ambassador', 'departament_dad_id'])->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string:max:45',
                'departament_dad_id' => 'nullable|integer'
            ]);

            $existingDepartament = Departament::where('name', $request->name)->first();

            if ($existingDepartament) {
                return response()->json(['error' => 'El nombre del departamento ya existe. Por favor, elige otro.'], 400);
            }

            if ($request->departament_dad_id) {
                $existingDadDepartament = Departament::find($request->departament_dad_id);

                if (!$existingDadDepartament) {
                    return response()->json(['error' => 'Departamento padre no encontrado.'], 404);
                }
            }

            if (strlen($request->name) > 45) {
                return response()->json(['error' => 'El nombre del departamento no puede tener más de 45 caracteres.'], 400);
            }

            $data = new Departament();
            $data->name = $request->name;
            if ($request->departament_dad_id) {
                $data->departament_dad_id = $request->departament_dad_id;
            }
            $data->save();

            $random = rand(3, 12);

            for ($i = 0; $i < $random; $i++) {
                $employee = new Employee();
                $employee->departament_id = $data->id;
                $employee->level = rand(0, 3);
                $employee->save();
            }

            return response()->json(['data' => $data, 'employees' => $random]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    public function applyAmbassador(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'ambassador' => 'required|integer',
                'name_ambassador' => 'required|string'
            ]);

            $existingDepartament = Departament::find($id);

            if (!$existingDepartament) {
                return response()->json(['error' => 'Departamento no encontrado.'], 404);
            }

            $employee = Employee::where('departament_id', $id)
                ->where('id', $validatedData['ambassador'])
                ->first();

            if (!$employee) {
                return response()->json(['error' => 'Empleado no encontrado.'], 404);
            }

            $employee->name = $validatedData['name_ambassador'];
            $employee->save();

            $existingDepartament->ambassador = $validatedData['ambassador'];
            $existingDepartament->save();

            return response()->json(['message' => 'Embajador asignado correctamente.']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function applyDaddy(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'departament_dad_id' => 'required|integer'
            ]);

            $existingDepartament = Departament::find($id);

            if (!$existingDepartament) {
                return response()->json(['error' => 'Departamento no encontrado.'], 404);
            }

            $existingDadDepartament = Departament::find($validatedData['departament_dad_id']);

            if (!$existingDadDepartament) {
                return response()->json(['error' => 'Departamento padre no encontrado.'], 404);
            }

            $existingDepartament->departament_dad_id = $validatedData['departament_dad_id'];
            $existingDepartament->save();

            return response()->json(['message' => 'Departamento padre asignado correctamente.']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $data = Departament::with(['ambassador', 'departament_dad_id'])->find($id);

        return response()->json($data);
    }

    public function showSubdepartaments($id)
    {
        try {
            $data = Departament::where('departament_dad_id', $id)->get();

            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = Departament::find($id);

            if (!$data) {
                return response()->json(['error' => 'Departamento no encontrado.'], 404);
            }

            $data->name = $request->name;
            $data->save();

            return response()->json($data);
        } catch (\Throwable $e) {

            if ($e->getCode() == 23000) {
                return response()->json(['error' => 'El nombre del departamento ya existe. Por favor, elige otro.'], 400);
            }

            throw $e;
        }
    }

    public function destroy($id)
    {
        $data = Departament::find($id);

        if (!$data) {
            return response()->json(['error' => 'Departamento no encontrado.'], 404);
        }

        $data->ambassador = null;
        $data->save();

        $data->employees()->delete();

        $data->delete();

        return response()->json(['message' => 'Departamento eliminado correctamente.']);
    }

    public function formatData($perPage = 15, $sortField = 'id', $sortOrder = 'asc')
    {

        $data = Departament::with(['ambassador', 'departament_dad_id'])
            ->withCount('employees')
            ->orderBy($sortField, $sortOrder)
            ->paginate($perPage);

        $newData = $data->map(function ($item) {
            $itemArray = $item->toArray();
            $itemArray['subdivision_count'] = Departament::where('departament_dad_id', $item->id)->count();
            return $itemArray;
        });


        return response()->json(['data' => $newData, 'total' => $data->total()]);
    }

    public function searchData($filter, $search)
    {
        [$relation, $field] = explode('.', $filter);

        $data = Departament::with(['ambassador', 'departament_dad_id'])
            ->whereHas($relation, function ($query) use ($field, $search) {
                $query->where($field, 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json($data);
    }

    public function getData(Request $request)
    {

        $perPage = $request->perPage ?? 15;
        $sortField = $request->sortField ?? 'id';
        $sortOrder = $request->sortOrder ?? 'asc';
        $filter = $request->filter ?? null;
        $search = $request->search ?? null;

        $query = Departament::with(['ambassador', 'departament_dad_id'])
            ->withCount('employees')
            ->orderBy($sortField, $sortOrder);

        if ($filter && $search && strpos($filter, '.') !== false) {
            [$relation, $field] = explode('.', $filter);
            $query->whereHas($relation, function ($query) use ($field, $search) {
                $query->where($field, 'like', '%' . $search . '%');
            });
        } else {
            if ($search) {
                $searchItems = explode(',', $search);
                if (count($searchItems) > 1) {
                    $query->whereIn($filter, $searchItems);
                } else {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            }
        }

        $data = $query->paginate($perPage);

        $newData = $data->map(function ($item) {
            $itemArray = $item->toArray();
            $itemArray['subdivision_count'] = Departament::where('departament_dad_id', $item->id)->count();
            return $itemArray;
        });

        return response()->json(['data' => $newData, 'total' => $data->total()]);
    }

    public function listNameDepartaments()
    {
        $data = Departament::select('id', 'name')->get();

        return response()->json($data);
    }
}
