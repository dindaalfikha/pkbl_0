<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            width: 100%;
        }

        td {
            width: 100%;
            text-wrap: true;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td rowspan="2">No Urut</td>
                <td rowspan="2">Nama Mitra Binaan</td>
                <td rowspan="2">Unit / Kandir</td>
                <td colspan="3" align="center">Identitas Diri</td>
                <td colspan="3" align="center">Alamat</td>
                <td rowspan="2">Nama Kelompok</td>
                <td rowspan="2">Jumlah Anggota</td>
                <td rowspan="2">Nama Usaha</td>
                <td rowspan="2">Jenis Usaha</td>
                <td rowspan="2">Sektor Usaha</td>
                <td rowspan="2">Jaminan</td>
                <td rowspan="2">Alamat Jaminan</td>
                <td colspan="2">Jumlah</td>
                <td rowspan="2">Jumlah Aset</td>
                <td rowspan="2">Jumlah Omset</td>
                <td rowspan="2">Proposal Diterima</td>
                <td rowspan="2">Survey UU/Kandir</td>
                <td rowspan="2">Petugas Survey</td>
                <td colspan="2">Memo</td>
                <td colspan="2">Persetujuan</td>
                <td colspan="2">Kontrak</td>
                <td colspan="2">Penyaluran</td>
                <td colspan="2">Masa Angsuran</td>
            </tr>
            <tr>
                <td>No. KTP</td>
                <td>Tgl. Lahir</td>
                <td>No. Telp</td>
                <td>(Rt/Rw, Dsn, Desa/Kel, Kec)</td>
                <td>Kota/Kabupaten</td>
                <td>Provinsi</td>
                <td>Permohonan</td>
                <td>Disetujui</td>
                <td>No.</td>
                <td>Tanggal</td>
                <td>No.</td>
                <td>Tanggal</td>
                <td>No.</td>
                <td>Tanggal</td>
                <td>Rencana</td>
                <td>Realisasi</td>
                <td>Mulai</td>
                <td>Akhir</td>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0; ?>
            @foreach ($loan as $item)    
            <tr>
                <td>{{++$no}}</td>
                <td>{{$item->name}}</td>
                <td>{{$unit[$item->unit]}}</td>
                <td>{{$item->no_ktp}}</td>
                <td>{{date('d/m/y', strtotime($item->tgl_lahir))}}</td>
                <td>{{$item->phone}}</td>
                <td>{{$item->address}}</td>
                <?php 
                $city = DB::table('wilayah_2020')->where(['kode' => $item->city])->first();
                $province = DB::table('wilayah_2020')->where(['kode' => $item->province])->first();
                $id_agunan = explode(';', $item->id_jaminan);
                ?>
                <td>{{$city->nama}}</td>
                <td>{{$province->nama}}</td>
                <td>{{$item->nama_kelompok}}</td>
                <td>{{$item->jumlah_anggota}}</td>
                <td>{{$item->nama_usaha}}</td>
                <td>{{$jenis_usaha[$item->jenis_usaha]}}</td>
                <td>{{$sektor_usaha[$item->sektor_usaha]}}</td>
                <td>
                    <?php $alamat_agunan = []; ?>
                    @foreach ($id_agunan as $id)
                        <?php 
                        $agunan = DB::table('data_agunans')->where(['id' => $id])->first();
                        $alamat_agunan[] = $agunan->alamat;
                        ?>
                        {{$agunan->nama . ','}}
                    @endforeach
                </td>
                <td>
                    @foreach ($alamat_agunan as $alamat)
                        {{$alamat . ' | '}}
                    @endforeach
                </td>
                <td>{{number_format($item->amount, 0,',', '.')}}</td>
                <td>{{number_format($item->rls_penyaluran, 0,',', '.')}}</td>
                <td>{{number_format($item->jml_aset, 0,',', '.')}}</td>
                <td>{{number_format($item->jml_omset, 0,',', '.')}}</td>
                <td>{{date('d/m/Y', strtotime($item->tgl_diterima))}}</td>
                <?php $survey = DB::table('surveys')->where(['id_loan' => $item->id])->get(); ?>
                <td>
                    @foreach ($survey as $s)
                        {{date('d/m/Y', strtotime($s->tgl_survei))}} <br>
                    @endforeach
                </td>
                <td>
                    @foreach ($survey as $s)
                        {{$s->nama}} <br>
                    @endforeach
                </td>
                <td>{{$item->memo}}</td>
                <td>{{date('d/m/y', strtotime($item->tgl_memo))}}</td>
                <td>{{$item->persetujuan}}</td>
                <td>{{date('d/m/y', strtotime($item->tgl_persetujuan))}}</td>
                <td>{{$item->kontrak}}</td>
                <td>{{date('d/m/y', strtotime($item->tgl_kontrak))}}</td>
                <td>{{$item->rcn_penyaluran}}</td>
                <td>{{$item->rls_penyaluran}}</td>
                <td>{{date('d/m/Y', strtotime($item->mulai_angsuran))}}</td>
                <td>{{date('d/m/Y', strtotime($item->berakhir_angsuran))}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>