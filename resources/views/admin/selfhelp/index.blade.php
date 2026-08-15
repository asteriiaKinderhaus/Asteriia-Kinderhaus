@extends('adminlte::page')

@section('title', 'Master Self Help')

@section('content_header')
<div class="d-flex justify-content-between">

    <h1>
        <i class="fas fa-user-tag"></i>
        Master Self Help
    </h1>

    <a href=""
        class="btn btn-primary">

        <i class="fas fa-plus"></i>

        Tambah item Self Help

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

        <table id="selfHelpTable"
            class="table table-bordered table-hover">

            <thead>

                <tr>

                    <th width="50">No</th>

                    <th>ID</th>

                    <th>Nama</th>

                    <th width="150">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($selfhelp as $row)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $row->id }}</td>

                    <td>{{ $row->name }}</td>

                    <td>

                        <a href=""
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form
                            action=""
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

        $('#selfHelpTable').DataTable({

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