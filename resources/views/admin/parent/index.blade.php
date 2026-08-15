@extends('adminlte::page')

@section('title', 'Orang Tua')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Orang Tua</h1>

    <a href="{{ route('admin.parents.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Orang Tua
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button"
        class="close"
        data-dismiss="alert">

        &times;

    </button>

    {{ session('success') }}

</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Daftar Orang Tua
        </h3>
    </div>

    <div class="card-body">
        <table id="parentTable"
            class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Telephone</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($parents as $parent)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $parent->id }}</td>

                    <td>{{ $parent->name }}</td>

                    <td>{{ optional($parent->gender)->gender }}</td>

                    <td>{{ $parent->telephone }}</td>

                    <td>{{ $parent->email }}</td>

                    <td>{{ optional($parent->user)->username }}</td>

                    <td>

                        @if(optional($parent->user)->status)

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

                        <a href="{{ route('admin.parents.show',$parent->id) }}"
                            class="btn btn-info btn-sm">

                            <i class="fas fa-eye"></i>

                        </a>

                        <a href="{{ route('admin.parents.edit',$parent->id) }}"
                            class="btn btn-warning btn-sm">

                            <i class="fas fa-edit"></i>

                        </a>

                        <form action="{{ route('admin.parents.destroy',$parent->id) }}"
                            method="POST"
                            style="display:inline-block">

                            @csrf

                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this data?')">

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

        $('#parentTable').DataTable({

            responsive: true,

            autoWidth: false,

            pageLength: 10,

        });

    });
</script>

@stop