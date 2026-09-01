@extends('adminlte::page')

@section('title', 'Fasilitator - Peserta Didik')

@section('content_header') <h1>Fasilitator - Peserta Didik</h1>
@stop

@section('content')

<div class="card">

    ```
    <div class="card-header">
        <h3 class="card-title">
            Daftar Hubungan Fasilitator - Peserta Didik
        </h3>

        <div class="card-tools">
            <a href="{{ route('admin.facilitator-students.create') }}"
                class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>
    </div>

    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="text-center">
                    <tr>
                        <th width="60">No</th>
                        <th>Fasilitator</th>
                        <th>Peserta Didik</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($facilitatorStudents as $item)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->facilitator->name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->student->name ?? '-' }}
                        </td>

                        <td class="text-center">

                            <a href="{{ route(
                                'admin.facilitator-students.edit',
                                $item->facilitator_id
                            ) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form
                                action="{{ route(
                                    'admin.facilitator-students.destroy',
                                    $item->facilitator_id
                                ) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm(
                                        'Hapus hubungan fasilitator dan peserta didik ini?'
                                    )">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada hubungan fasilitator dengan peserta didik.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@stop