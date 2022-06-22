<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>OIL | {{$title}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/jqvmap/jqvmap.min.css">

  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/assets/')}}/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('/assets/')}}/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{url('/assets/')}}/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{url('/assets/')}}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{url('/assets/')}}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link @if($active == 1){{"active"}}@endif">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item @if($active == 2 || $active == 3 || $active == 4){{"menu-open"}}@endif">
            <a href="#" class="nav-link @if($active == 2 || $active == 3 || $active == 4){{"active"}}@endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Master Data Config
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.master.csv.data')}}" class="nav-link @if($active == 2){{"active"}}@endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master CSV Data</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.master.csv.table')}}" class="nav-link @if($active == 3){{"active"}}@endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Table for CSV</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.master.unit')}}" class="nav-link @if($active == 4){{"active"}}@endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master Unit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Master User</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if($active == 5){{"menu-open"}}@endif">
            <a href="#" class="nav-link @if($active == 5){{"active"}}@endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Measurement Data
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('admin.data.sync')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Data Sync</p>
                </a>
              </li>
              @foreach ($measure_data as $item)    
              <li class="nav-item">
                <a href="{{route('admin.measure.data', $item->id_table)}}" class="nav-link @if($active == 5 && request()->segment(count(request()->segments())) == $item->id_table){{"active"}}@endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ucwords(str_replace('_', ' ', $item->table_name))}}</p>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
          <li class="nav-header">SETTINGS</li>
          <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link @if($active == 6){{"active"}}@endif">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Setting
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.dashboard')}}" class="nav-link">
              <i class="nav-icon fa fa-arrow-left"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{url('/assets/')}}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('/assets/')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('/assets/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/assets/')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- ChartJS -->
<script src="{{url('/assets/')}}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{url('/assets/')}}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{url('/assets/')}}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{url('/assets/')}}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('/assets/')}}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{url('/assets/')}}/plugins/moment/moment.min.js"></script>
<script src="{{url('/assets/')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('/assets/')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{url('/assets/')}}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{url('/assets/')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/assets/')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{url('/assets/')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{url('/assets/')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{url('/assets/')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{url('/assets/')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>



<script src="{{url('/assets/')}}/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/assets/')}}/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/assets/')}}/dist/js/pages/dashboard.js"></script>

<script>
  $(document).ready(function() {
    $('#add_field').click(function() {
      var html = '<div class="row"><div class="col-md-3"><div class="form-group"><label for="col_table_name">Column Table Name</label><div class="input-group"><div class="input-group-prepend"><button type="button" class="btn btn-danger delete"><i class="fa fa-minus"></i></button></div><input type="text" name="col_table_name[]" id="col_table_name" class="form-control"></div></div></div><div class="col-md-3"><div class="form-group"><label for="col_csv_name">Column CSV Name</label><input type="text" name="col_csv_name[]" id="col_csv_name" class="form-control"></div></div><div class="col-md-2"><div class="form-group"><label for="col_csv_index">Column CSV Index</label><input type="text" name="col_csv_index[]" id="col_csv_index" class="form-control"></div></div><div class="col-md-2"><label for="col_csv_index">Nilai Norma</label><input type="text" name="norma_value[]" id="col_csv_index" class="form-control"></div><div class="col-md-2"><label for="col_csv_index">Use Warning</label><select class="custom-select" name="use_warning[]"><option value="1">Yes</option><option value="0">No</option></select></div></div>';

      $('#field-container').append(html);
    });

    $('#field-container').on('click', '.delete', function() {
      $(this).parent().parent().parent().parent().parent().remove();
    });

    $('#table').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

@if(!empty($unitSelected) && $unitSelected[0] != '')
  @php
      $arr = '[';
      foreach ($unit as $key => $value) {
        if(in_array($value->nama_unit, $unitSelected)) {
          if($key < count($unitSelected)) {
            $arr .= " '" . $value->nama_unit . "' ]";
          } else {
            $arr .= " '" . $value->nama_unit . "', ";
          }
        }
      }
  @endphp
  <script>
    $(document).ready(function() {
      $('.select2').select2().select2('val', <?= $arr ?>);
    });
  </script>
@else
  <script>
    $(document).ready(function() {
      $('.select2').select2();
    });
  </script>
@endif

@if (file_exists(url('/assets/dist/js/') . '/' . request()->segment(count(request()->segments()) - 1) . '.js'))
    <script src="{{url('/assets/dist/js/') . '/' . request()->segment(count(request()->segments()) - 1) . '.js'}}"></script>
@endif
</body>
</html>
