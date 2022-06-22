@extends('master_unit')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{url('/')}}/admin/addLoan" method="POST" enctype="multipart/form-data" class="form-steps">
                    @csrf
                    <h3>Data Pinjaman</h3>
                    <section class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Pilih User</label>
                                <select name="user" id="pilih-user" class="custom-select">
                                    @foreach($user_list as $key => $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Proposal Diterima</label>
                                <input type="date" name="tgl_proposal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Pinjaman</label>
                                <input type="number" name="jumlah" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Aset</label>
                                <input type="number" class="form-control" name="asset">
                            </div>
                            <div class="form-group">
                                <label for="">Jumlah Omset</label>
                                <input type="number" class="form-control" name="omset">
                            </div>
                            <div class="form-group">
                                <label for="">Keterangan Pinjaman</label>
                                <textarea name="keterangan" id="" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                        </div>
                    </section>
                    <h3>Data Agunan</h3>
                    <section>
                        <div class="row" id="agunan-container">
                            <div class="col-md-12 mb-3">
                                <button class="btn btn-primary w-100" type="button" id="add-agunan">Tambah Agunan</button>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Data Agunan</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="">Nama Jaminan</label>
                                            <input type="text" class="form-control" name="nama_jaminan[]">
                                        </div>
            
                                        <div class="form-group">
                                            <label for="">Alamat Jaminan</label>
                                            <textarea name="alamat_jaminan[]" id="" cols="30" rows="10" class="form-control"></textarea>
                                        </div>
            
                                        <div class="form-group">
                                            <label>File Jaminan:</label>
                                            <input type="file" name="file_jaminan[]" class="form-input-styled" data-fouc>
                                            <span class="form-text text-muted">Accepted formats: pdf, jpg, png. Max file size 6Mb</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@stop