@extends('layouts.app')
@section('title','Dashboard')
@section('content')

    @if((Entrust::hasRole('admin'))||(Entrust::hasRole('master')))
    @include('partials._admin',['fiados'=>$fiados] )
    @endif


    @role('user')
    @include('partials._user' )
    @endrole

@endsection