
<?php 
use App\Models\Staff_leave;
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
	<div style="padding-left:50px;">
		<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		<div class="col-sm-12 float-left mf-1" style=" text-align:center;"><strong> <u>Application For Leave </u></strong></div>
		<table width="100%">		
			<thead>
				<tr>
					<th style="text-align:left; ">Applican's Name</th>
					<th style="text-align:center; width:33%;">Designation</th>
					<th style="text-align:center; width:33%;">Department</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td style="text-align:left; ">{{ $data->name }}</td>
					<td style="text-align:center; width:33%;">{{ $data->designation->designation_name }}</td>
					<td style="text-align:center; width:33%;"></td>
				</tr>
			</tbody>
		</table>
		<p>
		<strong>Manager</strong> <br>
		Impetus Center<br>
		242/B, Tejgaon Gulshan Link Road <br>
		Tejgaon I/A, Dhaka-1208
		<br/><br/>
		Dear Sir,<br>
		Assalamu Alaikum Wa-Rahmatullah: <br/><br/>
		I pray for leave as described below:<br/>
		1. Nature of the leave : Casual / Medical / Special / Others <br/>
		2. Purpose of the leave : <br/>
		3. Leave Period : {{ date("d.m.Y", strtotime($f_date)) }} to {{ date("d.m.Y", strtotime($t_date)) }}<br/>
		4. Address / Contact Number to communicate at leave period: 
		<div style="width:650px; height:30px; border:1px solid black;">
		
		</div>
		I request you to kindly grant me the leave mentioned above for this day only.<br/>
		</p>
		<div style="width:650px; height:50px; text-align:right;">
			Yours faithfully <br/><br/><br/><br/> _______________________  (Signature of the applicant)
		</div>
		<div style=" margin-top:60px; width:650px; height:30px; text-align:center;">
			---------------------------------------------- FOR OFFICE USE ----------------------------------------------
		</div>
		<div style="width:650px; height:30px; text-align:left;">
			Leave outstanding in the account of applicant ______ days.
		</div>
		<div style="width:650px; height:30px; border:1px solid black; text-align:left;">
		Recommendation : 
		</div>
		<div style="width:650px; height:30px; border:1px solid black; text-align:left;">
		Comment (if any) : 
		</div>
		<div style="width:650px; height:30px; border:1px solid black; text-align:left;">
		Leave Sanctioned/Deferred : 
		</div>
		<div style=" margin-top:30px; width:650px; height:30px; text-align:left;">
			------------------------------------ FOR RECORD OF THE APPLICANT ------------------------------------ <br><br>
			Dear Sir,
			Please be informed that the leave has been / has not been sanctioned against your application dated ______________ for ________ day/s from {{ date("d.m.Y", strtotime($f_date)) }} to {{ date("d.m.Y", strtotime($t_date)) }}. 
			As such, the balance of your CL/ML/SL now remains _________ days.
		</div>		
		<div style="margin-top:100px; width:650px; height:30px; text-align:right;">
		Authority / Manager 
		</div>
	</div>
</body>