@extends('errors::minimal')

@section('title', __('Serwis nieosiągalny | UsedCarsPL'))
@section('code', '503')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Service Unavailable - Serwis nieosiągalny'))
