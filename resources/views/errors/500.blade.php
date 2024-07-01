@extends('errors::minimal')

@section('title', __('Bład serwera | UsedCarsPL'))
@section('code', '500')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Server Error - Błąd serwera'))
