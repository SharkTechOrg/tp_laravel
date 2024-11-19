<?php

namespace App\Http\Controllers;
use App\Models\Empleado;
use App\Models\Departamento;

use Illuminate\Http\Request;

class EmpleadoController extends Controller
{

    
    public function inicio()
{
    return view('empleados.inicio');
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::all();
        // Pasar los departamentos a la vista
        return view('empleados.create', compact('departamentos'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:empleados,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
        'alta_contrato' => 'required|date|before_or_equal:today',
        'salario' => 'required|numeric|min:0|max:999999999',
        'activo' => 'required|boolean',
        'id_departamento' => 'required|exists:departamentos,id_departamento',
    ]);

    Empleado::create($validated);
    // Redirigir con un mensaje de éxito
    return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id_empleado)
    {
        $empleado = Empleado::findOrFail($id_empleado);
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $empleado = Empleado::findOrFail($id);
    $departamentos = Departamento::all(); // Recupera todos los departamentos

    return view('empleados.edit', compact('empleado', 'departamentos'));
}



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validación de los datos enviados desde el formulario
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'email' => 'required|email|unique:empleados,email,' . $id . ',id_empleado|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/',
        'alta_contrato' => 'required|date|before_or_equal:today',
        'salario' => 'required|numeric|min:0|max:999999999',
        'activo' => 'required|boolean',
        'id_departamento' => 'nullable|exists:departamentos,id_departamento',
    ]);

    // Buscar el empleado por su ID
    $empleado = Empleado::findOrFail($id);

    // Actualizar los datos del empleado, manteniendo el departamento si no se cambia
    $empleado->update([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'email' => $request->email,
        'alta_contrato' => $request->alta_contrato,
        'salario' => $request->salario,
        'activo' => $request->activo,
        // Mantener el valor anterior si no se selecciona un departamento nuevo
        'id_departamento' => $request->id_departamento ?: $empleado->id_departamento, 
    ]);

    // Redirigir con un mensaje de éxito
    return redirect()->route('empleados.index')
                     ->with('success', 'Empleado actualizado correctamente.');
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();
        // Redirigir con un mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}
