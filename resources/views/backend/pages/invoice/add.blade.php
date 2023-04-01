@extends('admin.admin')
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class=""><h4 style="color:#00CC00;">Invoice Generate</h4>
									</div>

                                    <div class="card-footer text-center">
                                        <div class="table-responsive">
										<form method="post" action="{{route('invoice.add')}}" id="myForm" >
										 @csrf
											<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th width="10px;">SL</th>
														<th>Delivery</th>
														<th>Customer</th>
														<th>Product</th>
														<th> Color</th>
														<th>Size</th>
														<th>Qty</th>
														<th>Price</th>
														<th>Adv</th>
														<th>Due</th>
														<th width="80px;">Action</th>
													</tr>
												</thead>
												<tbody>
												 
												
													@foreach($customer_order as $row)
														<tr>
															<input type="hidden" name="id[]" value="{{ $row->id }}" />
															<input type="hidden" name="customer_id[]" value="{{ $row->customer->id }}" />
															<input type="hidden" name="stock_id[]" value="{{ $row->stock_id }}" />
															<input type="hidden" name="quantity[]" value="{{ $row->quantity }}" />
															<input type="hidden" name="order_id[]" value="{{ $row->order_id }}" />
															<input type="hidden" name="delivery_date" value="{{ $row->delivery_date }}" />
															<input type="hidden" name="total_price[]" value="{{ $row->total_price }}" />
															<td>{{ $loop->iteration }}</td>
															<td style="text-align:left;">{{ date("d.m.y", strtotime($row->delivery_date)) }}</td>
															<td style="text-align:left;">{{ $row->customer->name }} {{ $row->customer->phone_1 }}</td>
															<td style="text-align:left;">{{ $row->stock->product->product_name }}</td>
															<td style="text-align:left;">{{ $row->stock->color->color_name }}</td>
															<td style="text-align:center;">{{ $row->stock->size->size_name }}</td>
															<td style="text-align:center;">{{ $row->quantity }}</td>
															<td style="text-align:right;">{{ $row->total_price }}</td>
															<td style="text-align:right;">{{ $row->advance }}</td>
															<td style="text-align:right;">{{ $row->total_price - $row->advance }}</td>
															<td style="text-align:left;">
																<select name="order[]" >
																	<option value=""></option>
																	<option value="1">Selected</option>
																</select>
															</td>
														</tr>
													@endforeach
												</tbody>
											</table>
											
											<button type="submit" class="btn btn-success" >Submit </button>
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