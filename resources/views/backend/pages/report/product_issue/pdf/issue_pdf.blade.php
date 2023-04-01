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
use App\Courier_br; 
use App\Models\Company_info;
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
  height: 20px;
  background-color: yellow;
  -ms-transform: skewY(20deg); /* IE 9 */
  transform: skewY(20deg);
}
td, th {
    border: 1px solid black;
}
</style>
	<body>
		<table>
			<thead>
				<tr>
					<td colspan="7" style=" text-align:center; border:none; font-size:20px;">IMPETUS Center Owners Association</td>
				</tr>
				<tr>
					<td colspan="7" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<td colspan="7" style=" text-align:center; border:none;">Product Issued Report</td>
				</tr>
				<tr>
					<td colspan="7" style=" text-align:center; border:none;">Period: {{  date("d.m.Y", strtotime($f_date)) }} to {{  date("d.m.Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:10px;">SL</th>
					<th style="text-align:center; width:75px;">Date</th>
					<th style="text-align:center; width:250px;">Particulars</th>
					<th style="width:100px; width:50px;">Qty</th>
					<th style="text-align:center; width:120px;">Received By</th>
					<th style="width:100px; width:80px;">Rate</th>
					<th style="text-align:center; width:95px;"> Amount</th>
				</tr>
			</thead>
			<tbody>
				@php $total=0; @endphp
				@foreach($issue as $data)
				<tr>
					<td class="text-center">{{ $loop->iteration }}</td>
					<td>{{  date("d.m.Y", strtotime($data->date)) }}</td>
					<td style="text-align:left;">{{ $data->stock->product->product_name }}</td>
					<td style="text-align:center;">{{ $data->quantity }}</td>
					<td style="text-align:left;">{{ $data->trade_with }}</td>
					<td style="text-align:right;">{{ number_format($data->amount/$data->quantity,2,".",",") }}</td>
					<td style="text-align:right;">{{ number_format($data->amount,2,".",",") }} <?php $total+=$data->amount; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					 <th colspan="6" class="text-center">Total</th>
					<th style="text-align:right;">{{ number_format($total,2,".",",") }}</th>
				</tr>
			</tfoot>	  
		</table>	
			
</body>