@extends('master_unit')

@section('content')
    <div class="content">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Data Pinjaman</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Data Survei</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @if($state == 0)
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title font-weight-semibold">
                            Histori Pembayaran
                        </h6>
                        <button type="button" data-toggle="modal" data-target="#tambah-bayar" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Pembayaran</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table datatable-show-all">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jumlah</th>
                                        <th>Sisa Pembayaran</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Bukti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = ( $loan->amount + ( $loan->amount * $loan->bunga / 100 )); ?>
                                    @foreach($pay_loan as $key => $val)
                                    <?php $total -= $val->amount ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{'Rp. ' . number_format($val->amount, 2, ',', '.')}}</td>
                                        <td>{{'Rp. ' . number_format($total, 2, ',', '.')}}</td>
                                        <td>{{date('Y-m-d H:i:s', strtotime($val->created_at))}}</td>
                                        <td>{{date('Y-m-d H:i:s', strtotime($val->updated_at))}}</td>
                                        <td></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal" tabindex="-1" id="tambah-bayar">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Pembayaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{url('/')}}/admin-unit/payloan/{{$loan->id}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Jumlah</label>
                                        <input type="text" name="jumlah" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label>File Bukti</label>
                                        <input type="file" name="file_bukti" class="form-input-styled" data-fouc>
                                        <span class="form-text text-muted">Accepted formats: pdf, jpg, png. Max file size 6Mb</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title font-weight-semibold">
                            Data Peminjam
                        </h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>{{$peminjam->name}}</td>
                            </tr>
                            <tr>
                                <td>Kontak</td>
                                <td>:</td>
                                <td>{{$peminjam->phone}}</td>
                            </tr>
                            <tr>
                                <td>Kelompok Usaha</td>
                                <td>:</td>
                                <td>{{$loan->nama_kelompok}} ( {{$loan->jumlah_anggota}} Anggota )</td>
                            </tr>
                            <tr>
                                <td>Nama Usaha</td>
                                <td>:</td>
                                <td>{{$peminjam->nama_usaha}}</td>
                            </tr>
                            <tr>
                                <td>Jenis Usaha</td>
                                <td>:</td>
                                <td>{{$peminjam->jenis}}</td>
                            </tr>
                            <tr>
                                <td>Sektor Usaha</td>
                                <td>:</td>
                                <td>{{$peminjam->usaha}}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Aset</td>
                                <td>:</td>
                                <td><?= 'Rp. ' . number_format($loan->jml_aset, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Jumlah Omset</td>
                                <td>:</td>
                                <td><?= 'Rp. ' . number_format($loan->jml_omset, 0, ',', '.') ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title font-weight-semibold">Data Pinjaman</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Jumlah Permohonan</td>
                                <td>: <?= 'Rp. ' . number_format($loan->amount, 0, ',', '.') ?></td>
                            </tr>
                            @if($state != 2)
                            <tr>
                                <td>Jumlah Terbayar</td>
                                <td>: <?= 'Rp. ' . number_format($loan_payed->total, 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Sisa Pinjaman</td>
                                <td>: <?= 'Rp. ' . number_format(($loan->amount + ($loan->amount * $loan->bunga / 100) - $loan_payed->total), 0, ',', '.') ?></td>
                            </tr>
                            @endif
                            <tr>
                                <td>Keterangan</td>
                                <td>: {{$loan->details}}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>No</td>
                                <td>Nama Agunan</td>
                                <td>Alamat Agunan</td>
                                <td>File Agunan</td>
                            </tr>
                            <?php $no = 0; $agunan = explode(';', $loan->id_jaminan); ?>
                            @foreach ($agunan as $key => $item)    
                            <?php $data = DB::table('data_agunans')->whereId($item)->first(); ?>
                            <tr>
                                <td>{{++$no}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->alamat}}</td>
                                <td>
                                    <a target="_blank" href="{{url('/')}}/admin-unit/agunan/{{$data->bukti}}" class=""><i class="fa fa-file mr-2"></i>Lihat Data Agunan</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @if($survei->isEmpty())
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title font-weight-semibold">Data Survei</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{url('/')}}/admin-unit/add-survey/{{$loan->id}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Tanggal Survei</label>
                                <input type="date" class="form-control" name="tgl_survei">
                            </div>
                            <div class="row" id="petugas-survei-container">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nama Petugas</label>
                                        <input type="text" name="nama_petugas[]" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-sm mb-3" id="tambahPetugas" type="button"><i class="fa fa-plus"></i> Tambah Petugas</button>
                            <hr>
                            <button class="btn btn-success w-100" type="submit">Tambah</button>
                        </form>
                    </div>
                </div>        
                @else
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl Survei</th>
                                    <th>Status</th>
                                    <th>Petugas Survei</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
    
                                $days = [
                                    date('D', strtotime('Mon')) => 'Senin',
                                    date('D', strtotime('Tue')) => 'Selasa',
                                    date('D', strtotime('Wed')) => 'Rabu',
                                    date('D', strtotime('Thu')) => 'Kamis',
                                    date('D', strtotime('Fri')) => 'Jum\'at',
                                    date('D', strtotime('Sat')) => 'Sabtu',
                                    date('D', strtotime('Sun')) => 'Minggu'
                                ];
    
                                $month = [
                                    'Jan' => 'Januari',
                                    'Feb' => 'Februari',
                                    'Mar' => 'Maret',
                                    'Apr' => 'April',
                                    'May' => 'Mei',
                                    'Jun' => 'Juni',
                                    'Jul' => 'Juli',
                                    'Aug' => 'Agustus',
                                    'Sep' => 'September',
                                    'Oct' => 'Oktober',
                                    'Nov' => 'November',
                                    'Dec' => 'Desember'
                                ];
    
                                ?>
                                @foreach ($survei as $k => $item)    
                                <tr>
                                    <td>{{++$k}}</td>
                                    <td>{{$days[date('D', strtotime($item->tgl_survei))] . ', ' . date('d', strtotime($item->tgl_survei)) . ' ' . $month[date('M', strtotime($item->tgl_survei))] . ' ' . date('Y', strtotime($item->tgl_survei))}}</td>
                                    <td>
                                        @if($item->status == 1)
                                        <span class="badge badge-success">Sudah Terlaksana</span>
                                        @elseif($item->status == 0)
                                            @if($item->tgl_survei > date('Y-m-d H:i:s'))
                                            <span class="badge badge-warning">Belum Terlaksana</span>
                                            @else
                                            <span class="badge badge-primary">Sedang Berjalan</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <ul>
                                            <?php $pegawai = explode(';', $item->nama); ?>
                                            @foreach ($pegawai as $k => $val)
                                            <li>{{$val}}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{$days[date('D', strtotime($item->created_at))] . ', ' . date('d', strtotime($item->created_at)) . ' ' . $month[date('M', strtotime($item->created_at))] . ' ' . date('Y', strtotime($item->created_at))}}</td>
                                    <td>{{$days[date('D', strtotime($item->updated_at))] . ', ' . date('d', strtotime($item->updated_at)) . ' ' . $month[date('M', strtotime($item->updated_at))] . ' ' . date('Y', strtotime($item->updated_at))}}</td>
                                    <td>
                                        <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="icon-menu9"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{url('/')}}/admin-unit/approve-survey/{{$item->id}}" class="dropdown-item"><i class="fa fa-check mr-2"></i> Done</a>
                                                    <a data-toggle="modal" data-target="#{{$item->id}}delete" class="dropdown-item"><i class="icon-bin2 mr-2"></i>Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <div id="{{$item->id}}delete" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">   
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="font-weight-semibold">Are you sure you want to delete this?</h6>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                <a  href="{{url('/')}}/admin-unit/loan/delete/{{$item->id}}" class="btn bg-danger">Proceed</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

        
    </div>
@stop