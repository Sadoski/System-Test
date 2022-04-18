@extends('layouts.app')

@section('title', 'Usuário')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Usuários') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="row">
                        <div class="form-group mb-2 col-lg-5">
                            {!! Form::open(['url' => 'usuario']) !!}
                                @csrf
                                @method('GET')
                                <div class="input-group">
                                    {!! Form::text('name', old('name'), ['aria-describedby' => 'search_parent_user', 'class' => 'form-control', 'maxlength'=>'150', 'placeholder'=>'Pesquisar']) !!}
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-sm " id="search_parent_user"><span class="material-icons-outlined">search</span></button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="form-group mb-2 col-lg-7">
                            <a class="btn btn-primary btn-sm mb-2 float-end" href="{{ route('auth.register') }}"><span class="material-icons-outlined">add_circle_outline</span></a>
                        </div>
                    </div>
                    <div>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <td style="width:10%;">ID</td>
                                    <td style="width:65%;">Nome</td>
                                    <td class="text-center " style="width:15%;">Ação</td>

                                </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $key => $value)
                                <tr>
                                    <td>{{ $value->id_user }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        @can('is_admin')
                                        {!! Form::model($user, ['route' => ['delete_user', $value->id_user]]) !!}
                                            <a class="btn btn-small btn-primary mb-2" href="{{ route('show_user',$value->id_user) }}"><span class="material-icons-outlined">visibility</span></a>
                                            
                                            <a class="btn btn-small btn-warning mb-2" href="{{ route('edit_user', $value->id_user) }}"><span class="material-icons-outlined">edit</span></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="delete" class="btn btn-small btn-danger mb-2"><span class="material-icons-outlined">delete</span></button>
                                            
                                        {!! Form::close() !!} 
                                        @else
                                            <a class="btn btn-small btn-primary mb-2" href="{{ route('show_user',$value->id_user) }}"><span class="material-icons-outlined">visibility</span></a>
                                        @endcannot
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection