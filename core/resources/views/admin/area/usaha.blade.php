@extends('master')

@section('content')

    <div class="content">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title font-weight-semibold">Daftar Usaha</h6>
                <a data-toggle="modal" data-target="#tambah-usaha" class="btn btn-primary btn-sm text-white"><i class="fa fa-plus"></i> Tambah Usaha</a>
            </div>
            <div class="">
                <table class="table datatable-show-all">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Nama Sektor Usaha</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th class="text-center">Action</th>    
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($usaha as $k=>$val)
                        <tr>
                            <td>{{++$k}}.</td>
                            <td>{{$val->nama}}</td>
                            <td>{{date('Y-m-d H:i:s', strtotime($val->created_at))}}</td>
                            <td>{{date('Y-m-d H:i:s', strtotime($val->updated_at))}}</td>
                            <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class='dropdown-item' data-toggle="modal" data-target="#{{$val->id}}edit"><i class="icon-pencil mr-2"></i>Edit</a>
                                            <a data-toggle="modal" data-target="#{{$val->id}}delete" class="dropdown-item"><i class="icon-bin2 mr-2"></i>Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>                   
                        </tr>
                        <div id="{{$val->id}}edit" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{route('admin.edit.usaha')}}" method="POST">
                                        @csrf
                                        <div class="modal-header">   
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="font-weight-semibold">Edit Sektor Usaha</h6>
                                            <input type="hidden" name="id_usaha" value="{{$val->id}}">
                                            <div class="form-group">
                                                <label for="">Sektor Usaha</label>
                                                <input type="text" name="nama" value="{{$val->nama}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn bg-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="{{$val->id}}delete" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">   
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <h6 class="font-weight-semibold">Are you sure you want to delete this?</h6>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <a  href="{{url('/')}}/admin/usaha-delete/{{$val->id}}" class="btn bg-danger">Proceed</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach               
                    </tbody>                    
                </table>
            </div>
        </div>

        <div id="tambah-usaha" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{route('admin.add.usaha')}}" method="POST">
                        @csrf
                        <div class="modal-header">   
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <h6 class="font-weight-semibold">Tambah Usaha</h6>
                            <div class="form-group">
                                <label for="">Nama Usaha</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-success">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop