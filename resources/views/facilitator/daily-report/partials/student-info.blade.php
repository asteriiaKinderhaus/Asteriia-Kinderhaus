<div class="card card-primary">

    <div class="card-header">

        <h3 class="card-title">
            <i class="fas fa-child"></i>
            Informasi Anak
        </h3>

    </div>

    <div class="card-body">

        <div class="row">

            {{-- Tanggal --}}
            <div class="col-md-4">

                <div class="form-group">

                    <label for="report_date">
                        Tanggal Laporan
                    </label>

                    <input
                        type="date"
                        id="report_date"
                        name="report_date"
                        class="form-control"
                        value="{{ old('report_date', date('Y-m-d')) }}"
                        required>

                </div>

            </div>

            {{-- Kelas --}}
            <div class="col-md-4">

                <div class="form-group">

                    <label>Kelas</label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $class?->name }}"
                        readonly>

                    <input
                        type="hidden"
                        name="class_id"
                        value="{{ $class?->id }}">

                </div>

            </div>

            {{-- Fasilitator --}}
            <div class="col-md-4">

                <div class="form-group">

                    <label>Fasilitator</label>

                    <input
                        type="text"
                        class="form-control"
                        value="{{ $facilitator->name }}"
                        readonly>

                    <input
                        type="hidden"
                        name="facilitator_id"
                        value="{{ $facilitator->id }}">

                </div>

            </div>

        </div>

        <div class="row">

            {{-- Nama Anak --}}
            <div class="col-md-12">

                <div class="form-group">

                    <label for="student_id">
                        Nama Anak
                    </label>

                    <select
                        name="student_id"
                        id="student_id"
                        class="form-control"
                        required>

                        <option value="">
                            -- Pilih Anak --
                        </option>

                        @foreach($students as $student)

                        <option
                            value="{{ $student->id }}"
                            {{ old('student_id') == $student->id ? 'selected' : '' }}>

                            {{ $student->name }}

                        </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>

</div>