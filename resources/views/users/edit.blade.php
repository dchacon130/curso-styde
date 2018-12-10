@extends('layout')

@section('title', "Editar usuario")

@section('content')

	<h1>Editar Usuario</h1>

	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif

	<form method="POST" action="{{ route('users.show',['id' => $user->id]) }}">
		<!-- Metodo oculto -->
		{{ method_field('PUT')}}
		<!-- Obtener un token -->
		{!! csrf_field() !!}
		<label form="nombre">Nombre</label>
		<input type="text" name="name" placeholder="Nombre" value="{{ old('name', $user->name) }}">
		<br>
		<br>
		<label form="email">Email  </label>
		<input type="email" name="email" placeholder="Email" value="{{ old('email', $user->email) }}">
		<br>
		<br>
		<label form="password">Password</label>
		<input type="password" name="password" placeholder="Password">
		<br>
		<br>
		<button type="submit">Actualizar usuario</button>
	</form>

	<br>
	<a href="{{ route('users.index') }}">Regresar</a>
@endsection