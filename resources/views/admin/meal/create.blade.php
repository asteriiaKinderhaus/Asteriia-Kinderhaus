@extends('adminlte::page')

@section('title', 'Add Meal')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Add Meal</h1>

    <a href="{{ route('admin.meals.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Meal Form</h3>
    </div>

    <form action="{{ route('admin.meals.store') }}" method="POST">
        @csrf

        <div class="card-body">

            {{-- Meal Name --}}
            <div class="form-group">
                <label>Meal Name <span class="text-danger">*</span></label>

                <input
                    type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Enter meal name">

                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- Order --}}
            <div class="form-group">
                <label>Order <span class="text-danger">*</span></label>

                <input
                    type="number"
                    name="order_no"
                    class="form-control @error('order_no') is-invalid @enderror"
                    value="{{ old('order_no') }}"
                    min="1">

                @error('order_no')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>Status</label>

                <select
                    name="status"
                    class="form-control @error('status') is-invalid @enderror">

                    <option value="1"
                        {{ old('status',1)==1 ? 'selected':'' }}>
                        Active
                    </option>

                    <option value="0"
                        {{ old('status')==='0' ? 'selected':'' }}>
                        Inactive
                    </option>

                </select>

                @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

        </div>

        <div class="card-footer">
            <button class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save
            </button>

            <a href="{{ route('admin.meals.index') }}"
                class="btn btn-secondary">
                Cancel
            </a>
        </div>

    </form>

</div>

@stop