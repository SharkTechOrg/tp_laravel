@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="card p-4 shadow-lg" style="width: 850px;">
            <h4 class="text-center mb-4">Detalles del Empleado</h4>

            <div class="mb-3">
                <p><strong>Nombre:</strong> {{ $empleado->nombre }} {{ $empleado->apellido }}</p>
                <p><strong>Email:</strong> {{ $empleado->email }}</p>
                <p><strong>Fecha de Contratación:</strong> 
                    {{ \Carbon\Carbon::parse($empleado->alta_contrato)->format('d/m/Y') }}
                </p>
                <p><strong>Salario:</strong> ${{ number_format($empleado->salario, 2) }}</p>
                <p><strong>Estado:</strong> {{ $empleado->activo ? 'Activo' : 'Inactivo' }}</p>
                <p><strong>Departamento:</strong> {{ $empleado->departamento->descripcion }}</p>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('empleados.edit', $empleado->id_empleado) }}" class="btn btn-warning">Editar</a>
                <form action="{{ route('empleados.destroy', $empleado->id_empleado) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
