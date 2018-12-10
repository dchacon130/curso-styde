@extends('layout')

@section('title', "Usuario {$user->name}")

@section('content')

	<h1>Usuario #{{ $user->id}}</h1>

	Mostrando detalle del usuario: {{ $user->name }}
	<br>
	Mostrando correo del usuario: {{ $user->email }}
	<br>
	<a href="{{ route('users.index') }}">Regresar</a>
@endsection