@extends('adminlte::page')

@section('title', 'Edit Makanan')

@section('content_header')
<h1>Edit Makanan</h1>
@stop

@section('content')

<form action="{{ route('admin.meals.update', $meal->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="name">Nama Makanan</label>

        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $meal->name) }}"
            required>

        @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Simpan Perubahan
    </button>

    <a href="{{ route('admin.meals.index') }}" class="btn btn-secondary">
        Batal
    </a>

</form>

@stop
