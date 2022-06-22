@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-5">
            <div class="card">
              <div class="card-body">
                <p>
                  <strong>Measurement Amount {{date('F')}}</strong>
                </p>
                @php
                    $arr = ['bg-primary', 'bg-info', 'bg-warning', 'bg-danger', 'bg-success'];
                    $no = 0;
                @endphp
                @foreach ($transaction as $item)
                @php
                    $sql = "SELECT COUNT(`sample_number`) AS `count` FROM `".$item->table_name."` WHERE MONTH(`date`) = '".date('m')."'";
                    $res = collect(DB::select($sql))->first();
                @endphp
                <div class="progress-group">
                  {{str_replace('_', ' ', ucwords($item->table_name))}}
                  <span class="float-right"><b>{{$res->count}}</b> Samples</span>
                  <div class="progress progress-sm">
                    <div class="progress-bar {{$arr[$no++]}}" style="width: 80%"></div>
                  </div>
                </div>
                @php
                    if($no == count($arr)) {
                      $no = 0;
                    }
                @endphp
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
