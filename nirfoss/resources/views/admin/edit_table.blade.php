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
              <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{route('admin.master.csv.table')}}">Master Table to CSV</a></li>
              <li class="breadcrumb-item active">Add Table</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" id="add_field" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus"></i> Add Field</button>
                <h1 class="card-title">CSV to DB Master</h1>
            </div>
            <div class="card-body">
                <form action="{{route('admin.edit.table.process')}}" method="post">
                    @csrf
                    <input type="hidden" name="id_table" value="{{$table_detail->id_table}}">
                    <div class="form-group">
                        <label for="table_name">Table Name</label>
                        <input type="text" name="table_name" id="table_name" value="{{$table_detail->table_name}}" class="form-control">
                          @php
                              $unitSelected = explode(',', $table_detail->unit);
                          @endphp
                    </div>
                    <div class="form-group">
                      <label for="">Unit</label>
                      <div class="select2-purple">
                        <select class="select2" multiple="multiple" data-placeholder="Pilih Unit" name="unit[]" data-dropdown-css-class="select2-purple" style="width: 100%;">
                            @foreach ($unit as $item)
                            <option value="{{$item->nama_unit}}">{{$item->nama_unit}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div id="field-container">
                      @foreach ($col as $item)
                      <input type="hidden" name="id_csv[]" value="{{$item->id_csv}}">
                      <input type="hidden" name="id_norma[]" value="{{$item->id_norma}}">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="col_table_name">Column Table Name</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <button type="button" class="btn btn-danger delete">
                                  <i class="fa fa-minus"></i>
                                </button>
                              </div>
                              <input type="text" name="col_table_name[]" readonly value="{{$item->table_col_name}}" class="form-control">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="col_csv_name">Column CSV Name</label>
                            <input type="text" name="col_csv_name[]" value="{{$item->csv_col_name}}" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label for="col_csv_index">Column CSV Index</label>
                            <input type="text" name="col_csv_index[]" value="{{$item->csv_col_index}}" class="form-control">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <label for="col_csv_index">Nilai Norma</label>
                          <input type="text" name="norma_value[]" value="{{$item->jml_norma}}" class="form-control">
                        </div>
                        <div class="col-md-2">
                          <label for="col_csv_index">Use Warning</label>
                          <select class="custom-select" name="use_warning[]">
                            <option value="1" @if($item->use_warning == 1){{"selected"}}@endif>Yes</option>
                            <option value="0" @if($item->use_warning == 0){{"selected"}}@endif>No</option>
                          </select>
                        </div>
                      </div>
                      @endforeach
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
                </form>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection
