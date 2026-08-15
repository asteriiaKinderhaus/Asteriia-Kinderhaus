@extends('adminlte::page')

@section('title', 'Stimulation')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Stimulasi</h1>

    <a href="{{route('admin.stimulation.create') }}"
        class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah item stimulasi
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">

    <button type="button"
        class="close"
        data-dismiss="alert">
        <span>&times;</span>
    </button>

    {{ session('success') }}

</div>
@endif

<div class="card">

    <div class="card-header">

        <h3 class="card-title">

            Master Stimulasi

        </h3>

    </div>

    <div class="card-body">

        <table id="stimulationTable"
            class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="40">No</th>
                    <th>Kategori</th>
                    <th>Nama</th>
                    <th width="130">Aksi</th>

                </tr>
            </thead>

            <tbody>

                @foreach($stimulations as $stimulation)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $stimulation->category->name }}</td>
                    <td>{{ $stimulation->name }}</td>
                    <td>

                        <a href=""
                            class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{route('admin.stimulation.edit', $stimulation) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action=""
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this student?')">

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

        $('#stimulationTable').DataTable({

            responsive: true,

            autoWidth: false,

            pageLength: 10,

            language: {

                search: "Search:",

                lengthMenu: "Show _MENU_ data",

                zeroRecords: "No data found",

                info: "Showing _START_ to _END_ of _TOTAL_ data",

                infoEmpty: "No data",

                paginate: {

                    first: "First",

                    last: "Last",

                    next: "Next",

                    previous: "Previous"

                }

            }

        });

    });
</script>

@stop