@extends('layouts.app')

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
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-default btn-sm float-right" data-toggle="modal" data-target="#modal-default">
                    <i class="fa fa-plus"></i> Add Value
                </button>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Add Value</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{route('add.master.csv.process')}}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Table Column Name</label>
                                    <input type="text" name="col_table_name" class="form-control">
                                </div>
                              <div class="form-group">
                                  <label for="">CSV Column Name</label>
                                  <input type="text" name="col_csv_name" class="form-control">
                              </div>
                              <div class="form-group">
                                <label for="">CSV Column Index</label>
                                <input type="text" name="col_csv_index" class="form-control">
                            </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                <h1 class="card-title mb-4">CSV Master</h1>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <td width="10%">No</td>
                                <td>Column Table Name</td>
                                <td>Column CSV Name</td>
                                <td>Column CSV Index</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($csv as $item)    
                            <tr>
                                <td>{{++$no}}</td>
                                <td>{{$item->col_table_name}}</td>
                                <td>{{$item->col_csv_name}}</td>
                                <td>{{$item->col_csv_index}}</td>
                                <td></td>
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
