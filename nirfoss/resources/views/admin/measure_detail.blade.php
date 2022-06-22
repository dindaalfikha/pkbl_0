@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Measure Data</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Measure Data</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
              <button class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal-default"><i class="fa fa-filter"></i> Advanced Filter</button>
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Sort &amp; Filter</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="" method="get">
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="">Date Time Range</label>
                            <div class="row">
                              <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control">
                              </div>
                              <div class="col-md-2">
                                <input type="time" name="start_time" class="form-control">
                              </div>
                              <div class="col-md-2">
                                <p class="text-center"><hr></p>
                              </div>
                              <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control">
                              </div>
                              <div class="col-md-2">
                                <input type="time" name="end_time" class="form-control">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="unit">Unit</label>
                                <select name="unit" id="unit" class="custom-select">
                                  <option value="all" selected>All Data</option>
                                  @foreach ($unit as $item)
                                  <option value="{{$item->nama_unit}}">{{$item->nama_unit}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label for="">Sample Number Contains</label>
                                <input type="text" name="sample_number" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-success">Apply Filter</button>
                        </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
              <h1 class="card-title">Measure Data {{ucwords(str_replace('_', ' ', $table_name->table_name))}}</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table">
                        <thead>
                            <tr>
                                <td width="7%">No</td>
                                <td>Sample Number</td>
                                @foreach ($col as $datas)
                                <td>{{$datas->csv_col_name}}</td>
                                <td>N</td>
                                @endforeach
                                <td>Tanggal / Waktu</td>
                                <td>Unit</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                                $data = (array) $data;
                            @endphp
                            @foreach ($data as $item)    
                            @php
                                $tmp = (array) $item;
                            @endphp
                            <tr>
                                <td>{{++$no}}</td>
                                <td>{{$tmp['sample_number']}}</td>
                                @php
                                    $unitName = explode(' ', $tmp['unit']);
                                    $unitName = array_pop($unitName);
                                    $sql = "SELECT * FROM `norma` LEFT JOIN `csv_db_associate` ON `norma`.`id_csv` = `csv_db_associate`.`id_csv`  WHERE `csv_db_associate`.`id_table` = '".$table_name->id_table."'";

                                    $dataNorma = DB::select($sql);
                                    $norma = [];
                                    foreach ($dataNorma as $keys => $values) {
                                      $norma[] = $values->jml_norma;
                                    }
                                @endphp
                                @foreach ($col as $key => $datas)
                                @php
                                    $bg = 'bg-';
                                    $unit = explode(' ', $tmp['unit']);
                                    $unit = array_pop($unit);
                                    if($datas->use_warning == 1) {
                                      if($tmp[$datas->table_col_name] > $norma[$key] && $norma[$key] != 0) {
                                        $bg .= 'danger';
                                      } else if($tmp[$datas->table_col_name] == $norma[$key] && $norma[$key] != 0) {
                                        $bg .= 'warning';
                                      } else if($norma[$key] != 0){
                                        $bg .= 'success';
                                      }
                                    }
                                @endphp
                                <td class="{{$bg}}">{{$tmp[$datas->table_col_name]}}</td>
                                <td>
                                  @if (empty($norma))
                                  {{0}}
                                  @else
                                  {{$norma[$key]}}
                                  @endif
                                </td>
                                @endforeach
                                <td>{{date('d/m/Y', strtotime($tmp['date'])) . ' Pukul ' . date('H:i', strtotime($tmp['time']))}}</td>
                                <td>{{$unit}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection