@extends('adminlte::page')

@section('title', 'Master User')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-users"></i>
        Master User
    </h1>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah User
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
</div>
@endif

<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title">
            Daftar User
        </h3>
    </div>

    <div class="card-body">

        <table id="userTable" class="table table-bordered table-hover table-striped">

            <thead class="table-primary">

                <tr>

                    <th width="50">No</th>
                    <th>Nama</th>

                    <th>Username</th>

                    <th>Role</th>

                    <th>Status</th>

                    <th width="160">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>

                    <td>{{ $user->username }}</td>

                    <td>{{ $user->role->nama }}</td>

                    <td>

                        @if($user->status)

                        <span class="badge bg-success">

                            Aktif

                        </span>

                        @else

                        <span class="badge bg-danger">

                            Non Aktif

                        </span>

                        @endif

                    </td>

                    <td>

                        <a href="{{ route('admin.users.show',$user) }}"
                            class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('admin.users.edit',$user) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form
                            action="{{ route('admin.users.destroy',$user) }}"
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

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        Belum ada data user.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop

@section('js')

<script>
    $(function() {

        $('#userTable').DataTable({

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

        let form = this;

        Swal.fire({

            title: 'Hapus User?',

            text: 'Data yang dihapus tidak dapat dikembalikan.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',

            cancelButtonColor: '#3085d6',

            confirmButtonText: 'Ya',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                form.submit();

            }

        });

    });
</script>

@stop