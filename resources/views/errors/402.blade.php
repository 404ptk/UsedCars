@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Payment Required'))
