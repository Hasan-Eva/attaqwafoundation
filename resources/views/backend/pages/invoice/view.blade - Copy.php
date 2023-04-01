@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    
									<div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Invoice Generate <button type="submit" class="btn btn-primary float-right btn-xs" data-toggle="modal" data-target="#allModal"><i class="fa fa-print"></i> Print All</button></h4>
									
										<!-- Start Modal -->
										<div class="modal fade" id="allModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-sm" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Invoice Print</h5> <span style="padding-left:10px; color: #000066;"> </span>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form id="search_form" action="{{ route('invoice.view_pdf_all') }}" target="_blank" method="POST" id="editForm">
													{{ csrf_field() }}
														<input type="hidden" name="id" id="id" value="" >
														<div class="modal-body">
																<div class="form-group">
																	<label for="recipient-name" class="col-form-label">From</label>
																	<input type="date" name="f_date" class="form-control" value="{{ date('Y-m-d') }}">
																</div>
																<div class="form-group">
																	<label for="recipient-name" class="col-form-label">To</label>
																	<input type="date" name="t_date" class="form-control" value="{{ date('Y-m-d') }}">
																</div>
														</div>
														<div class="modal-footer">
																<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
																<button type="submit" class="btn btn-primary btn-sm"> Submit </button>
														</div>
													</form>
												</div>
											</div>
										</div>
									<!-- End Modal -->
												
                                    <div class="card-footer text-center">
                                        <div class="table-responsive">
										<form method="post" action="{{route('invoice.add')}}" id="myForm"  target="_blank">
										 @csrf
											<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
												<thead>
													<tr>
														<th width="10px;">SL</th>
														<th>Date</th>
														<th>Customer Name</th>
														<th>Phone</th>
														<th>Address</th>
														<th width="80px;">View</th>
													</tr>
												</thead>
												<tbody>
													@foreach($invoice as $row)
														<tr>
															<input type="hidden" name="id[]" value="{{ $row->id }}" />
															<input type="hidden" name="customer_id[]" value="{{ $row->customer_order_id }}" />
															
															<td>{{ $loop->iteration }}</td>
															<td style="text-align:left;">{{ date("d.m.y", strtotime($row->invoice_date)) }}</td>
															<td style="text-align:left;">{{ $row->customer_order->customer->customer_name }}</td>
															<td style="text-align:left;">{{ $row->customer_order->customer->phone_1 }}</td>
															<td style="text-align:left;">{{ $row->customer_order->customer->address_1 }}</td>
															<td style="text-align:left;">
																<a title="Edit" href="{{ route('invoice.individual_view',$row->id)}}" target="_blank" class="btn btn-success btn-xs" style="margin-left:10px;"><i class="fa fa-list"></i></a>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>	
										</form>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
    </body>

@endsection

</html>