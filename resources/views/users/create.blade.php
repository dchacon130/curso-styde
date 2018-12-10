@extends('layout')

@section('title', "Crear usuario")

@section('content')

	<div class="card">
		<div class="card-header">
			<h1>Crear usuario</h1>
		</div>
		<div class="card-body">
			@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
			@endif

			<form method="POST" action="{{ route('users.store') }}">
				<!-- Obtener un token -->
				{!! csrf_field() !!}

				<div class="form-group">
				    <label form="nombre">Nombre</label>
					<input type="text" name="name" class="form-control" placeholder="Nombre" value="{{ old('name') }}">
				</div>

				<div class="form-group">
				    <label form="email">Email  </label>
					<input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
				</div>
				
				<div class="form-group">
				    <label form="password">Password</label>
				<input type="password" name="password" class="form-control" placeholder="Password">
				</div>

				
				<button type="submit" class="btn btn-primary">Crear usuario</button>
				<a href="{{ route('users.index') }}" class="btn btn-link">Regresar</a>
			</form>
		</div>
	</div>
@endsection