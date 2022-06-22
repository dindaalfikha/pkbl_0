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
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="table_name">Table Name</label>
                        <input type="text" name="table_name" id="table_name" class="form-control">
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
                        
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
                </form>
            </div>
        </div>
      </div>
    </section>
  </div>
@endsection
