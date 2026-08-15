@extends('adminlte::page')
@section('title', 'Data Fasilitator')

@section('content_header')
<h1>
    <i class="fas fa-chalkboard-teacher"></i>
    Data Fasilitator
</h1>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button"
        class="close"
        data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Data Fasilitator
        </h3>

        <div class="card-tools">

            <a href="{{ route('admin.facilitators.create') }}"
                class="btn btn-primary">

                <i class="fas fa-plus"></i>

                Tambah Fasilitator

            </a>

        </div>

    </div>

    <div class="card-body">

        <table id="facilitatorTable"
            class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th width="5%">No</th>

                    <th>Nama</th>
                    <th>Tanggal lahir</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th width="18%">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($facilitators as $key => $facilitator)

                <tr>

                    <td>{{ $key + 1 }}</td>
                    <td>{{ $facilitator->name }}</td>
                    <td>{{ date('d-m-Y', strtotime($facilitator->birth_date)) }} </td>
                    <td>{{ $facilitator->email }}</td>
                    <td>{{ $facilitator->telephone }}</td>
                    <td>{{ $facilitator->gender->gender }}</td>
                    <td>
                        @if($facilitator->user->status)
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
                        <a href="{{ route('admin.facilitators.show',$facilitator->id) }}"
                            class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.facilitators.edit',$facilitator->id) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action="{{ route('admin.facilitators.destroy',$facilitator->id) }}"
                            method="POST"
                            style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this facilitator?')">

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8"
                        class="text-center">

                        No data available

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop

@section('plugins.Datatables', true)

@section('js')

<script>
    $(function() {

        $('#facilitatorTable').DataTable({

            responsive: true,
            autoWidth: false,

            language: {

                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                zeroRecords: "No matching records found",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries available",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }

            }

        });

    });
</script>

@stop