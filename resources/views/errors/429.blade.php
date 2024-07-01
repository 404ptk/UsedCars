@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Too Many Requests'))
