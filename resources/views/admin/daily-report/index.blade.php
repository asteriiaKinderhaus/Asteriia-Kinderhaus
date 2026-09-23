@extends('adminlte::page')

@section('title', 'Laporan Harian')

@section('content_header')
<h1>Laporan Harian</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Laporan</h3>
    </div>

    <div class="card-body">
        {{-- Filter Bulan dan Tahun --}}
        <form method="GET" action="{{ route('admin.daily-reports.index') }}" class="mb-4">
            <div class="row">
                {{-- Filter Bulan --}}
                <div class="col-md-3">
                    <label for="month">Bulan</label>
                    <select name="month"
                        id="month"
                        class="form-control">
                        <option value="">Semua Bulan</option>
                        <option value="1"
                            {{ request('month') == '1' ? 'selected' : '' }}>
                            Januari
                        </option>
                        <option value="2"
                            {{ request('month') == '2' ? 'selected' : '' }}>
                            Februari
                        </option>
                        <option value="3"
                            {{ request('month') == '3' ? 'selected' : '' }}>
                            Maret
                        </option>
                        <option value="4"
                            {{ request('month') == '4' ? 'selected' : '' }}>
                            April
                        </option>
                        <option value="5"
                            {{ request('month') == '5' ? 'selected' : '' }}>
                            Mei
                        </option>
                        <option value="6"
                            {{ request('month') == '6' ? 'selected' : '' }}>
                            Juni
                        </option>
                        <option value="7"
                            {{ request('month') == '7' ? 'selected' : '' }}>
                            Juli
                        </option>
                        <option value="8"
                            {{ request('month') == '8' ? 'selected' : '' }}>
                            Agustus
                        </option>
                        <option value="9"
                            {{ request('month') == '9' ? 'selected' : '' }}>
                            September
                        </option>
                        <option value="10"
                            {{ request('month') == '10' ? 'selected' : '' }}>
                            Oktober
                        </option>
                        <option value="11"
                            {{ request('month') == '11' ? 'selected' : '' }}>
                            November
                        </option>
                        <option value="12"
                            {{ request('month') == '12' ? 'selected' : '' }}>
                            Desember
                        </option>
                    </select>
                </div>

                {{-- Filter Tahun --}}
                <div class="col-md-3">
                    <label for="year">Tahun</label>
                    <select name="year"
                        id="year"
                        class="form-control">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                        <option value="{{ $year }}"
                            {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol --}}
                <div class="col-md-6 d-flex align-items-end">
                    <button type="submit"
                        class="btn btn-primary mr-2">
                        <i class="fas fa-filter"></i>
                        Tampilkan
                    </button>

                    <a href="{{ route('admin.daily-reports.index') }}"
                        class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i>
                        Reset
                    </a>
                </div>
            </div>
        </form>

        {{-- Tabel --}}
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