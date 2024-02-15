@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Nama</td>
                                <td>{{ $siswa->nama }}</td>
                            </tr>
                            <tr>
                                <td>NIS</td>
                                <td>{{ $siswa->nis }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{{ $siswa->gender }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>{{ $siswa->kelas }}</td>
                            </tr>
                            <tr>
                                <td>Rombel</td>
                                <td>{{ $siswa->rombel }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset('storage/foto_siswa/'.$siswa->foto) }}" class="w-100 rounded">
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12  text-center">
                

                <a href="{{ route('siswa.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection