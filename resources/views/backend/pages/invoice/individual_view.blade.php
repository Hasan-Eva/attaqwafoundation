<?php
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 
	$Cn = floor($number / 10000000);  /* Crore (giga) */ 
    $number -= $Cn * 10000000; 

    $Gn = floor($number / 100000);  /* Lac (giga) */ 
    $number -= $Gn * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 
	if ($Cn) 
    { 
        $res .= convert_number($Cn) . " Crore"; 
    } 

    if ($Gn) 
    { 
        $res .= (empty($res) ? "" : " ") .
		convert_number($Gn) . " Lac"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= " " . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 

?>
<?php use App\Courier_br; ?>

<style>
table {
  font-family: arial, sans-serif;
  font-style: italic;
  font-size:13px;
  border-collapse: collapse;
}
h1 {
  width: 200px;
  height: 40px;
  background-color: yellow;
  -ms-transform: skewY(20deg); /* IE 9 */
  transform: skewY(20deg);
}
</style>
	<body>
	<?php $total=0; $advance=0; $charge=0;?>
	
		<?php $customer=$customer_order->customer->customer_name; $address=$customer_order->customer->address_1; $phone=$customer_order->customer->phone_1; $courier_br=$invoice->courier_br->courier_br; $courier=$invoice->courier_br->courier->name; 
		?>
	
			<table style="margin-top:0px;">
				<tr>
					<th><img src="{{ asset('public/images/logo/logo.jpg') }}" alt="Card image" width="100px;" /></th>
					<td style="width:500px; text-align:center; font-size:24px;">Condition : Tk. <u>{{ number_format($invoice->invoice_amount,0,",",",") }}/=</u></td>
				</tr>
			</table>
			<table style="margin-top:0px;">
				<tr>
					<td style="width:300px; text-transform:capitalize; font-style:italic; font-size:16px; font-family:"Times New Roman", Times, serif;"><strong>Mr./Ms. {{ ucwords(strtolower($customer)) }}</strong> <br/>{{ $address}}<br/>Cell: {{ $phone}}</td>
					<td style="text-align:center;">
						<address style=" width:120px; float:left; border:thin solid #003399; transform: rotate(25deg); border-radius: 15px 50px;">
							<p><strong>{{ $courier_br}}, {{ $invoice->courier_br->courier->short_name }}</strong></p>
						</address>
					</td>
					<td style="width:270px; font-size:16px; font-family:"Times New Roman", Times, serif; text-align:right;">
						<p> Invoice # RBZ-{{ 1000+ 1}}<br/>Date : {{ date("d-m-Y") }}</p>
					</td>
				</tr>
			</table>
			
			<br/>
			<table style="margin-top:5px;">
					<tr>
						<th style="border:1px solid #CCCCCC; width:10px;">SL</th>
						<th style="border:1px solid #CCCCCC; width:150px; text-align:center;">Item Name</th>
						<th style="border:1px solid #CCCCCC; table-layout:fixed; width:120px; word-wrap:break-word; text-align:center;">Item Code</th>
						<th style="border:1px solid #CCCCCC; width:150px; text-align:center;">Description</th>
						<th style="border:1px solid #CCCCCC; width:60px; text-align:center;">Rate</th>
						<th style="border:1px solid #CCCCCC; width:60px; text-align:center;">Quantity</th>
						<th colspan="2" style="border:1px solid #CCCCCC; width:100px; text-align:center;">Amount</th>
					</tr>
				
				@foreach($customer_order_detail as $row) 
					<tr>
						<td style="border:1px solid #CCCCCC;">{{ $loop->iteration }}</td>
						<td style="border:1px solid #CCCCCC;">{{ $row->stock->product->gender->gender_name }} {{ $row->stock->product->category->category_name }} - {{ $row->stock->product->subcategory->subcategory_name }}</td>
						<td style="border:1px solid #CCCCCC;"> {{ $row->stock->product->product_name }}</td>
						<td style="border:1px solid #CCCCCC; text-align:left;">Color- {{ $row->stock->color->color_name }} Size- {{ $row->stock->size->size_name }}</td>
						<td style="border:1px solid #CCCCCC; text-align:center;">Tk. {{ number_format($row->product_price/$row->order_quantity,0,",",",") }}</td>
						<td style="border:1px solid #CCCCCC; text-align:center;">{{ $row->order_quantity }} {{ $row->stock->product->unit->unit_name }}</td> 
						<td colspan="2" style="border:1px solid #CCCCCC; text-align:right; padding-right:5px;">Tk. {{ number_format($row->product_price,0,",",",") }}<?php $total+=$row->product_price; ?></td>
					</tr>
				@endforeach
				<tr>
					<td colspan="8" style="height:10px;"></td>
				</tr>
				<tr>
					<td colspan="6" style="width:100px; text-align:right;">Total </td>
					<td style="width:50px; text-align:right;">Tk.</td>
					<td style="text-align:right;">{{ number_format($total,0,",",",") }}</th>
				</tr>
				<tr>
					<td colspan="6" style="width:100px; text-align:right;">Courier Charge</td>
					<td style="width:50px; text-align:right;">Tk.</td>
					<td style="text-align:right;">{{ number_format($invoice->courier_charge,0,",",",") }}</th>
				</tr>
			
				<tr>
					<td colspan="6" style="width:100px; text-align:right;">Discount</td>
					<td style="width:50px; text-align:right;">Tk.</td>
					<td style="text-align:right;">{{ number_format($invoice->discount,0,",",",") }}</th>
				</tr>
			
				<tr>
					<td colspan="6" style="width:100px; text-align:right;">Amount Paid</td>
					<td style="width:50px; text-align:right;">Tk.</td>
					<td style="text-align:right;">{{ number_format($invoice->advance_avail,0,",",",") }}</th>
				</tr>
				<tr>
					<th colspan="6" style="width:100px; text-align:right;">Balance Due</th>
					<th style="width:50px; text-align:right;">Tk.</th>
					<th style="text-align:right;">{{ number_format($total + $invoice->courier_charge - $invoice->discount - $invoice->advance_avail,0,",",",") }}</th>
				</tr>
				
			</table>
			<table style="float:left; margin-top:5px; margin-right:1px;" width="50%">
				<tr>
					<td style="text-align:right; width:65px;">**In Word :</td>
					<td colspan="" style="text-align:left; width:700px; font-style:italic;">{{ convert_number($total + $invoice->courier_charge - $invoice->discount - $invoice->advance_avail) }}  Only.</td>
				</tr>
			</table>
			
</body>