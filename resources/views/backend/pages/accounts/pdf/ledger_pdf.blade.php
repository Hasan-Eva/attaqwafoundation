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
		<?php $id=request()->input('h_name'); 
			$query="SELECT * FROM ac_heads where id ='".$id."'";
			$data=DB::select($query);
			$company_name = Company_info::first()->name;
		?>
		<table style="margin-top:0px; width:100%;">
			<tr>
				@foreach($data as $row)
                <td colspan="8" style="text-align:center; border:none; font-size:20px;"><strong>{{ $company_name }}</strong> </td>
				@endforeach
			</tr>
			<tr>
				@foreach($data as $row)
                <td colspan="8" style="text-align:center; border:none;"><strong>Ledger - {{ $row->h_name }}</strong> </td>
				@endforeach
			</tr>
			<tr>
				@foreach($data as $row)
                <td colspan="8" style="text-align:center; border:none;"><i>Period : {{  date("d.m.y", strtotime($f)) }} To {{  date("d.m.y", strtotime($t)) }} </i></td>
				@endforeach
			</tr>
		</table>
		
		<table>
			<thead>
				<tr>
					<td style="height:20px; border:none;"></td>
				</tr>
				<tr>
					<th rowspan="2" style="text-align:center;">SL</th>
					<th rowspan="2" style="text-align:center; width:80px;">Date</th>
					<th rowspan="2" style="text-align:center; width:90px;">A/c Title</th>
					<th rowspan="2" style="text-align:center; width:195px;">Particulars</th>
					<th rowspan="2" style="width:80px;">Debit</th>
					<th rowspan="2" style="width:80px;">Credit</th>
					<th colspan="2" style="text-align:center;">Balance Amount</th>
				</tr>
				<tr>
					<th style="width:80px; text-align:center;">Dr.</th><th style="width:80px; text-align:center;">Cr.</th>
				</tr>
			</thead>
			<tbody>
			@if(isset($cr)) 
				<tr>
                    <td></td>
                    <td colspan="5" style="text-align:center;"> Opening Balance</td>
                    <td style="text-align:right;"><?php if( $opening_dr - $opening_cr > 0) { echo number_format($opening_dr - $opening_cr,2,".",","); $openingdr=$opening_dr - $opening_cr;} else { $openingdr=0; } ?></td>
					<td style="text-align:right;"><?php if( $opening_dr - $opening_cr < 0) { echo number_format($opening_cr - $opening_dr,2,".",","); $openingcr=$opening_cr - $opening_dr;} else { $openingcr=0; } ?></td>
                </tr>
                 	  
				@php $dr_total=0; $cr_total=0; @endphp
				@foreach($cr as $data)
				<tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td style="text-align:center;">{{  date("d.m.Y", strtotime($data->j_date)) }}</td>
                    <td style="text-align:left; padding:3px;">{{ $head == $data->dr_head? $data->cr_name:$data->dr_name }}</td>
					<td style="text-align:left; padding:3px; text-transform:capitalize; font-size:12px;">{{ $data->particulars }}</td>
					<td style="text-align:right; padding:3px;"><?php if($head == $data->dr_head){ echo number_format($data->amount,2,".",","); $dr_total+=$data->amount;} ?></td>
					<td style="text-align:right; padding:3px;"><?php if($head != $data->dr_head){ echo number_format($data->amount,2,".",","); $cr_total+=$data->amount;} ?></td>
					<td style="text-align:right; padding:3px;"><?php if($dr_total-$cr_total+$openingdr-$openingcr>0){ echo number_format($dr_total-$cr_total+$openingdr-$openingcr,2,".",","); } ?></td>
					<td style="text-align:right; padding:3px;"><?php if($cr_total-$dr_total+$openingcr-$openingdr>0){ echo number_format($cr_total-$dr_total + $openingcr-$openingdr,2,".",","); } ?></td>
                </tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center">Closing Balance</th>
					<th style="text-align:right; padding:3px;">{{ number_format($dr_total,2,".",",") }}</th>
					<th style="text-align:right; padding:3px;">{{ number_format($cr_total,2,".",",") }}</th>
					<th style="text-align:right; padding:3px;"><?php if($dr_total-$cr_total+$openingdr-$openingcr>0){ echo number_format($dr_total-$cr_total+$openingdr-$openingcr,2,".",","); } ?></th>
					<th style="text-align:right; padding:3px;"><?php if($cr_total-$dr_total+$openingcr-$openingdr>0){ echo number_format($cr_total-$dr_total+ $openingcr-$openingdr,2,".",","); } ?></th>
				</tr>
			</tfoot>
			@endif
				  
		</table>	
			
</body>