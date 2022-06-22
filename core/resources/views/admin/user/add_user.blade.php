@extends('master')

@section('content')

    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{url('admin/add-user')}}" enctype="multipart/form-data" method="post" class="form-steps">
                    @csrf
                    <h3>Data Pribadi</h3>
                    <section>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Email</label>
                            </div>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" name="email" required>
                                <span class="form-text text-muted">Email yang akan digunakan untuk login</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Password</label>
                            </div>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" name="password" required>
                                <span class="form-text text-muted">Password yang akan digunakan untuk login</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Nama</label>
                            </div>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Tanggal Lahir</label>
                            </div>
                            <div class="col-lg-10">
                                <input type="date" class="form-control" name="tgl_lahir" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Provinsi</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="provinsi" id="provinsiAdd" class="custom-select">
                                    <option selected disabled>Pilih Provinsi</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{$item->kode}}">{{$item->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Kota</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="kota" id="kotaAdd" class="custom-select" disabled>
                                    <option selected disabled>Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Alamat Rumah</label>
                            </div>
                            <div class="col-lg-10">
                                <textarea name="alamat" class="form-control" cols="30" rows="10" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-form-label col-lg-2">
                                <label>Nomor HP</label>
                            </div>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" name="nomor_hp" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nomor KTP</label>
                            <div class="col-lg-10">
                                <input type="number" maxlength="16" name="no_ktp" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Foto KTP :</label>
                            <div class="col-lg-10">
                                <input type="file" name="ktp" class="form-input-styled" data-fouc>
                                <span class="form-text text-muted">Accepted formats: jpg. Max file size 1Mb</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Apakah pernah menjadi mitra binaan PTPN VII?</label>
                            <div class="col-lg-10">
                                <input type="number" maxlength="16" name="mitra" class="form-control">
                                <span class="form-text text-muted">Jika Ya, ketikkan tahun nya</span>
                            </div>
                            <!-- <div class="form-group row">
                            <label class="col-form-label col-lg-2">Apakah ada hubungan kekerabatan dengan karyawan PTPN VII?</label>
                            <div class="col-lg-9">
                                <input type="text" id="hubungan" name="hubungan" class="form-control">
                                <span class="form-text text-muted">Jika Ada,sebutkan nama dan tempat bekerja</span>
                            </div> -->
                    </section>
        
                    <h3>Data Kelompok Usaha</h3>
                    <section class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Nama Kelompok</label>
                                <input type="text" class="form-control" name="nama_kelompok">
                            </div>
        
                            <div class="form-group">
                                <label for="">Jumlah Anggota</label>
                                <input type="number" class="form-control" name="jumlah_anggota">
                            </div>
                            
                            <div class="form-group">
                                <label for="nama_usaha">Nama Usaha</label>
                                <input type="text" id="nama_usaha" name="nama_usaha" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="alamat_usaha">Alamat Usaha</label>
                                <input type="text" id="nama_usaha" name="nama_usaha" class="form-control">
                            </div>
                            @if(!$jenis_usaha->isEmpty())
                            <div class="form-group" id="usaha_container">
                                <label for="">Jenis Usaha</label>
                                <select name="jenis_usaha" id="usaha" class="custom-select">
                                    <option selected disabled>Pilih Usaha</option>
                                    @foreach($jenis_usaha as $key => $value)
                                    <option value="{{$value->id}}">{{$value->nama}}</option>
                                    @endforeach
                                    <option value="0">Jenis Usaha Lain</option>
                                </select>
                            </div>
                            @endif
        
                            <div class="form-group" id="usaha_lain_container" @if(!$jenis_usaha->isEmpty()) style="display: none" @endif>
                                <label for="">Jenis Usaha</label>
                                <div class="input-group">
                                    @if(!$jenis_usaha->isEmpty())
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-danger" id="change-usaha" type="button"><i class="fa fa-close"></i></button>
                                    </div>
                                    @endif
                                    <input type="text" class="form-control" name="jenis_usaha" id="usaha_lain" placeholder="Masukan Jenis Usaha" @if(!$jenis_usaha->isEmpty()) disabled @endif>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Sektor Usaha</label>
                                <select name="sektor_usaha" id="" class="custom-select">
                                    @foreach($usaha as $key => $val)
                                    <option value="{{$val->id}}">{{$val->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- <div class="form-group">
                                <label for="">Jumlah Aset</label>
                                <input type="number" class="form-control" name="asset">
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Omset</label>
                                <input type="number" class="form-control" name="omset">
                            </div> -->
                            <div class="form-group">
                                <label for="">Wilayah / Unit</label>
                                <select name="unit" class="custom-select">
                                    <option selected disabled>Pilih Unit / Wilayah</option>
                                    @foreach($unit as $key => $val)
                                    <option value="{{$val->id}}">{{$val->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Foto Usaha :</label>
                                <input type="file" name="usaha" class="form-input-styled" data-fouc>
                                <span class="form-text text-muted">Accepted formats: jpg. Max file size 1Mb</span>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@stop