@extends('layouts.app')

@section('title', 'Visualização Empresa')

@section('scriptHead')
    {!! $map['js'] !!}
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center mb-4 px-4">
            <div class="flex-row">
                <div class="pull-left">
                    <h2> {{ $company->name }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('company') }}" title="Go back"> <span class="material-icons">keyboard_return</span> </a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="">
                    <div class="form-group ">
                        <strong>Tipo de Empresa:</strong>
                        {{ $company->companyType->company_type }}
                    </div>
                    <div class="form-group">
                        <strong>Nome:</strong>
                        {{ $company->name }}
                    </div>
                    <div class="form-group">
                        <strong>Nome Fantasia:</strong>
                        {{ $company->trading_name }}
                    </div>
                    <div class="form-group">
                        <strong>CNPJ:</strong>
                        {{ $company->cnpj }}
                    </div>
                    <div class="form-group">
                        <strong>Endereço:</strong>
                        {{ $company->address }}
                    </div>
                    <div class="form-group">
                        <strong>Cidade:</strong>
                        {{ $company->city }}
                    </div>
                    <div class="form-group">
                        <strong>Estado:</strong>
                        {{ $company->state }}
                    </div>
                    <div class="form-group">
                        <strong>E-mail:</strong>
                        {{ $company->email }}
                    </div>
                    <div class="form-group">
                        <strong>Latitude:</strong>
                        {{ $company->latitude }}
                    </div>
                    <div class="form-group">
                        <strong>Logitude:</strong>
                        {{ $company->longitude }}
                    </div>
                    <div class="mt-5">
                        {!! $map['html'] !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection