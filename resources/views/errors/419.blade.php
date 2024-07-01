@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
<a aria-current="page" href="{{ route('mainpage') }}">Powrót do głównej strony</a>
@section('message', __('Page Expired'))
