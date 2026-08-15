@extends('adminlte::page')

@section('title', 'Siswa')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Siswa</h1>

    <a href="{{ route('admin.students.create') }}"
        class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Tambah siswa
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
            Student List
        </h3>
    </div>

    <div class="card-body">

        <table id="studentTable"
            class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="40">No</th>
                    <th>Nama siswa</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Nama Orang Tua</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th width="130">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @foreach($students as $student)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->birth_date->format('d-m-Y') }}</td>
                    <td>{{ $student->gender->gender ?? '-' }}</td>
                    <td>{{ $student->parent->name ?? '-' }}</td>
                    <td>{{ $student->schoolClass->name ?? '-' }}</td>
                    <td>
                        @if($student->status)
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
                        <a href="{{ route('admin.students.show',$student->id) }}"
                            class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.students.edit',$student->id) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action="{{ route('admin.students.destroy',$student->id) }}"
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

        $('#studentTable').DataTable({

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