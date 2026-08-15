@extends('adminlte::page')

@section('title', 'Fasilitator-Kelas')

@section('content_header')

<div class="content-header">
    <div class="container-fluid">

        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    <i class="fas fa-school"></i>
                    Kelas
                </h1>
            </div>

            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.school-classes.create') }}"
                    class="btn btn-primary">

                    <i class="fas fa-plus"></i>
                    Add Class
                </a>
            </div>
        </div>

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">

                    Daftar Fasilitator - Kelas

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>ID</th>

                            <th>Nama Kelas</th>

                            <th>Nama Fasilitator</th>

                            <th>Kapasitas</th>

                            <th>Status</th>

                            <th width="180">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($classes as $class)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $class->id }}</td>

                            <td>{{ $class->name }}</td>

                            <td>
                                @forelse($class->facilitators as $facilitator)
                                <span class="badge badge-success">
                                    {{ $facilitator->name }}
                                </span>
                                @empty
                                <span class="text-muted">Belum ada fasilitator</span>
                                @endforelse
                            </td>

                            <td>{{ $class->capacity }}</td>

                            <td>

                                @if($class->status)

                                <span class="badge badge-success">

                                    Active

                                </span>

                                @else

                                <span class="badge badge-danger">

                                    Inactive

                                </span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.school-classes.show',$class->id) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                </a>

                                <a href="{{ route('admin.school-classes.edit',$class->id) }}"
                                    class="btn btn-warning btn-sm">

                                    <i class="fas fa-edit"></i>

                                </a>

                                <form action="{{ route('admin.school-classes.destroy',$class->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this class?')">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="7"
                                class="text-center">

                                No Data

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
