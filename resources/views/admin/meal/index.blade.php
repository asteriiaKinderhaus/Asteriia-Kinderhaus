@extends('adminlte::page')

@section('title', 'Meal')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Meal</h1>

    <a href="{{ route('admin.meals.create') }}"
        class="btn btn-primary">
        <i class="fas fa-plus"></i>
        Add Meal
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            Meal List
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="120">ID</th>
                    <th>Meal Name</th>
                    <!--<th width="100">Order</th>
                    <th width="100">Status</th>-->
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($meals as $meal)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $meal->id }}</td>

                    <td>{{ $meal->name }}</td>

                    <!--<td class="text-center">
                        {{ $meal->order_no }}
                    </td>

                    <td class="text-center">

                        @if($meal->status)
                        <span class="badge badge-success">
                            Active
                        </span>
                        @else
                        <span class="badge badge-danger">
                            Inactive
                        </span>
                        @endif

                    </td>-->

                    <td>

                        <a href="{{ route('admin.meals.show',$meal) }}"
                            class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.meals.edit',$meal) }}"
                            class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.meals.destroy',$meal) }}"
                            method="POST"
                            style="display:inline-block"
                            onsubmit="return confirm('Delete this meal?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm">

                                <i class="fas fa-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">
                        No data available.
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

        $('.table').DataTable({

            responsive: true,

            autoWidth: false,

            pageLength: 10,

        });

    });
</script>

@endsection