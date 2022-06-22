@extends('master')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title font-weight-semibold">
                    Data Survei
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td>Tanggal Survei:</td>
                            <td>{{$survey->tgl_survei}}</td>
                        </tr>
                        <?php $petugas = explode(';', $survey->nama) ?>
                        @foreach($petugas as $key => $value)
                        <tr>
                            <td>Petugas {{$key+1}}:</td>
                            <td>
                                {{$value}}
                            </td>
                        </tr>
                        @endforeach
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
                            <div class="form-group">
                                <textarea name="keterangan" id="summernote" rows="8" class="form-control">{{$survey->keterangan}}</textarea>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-success"><i class="fa fa-send"></i> update</button>
                            </div>
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
                @foreach($dokumentasi as $key => $value)
                <div class="col-md-3">
                    <img src="{{url('/')}}/asset/survei/{{$value->gambar}}" alt="" class="img-thumbnail">
                </div>
                @endforeach
            </div>
        </div>

    </div>
@stop