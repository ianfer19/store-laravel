@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Encabezado -->
        <div class="col-md-8">
            <h2 class="text-center fw-bold mb-4">
                {{ __('Profile') }}
            </h2>
        </div>

        <!-- Formulario para actualizar información del perfil -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    {{ __('Update Profile Information') }}
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Formulario para actualizar contraseña -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    {{ __('Update Password') }}
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Formulario para eliminar cuenta -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white">
                    {{ __('Delete Account') }}
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
