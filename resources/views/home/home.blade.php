@extends('master.master')

@section('content')

    <action 
        action="{{url('/')}}/security/users/create" 
        aclass="btn btn-primary" 
        message="Criar novo usuário"
    >
    </action>

<h1>Ola</h1>

@stop