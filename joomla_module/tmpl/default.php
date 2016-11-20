<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

/**
 * @version 1.0.0
 * @package PayrollCalculator 
 * @copyright 2016 RosdyanaKusuma
 * @author 2016 RosdyanaKusuma(rosdyana.kusuma@mail.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @description Payroll Calculator
 * Homepage: http://r3m1ck.us/
*/
$uri = JURI::getInstance();
$calculatorscript = $uri->root().'modules/mod_payrollcalc/tmpl/calculatev2.js';
$iconcalculate = $uri->root().'modules/mod_payrollcalc/tmpl/calculate.png';
$iconclear = $uri->root().'modules/mod_payrollcalc/tmpl/clear.png';
$iconresult = $uri->root().'modules/mod_payrollcalc/tmpl/result.png';
?>
		<style type="text/css">
		/* latin */
        @font-face {
			font-family: 'Dancing Script';
			font-style: normal;
			font-weight: 400;
			src: local('Dancing Script'), local('DancingScript'), url(https://fonts.gstatic.com/s/dancingscript/v7/DK0eTGXiZjN6yA8zAEyM2Ud0sm1ffa_JvZxsF_BEwQk.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
        }
        /* latin */
        @font-face {
			font-family: 'Droid Serif';
			font-style: normal;
			font-weight: 400;
			src: local('Droid Serif'), local('DroidSerif'), url(https://fonts.gstatic.com/s/droidserif/v6/0AKsP294HTD-nvJgucYTaI4P5ICox8Kq3LLUNMylGO4.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
        }
        .tg  {border-collapse:collapse;border-spacing:0; width: 580px;}
        .tg td{font-family: 'Droid Serif', cursive;font-size:11px;padding:8px 4px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg th{font-family: 'Droid Serif', cursive;text-align:left;font-size:11px;font-weight:normal;padding:8px 3px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
        .tg .tg-cmwg{background-color:#D8BFD8;text-align:center;vertical-align:top;font-size:25px;font-family: 'Dancing Script', cursive;}
        .tg .tg-yw4l{vertical-align:top}
        .tg .th
        .input {font-family: 'Droid Serif', cursive;}
        .calculate-button {
			background: url('<?php echo $iconcalculate ?>') top center no-repeat #D8BFD8;
			background-position: 50% 20%;
			padding-top:20px; 
        }
        .clear-button {
			background: url('<?php echo $iconclear ?>') top center no-repeat #D8BFD8;
			background-position: 50% 20%;
			padding-top:20px;
        }
        .result-button {
			background: url('<?php echo $iconresult ?>') top center no-repeat #D8BFD8;
			background-position: 50% 20%;
			padding-top:20px;
        }
		.button-biasa {
			background-color:#F0F0F0;
			height:100px;
			font-family: 'Droid Serif', cursive;
		}
    </style>
	
<script language="JavaScript" src="<?php echo $calculatorscript?>?n=1"></script>
<center>
		<form id="PayrollCalculator" name="PayrollCalculator">
			<table class="tg">
				<tbody>
					<tr>
						<th class="tg-cmwg">PayRoll Calculator</th>
					</tr>
					<tr>
						<td class="tg-yw4l">
							<table class="tg" id="FirstGroup">
								<tbody>
									<tr>
										<th class="tg-031e">Tax Status</th>
										<th class="tg-031e"><select class="form-control" id="tax_status_combobox" name="tax_status_combobox" onchange="CariPTKP()" style="width:50px">
											<option disabled selected value="">
											</option>
											<option value="TK/0">
												TK/0
											</option>
											<option value="TK/1">
												TK/1
											</option>
											<option value="TK/2">
												TK/2
											</option>
											<option value="TK/3">
												TK/3
											</option>
											<option value="K/0">
												K/0
											</option>
											<option value="K/1">
												K/1
											</option>
											<option value="K/2">
												K/2
											</option>
											<option value="K/3">
												K/3
											</option>
											<option value="PH/0">
												PH/0
											</option>
											<option value="PH/1">
												PH/1
											</option>
											<option value="PH/2">
												PH/2
											</option>
											<option value="PH/3">
												PH/3
											</option>
										</select></th>
										<th class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="ptkp_field" name="ptkp_field" style="width:90px" type="text">
											</div>
										</th>
										<th class="tg-031e">Previous NETT Income</th>
										<th class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="prev_nett_income_field" name="prev_nett_income_field">
											</div>
										</th>
									</tr>
									<tr>
										<td class="tg-031e">JK/JKK/JPK (%)</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="jkjkkjpk_field" maxlength="4" name="jkjkkjpk_field" oninput="javascript: if (this.value.length &gt; this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="width:50px">
											</div>
										</td>
										<td class="tg-031e"><label class="col-lg-2 control-label" for="select">From</label> <select class="form-control" id="jkkjpk_combobox" name="jkkjpk_combobox" style="width:90px">
											<option disabled selected value="">
											</option>
											<option value="Basic Salary">
												Basic Salary
											</option>
											<option value="Total Income">
												Total Income
											</option>
										</select></td>
										<td class="tg-031e">Previous Tax Collection</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="prev_tax_coll_field" name="prev_tax_coll_field">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-031e">JHT Employee (%)</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="jht_field" maxlength="4" name="jht_field" oninput="javascript: if (this.value.length &gt; this.maxLength) this.value = this.value.slice(0, this.maxLength);" style="width:50px">
											</div>
										</td>
										<td class="tg-031e"><label class="col-lg-2 control-label" for="select">From</label> <select class="form-control" id="jhtsource" name="jhtsource" style="width:90px">
											<option disabled selected value="">
											</option>
											<option value="Basic Salary">
												Basic Salary
											</option>
											<option value="Total Income">
												Total Income
											</option>
										</select></td>
										<td class="tg-031e" colspan="2" rowspan="3">
											<center>
												<input class="button-biasa" onclick="GrossNettApproach_func()" type="button" value="Gross/Nett Approach"> <input class="button-biasa" onclick="THPApproach_func()" type="button" value="THP Approach">
											</center>
										</td>
									</tr>
									<tr>
										<td class="tg-031e">Insurance Premium</td>
										<td class="tg-031e" colspan="2">
											<div class="form-group">
												<input class="form-control" id="insurance_premium_field" name="insurance_premium_field" style="width:140px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-031e">Starting month</td>
										<td class="tg-031e" colspan="2"><select class="form-control" id="starting_month_combobox" name="starting_month_combobox" style="width:140px">
											<option disabled selected value="">
											</option>
											<option value="January">
												January
											</option>
											<option value="February">
												February
											</option>
											<option value="March">
												March
											</option>
											<option value="April">
												April
											</option>
											<option value="May">
												May
											</option>
											<option value="June">
												June
											</option>
											<option value="July">
												July
											</option>
											<option value="August">
												August
											</option>
											<option value="September">
												September
											</option>
											<option value="October">
												October
											</option>
											<option value="November">
												November
											</option>
											<option value="Desember">
												Desember
											</option>
										</select></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td class="tg-yw4l">
							<div class="panel panel-default">
								<div class="panel-body">
									<h4>THP Approach</h4>
								</div>
							</div>
							<table class="tg" id="SecondGroup">
								<tbody>
									<tr>
										<th class="tg-031e" colspan="3"></th>
										<th class="tg-031e">Nett Component</th>
										<th class="tg-031e">Tax</th>
										<th class="tg-031e">Total GROSS</th>
									</tr>
									<tr>
										<td class="tg-031e">Target THP</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="targetTHP_field" name="targetTHP_field" style="width:120px">
											</div>
										</td>
										<td class="tg-031e">Adj. Income</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" disabled id="Nett_adjIncome_field" name="Nett_adjIncome_field" placeholder="" style="width:90px">
											</div>
										</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" disabled id="Tax_adjIncome_field" name="Tax_adjIncome_field" placeholder="" style="width:90px">
											</div>
										</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="totalGross_adjIncome" name="totalGross_adjIncome" style="width:90px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-031e">Fixed Income1</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="fixedIncome1_field" name="fixedIncome1_field" style="width:120px">
											</div>
										</td>
										<td class="tg-031e">Fixed Income1</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" disabled id="nett_fixedIncome1_field" name="nett_fixedIncome1_field" placeholder="" style="width:90px">
											</div>
										</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" disabled id="tax_fixedIncome1_field" name="tax_fixedIncome1_field" placeholder="" style="width:90px">
											</div>
										</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="totalGrossFixedIncome1" name="totalGrossFixedIncome1" style="width:90px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-031e">Fixed Income2</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="fixedIncome2_field" name="fixedIncome2_field" style="width:120px">
											</div>
										</td>
										<td class="tg-031e">Fixed Income2</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" disabled id="nett_fixedIncome2_field" name="nett_fixedIncome2_field" placeholder="" style="width:90px">
											</div>
										</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" disabled id="tax_fixedIncome2_field" name="tax_fixedIncome2_field" placeholder="" style="width:90px">
											</div>
										</td>
										<td class="tg-031e">
											<div class="form-group">
												<input class="form-control" id="totalGrossFixedIncome2" name="totalGrossFixedIncome2" style="width:90px">
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td class="tg-yw4l">
							<div class="panel panel-default">
								<div class="panel-body">
									<h4>Gross / Nett Approach</h4>
								</div>
							</div>
							<table class="tg" id="ThirdGroup" width="100%">
								<tbody>
									<tr>
										<th class="tg-031e" colspan="6"></th>
										<th class="tg-yw4l">Nett Component</th>
										<th class="tg-yw4l">Tax</th>
										<th class="tg-yw4l">Total GROSS</th>
									</tr>
									<tr>
										<td class="tg-031e">Basic Salary</td>
										<td class="tg-031e">
											<div class="checkbox">
												<center>
													<input id="gross_basic_salary_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-031e">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="nett_basic_salary_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="basic_salary_field" name="basic_salary_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="BS_nettComp_field" name="BS_nettComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="BS_tax_field" name="BS_tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="BS_totalGross" name="BS_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-031e">Insurance</td>
										<td class="tg-031e">
											<div class="checkbox">
												<center>
													<input id="gross_insurance_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-031e">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="nett_insurance_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="insurance_field" name="insurance_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="insurance_NettComp_field" name="insurance_NettComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="insurance_Tax_field" name="insurance_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="insurance_totalGross" name="insurance_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">JK/JKK</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="gros_jkjkk_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="nett_jkjkk_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="jkkjkk_field" name="jkkjkk_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="jkjkk_NettComp_field" name="jkjkk_NettComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="jkjkk_Tax_field" name="jkjkk_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="jkjkk_totalGross" name="jkjkk_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 1</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income1_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income1_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income1_field" name="income1_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income1_NetComp_field" name="income1_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income1_Tax_field" name="income1_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income1_totalGross" name="income1_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 2</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income2_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income2_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income2_field" name="income2_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income2_NetComp_field" name="income2_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income2_Tax_field" name="income2_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income2_totalGross" name="income2_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 3</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income3_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income3_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income3_field" name="income3_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income3_NetComp_field" name="income3_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income3_Tax_field" name="income3_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income3_totalGross" name="income3_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 4</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income4_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income4_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income4_field" name="income4_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income4_NetComp_field" name="income4_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income4_Tax_field" name="income4_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income4_totalGross" name="income4_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 5</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income5_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income5_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income5_field" name="income5_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income5_NetComp_field" name="income5_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income5_Tax_field" name="income5_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income5_totalGross" name="income5_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 6</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income6_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income6_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income6_field" name="income6_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income6_NetComp_field" name="income6_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income6_Tax_field" name="income6_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income6_totalGross" name="income6_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Income 7</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income7_gross_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Gross</td>
										<td class="tg-yw4l">
											<div class="checkbox">
												<center>
													<input id="income7_nett_checkbox" type="checkbox">
												</center>
											</div>
										</td>
										<td class="tg-yw4l">Nett</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income7_field" name="income7_field" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income7_NetComp_field" name="income7_NetComp_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" disabled id="income7_Tax_field" name="income7_Tax_field" placeholder="" style="width:100px">
											</div>
										</td>
										<td class="tg-yw4l">
											<div class="form-group">
												<input class="form-control" id="income7_totalGross" name="income7_totalGross" style="width:100px">
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<table>
								<tbody>
									<tr>
										<td class="tg-yw4l" colspan="6" rowspan="2">
											<center>
												<input class="calculate-button" id="hitung_button" name="hitung_button" onclick="calculate();" style="height:40px;width:80px" type="button" value="Calculate"> <input class="result-button" onclick="result()" style="height:40px;width:80px" type="button" value="Result"> <input class="clear-button" onclick="resetForm()" style="height:40px;width:80px" type="button" value="Reset">
											</center>
										</td>
										<td class="tg-yw4l">Total Tax Component</td>
										<td class="tg-yw4l" colspan="2">
											<div class="form-group">
												<input class="form-control" disabled id="totalTaxComponent_field" name="totalTaxComponent_field" placeholder="" style="width:200px">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tg-yw4l">Total Take Home Pay</td>
										<td class="tg-yw4l" colspan="2">
											<div class="form-group">
												<input class="form-control" disabled id="total_take_home_pay" placeholder="" style="width:200px">
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</form>
	</center>