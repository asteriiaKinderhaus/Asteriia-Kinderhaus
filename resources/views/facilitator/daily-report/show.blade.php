@extends('adminlte::page')

@section('title', 'Show Daily Report')

@section('content')

@error('student_id')
<div class="alert alert-danger">
    {{ $message }}
</div>

@enderror