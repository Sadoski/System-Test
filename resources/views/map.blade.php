@extends('layouts.app')

@section('title', 'Localização')

@section('scriptHead')
    <script type="text/javascript">var centreGot = false;</script>
    {!! $map['js'] !!}
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-center mb-4 px-4">
        {!! $map['html'] !!}
    </div>
</div>
@endsection
