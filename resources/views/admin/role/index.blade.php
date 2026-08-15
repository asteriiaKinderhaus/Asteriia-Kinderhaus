@extends('adminlte::page')
@section('title', 'Master Role')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>
        <i class="fas fa-user-tag"></i>
        Master Role
    </h1>

    <a href="{{ route('admin.roles.create') }}"
        class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah Role
    </a>
</div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card card-primary card-outline">
    <div class="card-body">
        <table id="roleTable"
            class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Keterangan</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->nama }}</td>
                    <td>{{ $role->keterangan }}</td>
                    <td>
                        <a href="{{ route('admin.roles.edit',$role) }}"
                            class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form
                            action="{{ route('admin.roles.destroy',$role) }}"
                            method="POST"
                            class="d-inline delete-form">

                            @csrf
                            @method('DELETE')
                            <button
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    $(function() {
        $('#roleTable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });

    $('.delete-form').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Hapus data?',
            text: 'Data tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>
@stop