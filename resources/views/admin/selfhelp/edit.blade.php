@extends('adminlte::page')

@section('title', 'Edit Self Help')

@section('content_header')
<h1>Edit Self Help</h1>
@stop

@section('content')

<form action="{{ route('admin.selfhelp.update', ['selfhelp' => $selfhelp->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Nama Self Help</label>

        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $selfhelp->name) }}"
            required>

        @error('name')
        <span class="invalid-feedback">
            {{ $message }}
        </span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Simpan Perubahan
    </button>

    <a href="{{ route('admin.selfhelp.index') }}" class="btn btn-secondary">
        Batal
    </a>

</form>

@stop
