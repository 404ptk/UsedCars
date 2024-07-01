@extends('errors::minimal')

@section('title', __('Nie znaleziono strony | UsedCarsPL'))
@section('code', '404')
    <a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Not Found - Nie znaleziono strony'))
