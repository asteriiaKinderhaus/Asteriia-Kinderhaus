@extends('adminlte::page')
@section('title', 'Laporan Harian')

@section('content_header')
<h1>Laporan Harian</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('facilitator.daily-reports.create') }}"
            class="btn btn-primary float-right">
            <i class="fas fa-plus"></i> Buat Laporan harian
        </a>
        <h3 class="card-title">
            Daftar Laporan Harian
        </h3>
    </div>

    <div class="card-body">
        <table id="reportTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama siswa</th>
                    <th>Status</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d-m-Y') }}</td>
                    <td>{{ $report->student->name }}</td>
                    <td>
                        @if($report->status == 0)
                        <span class="badge badge-secondary">
                            Draft
                        </span>
                        @else
                        <span class="badge badge-success">
                            Published
                        </span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('facilitator.daily-reports.show', $report->id) }}"
                            class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('facilitator.daily-reports.edit', $report->id) }}"
                            class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No report yet.
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

        $('#reportTable').DataTable({
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