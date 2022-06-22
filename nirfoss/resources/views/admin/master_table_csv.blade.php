@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Master CSV to Table</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Master CSV to Table</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <a href="{{route('admin.add.table')}}" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add Table</a>
                <h1 class="card-title">Master CSV to Table</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td width="10%">No</td>
                                <td>Table Name</td>
                                <td>Column</td>
                                <td>Unit</td>
                                <td width="10%"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($csv as $item)    
                            <tr>
                                <td>{{++$no}}</td>
                                <td>{{$item->table_name}}</td>
                                <td>
                                    @php
                                        $data = DB::table('csv_db_associate')->select('csv_col_name')->where(['id_table' => $item->id_table])->get();
                                    @endphp
                                    @foreach ($data as $items)
                                        {{$items->csv_col_name . ", "}}
                                    @endforeach
                                </td>
                                <td>{{$item->unit}}</td>
                                <td>
                                  <a href="{{route('admin.edit.table', $item->id_table)}}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                                  <a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </td>
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
