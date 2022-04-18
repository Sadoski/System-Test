@extends('layouts.app')

@section('title', 'Visualização Usuário')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center mb-4 px-4">
            <div class="flex-row">
                <div class="pull-left">
                    <h2> {{ $user->name }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('user') }}" title="Go back"> <span class="material-icons">keyboard_return</span> </a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="">
                    <div class="form-group">
                        <strong>E-mail:</strong>
                        {{ $user->email }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection