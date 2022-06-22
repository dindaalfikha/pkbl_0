<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Histori Pembayaran</title>
</head>
<body>
    <table style="width:100%">
        <thead>
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

                $yearIt = $diffDate->y;
                $monthIt = $diffDate->m;
                ?>
            @for($j = 0; $j < ($yearIt + 1); $j++)
            <?php
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
                $ttl_pjk = 0;
                $jmlAngsuran = 0;
                $ttl_angsuran += $angsuran;
                if($i == 1) {
                    $pjk_adm =(($total / 100) * $loan->bunga) / 12;
                }

                $thisMonth = date('n', strtotime("+" . $i . " months", strtotime($start_angsuran)));
                // echo $thisMonth;
                $payment = DB::table('loan_payment_history')->whereRaw("MONTH(`tgl_bayar`) = ".$thisMonth." AND YEAR(`tgl_bayar`) = " . date('Y', strtotime("+" . $i . " month", strtotime($start_angsuran))))->get();
                if(!$payment->isEmpty()) {
                    foreach ($payment as $k => $dt) {
                        $totPayment += $dt->amount;
                    }
                    
                    if($sisaPinjaman != 0) {
                        $sisaPinjaman += $pjk_adm;
                    }

                    $totAngsuranPokok += $totPayment;
                    $totJasaAdmin += $pjk_adm + $sisaPinjaman;
                    $total -= $totPayment;
                    $totalSisaPinjaman -= $totPayment;
                    $jmlAngsuran += ($totPayment - $sisaPinjaman - $pjk_adm);
                } else if($j > 0) {
                    $sisaPinjaman += $pjk_adm;
                } else if($i > 1) {
                    $sisaPinjaman += $pjk_adm;
                }

                ?>
                <tr>
                    <td>{{date('m-Y', strtotime("+" . $i . " months", strtotime($start_angsuran)))}}</td>
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
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td><center>-</center></td>
                        <td>Rp. {{number_format($totalSisaPinjaman, 0, ',', '.')}}</td>
                        @if($sisaPinjaman == 0)
                            <td><center>-</center></td>
                        @else
                            <td>Rp. {{number_format($sisaPinjaman, 0, ',', '.')}}</td>
                        @endif
                        <?php $totalSisaPinjaman += $sisaPinjaman; ?>
                        <td>Rp. {{number_format($totalSisaPinjaman, 0, ',', '.')}}0</td>
                        <td></td>
                    @endif
                </tr>
                @endfor
                <tr>
                    <td></td>
                    <td><strong>Sub Jumlah</strong></td>
                    <td><strong>Rp. {{number_format($ttl_angsuran,0, ',', '.')}}</strong></td>
                    <td><strong>Rp. {{number_format($pjk_adm*12,0, ',', '.')}}</strong></td>
                    <td colspan="2"></td>
                    <td><strong>Rp. {{number_format($totAngsuranPokok - $totJasaAdmin, 0, ',', '.')}}</strong></td>
                    <td><strong>Rp. {{number_format($totJasaAdmin, 0, ',', '.')}}</strong></td>
                    <td><strong>Rp. {{number_format($totAngsuranPokok, 0, ',', '.')}}</strong></td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td colspan="13"></td>
                </tr>
            @endfor
        </tbody>
    </table>
</body>
</html>