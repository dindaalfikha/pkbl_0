@extends('master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title font-weight-semibold">Admin Unit</h6>
                        <button type="button" data-toggle="modal" data-target="#tambah-admin" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Admin</button>
                        <div id="tambah-admin" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">   
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <form action="{{route('admin.add.admin_unit')}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <h6 class="font-weight-semibold">Tambah Admin</h6>
                                            <div class="form-group">
                                                <label for="">Username</label>
                                                <input type="text" name="username" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Unit</label>
                                                <select name="unit" id="" class="custom-select">
                                                    @foreach($unit as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->nama}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                            <input type="submit" value="proceed" class="btn btn-success">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <table class="table datatable-show-all">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Username</th>
                                    <th>Unit</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach($admin_list as $key => $value)
                                <tr>
                                    <td>{{++$no}}</td>
                                    <td>{{$value->username}}</td>
                                    <td>{{$value->nama}}</td>
                                    <td>{{date('Y-m-d H:i:s', strtotime($value->created_at))}}</td>
                                    <td>{{date('Y-m-d H:i:s', strtotime($value->updated_at))}}</td>
                                    <td class="text-center">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown">
                                            <i class="icon-menu9"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-toggle="modal" data-target="#{{$value->id}}edit" class="dropdown-item">
                                                <i class="fa fa-pencil mr-2"></i> Edit
                                            </a>
                                            <a data-toggle="modal" data-target="#{{$value->id}}delete" class="dropdown-item">
                                                <i class="fa fa-trash mr-2"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <div id="{{$value->id}}edit" class="modal fade" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">   
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <form action="{{url('/')}}/admin/edit-admin/{{$value->username}}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <h6 class="font-weight-semibold">Edit Admin</h6>
                                                    <div class="form-group">
                                                        <label for="">Username</label>
                                                        <input type="text" name="username" value="{{$value->username}}" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Unit</label>
                                                        <select name="unit" id="" class="custom-select">
                                                            @foreach($unit as $key => $val)
                                                            <option value="{{$val->id}}">{{$val->nama}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                                    <input type="submit" value="save" class="btn btn-success">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="{{$value->id}}delete" class="modal fade">
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
                                                    <a href="{{url('/')}}/admin/delete-admin/{{$value->id}}" class="btn bg-danger">Proceed</a>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>                    
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop