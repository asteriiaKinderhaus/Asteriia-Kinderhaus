```blade
@extends('adminlte::page')

@section('title', 'Pendaftaran Peserta Didik')

@section('content_header')
<h1>Pendaftaran Peserta Didik</h1>
@endsection

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Form Pendaftaran Peserta Didik dan Orang Tua
        </h3>
    </div>

    <form
        action="{{ route('admin.students.store') }}"
        method="POST"
        autocomplete="off">
        @csrf

        <div class="card-body">

            {{-- ===================================================== --}}
            {{-- PESERTA DIDIK --}}
            {{-- ===================================================== --}}

            <h5 class="mb-3">
                <i class="fas fa-child"></i>
                Data Peserta Didik
            </h5>

            <div class="row">
                {{-- Nama --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="student_name">
                            Nama Peserta Didik
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="student_name"
                            id="student_name"
                            class="form-control @error('student_name') is-invalid @enderror"
                            value="{{ old('student_name') }}"
                            maxlength="50"
                            required>

                        @error('student_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>


                {{-- Nama Panggilan --}}
                <div class="col-md-6">
                    <div class="form-group">

                        <label for="student_nickname">
                            Nama Panggilan
                        </label>

                        <input
                            type="text"
                            name="student_nickname"
                            id="student_nickname"
                            class="form-control @error('student_nickname') is-invalid @enderror"
                            value="{{ old('student_nickname') }}"
                            maxlength="30">

                        @error('student_nickname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>


                {{-- Tempat Lahir --}}
                <div class="col-md-6">
                    <div class="form-group">

                        <label for="student_birth_place">
                            Tempat Lahir
                        </label>

                        <input
                            type="text"
                            name="student_birth_place"
                            id="student_birth_place"
                            class="form-control @error('student_birth_place') is-invalid @enderror"
                            value="{{ old('student_birth_place') }}"
                            maxlength="50">

                        @error('student_birth_place')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>


                {{-- Tanggal Lahir --}}
                <div class="col-md-6">
                    <div class="form-group">

                        <label for="student_birth_date">
                            Tanggal Lahir
                        </label>

                        <input
                            type="date"
                            name="student_birth_date"
                            id="student_birth_date"
                            class="form-control @error('student_birth_date') is-invalid @enderror"
                            value="{{ old('student_birth_date') }}">

                        @error('student_birth_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>


                {{-- Jenis Kelamin --}}
                <div class="col-md-6">
                    <div class="form-group">

                        <label for="student_gender_id">
                            Jenis Kelamin
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="student_gender_id"
                            id="student_gender_id"
                            class="form-control @error('student_gender_id') is-invalid @enderror"
                            required>
                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            @foreach ($genders as $gender)
                            <option
                                value="{{ $gender->id }}"
                                @selected(old('student_gender_id')==$gender->id)
                                >
                                {{ $gender->gender }}
                            </option>
                            @endforeach

                        </select>

                        @error('student_gender_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>

            </div>


            <hr class="my-4">


            {{-- ===================================================== --}}
            {{-- ORANG TUA --}}
            {{-- ===================================================== --}}

            <h5 class="mb-3">
                <i class="fas fa-user-friends"></i>
                Data Orang Tua
            </h5>


            {{-- Parent ID --}}
            <input
                type="hidden"
                name="parent_id"
                id="parent_id"
                value="{{ old('parent_id') }}">


            <div class="row">

                {{-- ================================================= --}}
                {{-- Nama Orang Tua + AUTOCOMPLETE --}}
                {{-- ================================================= --}}

                <div class="col-md-12">

                    <div class="form-group position-relative">

                        <label for="parent_name">
                            Nama Orang Tua
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="parent_name"
                            id="parent_name"
                            class="form-control @error('parent_name') is-invalid @enderror"
                            value="{{ old('parent_name') }}"
                            maxlength="50"
                            placeholder="Ketik nama orang tua..."
                            autocomplete="off"
                            required>

                        @error('parent_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror


                        {{-- Hasil autocomplete --}}
                        <div
                            id="parent-suggestions"
                            class="list-group position-absolute w-100 shadow-sm"
                            style="
                                z-index: 1050;
                                display: none;
                                top: 100%;
                            "></div>

                    </div>

                </div>


                {{-- Status pencarian --}}
                <div class="col-md-12">

                    <div
                        id="parent-search-status"
                        class="small mb-3"></div>

                </div>


                {{-- ================================================= --}}
                {{-- Jenis Kelamin Orang Tua --}}
                {{-- ================================================= --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="parent_gender_id">
                            Jenis Kelamin
                            <span
                                id="parent-gender-required"
                                class="text-danger">*</span>
                        </label>

                        <select
                            name="parent_gender_id"
                            id="parent_gender_id"
                            class="form-control @error('parent_gender_id') is-invalid @enderror">
                            <option value="">
                                -- Pilih Jenis Kelamin --
                            </option>

                            @foreach ($genders as $gender)

                            <option
                                value="{{ $gender->id }}"
                                @selected(old('parent_gender_id')==$gender->id)
                                >
                                {{ $gender->gender }}
                            </option>

                            @endforeach

                        </select>

                        @error('parent_gender_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- Email --}}
                {{-- ================================================= --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="parent_email">
                            Email
                        </label>

                        <input
                            type="email"
                            name="parent_email"
                            id="parent_email"
                            class="form-control @error('parent_email') is-invalid @enderror"
                            value="{{ old('parent_email') }}"
                            maxlength="50"
                            placeholder="email@example.com">

                        @error('parent_email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- Telepon --}}
                {{-- ================================================= --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="parent_telephone">
                            Nomor Telepon
                        </label>

                        <input
                            type="text"
                            name="parent_telephone"
                            id="parent_telephone"
                            class="form-control @error('parent_telephone') is-invalid @enderror"
                            value="{{ old('parent_telephone') }}"
                            maxlength="20"
                            placeholder="08xxxxxxxxxx">

                        @error('parent_telephone')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- Alamat --}}
                {{-- ================================================= --}}

                <div class="col-md-6">

                    <div class="form-group">

                        <label for="parent_address">
                            Alamat
                        </label>

                        <textarea
                            name="parent_address"
                            id="parent_address"
                            rows="2"
                            maxlength="100"
                            class="form-control @error('parent_address') is-invalid @enderror"
                            placeholder="Alamat orang tua...">{{ old('parent_address') }}</textarea>

                        @error('parent_address')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- FOOTER --}}
        {{-- ========================================================= --}}

        <div class="card-footer">

            <button
                type="submit"
                class="btn btn-primary">
                <i class="fas fa-save"></i>
                Simpan Pendaftaran
            </button>

            <a
                href="{{ route('admin.students.index') }}"
                class="btn btn-secondary">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection

```blade
@section('js')

<script>

$(document).ready(function () {

    let searchTimer = null;


    /*
    |--------------------------------------------------------------------------
    | Elemen
    |--------------------------------------------------------------------------
    */

    const parentName        = $('#parent_name');
    const parentId          = $('#parent_id');
    const suggestions       = $('#parent-suggestions');
    const searchStatus      = $('#parent-search-status');

    const parentGender      = $('#parent_gender_id');
    const parentEmail       = $('#parent_email');
    const parentTelephone   = $('#parent_telephone');
    const parentAddress     = $('#parent_address');


    /*
    |--------------------------------------------------------------------------
    | Fungsi mengosongkan data orang tua
    |--------------------------------------------------------------------------
    */

    function clearParentData() {

        parentId.val('');

        parentGender.val('');
        parentEmail.val('');
        parentTelephone.val('');
        parentAddress.val('');

        parentGender.prop('readonly', false);
        parentEmail.prop('readonly', false);
        parentTelephone.prop('readonly', false);
        parentAddress.prop('readonly', false);

        searchStatus
            .removeClass('text-success text-info text-warning')
            .html('');

    }


    /*
    |--------------------------------------------------------------------------
    | Isi data orang tua dari hasil pencarian
    |--------------------------------------------------------------------------
    */

    function fillParentData(parent) {

        parentId.val(parent.id);

        parentName.val(parent.name);

        parentGender.val(parent.gender_id);
        parentEmail.val(parent.email ?? '');
        parentTelephone.val(parent.telephone ?? '');
        parentAddress.val(parent.address ?? '');


        /*
         * Data parent yang sudah ada dibuat readonly.
         * Karena kita hanya memilih parent yang sudah terdaftar.
         */

        parentGender.prop('readonly', true);
        parentEmail.prop('readonly', true);
        parentTelephone.prop('readonly', true);
        parentAddress.prop('readonly', true);


        searchStatus
            .removeClass('text-warning text-info')
            .addClass('text-success')
            .html(
                '<i class="fas fa-check-circle"></i> ' +
                'Orang tua sudah terdaftar.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Tampilkan hasil pencarian
    |--------------------------------------------------------------------------
    */

    function showSuggestions(parents) {

        suggestions.empty();


        if (!parents.length) {

            suggestions
                .hide();

            searchStatus
                .removeClass('text-success text-info')
                .addClass('text-warning')
                .html(
                    '<i class="fas fa-info-circle"></i> ' +
                    'Orang tua belum ditemukan. ' +
                    'Silakan lengkapi data di bawah.'
                );

            return;
        }


        parents.forEach(function (parent) {

            const item = $('<button>', {
                type: 'button',
                class: 'list-group-item list-group-item-action'
            });


            /*
             * Nama orang tua
             */

            const name = $('<strong>')
                .text(parent.name);


            /*
             * Informasi tambahan
             */

            const information = $('<small>')
                .addClass('d-block text-muted');


            let details = [];

            if (parent.telephone) {
                details.push(parent.telephone);
            }

            if (parent.email) {
                details.push(parent.email);
            }


            information.text(
                details.length
                    ? details.join(' • ')
                    : 'Data orang tua'
            );


            item.append(name);
            item.append(information);


            /*
             * Ketika hasil diklik
             */

            item.on('click', function () {

                fillParentData(parent);

                suggestions.hide();
            });


            suggestions.append(item);
        });


        suggestions.show();


        searchStatus
            .removeClass('text-success text-warning')
            .addClass('text-info')
            .html(
                '<i class="fas fa-search"></i> ' +
                'Pilih orang tua dari daftar jika sudah terdaftar.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Ketika mengetik nama orang tua
    |--------------------------------------------------------------------------
    */

    parentName.on('input', function () {

        const keyword = $(this).val().trim();


        /*
         * Jika user mengubah nama setelah sebelumnya
         * memilih parent, parent_id harus dihapus.
         */

        parentId.val('');


        /*
         * Data lama tidak boleh tetap dianggap sebagai
         * data parent yang dipilih.
         */

        parentGender.prop('readonly', false);
        parentEmail.prop('readonly', false);
        parentTelephone.prop('readonly', false);
        parentAddress.prop('readonly', false);


        /*
         * Jika kurang dari 2 karakter,
         * jangan melakukan AJAX.
         */

        if (keyword.length < 2) {

            suggestions
                .empty()
                .hide();

            searchStatus
                .removeClass(
                    'text-success text-info text-warning'
                )
                .html('');

            return;
        }


        /*
         * Debounce.
         *
         * AJAX tidak langsung dikirim setiap kali
         * user menekan tombol keyboard.
         */

        clearTimeout(searchTimer);


        searchTimer = setTimeout(function () {

            $.ajax({

                url: "{{ route('admin.parents.search') }}",

                type: "GET",

                data: {
                    q: keyword
                },

                dataType: "json",

                beforeSend: function () {

                    searchStatus
                        .removeClass(
                            'text-success text-warning'
                        )
                        .addClass('text-info')
                        .html(
                            '<i class="fas fa-spinner fa-spin"></i> ' +
                            'Mencari orang tua...'
                        );
                },

                success: function (parents) {

                    /*
                     * Pastikan hasil AJAX masih sesuai
                     * dengan teks yang sedang diketik.
                     */

                    if (
                        parentName.val().trim() !== keyword
                    ) {
                        return;
                    }

                    showSuggestions(parents);
                },

                error: function (xhr) {

                    console.error(
                        'Autocomplete parent error:',
                        xhr.responseText
                    );

                    suggestions
                        .empty()
                        .hide();

                    searchStatus
                        .removeClass(
                            'text-success text-info'
                        )
                        .addClass('text-warning')
                        .html(
                            '<i class="fas fa-exclamation-triangle"></i> ' +
                            'Gagal mencari data orang tua.'
                        );
                }

            });

        }, 300);

    });


    /*
    |--------------------------------------------------------------------------
    | Klik di luar autocomplete
    |--------------------------------------------------------------------------
    */

    $(document).on('click', function (event) {

        if (
            !$(event.target).closest('#parent_name').length &&
            !$(event.target).closest('#parent-suggestions').length
        ) {

            suggestions.hide();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Fokus ke input nama
    |--------------------------------------------------------------------------
    */

    parentName.on('focus', function () {

        const keyword = $(this).val().trim();

        if (keyword.length >= 2) {

            /*
             * Jika sudah ada hasil,
             * tampilkan kembali.
             */

            if (suggestions.children().length > 0) {
                suggestions.show();
            }
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Submit form
    |--------------------------------------------------------------------------
    |
    | Jika parent_id kosong:
    |   -> orang tua baru
    |
    | Jika parent_id ada:
    |   -> orang tua lama
    |
    */

    $('form').on('submit', function () {

        if (!parentId.val()) {

            searchStatus
                .removeClass('text-success text-info')
                .addClass('text-warning')
                .html(
                    '<i class="fas fa-user-plus"></i> ' +
                    'Orang tua baru akan didaftarkan.'
                );

        }

    });

});

</script>

@endsection

