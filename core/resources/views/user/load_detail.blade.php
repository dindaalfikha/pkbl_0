@extends('userlayout')

@section('content')
<div class="container-fluid mt--6">
	<div class="content-wrapper">
    
		<div class="row">
			<div class="col-md-7">
				<div class="card">
					<div class="card-body">
						<form role="form" action="{{url('/')}}/user/payloan/{{$loan->id}}" method="post" enctype="multipart/form-data"> 
							@csrf
							<div class="form-group">
								<label for="">Jumlah</label>
								<input type="number" name="amount" max="{{$loan->amount}}" min="0" class="form-control" @if ($loan->status == 2) {{'disabled'}} @endif>
							</div>

							<div class="custom-file mb-3">
								<input type="file" name="bukti_pembayaran" class="custom-file-input">
								<label for="" class="custom-file-label">Bukti Pembayaran</label>
							</div>
							
							<div class="form-group">
								<input type="submit" value="Bayar" class="btn btn-success w-100 z-depth-0" @if ($loan->status == 2) {{'disabled'}} @endif>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-5">
				<div class="card">
					<div class="card-body">
						<ul>
							<li>
								Total Tagihan: {{'Rp. ' . number_format($loan->amount, 2, ',', '.')}} <br>
							</li>
							<li>
								Total yang sudah dibayar: {{'Rp. ' . number_format($loan_left->total, 2, ',', '.')}} <br>
							</li>
							<li>
								Sisa Tagihan: {{'Rp. ' . number_format(( $loan->amount - $loan_left->total ), 2, ',', '.')}}
							</li>
						</ul>
						
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<th>No</th>
						<th>Waktu Pembayaran</th>
						<th>Jumlah</th>
						<!-- <th>Status</th> -->
					</thead>
					<tbody>
						<?php $no = 0; ?>
						@foreach($pay_loan_history as $val)   
						<tr>
							<td width="10%">{{++$no}}</td>
							<td>{{$val->created_at}}</td>
							<td>{{'Rp. ' . number_format($val->amount, 2, '.', ',')}}</td>
						</tr>
						@endforeach
					</tbody>

				</table>
			</div>
		</div>
    </div>
@stop