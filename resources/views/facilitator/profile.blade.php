@extends('adminlte::page')

@section('title', 'Profile Fasilitator')

@section('content_header')
    <h1>Profile Fasilitator</h1>
@stop

@section('content')

<div class="row">

    {{-- KARTU PROFIL --}}
    <div class="col-md-4">

        <div class="card card-primary card-outline">

            <div class="card-body box-profile">

                {{-- FOTO --}}
                <div class="text-center mb-3">
                    <img
                        class="profile-user-img img-fluid img-circle"
                        src="{{ asset('images/default-profile.png') }}"
                        alt="Profile"
                        style="width: 120px; height: 120px; object-fit: cover;"
                    >
                </div>

                {{-- NAMA --}}
                <h3 class="profile-username text-center">
                    {{ auth()->user()->name ?? 'Nama Fasilitator' }}
                </h3>

                <p class="text-muted text-center">
                    Fasilitator
                </p>

                <hr>

                <ul class="list-group list-group-unbordered mb-3">

                    <li class="list-group-item">
                        <b>ID User</b>
                        <span class="float-right">
                            {{ auth()->user()->id ?? 'u001' }}
                        </span>
                    </li>

                    <li class="list-group-item">
                        <b>Status</b>
                        <span class="float-right">
                            <span class="badge badge-success">
                                Aktif
                            </span>
                        </span>
                    </li>

                </ul>

                <a href="#"
                   class="btn btn-primary btn-block">
                    <i class="fas fa-edit mr-1"></i>
                    Edit Profile
                </a>

            </div>

        </div>

    </div>


    {{-- INFORMASI PROFILE --}}
    <div class="col-md-8">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user mr-2"></i>
                    Informasi Profile
                </h3>
            </div>

            <div class="card-body">

                {{-- NAMA --}}
                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        <i class="fas fa-user mr-2"></i>
                        Nama Lengkap
                    </div>

                    <div class="col-md-8">
                        {{ auth()->user()->name ?? '-' }}
                    </div>

                </div>

                <hr>

                {{-- USERNAME --}}
                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        <i class="fas fa-id-card mr-2"></i>
                        Username
                    </div>

                    <div class="col-md-8">
                        {{ auth()->user()->username ?? '-' }}
                    </div>

                </div>

                <hr>

                {{-- ROLE --}}
                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        <i class="fas fa-user-tag mr-2"></i>
                        Role
                    </div>

                    <div class="col-md-8">
                        Fasilitator
                    </div>

                </div>

                <hr>

                {{-- STATUS --}}
                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        <i class="fas fa-toggle-on mr-2"></i>
                        Status Akun
                    </div>

                    <div class="col-md-8">

                        <span class="badge badge-success">
                            Aktif
                        </span>

                    </div>

                </div>

                <hr>

                {{-- INFORMASI --}}
                <div class="row mb-3">

                    <div class="col-md-4 text-muted">
                        <i class="fas fa-info-circle mr-2"></i>
                        Keterangan
                    </div>

                    <div class="col-md-8">
                        Akun fasilitator Asteriia Kinderhaus.
                    </div>

                </div>

            </div>

        </div>


        {{-- KEAMANAN AKUN --}}
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Keamanan Akun
                </h3>
            </div>

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col-md-8">

                        <strong>Ganti Password</strong>

                        <p class="text-muted mb-0">
                            Ubah password akun Anda secara berkala
                            untuk menjaga keamanan akun.
                        </p>

                    </div>

                    <div class="col-md-4 text-right">

                        <a href="#"
                           class="btn btn-warning">

                            <i class="fas fa-key mr-1"></i>
                            Ubah Password

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@stop