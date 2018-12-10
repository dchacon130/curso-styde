@extends('layout')

@section('title', "Listado Usuarios")

@section('content')
    
    <div class="d-flex justify-content-between align-tiems-end">
        <h1 class="pb-1">{{ $title }}</h1>
        <p>
            <a href="{{ route('users.create') }}" class="btn btn-primary">Nuevo usuario</a>    
        </p>
    </div>

	

	<hr>

    @if ($users->isNotEmpty())

    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre</th>
          <th scope="col">Correo</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <th scope="row">{{ $user->id }}</th>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>             
            <form action="{{ route('users.destroy', $user) }}" method="POST">
                <!-- Metodo oculto -->
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <a href="{{ route('users.show', ['id' => $user->id]) }}" class="btn btn-link"><span class="oi oi-eye"></span></a> | 
                <a href="{{ route('users.edit', ['id' => $user]) }}" class="btn btn-link"><span class="oi oi-pencil"></span></a> |
                <button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @else
        <p>No hay usuarios registrados</p>
    @endif
    <hr>

@endsection

@section('sidebar')
	<h1>Barra lateral Personalizada</h1>
	<p>Ingresando texto estatico</p>
@endsection