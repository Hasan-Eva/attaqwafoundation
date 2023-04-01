@extends('backend.layouts.master')
<!-- datatables -->
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/datatables-buttons/css/buttons.bootstrap4.min.css">
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Supplier Order List<button class="small float-right btn btn-primary" id="show"><i class="fa fa-plus-circle"></i> Supplier Order List</button></h4>
									</div>

                                    <div class="card-footer text-center">
                                        <div class="table-responsive">
											<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th width="60px;">SL</th>
														<th>Date</th>
														<th>Order No</th>
														<th>Supplier Name</th>
														<th>Position</th>
														<th width="80px;">View</th>
														<th width="80px;">Receive</th>
													</tr>
												</thead>
												<tbody>
												 
												
													@foreach($orders as $row)
														<tr>
															<td>{{ $loop->iteration }}</td>
															<td style="text-align:left; padding-left:0px; text-align:center;">{{ date("d.m.Y", strtotime($row->date)) }}</td>
															<td style="text-align:left; padding-left:5px; text-align:center;">{{ $row->order_no }} </td>
															<td style="text-align:left; padding-left:5px;">{{ $row->supplier->supplier_name }}</td>
															<td style="text-align:left; padding-left:5px;">
																<?php if($row->status==1) { echo "Pending";} if($row->status==2) { echo "Confirm";} if($row->status==3) { echo "Received";} if($row->status==4) { echo "Cancelled";}?>
															</td>
															<td style="text-align:center; padding-left:5px;">
															<a href="{{route('supplier_order.pending_order_confirm',$row->id)}}" class="btn btn-danger btn-xs no_confirm" style="margin-left:10px;"><i class="fa fa-list"></i></a>
															</td>
															<td style="text-align:center; padding-left:5px;">
															@if($row->status==2)
															<a href="{{route('supplier_order.pending_order_receive',$row->id)}}" class="btn btn-danger btn-xs no_confirm" style="margin-left:10px;"><i class="fa fa-cart-plus"></i></a>
															@endif
															</td>
														</tr>
													@endforeach
													
												</tbody>
											</table>
											
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
    </body>

@endsection