@extends('adminlte::page')

@section('title', 'Edit Stimulasi')

@section('content_header')
<h1>Edit Stimulasi</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Form Edit Stimulasi</h3>
    </div>

    <form action="{{ route('admin.stimulation.update', $stimulation->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>ID</label>

                <input
                    type="text"
                    class="form-control"
                    value="{{ $stimulation->id }}"
                    readonly>
            </div>

            <div class="form-group">
                <label>Kategori</label>

                <select
                    name="category_id"
                    class="form-control @error('category_id') is-invalid @enderror"
                    required>

                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id', $stimulation->category_id) == $category->id ? 'selected' : '' }}>

                        {{ $category->name }}

                    </option>

                    @endforeach

                </select>

                @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            <div class="form-group">

                <label>Nama Stimulasi</label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $stimulation->name) }}"
                    required>

                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Update
            </button>

            <a href="{{ route('admin.stimulation.index') }}"
                class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Kembali

            </a>

        </div>

    </form>

</div>

@stop