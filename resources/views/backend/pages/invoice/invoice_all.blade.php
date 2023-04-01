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
<?php 
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Courier_br;
use App\Models\Courier;
?>

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
	@foreach($customer_order as $row) 
	<?php $total=0; $advance=0; $charge=0; $total1=0; $advance1=0; $charge1=0;?>
	<div style="page-break-before:always; font-size:18px;">
		<header>			
			<h2 style="text-align:center; background-color:#CCCCCC;"> <span style=" font-size:16px; font-style:italic;"></span> Condition : Tk. {{ number_format($row->invoice_amount,0,",",",") }}/-</h2>
			
		</header>
			<address style="float:left; margin-left:10px; text-transform: capitalize; max-width:350px;">
				<p><strong>Mr./Mrs. {{ ucwords(strtolower($row->customer_name)) }}</strong> <br/>{{ $row->address_1}}<br/>Cell: {{ $row->phone_1}}</p>
			</address>
			
			<address style="float:left; margin-left:10px; margin-top:20px; border:thin solid #003399; transform: rotate(25deg);">
				<p style=""><strong>{{ $row->courier_br}}, {{ $row->short_name}}</strong></p>
			</address>
			
			<address style="float:right; margin-right:30px;">
				<p> Invoice # JKH-{{ 1000+ $row->i_id}}<br/>Date : {{ date("d-m-Y", strtotime($row->invoice_date)) }}</p>
			</address>
			<br/>
			<table style="margin-top:105px;">
					<tr>
						<th style="border:1px solid #CCCCCC; width:20px;">SL</th>
						<th style="border:1px solid #CCCCCC; width:140px; text-align:center;">Item Name</th>
						<th style="border:1px solid #CCCCCC; width:130px; text-align:center;">Item Code</th>
						<th style="border:1px solid #CCCCCC; width:170px; text-align:center;">Description</th>
						<th style="border:1px solid #CCCCCC; width:80px; text-align:center;">Rate</th>
						<th style="border:1px solid #CCCCCC; max-width:100px; text-align:center;">Quantity</th>
						<th style="border:1px solid #CCCCCC; max-width:80px; text-align:center;" colspan="2">Amount</th>
					</tr>
			<?php $orders=Customer_order_detail::where('invoice_id', $row->i_id)->get(); ?>	
			@foreach($orders as $order) 
					<tr>
						<?php $total+=$order->total_price; $advance+=$order->advance; $charge+=$order->courier_charge; $discount=$order->invoice->discount; ?>
						<td style="border:1px solid #CCCCCC;">{{ $loop->iteration }}</td>
						<td style="border:1px solid #CCCCCC;">{{ $order->stock->product->gender->gender_name }} {{ $order->stock->product->category->category_name }}-{{ $order->stock->product->subcategory->subcategory_name }}</td>
						<td style="border:1px solid #CCCCCC;">{{ $order->stock->product->product_name }}</td>
						<td style="border:1px solid #CCCCCC; text-align:left;">Color-{{ $order->stock->color->color_name }}, Size-{{ $order->stock->size->size_name }}</td>
						<td style="border:1px solid #CCCCCC; text-align:center;">Tk. </td>
						<td style="border:1px solid #CCCCCC; text-align:center;">{{ $order->order_quantity }} {{ $order->stock->product->unit->unit_name }}</td> 
						<td style="border:1px solid #CCCCCC; text-align:right; padding-right:5px;" colspan="2">Tk. {{ number_format($order->product_price,0,",",",") }} <?php $total+=$order->product_price; ?></td>
					</tr>
			@endforeach	
				<tr>
					<td colspan="8" style="height:10px;"></td>
				</tr>
				<tr>
					<td colspan="4"> </td>
					<td colspan="2" style="width:100px; text-align:left; padding-left:40px;">Total </td>
					<td style="width:50px; text-align:right; padding-right:5px;">Tk. </td>
					<td style="text-align:right;">{{ number_format($total,0,",",",") }}</td>
				</tr>
				<tr>
					<td colspan="4"> </td>
					<td colspan="2" style="width:100px; text-align:left; padding-left:40px;">Courier Charge</td>
					<td style="width:50px; text-align:right; padding-right:5px;">Tk. </td>
					<td style="text-align:right;">{{ number_format($row->courier_charge,0,",",",") }}</td>
				</tr>
			@if($row->discount>0)
				<tr>
					<td colspan="4"> </td>
					<td colspan="2" style="width:100px; text-align:left; padding-left:40px;">Discount</td>
					<td style="width:50px; text-align:right; padding-right:5px;">Tk. </td>
					<td style="text-align:right;">{{ number_format($row->discount,0,",",",") }}</td>
				</tr>
			@endif	
				<tr>
					<td colspan="4"> </td>
					<td colspan="2" style="width:100px; text-align:left; padding-left:40px;">Amount Paid</td>
					<td style="width:50px; text-align:right; padding-right:5px;">Tk. </td>
					<td style="text-align:right;">{{ number_format($row->advance_avail,0,",",",") }}</td>
				</tr>
				<tr>
					<td colspan="4"> </td>
					<th colspan="2" style="width:100px; text-align:left; padding-left:40px;">Balance Due</th>
					<th style="width:50px; text-align:right; padding-right:5px;">Tk. </th>
					<th style="text-align:right;">{{ number_format($total + $row->courier_charge - $row->discount - $row->advance_avail,0,",",",") }}</th>
				</tr>
				
			</table>
			<table style="float:left; margin-top:5px; margin-right:1px;" width="50%">
				<tr>
					<td style="text-align:right; width:65px;">**In Word :</td>
					<td colspan="" style="text-align:left; width:700px;"> {{ convert_number($total + $row->courier_charge - $row->discount - $row->advance_avail) }} Only.</td>
				</tr>
			</table>
	@endforeach
	</div>		
	
	<!-- Start For Korotoya and SAP -->
	
	
<!-- End For Korotoya and SAP -->
</body>
