@extends('layouts.app')

@section('title', 'Início')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <section class="content mb-5">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4 col-8">
                                <div class="card bg-info mb-4" style="width: 15rem;">
                                    <div style="display: flex;
                                                position:absolute;
                                                right:15px;
                                                top:15px;
                                                transition:-webkit-transform .3s linear;
                                                transition:transform .3s linear;
                                                transition:transform .3s linear,
                                                -webkit-transform .3s linear;">
                                        <span class="material-icons-outlined opacity-25" style="font-size: 60px;">business</span>
                                    </div>
                                    <div class="card-body text-light">
                                        <h3>{{ $countCompany }}</h3>
                                        <p>Empresas</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-center" >
                                        <a href="{{ route('company') }}" class="link-light text-decoration-none d-flex align-items-center" style="">Mais informações <span class="material-icons-outlined text-light pulse">arrow_circle_right</span></a>
                                    </div>
                                </div>
                            </div>
                            @can('is_admin')
                            <div class="col-lg-4 col-8">
                                <div class="card bg-success mb-4" style="width: 15rem;">
                                    <div style="display: flex;
                                                position:absolute;
                                                right:15px;
                                                top:15px;
                                                transition:-webkit-transform .3s linear;
                                                transition:transform .3s linear;
                                                transition:transform .3s linear,
                                                -webkit-transform .3s linear;">
                                        <span class="material-icons-outlined opacity-25" style="font-size: 60px;">person</span>
                                    </div>
                                    <div class="card-body text-light">
                                        <h3>{{ $countUser }}</h3>
                                        <p>Usuários</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-center" >
                                        <a href="{{ route('user') }}" class="link-light text-decoration-none d-flex align-items-center" style="">Mais informações<span class="material-icons-outlined text-light ">arrow_circle_right</span></a> 
                                    </div>
                                </div>
                            </div>
                            @endcannot
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
