@extends('layouts.app')

@section('title', 'Cadastrar Empresa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __(' Cadastrar Empresas') }}</div>

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

                    {!! Form::open(['url' => 'empresa/cadastrar']) !!}
                        {!! Form::token() !!}
                        @can('is_admin')
                        <div class="form-group col-xs-2 mb-2">
                            {!! Form::label('company_type_id', 'Tipo de Empresa', ['class' => 'control-label']) !!}
                            {!! Form::select('company_type_id', $companyType, old('company_type_id'), ['class' => 'form-select' , 'style' =>'width:auto;']) !!}
                        </div>
                        <div class="form-group col-xs-2 mb-2" id="hidden_div" style="display: none;">
                            {!! Form::label('parent_company_id', 'Empresa Matriz', [ 'class' => 'control-label']) !!}
                            {!! Form::select('parent_company_id', $company, old('parent_company_id'), ['class' => 'form-select']) !!}
                        </div>
                        @else
                        <div class="form-group col-xs-2 mb-2" id="hidden_div">
                            {!! Form::label('parent_company_id', 'Empresa Matriz', ['class' => 'control-label']) !!}
                            {!! Form::select('parent_company_id', $company, old('parent_company_id'), ['class' => 'form-select', 'required']) !!}
                        </div>
                        @endcannot
                        <div class="form-group  mb-2">
                            {!! Form::label('name', 'Razão Social', ['class' => 'awesome']) !!}
                            {!! Form::text('name', old('name'),['class' => 'form-control', 'maxlength'=>'150', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('trading_name', 'Nome Fantasia', ['class' => 'awesome']) !!}
                            {!! Form::text('trading_name', old('trading_name'),['class' => 'form-control', 'maxlength'=>'150', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('cnpj', 'CNPJ', ['class' => 'awesome cpfCnpj']) !!}
                            {!! Form::text('cnpj', old('cnpj'),['class' => 'form-control', 'maxlength'=>'18', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('address', 'Endereço', ['class' => 'awesome']) !!}
                            {!! Form::text('address', old('address'),['class' => 'form-control', 'maxlength'=>'45', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('city', 'Cidade', ['class' => 'awesome']) !!}
                            {!! Form::text('city', old('city'),['class' => 'form-control', 'maxlength'=>'45', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('state', 'Estado', ['class' => 'awesome']) !!}
                            {!! Form::text('state', old('state'),['class' => 'form-control', 'maxlength'=>'45', 'required']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('email', 'E-Mail', ['class' => 'awesome']) !!}
                            {!! Form::email('email', old('email'),['class' => 'form-control', 'maxlength'=>'45']) !!}
                        </div>
                        <div class="form-group  mb-2">
                            {!! Form::label('latitude', 'Latitude', ['class' => 'awesome']) !!}
                            {!! Form::number('latitude', old('latitude'),['class' => 'form-control', 'maxlength'=>'20']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('longitude', 'Longitude', ['class' => 'awesome']) !!}
                            {!! Form::number('longitude', old('longitude'),['class' => 'form-control', 'maxlength'=>'20']) !!}
                        </div>
                        <div class="form-group py-3">
                            {!! Form::submit('Registrar', ['class' => 'btn btn-success']) !!}
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
@endsection