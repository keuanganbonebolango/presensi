@extends('layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Attendance</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Prensi</li>
                        <li class="breadcrumb-item active">Show</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12">
                    <!-- Attendance Chart -->
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-primary mb-2">Back</a>
                    @foreach ($attendance->presensidetail as $att)
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    Presensi Check-{{ $att->type }}
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table" id="datatable">
                                    <tbody>
                                        <tr>
                                            <th>Waktu</th>
                                            <td>{{ $att->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <td>{{ $attendance->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lat, Long</th>

                                            <td>{{ $att->lat }}, {{ $att->long }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $att->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>Lokasi</th>
                                            <td>
                                                <div style="width: 100%">
                                                    <iframe width="100%" height="300" frameborder="0" scrolling="no"
                                                        marginheight="0" marginwidth="0"
                                                        src="https://maps.google.com/maps?q={{ $att->lat }},{{ $att->long }}&hl=en&z=18&amp;output=embed">
                                                    </iframe>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Photo</th>
                                            <td><img width="350" src="{{ asset('storage/presensi/' . $att->photo) }}"
                                                    alt=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                    <!-- /.card -->
                </section>
                <!-- /.Left col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
