@extends('adminlte::page')

@section('title', 'Daily Report')

@section('content_header')
<h1>Daily Report</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Laporan</h3>
    </div>

    <div class="card-body">
        <table id="dailyReportTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Report</th>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Fasilitator</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $report->id }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d-m-Y') }}</td>
                    <td>{{ $report->student->name ?? '-' }}</td>
                    <td>{{ $report->facilitator->name ?? '-' }}</td>
                    <td>
                        @if($report->status)
                        <span class="badge badge-success">Published</span>
                        @else
                        <span class="badge badge-secondary">Draft</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.daily-reports.show',$report->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.daily-reports.edit',$report->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Belum ada data.
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

        $('#dailyReportTable').DataTable({

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