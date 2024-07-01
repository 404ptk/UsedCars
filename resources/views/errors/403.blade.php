@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __($exception->getMessage() ?: 'Forbidden'))
