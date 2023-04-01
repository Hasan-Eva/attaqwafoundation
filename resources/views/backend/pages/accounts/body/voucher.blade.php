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

@foreach($voucher as $data)
<div style="page-break-before:always; font-size:18px; height:500px; border:1px solid #CCCCCC;">

<table>
    <tbody>
		<tr>
            <td colspan="3" style="text-align:left; width:400px; height:100px;"><strong>Voucher No : {{ $data->id }}</strong> </br><i> </i></td>
			<td colspan="3" style="text-align:right; width:400px; height:100px;"><strong>Transaction Date : </strong> <i>{{  date("d.m.y", strtotime($t)) }} </i></td>
		</tr>
		<tr>
            <td colspan="6" style="text-align:left;">Transaction With : <b><i>{{ $data->transactionwith }} </i><b></td>
		</tr>
		<tr>
            <td colspan="4" style="text-align:center; height:60px;"><strong>Particulars </strong> </br><i> </i></td>
			<td style="text-align:right; height:40px;"><strong>Dr</i></td>
			<td style="text-align:right; height:40px;"><strong>Cr</i></td>
		</tr>
		<tr>
			<td colspan="4" style="text-align:left; padding-left:50px;">{{ $data->dr_name }} </td>
			<td style="text-align:right;"><?php echo number_format($data->amount,2,".",","); ?></td>
			<td></td>
		</tr>
		<tr>
			<td colspan="4" style="text-align:left; padding-left:50px;">{{ $data->cr_name }}</td>
			<td></td>
			<td style="text-align:right;"><?php echo number_format($data->amount,2,".",","); ?></td>
		</tr>
	</tbody>	
		
		<tr>
            <td colspan="6" style="text-align:left; height:80px;">In Word : {{ convert_number($data->amount) }} Only.</td>
		</tr>
		
		<tr>
			<th colspan="2" style="text-align:left; height:120px;">Prepared by:</th>
			<th colspan="2" style="text-align:center;">Verified by:</th>
			<th colspan="2" style="text-align:right;">Approved by:</th>
		</tr>
</table>
</div>
@endforeach
