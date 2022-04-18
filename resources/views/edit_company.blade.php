@extends('layouts.app')

@section('title', 'Editar Empresa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __(' Editar Empresas') }}</div>

                <div class="card-body">
                    <!-- if there are creation errors, they will show here -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {!! Form::model($company, ['route' => ['update_company', $company->id_company]]) !!}
                        @method('PUT')
                        @can('is_admin')
                        {!! Form::token() !!}
                        <div class="form-group mb-2">
                            {!! Form::label('company_type_id', 'Tipo de Empresa', ['class' => 'control-label']) !!}
                            {!! Form::select('company_type_id', $companyType, old('company_type_id', $company->company_type_id), ['class' => 'form-select', 'required', 'style' =>'width:auto;'] ) !!}
                        </div>
                        <div class="form-group col-xs-2 mb-2" id="hidden_div" @if($company->company_type_id == 1) style="display: none;" @endif>
                            {!! Form::label('parent_company_id', 'Empresa Matriz', ['class' => 'control-label']) !!}
                            {!! Form::select('parent_company_id', $companySearch, old('parent_company_id', $company->parent_company_id), ['class' => 'form-select', 'required']) !!}
                        </div>
                        @else
                        <div class="form-group col-xs-2 mb-2">
                            {!! Form::label('parent_company_id', 'Empresa Matriz', ['class' => 'control-label']) !!}
                            {!! Form::select('parent_company_id', $companySearch, old('parent_company_id', $company->parent_company_id), ['class' => 'form-select', 'required']) !!}
                        </div>
                        @endcannot
                        <div class="form-group  mb-2">
                            {!! Form::label('name', 'Razão Social', ['class' => 'awesome']) !!}
                            {!! Form::text('name', $company->name, ['class' => 'form-control', 'maxlength'=>'150', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('trading_name', 'Nome Fantasia', ['class' => 'awesome']) !!}
                            {!! Form::text('trading_name', $company->trading_name,['class' => 'form-control', 'maxlength'=>'150', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('cnpj', 'CNPJ', ['class' => 'awesome']) !!}
                            {!! Form::text('cnpj', $company->cnpj,['class' => 'form-control', 'maxlength'=>'18', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('address', 'Endereço', ['class' => 'awesome']) !!}
                            {!! Form::text('address', $company->address,['class' => 'form-control', 'maxlength'=>'45', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('city', 'Cidade', ['class' => 'awesome']) !!}
                            {!! Form::text('city', $company->city,['class' => 'form-control', 'maxlength'=>'45', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('state', 'Estado', ['class' => 'awesome']) !!}
                            {!! Form::text('state', $company->state,['class' => 'form-control', 'maxlength'=>'45', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('email', 'E-Mail', ['class' => 'awesome']) !!}
                            {!! Form::email('email', $company->email,['class' => 'form-control', 'maxlength'=>'45']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('latitude', 'Latitude', ['class' => 'awesome']) !!}
                            {!! Form::text('latitude', $company->latitude,['class' => 'form-control', 'maxlength'=>'25']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('longitude', 'Longitude', ['class' => 'awesome']) !!}
                            {!! Form::text('longitude', $company->longitude,['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group py-3">
                            {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@can('is_admin')
<script>
    window.onload=function(){document.getElementById('company_type_id').addEventListener('change', function () {
        var style = this.value == '2' ? 'block' : 'none';
        document.getElementById('hidden_div').style.display = style;
    });
    }
</script>
<script>
    $(document).ready(function(){
        var CpfCnpjMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
    },
    cpfCnpjpOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
        }
    };
    $('#cnpj').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
     }); 
</script>
@endcannot