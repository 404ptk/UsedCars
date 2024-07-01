@extends('errors::minimal')

@section('title', __('Brak dostępu | UsedCarsPL'))
@section('code', '401')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Unauthorized - Brak dostępu'))
