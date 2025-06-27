@extends('adminlte::page')

@section('title', 'Cambiar Contraseña')

@section('content_header')
    <h1>Cambiar Contraseña</h1>
@stop

@section('content')
    @if(session('success'))
        <x-adminlte-alert theme="success" title="Éxito">
            {{ session('success') }}
        </x-adminlte-alert>
    @endif

    @if ($errors->any())
        <x-adminlte-alert theme="danger" title="Error">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <x-adminlte-input name="current_password" label="Contraseña actual" type="password" required />

        <x-adminlte-input name="password" label="Nueva contraseña" type="password" required />

        <x-adminlte-input name="password_confirmation" label="Confirmar nueva contraseña" type="password" required />

        <x-adminlte-button class="btn btn-primary mt-3" type="submit" label="Actualizar contraseña" />
    </form>
@stop
