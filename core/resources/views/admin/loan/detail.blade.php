@extends('master')

@section('content')
    <div class="content">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            @if($state == 0)
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-monitor-tab" data-toggle="pill" href="#pills-monitor" role="tab" aria-controls="pills-monitor" aria-selected="true">Data Monitoring</a>
            </li>
            @endif
            <li class="nav-item" role="presentation">
                <a class="nav-link @if($state != 0) active @endif" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Data Pinjaman</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Data Survei</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">
                    @if($state == 2)
                    Approve Loan
                    @else
                    Data Kontrak
                    @endif
                </a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show @if($state != 0) active @endif" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

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
                                <td>Jenis Usaha</td>
                                <td>:</td>
                                <td>{{$peminjam->jenis_usaha}}</td>
                            </tr>
                            <tr>
                                <td>Sektor Usaha</td>
                                <td>:</td>
                                <td>{{$peminjam->sektor_usaha}}</td>
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
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>No</td>
                                <td>Nama Agunan</td>
                                <td>Alamat Agunan</td>
                                <td>File Agunan</td>
                            </tr>
                            <?php $agunan = explode(';', $loan->id_jaminan); ?>
                            @foreach ($agunan as $key => $item)    
                            <?php $data = DB::table('data_agunans')->whereId($item)->first(); ?>
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$data->nama}}</td>
                                <td>{{$data->alamat}}</td>
                                <td>
                                    <a target="_blank" href="{{url('/')}}/admin/agunan/{{$data->bukti}}" class=""><i class="fa fa-file mr-2"></i>Lihat Data Agunan</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            @if($state == 0)
            <div class="tab-pane fade show active" id="pills-monitor" role="tabpanel" aria-labelledby="pills-monitor-tab">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title font-weight-semibold">
                            Histori Pembayaran
                        </h6>
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a type="button" data-toggle="modal" data-target="#tambah-bayar" class="dropdown-item"><i class="fa fa-plus mr-2"></i> Tambah Pembayaran</a>
                                    <a href="{{url('/')}}/admin/print-loan/{{$loan->id}}" class="dropdown-item"><i class="fa fa-print mr-2"></i>Export Excel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th rowspan="2">Bulan</th>
                                        <th rowspan="2">Pinjaman Pokok</th>
                                        <th rowspan="2">Angsuran Pokok</th>
                                        <th colspan="3"><center>Beban Jasa Admin</center></th>
                                        <th colspan="3"><center>Angsuran</center></th>
                                        <th colspan="3"><center>Sisa Pinjaman</center></th>
                                        <th rowspan="2">Ket</th>
                                    </tr>
                                    <tr>
                                        <th><center>Bulan Ini</center></th>
                                        <th><center>Sisa Bln Lalu</center></th>
                                        <th><center>Jumlah</center></th>
                                        <th><center>Pokok</center></th>
                                        <th><center>Jasa Admin</center></th>
                                        <th><center>Jumlah</center></th>
                                        <th><center>Pokok</center></th>
                                        <th><center>Jasa Admin</center></th>
                                        <th><center>Akhir</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $total = 0; 
                                        $totalSisaPinjaman = 0;
                                        $month = 12;
                                        $angsuran = 0;
                                        $dateNow = new DateTime;
                                        $dateStart = new DateTime($loan->mulai_angsuran);
                                        
                                        $diffDate = $dateNow->diff($dateStart);
                                        $sisaPinjaman = 0;
                                        $resJasaAdmin = 0;

                                        $yearIt = $diffDate->y;
                                        $monthIt = $diffDate->m;
                                        ?>
                                    @for($j = 0; $j < ($yearIt + 1); $j++)
                                    <?php
                                        
                                        $ttl_pjk = 0;
                                        $totAngsuranPokok = 0;
                                        $totJasaAdmin = 0;

                                        if($j == 0) {
                                            $total = $loan->rls_penyaluran;
                                            $totalSisaPinjaman = $loan->rls_penyaluran;
                                            $angsuran = $total / 36;
                                        }

                                        $ttl_angsuran = 0;
                                        $pjk_adm = $loan->bunga;
                                        if($j == 0) {
                                            $start_angsuran = date('d-m-Y', strtotime($loan->mulai_angsuran));
                                        } else {
                                            $start_angsuran = date('d-m-Y', strtotime("+" . $j . " years", strtotime($loan->mulai_angsuran)));
                                        }

                                        if($yearIt > 0) {
                                            if($yearIt == $j) {
                                                $month = $monthIt;
                                            }
                                        } else {
                                            $month = $monthIt;
                                        }

                                        ?>

                                        <tr>
                                            <td colspan="13"><strong>Tahun ke - {{($j+1)}}</strong></td>
                                        </tr>
                                        @for($i = 1; $i <= $month; $i++)
                                        <?php

                                        $totPayment = 0;
                                        $jmlAngsuran = 0;
                                        $ttl_angsuran += $angsuran;
                                        $totJasaAdmin = 0;
                                        if($i == 1) {
                                            $pjk_adm =(($total / 100) * $loan->bunga) / 12;
                                        }
                                        $ttl_pjk += $pjk_adm;

                                        $thisMonth = date('n', strtotime("+" . $i . " months", strtotime($start_angsuran)));
                                        // echo $thisMonth;
                                        // DB::connection()->enableQueryLog();
                                        $payment = DB::table('loan_payment_history')->whereRaw("MONTH(`tgl_bayar`) = ".$thisMonth." AND YEAR(`tgl_bayar`) = " . date('Y', strtotime("+" . $i . " month", strtotime($start_angsuran))))->get();
                                        // echo "MONTH(`tgl_bayar`) = ".$thisMonth." AND YEAR(`tgl_bayar`) = " . date('Y', strtotime("+" . $i . " month", strtotime($start_angsuran)));
                                        // $queries = DB::getQueryLog();
                                        // print_r($queries);
                                        if(!$payment->isEmpty()) {
                                            foreach ($payment as $k => $dt) {
                                                $totPayment += $dt->amount;
                                            }
                                            
                                            // if($sisaPinjaman != 0) {
                                            //     $sisaPinjaman += $pjk_adm;
                                            // }

                                            $resJasaAdmin += $pjk_adm + $sisaPinjaman;
                                            $totJasaAdmin += $pjk_adm + $sisaPinjaman;
                                            $total -= $totPayment;
                                            $totalSisaPinjaman += $totJasaAdmin - $totPayment;
                                            $jmlAngsuran += ($totPayment - $sisaPinjaman - $pjk_adm);
                                            $totAngsuranPokok += $totPayment - $sisaPinjaman - $pjk_adm;

                                        }

                                        ?>
                                        <tr>
                                            <td>{{date('m/Y', strtotime("+" . $i . " months", strtotime($start_angsuran)))}}</td>
                                            <td>Rp. {{number_format($total, 0, ',', '.')}}</td>
                                            <td>Rp. {{number_format($angsuran, 0, ',', '.')}}</td>
                                            <td>Rp. {{number_format($pjk_adm, 0, ',', '.')}}</td>
                                            
                                            @if($sisaPinjaman != 0)
                                                <td>Rp. {{number_format($sisaPinjaman, 0, ',', '.')}}</td>
                                            @else
                                                <td><center>-</center></td>
                                            @endif

                                            <td>Rp. {{number_format(($pjk_adm + $sisaPinjaman), 0, ',', '.')}}</td>
                                            
                                            @if(!$payment->isEmpty())
                                                <td>Rp. {{number_format($jmlAngsuran, 0, ',', '.')}}</td>
                                                <td>Rp. {{number_format(($pjk_adm + $sisaPinjaman), 0, ',', '.')}}</td>
                                                <td>Rp. {{number_format($totPayment, 0, ',', '.')}}</td>
                                                <?php $sisaPinjaman = 0; ?>
                                                <td>Rp. {{number_format($totalSisaPinjaman, 0, ',', '.')}}</td>
                                                <td><center>-</center></td>
                                                <td>Rp. {{number_format($totalSisaPinjaman, 0, ',', '.')}}</td>
                                                <td></td>
                                            @else
                                            <?php $sisaPinjaman += $pjk_adm; ?>
                                                <td><center>-</center></td>
                                                <td><center>-</center></td>
                                                <td><center>-</center></td>
                                                <td>Rp. {{number_format($totalSisaPinjaman, 0, ',', '.')}}</td>
                                                <td>Rp. {{number_format($sisaPinjaman, 0, ',', '.')}}</td>
                                                <td>Rp. {{number_format(($totalSisaPinjaman + $sisaPinjaman), 0, ',', '.')}}</td>
                                                <td></td>
                                            @endif
                                        </tr>
                                        @endfor
                                        <tr>
                                            <td></td>
                                            <td><strong>Sub Jumlah</strong></td>
                                            <td><strong>Rp. {{number_format($ttl_angsuran,0, ',', '.')}}</strong></td>
                                            <td><strong>Rp. {{number_format($ttl_pjk,0, ',', '.')}}</strong></td>
                                            <td colspan="2"></td>
                                            <td><strong>Rp. {{number_format($totAngsuranPokok, 0, ',', '.')}}</strong></td>
                                            <td><strong>Rp. {{number_format($resJasaAdmin, 0, ',', '.')}}</strong></td>
                                            <td><strong>Rp. {{number_format($totAngsuranPokok + $resJasaAdmin, 0, ',', '.')}}</strong></td>
                                            <td colspan="4"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="13"></td>
                                        </tr>
                                        @if($j == $yearIt)
                                        <div id="sisa_bayar_value" style="display:none">{{$totalSisaPinjaman + $sisaPinjaman + $pjk_adm}}</div>
                                        @endif
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <!-- <div class="table-responsive">
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
                        </div> -->
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
                            <form action="{{url('/')}}/admin/payloan/{{$loan->id}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Jumlah</label>
                                        <input type="text" name="jumlah" class="form-control">
                                        <input type="hidden" name="sisa_bayar" id="sisa_bayar">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tanggal Bayar</label>
                                        <input type="date" name="tgl_bayar" class="form-control">
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
            </div>
            @endif
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                @if(!empty($survey))
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title font-weight-semibold">
                            Data Hasil Survei
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Tanggal Survei</td>
                                    <td>:</td>
                                    <td>{{$survey->tgl_survei}}</td>
                                </tr>
                                <?php $petugas = explode(';', $survey->nama) ?>
                                @foreach($petugas as $key => $value)
                                <tr>
                                    <td>Petugas {{$key+1}}</td>
                                    <td>:</td>
                                    <td>
                                        {{$value}}
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>Jumlah Permohonan Peminjam</td>
                                    <td>:</td>
                                    <td>Rp. {{number_format($loan->amount)}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title font-weight-semibold">
                                    Keterangan Survei
                                </h6>
                            </div>
                            <div class="card-body">
                                <form action="{{url('/')}}/admin/ket-survey/{{$survey->id}}" method="post">
                                    @csrf
                                    <textarea type="text" name="keterangan" class="tinymce form-control">{{$loan->details}}</textarea>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if($loan->status != 3)
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title font-weight-semibold">
                                    Tambah Dokumentasi
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- <button type="button" id="upload-image" class="btn btn-primary w-100 btn-sm"><i class="fa fa-upload"></i> upload</button> -->
                                <form action="" class="dropzone" id="myDropzone" enctype="multipart/form-data">
                                    @csrf
                                    <div class="fallback">
                                        <input name="file" type="file" multiple/>
                                    </div>
                                </form>
        
                                <!-- <form action="{{url('/')}}/admin/survey-image/{{$survey->id}}" method='post'>
                                    @csrf
                                    
                                </form> -->
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div @if($survey_dokumentasi->isEmpty()) {{'style="display:none"'}} @endif>
                    <h6 class="font-weight-semibold">Dokumentasi</h6>
                    <div class="row">
                        @foreach($survey_dokumentasi as $key => $value)
                        <div class="col-md-3">
                            <img src="{{url('/')}}/asset/survei/{{$value->gambar}}" alt="" class="img-thumbnail">
                        </div>
                        @endforeach
                    </div>
                </div>
        
                @else
                <div class="card">
                    <div class="card-body">
                        <h3>Data Survei Tidak Ada</h3>
                    </div>
                </div>
                @endif
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                @if($state == 2)
                    <form action="{{url('/')}}/admin/loan-approve/{{$loan->id}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Jumlah Permohonan Pinjaman</label>
                                            <input type="number" name="jml_pinjaman" value="{{$loan->amount}}" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <label for="">Bunga Pinjaman</label>
                                            <input type="number" value="3" name="bunga_pinjaman" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Nomor Memo</label>
                                            <input type="text" name="no_memo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" name="tgl_memo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Nomor Persetujuan</label>
                                            <input type="text" name="no_persetujuan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" name="tgl_persetujuan" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="">Nomor Kontrak</label>
                                            <input type="text" name="no_kontrak" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" name="tgl_kontrak" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Usulan Jumlah Peminjaman</label>
                                            <input type="number" value="{{$loan->rcn_penyaluran}}" name="rencana_peyaluran" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Realisasi Penyaluran</label>
                                            <input type="number" name="realisasi_peyaluran" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Mulai Masa Angsuran</label>
                                            <input type="date" name="tgl_mulai_angsuran" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Masa Angsuran Berakhir</label>
                                            <input type="date" name="tgl_berakhir_angsuran" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Setujui Pinjaman</button>
                    </form>
                @else
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Nomor Memo</td>
                                    <td>:</td>
                                    <td>{{$loan->memo}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Memo</td>
                                    <td>:</td>
                                    <td>{{$loan->tgl_memo}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Persetujuan</td>
                                    <td>:</td>
                                    <td>{{$loan->persetujuan}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Persetujuan</td>
                                    <td>:</td>
                                    <td>{{$loan->tgl_persetujuan}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Kontrak</td>
                                    <td>:</td>
                                    <td>{{$loan->kontrak}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Kontrak</td>
                                    <td>:</td>
                                    <td>{{$loan->tgl_kontrak}}</td>
                                </tr>
                                <tr>
                                    <td>Rencana Penyaluran</td>
                                    <td>:</td>
                                    <td>{{'Rp. ' . number_format($loan->rcn_penyaluran, 2, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Realisasi Penyaluran</td>
                                    <td>:</td>
                                    <td>{{'Rp. ' . number_format($loan->rls_penyaluran, 2, ',', '.')}}</td>
                                </tr>
                                <tr>
                                    <td>Bunga</td>
                                    <td>:</td>
                                    <td>{{$loan->bunga . '%'}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        
    </div>
@stop