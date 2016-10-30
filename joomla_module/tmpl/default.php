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
?>
    <script type="text/javascript">
        function resetForm() {
            document.getElementById("myForm").reset();
        }

        var logger = function()
        {
            var oldConsoleLog = null;
            var pub = {};

            pub.enableLogger =  function enableLogger() 
                                {
                                    if(oldConsoleLog == null)
                                        return;

                                    window['console']['log'] = oldConsoleLog;
                                };

            pub.disableLogger = function disableLogger()
                                {
                                    oldConsoleLog = console.log;
                                    window['console']['log'] = function() {};
                                };

            return pub;
        }();
        //disable it when go live ;)
        logger.enableLogger();
        
        //function for gross nett approach button
        function GrossNettApproach_func(){
            ControlDisableGroup('SecondGroup',true);
            ControlDisableGroup('ThirdGroup',false);
            controlCheckbox('gross_basic_salary_checkbox', true);
            controlCheckbox('gross_insurance_checkbox', true);
            controlCheckbox('gros_jkjkk_checkbox', true);
            //should be in group - TFU
            var disabledId = ["BS_nettComp_field","BS_tax_field","insurance_NettComp_field","insurance_Tax_field",
                                "jkjkk_NettComp_field","jkjkk_Tax_field","income1_NetComp_field","income1_Tax_field",
                                "income2_NetComp_field","income2_Tax_field","income3_NetComp_field","income3_Tax_field",
                                "income4_NetComp_field","income4_Tax_field","income5_NetComp_field","income5_Tax_field",
                                "income6_NetComp_field","income6_Tax_field","income7_NetComp_field","income7_Tax_field"];
            
            for (var i = 0; i < disabledId.length; i++) {
                controlDisableId(disabledId[i], true);   
            }
        }

        //function for THP approach button
        function THPApproach_func(){
            ControlDisableGroup('SecondGroup',false);
            ControlDisableGroup('ThirdGroup',true);
            controlCheckbox('gross_basic_salary_checkbox', false);
            controlCheckbox('gross_insurance_checkbox', false);
            controlCheckbox('gros_jkjkk_checkbox', false);
            //should be in group - TFU
            var disabledId = ["tax_fixedIncome1_field","tax_fixedIncome2_field","nett_fixedIncome1_field","Tax_adjIncome_field",
                                "Nett_adjIncome_field","nett_fixedIncome2_field"];
            for (var i = 0; i < disabledId.length; i++){
                controlDisableId(disabledId[i], true);
            }

        }

        //disable-enable group from input data
        function ControlDisableGroup(table_id, bool)
        {
            var inputs=document.getElementById(table_id).getElementsByTagName('input');
            var selects=document.getElementById(table_id).getElementsByTagName('select');
            if(bool)
            {
                for(var i=0; i<inputs.length; ++i)
                    inputs[i].disabled=true;
                for(var i=0; i<selects.length; ++i)
                    selects[i].disabled=true;
            }
            else{
                for(var i=0; i<inputs.length; ++i)
                    inputs[i].disabled=false;
                for(var i=0; i<selects.length; ++i)
                    selects[i].disabled=false;
            }   
        }

        //enabled-disable Id from input data
        function controlDisableId(Id, bool){
            var object=document.getElementById(Id);
            if(bool)
                object.disabled=true;
            else
                object.disabled=false;
        }

        //checked-unchecked checkbox properties
        function controlCheckbox(Id, bool){
            var checkbox=document.getElementById(Id);
            if(bool)
                checkbox.checked =  true;
            else
                checkbox.checked = false;
        }

        //check checkbox status
        function isCheckboxChecked(Id){
            var isChecked = document.getElementById(Id).checked;
            if(isChecked) return true;
            else return false;
        }
        
        //get combobox status easier
        function getComboBoxStatus(Id){
            var _combobox = document.getElementById(Id);
            var _boxValue = _combobox.options[_combobox.selectedIndex].text;
            return _boxValue;
        }

        //return textbox value easier
        function getTextboxValue(Id){
            var _textboxValue = document.getElementById(Id).value;
            return _textboxValue;
        }

        //global variable here
        var PayCal = {};
        PayCal.TaxPembanding = 0;
        PayCal.TaxKomponen = 0;
        PayCal.PTKP=0;

        //find ptkp value based on ptkp combobox / tax status combobox
        function CariPTKP(){
            var _combobox = document.getElementById('tax_status_combobox');
            var _ptkp_boxValue = _combobox.options[_combobox.selectedIndex].text;
            var _ptkp_field = document.getElementById("ptkp_field");
            if( _ptkp_boxValue == "TK/0")
                _ptkp_field.value = 24300000;
            else if ( _ptkp_boxValue == "TK/1")
                _ptkp_field.value = 26325000;
            else if ( _ptkp_boxValue == "TK/2")
                _ptkp_field.value = 28350000;
            else if ( _ptkp_boxValue == "TK/3")
                _ptkp_field.value = 30375000;
            else if ( _ptkp_boxValue == "K/0")
                _ptkp_field.value = 26325000;
            else if ( _ptkp_boxValue == "K/1")
                _ptkp_field.value = 28350000;
            else if ( _ptkp_boxValue == "K/2")
                _ptkp_field.value = 30375000;
            else if ( _ptkp_boxValue == "K/3")
                _ptkp_field.value = 32400000;
            else if ( _ptkp_boxValue == "PH/0")
                _ptkp_field.value = 48600000;
            else if ( _ptkp_boxValue == "PH/1")
                _ptkp_field.value = 50625000;
            else if ( _ptkp_boxValue == "PH/2")
                _ptkp_field.value = 52650000;
            else if ( _ptkp_boxValue == "PH/3")
                _ptkp_field.value = 54675000; 
            PayCal.PTKP = parseInt(_ptkp_field.value);
            console.log("CariPTKP::PTKP : ",PayCal.PTKP);      
        }

        function SetJKJKKJPKValue(){
            var JKJKKJPKValue = getTextboxValue('jkjkkjpk_field');
            PayCal.JKJKKJPKValue = parseInt(JKJKKJPKValue);
            console.log("SetJKJKKJPKValue::JKJKKJPKValue : ",PayCal.JKJKKJPKValue);
        }

        function SetJHTValue(){
            var JHTValue = getTextboxValue('jht_field');
            PayCal.JHTValue = parseInt(JHTValue);
            console.log("SetJHTValue::JHTValue : ",PayCal.JHTValue);            
        }

        function CariJKJKKBulanan(){
            var JKJKK_field = document.getElementById("jkkjkk_field");
            PayCal.JKJKKBulanan = PayCal.pengaliJkJkk / PayCal.sisaBulan * PayCal.JKJKKJPKValue / 100 || 0;
            JKJKK_field.value = PayCal.JKJKKBulanan;
            console.log("CariJKJKKBulanan::JKJKKBulanan : ",PayCal.JKJKKBulanan);
        }

        function TextBox1BasicSalaryFocus(){
            var _BasicSalaryValue = getTextboxValue('basic_salary_field');
            PayCal.BasicSalaryValue = parseInt(_BasicSalaryValue);
            console.log("BasicSalary : ",PayCal.BasicSalaryValue);
            CariNett();
            CariBasicSetahun();
            cariSisaBulan();
            CariPengaliJkJkk();
            CariJKJKKBulanan();
            console.log("TextBox1BasicSalaryFocus::BasicSalary : ",PayCal.BasicSalaryValue);
        }

        function SetInsuranceApproach(){
            var _InsuranceApproach = getTextboxValue('insurance_field');
            PayCal.InsuranceValue = parseInt(_InsuranceApproach);
            console.log("SetInsuranceApproach::InsuranceApproach : ",PayCal.InsuranceValue);  
        }

        function SetInsurancePremiumValue(){
            var _InsurancePremiumValue = getTextboxValue('insurance_premium_field');
            PayCal.AsuransiSetahun = parseInt(_InsurancePremiumValue);
            console.log("SetInsurancePremiumValue::AsuransiSetahun : ",PayCal.AsuransiSetahun);
        }

        function SetJKKValue(){
            CariJKJKKBulanan();
            PayCal.JKKValue = PayCal.JKJKKBulanan;
            console.log("SetJKKValue::JKKValue : ",PayCal.JKKValue);
        }

        //find basic setahun :?
        function CariBasicSetahun(){
            var _basicSalary = document.getElementById('basic_salary_field').value;
            PayCal.basicSetahun=0;
            if(isCheckboxChecked('gross_basic_salary_checkbox'))
                PayCal.basicSetahun = PayCal.sisaBulan * _basicSalary;
            else
                PayCal.basicSetahun = PayCal.sisaBulan * (_basicSalary - PayCal.basicSetahun * PayCal.TaxKomponen);
            console.log("CariBasicSetahun::basicSetahun : ",PayCal.basicSetahun);
        }

        function SetJKJKKJPKSource(){
            var _jkjkk_boxValue = getComboBoxStatus('jkkjpk_combobox');
            PayCal.JKJKKJPKSource = String(_jkjkk_boxValue);
            console.log("SetJKJKKJPKSource::JKJKKJPKSource : ",PayCal.JKJKKJPKSource);
        }

        function SetJHTSource(){
            var _jht_boxValue = getComboBoxStatus('jhtsource');
            PayCal.JHTSource = _jht_boxValue;
            console.log("SetJHTSource::JHTSource : ",PayCal.JHTSource);            
        }

        //find multiply for jkjkk :?
        function CariPengaliJkJkk(){
            if ( PayCal.JKJKKJPKSource == "Basic Salary" )
            {
                PayCal.pengaliJkJkk = PayCal.basicSetahun || 0;
            }
            else if ( PayCal.JKJKKJPKSource == "Total Income" ){
                PayCal.PengaliJkJkk = PayCal.NettBasic + PayCal.NettInsurance + PayCal.NettIncome1 + PayCal.NettIncome2 + PayCal.NettIncome3 + PayCal.NettIncome4 + PayCal.NettIncome5 + PayCal.NettIncome6 + PayCal.NettIncome7 + (PayCal.sisaBulan * PayCal.TaxKomponen ) - ( PayCal.sisaBulan * PayCal.PercentJKK * PayCal.TaxKomponen || 0);
            }
            console.log("CariPengaliJkJkk::PengaliJkJkk : ",PayCal.pengaliJkJkk);
        }

        //find month left :?
        function cariSisaBulan(){
            var _combobox = document.getElementById('starting_month_combobox');
            var _StartingMonth_boxValue = _combobox.options[_combobox.selectedIndex].text;
            PayCal.sisaBulan = 0;
            if ( _StartingMonth_boxValue == "January" )
                PayCal.sisaBulan = 12;
            else if ( _StartingMonth_boxValue == "February" )
               PayCal.sisaBulan = 11;
            else if ( _StartingMonth_boxValue == "March" )
                PayCal.sisaBulan = 10;
            else if ( _StartingMonth_boxValue == "April" )
                PayCal.sisaBulan = 9;
            else if ( _StartingMonth_boxValue == "May" )
                PayCal.sisaBulan = 8;
            else if ( _StartingMonth_boxValue == "June" )
                PayCal.sisaBulan = 7;
            else if ( _StartingMonth_boxValue == "July" )
                PayCal.sisaBulan = 6;
            else if ( _StartingMonth_boxValue == "August" )
                PayCal.sisaBulan = 5;
            else if ( _StartingMonth_boxValue == "September" )
                PayCal.sisaBulan = 4;
            else if ( _StartingMonth_boxValue == "October" )
                PayCal.sisaBulan = 3;
            else if ( _StartingMonth_boxValue == "November" )
                PayCal.sisaBulan = 2;
            else if ( _StartingMonth_boxValue == "December" )
                PayCal.sisaBulan = 1;
            console.log("cariSisaBulan::sisaBulan : ",PayCal.sisaBulan);
        }

        function SetPrevNettIncome(){
            var _prevNettIncome = getTextboxValue('prev_nett_income_field');
            PayCal.PrevNettIncome = parseInt(_prevNettIncome);
            console.log("SetPrevNettIncome::PrevNettIncome : ",PayCal.PrevNettIncome);
        }

        function SetPrevTaxCollection(){
            var _prevTaxCollection = getTextboxValue('prev_tax_coll_field');
            PayCal.PrevTaxCollection = parseInt(_prevTaxCollection);
            console.log("SetPrevTaxCollection::PrevTaxCollection : ",PayCal.PrevTaxCollection);            
        }

        //find PKP
        function CariPKP(){
            var _TotalSementaraPlusSBLM = PayCal.TotalNett + PayCal.PrevNettIncome  + PayCal.sisaBulan * PayCal.TaxKomponen || 0;
            PayCal.PKP = _TotalSementaraPlusSBLM - PayCal.PTKP - (0.02 * PayCal.pengaliJkJkk) - PayCal.BiayaJabatan || 0;
            if(PayCal.PKP > 0) {
                PayCal.PKP = PayCal.PKP;
            }
            else{
                PayCal.PKP = 0;
            }
            console.log("==========CariPKP==========");
            console.log("CariPKP::PKP : ",PayCal.PKP);
            console.log("CariPKP::_TotalSementaraPlusSBLM : ", _TotalSementaraPlusSBLM);
            console.log("==========CariPKP==========");
        }

        //total nett
        function TotalNettSementara(){
            PayCal.TotalNett = parseInt(PayCal.NettBasic + PayCal.NettInsurance + PayCal.NettJKK + PayCal.NettIncome1 + PayCal.NettIncome2 + PayCal.NettIncome3 + PayCal.NettIncome4 + PayCal.NettIncome5 + PayCal.NettIncome6 + PayCal.NettIncome7) || 0;
            console.log("TotalNettSementara::TotalNett : ", PayCal.TotalNett);
        }

        //calculate position cost
        function CariBiayaJabatan(){
            var pembanding = PayCal.TotalNett + (12 * PayCal.TaxKomponen) * 0.05  || 0;
            if ( pembanding > 6000000)
                PayCal.BiayaJabatan = 6000000;
            else
                PayCal.BiayaJabatan = (PayCal.TotalNett + PayCal.sisaBulan * PayCal.TaxKomponen) * 0.05  || 0;
            console.log("CariBiayaJabatan::BiayaJabatan : ",PayCal.BiayaJabatan);
        }

        //calculate the tax
        function HitungPajak(){
            if ( PayCal.PKP <= 50000000 )
                PayCal.TaxPembanding = 0.05 * PayCal.PKP || 0;
            else if ( PayCal.PKP <= 250000000 && PKP > 50000000 )
                PayCal.TaxPembanding = 2500000 + (0.15 * (PayCal.PKP - 50000000)) || 0;
            else if ( PayCal.PKP <= 500000000 && PayCal.PKP > 250000000 )
                PayCal.TaxPembanding = 32500000 + (0.25 * (PayCal.PKP - 250000000) || 0);
            else if ( PayCal.PKP >= 500000000 )
                PayCal.TaxPembanding = 95000000 + (0.3 * (PayCal.PKP - 500000000)) || 0;
            console.log("==========HitungPajak==========");
            console.log("HitungPajak::TaxPembanding :",PayCal.TaxPembanding);
            console.log("HitungPajak::PKP :",PayCal.PKP);
            console.log("==========HitungPajak==========");
        }

        function CariTaxKomponenAwalLooping(){
            if ( PayCal.TaxPembanding === 0 )
                PayCal.TaxKomponen = 0;
            else if ( PayCal.TaxPembanding <= 120000 ) 
                PayCal.TaxKomponen = 100;
            else if ( PayCal.TaxPembanding <= 240000 )
                PayCal.TaxKomponen = 1000;
            else if ( PayCal.TaxPembanding <= 360000 )
                PayCal.TaxKomponen = 2000;
            else if ( PayCal.TaxPembanding <= 480000 )
                PayCal.TaxKomponen = 3000;
            else if ( PayCal.TaxPembanding <= 600000 )
                PayCal.TaxKomponen = 4000;
            else if ( PayCal.TaxPembanding <= 720000 ) 
                PayCal.TaxKomponen = 5000;
            else if ( PayCal.TaxPembanding <= 840000 )
                PayCal.TaxKomponen = 6000;
            else if ( PayCal.TaxPembanding <= 960000 )
                PayCal.TaxKomponen = 7000;
            else if ( PayCal.TaxPembanding <= 1080000 )
                PayCal.TaxKomponen = 8000;
            else if ( PayCal.TaxPembanding <= 1200000 )
                PayCal.TaxKomponen = 9000;
            else if ( PayCal.TaxPembanding <= 1500000 )
                PayCal.TaxKomponen = 10000;
            else if ( PayCal.TaxPembanding <= 3000000 )
                PayCal.TaxKomponen = 125000;
            else if ( PayCal.TaxPembanding <= 5000000 ) 
                PayCal.TaxKomponen = 250000;
            else if ( PayCal.TaxPembanding <= 9000000 )
                PayCal.TaxKomponen = 400000;
            else if ( PayCal.TaxPembanding <= 20000000 )
                PayCal.TaxKomponen = 750000;
            else if ( PayCal.TaxPembanding <= 50000000 )
                PayCal.TaxKomponen = 1650000;
            else if ( PayCal.TaxPembanding <= 75000000 )
                PayCal.TaxKomponen = 4100000;
            console.log("==========CariTaxKomponenAwalLooping==========");
            console.log("CariTaxKomponenAwalLooping::TaxKomponen :", PayCal.TaxKomponen);
            console.log("CariTaxKomponenAwalLooping::TaxPembanding :",PayCal.TaxPembanding);
            console.log("==========CariTaxKomponenAwalLooping==========");
        }

        function SetNettIncome1() {
            var _NettIncome1 = getTextboxValue('income1_field');
            PayCal.NettIncome1Value = parseInt(_NettIncome1);
            console.log("NettIncome1 : ", PayCal.NettIncome1Value);
        }

        function SetNettIncome2() {
            var _NettIncome2 = getTextboxValue('income2_field');
            PayCal.NettIncome2Value = parseInt(_NettIncome2);
            console.log("NettIncome2 : ", PayCal.NettIncome2Value);
        }

        function SetNettIncome3() {
            var _NettIncome3 = getTextboxValue('income3_field');
            PayCal.NettIncome3Value = parseInt(_NettIncome3);
            console.log("NettIncome3 : ", PayCal.NettIncome3Value);
        }

        function SetNettIncome4() {
            var _NettIncome4 = getTextboxValue('income4_field');
            PayCal.NettIncome4Value = parseInt(_NettIncome4);
            console.log("NettIncome4 : ", PayCal.NettIncome4Value);
        }

        function SetNettIncome5() {
            var _NettIncome5 = getTextboxValue('income5_field');
            PayCal.NettIncome5Value = parseInt(_NettIncome5);
            console.log("NettIncome5 : ", PayCal.NettIncome5Value);
        }

        function SetNettIncome6() {
            var _NettIncome6 = getTextboxValue('income6_field');
            PayCal.NettIncome6Value = parseInt(_NettIncome6);
            console.log("NettIncome6 : ", PayCal.NettIncome6Value);
        }

        function SetNettIncome7() {
            var _NettIncome7 = getTextboxValue('income7_field');
            PayCal.NettIncome7Value = parseInt(_NettIncome7);
            console.log("NettIncome7 : ", PayCal.NettIncome7Value);
        }


        function CariNett(){
            var isNettBasic = isCheckboxChecked('nett_basic_salary_checkbox');
            var isNettInsurance = isCheckboxChecked('nett_insurance_checkbox');
            var isNettJKK = isCheckboxChecked('nett_jkjkk_checkbox');
            var isNettIncome1 = isCheckboxChecked('income1_net_checkbox');
            var isNettIncome2 = isCheckboxChecked('income2_net_checkbox');
            var isNettIncome3 = isCheckboxChecked('income3_net_checkbox');
            var isNettIncome4 = isCheckboxChecked('income4_net_checkbox');
            var isNettIncome5 = isCheckboxChecked('income5_net_checkbox');
            var isNettIncome6 = isCheckboxChecked('income6_net_checkbox');
            var isNettIncome7 = isCheckboxChecked('income7_net_checkbox');

            //if(isNaN(PayCal.NettIncome1Value)) PayCal.NettIncome1Value=0;

            if(isNettBasic)
                PayCal.NettBasic = PayCal.sisaBulan * PayCal.BasicSalaryValue || 0;
            else if(!isNettBasic)
                PayCal.NettBasic = PayCal.sisaBulan * PayCal.BasicSalaryValue - PayCal.PercentBasic * PayCal.TaxKomponen || 0;

            if(isNettInsurance)
                PayCal.NettInsurance = PayCal.sisaBulan * PayCal.InsuranceValue || 0;
            else if(!isNettInsurance)
                PayCal.NettInsurance = PayCal.sisaBulan * PayCal.InsuranceValue - PayCal.PercentInsurance * PayCal.TaxKomponen || 0;

            if(isNettJKK)
                PayCal.NettJKK = PayCal.sisaBulan * PayCal.JKJKKBulanan || 0;
            else if(!isNettJKK)
                PayCal.NettJKK = PayCal.sisaBulan * PayCal.JKJKKBulanan - PayCal.PercentJKK * PayCal.TaxKomponen || 0;

            if(isNettIncome1)
                PayCal.NettIncome1 = PayCal.sisaBulan * PayCal.NettIncome1Value || 0;
            else if(!isNettIncome1)
                PayCal.NettIncome1 = PayCal.sisaBulan * PayCal.NettIncome1Value - PayCal.PercentIncome1 * PayCal.TaxKomponen || 0;
            
            if(isNettIncome2)
                PayCal.NettIncome2 = PayCal.sisaBulan * PayCal.NettIncome2Value || 0;
            else if(!isNettIncome2)
                PayCal.NettIncome2 = PayCal.sisaBulan * PayCal.NettIncome2Value - PayCal.PercentIncome2 * PayCal.TaxKomponen || 0;

            if(isNettIncome3)
                PayCal.NettIncome3 = PayCal.sisaBulan * PayCal.NettIncome3Value || 0;
            else if(!isNettIncome3)
                PayCal.NettIncome3 = PayCal.sisaBulan * PayCal.NettIncome3Value - PayCal.PercentIncome3 * PayCal.TaxKomponen || 0;

            if(isNettIncome4)
                PayCal.NettIncome4 = PayCal.sisaBulan * PayCal.NettIncome4Value || 0;
            else if(!isNettIncome4)
                PayCal.NettIncome4 = PayCal.sisaBulan * PayCal.NettIncome4Value - PayCal.PercentIncome4 * PayCal.TaxKomponen || 0;
            
            if(isNettIncome5)
                PayCal.NettIncome5 = PayCal.sisaBulan * PayCal.NettIncome5Value || 0;
            else if(!isNettIncome5)
                PayCal.NettIncome5 = PayCal.sisaBulan * PayCal.NettIncome5Value - PayCal.PercentIncome5 * PayCal.TaxKomponen || 0;
        
            if(isNettIncome6)
                PayCal.NettIncome6 = PayCal.sisaBulan * PayCal.NettIncome6Value || 0;
            else if(!isNettIncome6)
                PayCal.NettIncome6 = PayCal.sisaBulan * PayCal.NettIncome6Value - PayCal.PercentIncome6 * PayCal.TaxKomponen || 0;
            
            if(isNettIncome7)
                PayCal.NettIncome7 = PayCal.sisaBulan * PayCal.NettIncome7Value || 0;
            else if(!isNettIncome7)
                PayCal.NettIncome7 = PayCal.sisaBulan * PayCal.NettIncome7Value - PayCal.PercentIncome7 * PayCal.TaxKomponen || 0;
            
            console.log("==========CariNett==========");
            console.log("CariNett::NettBasic :",PayCal.NettBasic);
            console.log("CariNett::NettInsurance :",PayCal.NettInsurance);
            console.log("CariNett::NettJKK :",PayCal.NettJKK);
            console.log("CariNett::NettIncome1 :",PayCal.NettIncome1);
            console.log("CariNett::NettIncome2 :",PayCal.NettIncome2);
            console.log("CariNett::NettIncome3 :",PayCal.NettIncome3);
            console.log("CariNett::NettIncome4 :",PayCal.NettIncome4);
            console.log("CariNett::NettIncome5 :",PayCal.NettIncome5);
            console.log("CariNett::NettIncome6 :",PayCal.NettIncome6);
            console.log("CariNett::NettIncome7 :",PayCal.NettIncome7);
            console.log("CariNett::TaxKomponen :",PayCal.TaxKomponen);
            console.log("==========CariNett==========");
        }

        function CariPercent(){
            var BS_field = PayCal.BasicSalaryValue;
            var insurance_field = PayCal.InsuranceValue;
            var jkjkk_field = parseInt(PayCal.JKJKKBulanan);
            var income1_field = parseInt(PayCal.NettIncome1Value) || 0;
            var income2_field = parseInt(PayCal.NettIncome2Value) || 0;
            var income3_field = parseInt(PayCal.NettIncome3Value) || 0;
            var income4_field = parseInt(PayCal.NettIncome4Value) || 0;
            var income5_field = parseInt(PayCal.NettIncome5Value) || 0;
            var income6_field = parseInt(PayCal.NettIncome6Value) || 0;
            var income7_field = parseInt(PayCal.NettIncome7Value) || 0;
            var TotalSementara = parseInt(BS_field + insurance_field + jkjkk_field + income1_field + income2_field + income3_field + income4_field + income5_field + income6_field+ income7_field) || 0;

            PayCal.PercentBasic = BS_field / TotalSementara || 0;
            PayCal.PercentInsurance = insurance_field / TotalSementara || 0;
            PayCal.PercentJKK = jkjkk_field / TotalSementara || 0;
            PayCal.PercentIncome1 = income1_field / TotalSementara || 0;
            PayCal.PercentIncome2 = income2_field / TotalSementara || 0;
            PayCal.PercentIncome3 = income3_field / TotalSementara || 0;
            PayCal.PercentIncome4 = income4_field / TotalSementara || 0;
            PayCal.PercentIncome5 = income5_field / TotalSementara || 0;
            PayCal.PercentIncome6 = income6_field / TotalSementara || 0;
            PayCal.PercentIncome7 = income7_field / TotalSementara || 0;

            console.log("==========CariPercent==========");
            console.log("CariPercent::PercentBasic :",PayCal.PercentBasic);
            console.log("CariPercent::PercentInsurance :",PayCal.PercentInsurance);
            console.log("CariPercent::PercentJKK :",PayCal.PercentJKK);
            console.log("CariPercent::PercentIncome1 :",PayCal.PercentIncome1);
            console.log("CariPercent::PercentIncome2 :",PayCal.PercentIncome2);
            console.log("CariPercent::PercentIncome3 :",PayCal.PercentIncome3);
            console.log("CariPercent::PercentIncome4 :",PayCal.PercentIncome4);
            console.log("CariPercent::PercentIncome5 :",PayCal.PercentIncome5);
            console.log("CariPercent::PercentIncome6 :",PayCal.PercentIncome6);
            console.log("CariPercent::PercentIncome7 :",PayCal.PercentIncome7);
            console.log("CariPercent::TotalSementara : ",TotalSementara);
            console.log("==========CariPercent==========");
        }

        //calculate button
        function calculate() {
            CariTaxKomponenAwalLooping();
            CariPengaliJkJkk();
            CariPTKP();
            CariPercent();
            CariNett();
            CariBasicSetahun();
            TotalNettSementara();
            cariSisaBulan();
            CariBiayaJabatan();
            CariPKP();
            HitungPajak();    
        }
        //result button
        function result(){
            var NettBasicAkhir = document.getElementById('BS_nettComp_field');
            var NettInsuranceAkhir = document.getElementById('insurance_NettComp_field');
            var NettJKKAkhir = document.getElementById('jkjkk_NettComp_field');
            var NettIncome1Akhir = document.getElementById('income1_NetComp_field');
            var NettIncome2Akhir = document.getElementById('income2_NetComp_field');
            var NettIncome3Akhir = document.getElementById('income3_NetComp_field');
            var NettIncome4Akhir = document.getElementById('income4_NetComp_field');
            var NettIncome5Akhir = document.getElementById('income5_NetComp_field');
            var NettIncome6Akhir = document.getElementById('income6_NetComp_field'); 
            var NettIncome7Akhir = document.getElementById('income7_NetComp_field');

            var TaxBasicAkhir = document.getElementById('BS_tax_field');
            var TaxInsuranceAkhir = document.getElementById('insurance_Tax_field');
            var TaxJKKAkhir = document.getElementById('jkjkk_Tax_field'); 
            var TaxIncome1Akhir = document.getElementById('income1_Tax_field'); 
            var TaxIncome2Akhir = document.getElementById('income2_Tax_field');
            var TaxIncome3Akhir = document.getElementById('income3_Tax_field');
            var TaxIncome4Akhir = document.getElementById('income4_Tax_field');
            var TaxIncome5Akhir = document.getElementById('income5_Tax_field');
            var TaxIncome6Akhir = document.getElementById('income6_Tax_field');
            var TaxIncome7Akhir = document.getElementById('income7_Tax_field');

            var TotalGrossBasicSalary = document.getElementById('BS_totalGross');
            var TotalGrossInsurance = document.getElementById('insurance_totalGross');
            var TotalGrossJKK = document.getElementById('jkjkk_totalGross');
            var TotalGrossIncome1 = document.getElementById('income1_totalGross');
            var TotalGrossIncome2 = document.getElementById('income2_totalGross');
            var TotalGrossIncome3 = document.getElementById('income3_totalGross');
            var TotalGrossIncome4 = document.getElementById('income4_totalGross');
            var TotalGrossIncome5 = document.getElementById('income5_totalGross');
            var TotalGrossIncome6 = document.getElementById('income6_totalGross');
            var TotalGrossIncome7 = document.getElementById('income7_totalGross');

            var TotalTaxKomponen = document.getElementById('totalTaxComponent_field');
            var TotalTakeHomePay = document.getElementById('total_take_home_pay');

            CariTaxKomponenAwalLooping();
            do {
                PayCal.TaxKomponen = PayCal.TaxKomponen * 1.00025;
                CariPercent();  
                CariNett();
                CariPTKP();
                CariBasicSetahun();
                TotalNettSementara();
                CariBiayaJabatan();
                CariPengaliJkJkk();
                cariSisaBulan();
                CariPKP();
                HitungPajak();

                PayCal.TaxPembanding = PayCal.TaxPembanding;
                PayCal.TaxKomponen = PayCal.TaxKomponen * 12;
                NettBasicAkhir.value = PayCal.NettBasic / PayCal.sisaBulan || 0;
                NettInsuranceAkhir.value = PayCal.NettInsurance / PayCal.sisaBulan || 0;
                NettJKKAkhir.value = PayCal.NettJKK / PayCal.sisaBulan || 0;
                NettIncome1Akhir.value = PayCal.NettIncome1 / PayCal.sisaBulan || 0;
                NettIncome2Akhir.value = PayCal.NettIncome2 / PayCal.sisaBulan || 0;
                NettIncome3Akhir.value = PayCal.NettIncome3 / PayCal.sisaBulan || 0;
                NettIncome4Akhir.value = PayCal.NettIncome4 / PayCal.sisaBulan || 0;
                NettIncome5Akhir.value = PayCal.NettIncome5 / PayCal.sisaBulan || 0;
                NettIncome6Akhir.value = PayCal.NettIncome6 / PayCal.sisaBulan || 0;
                NettIncome7Akhir.value = PayCal.NettIncome7 / PayCal.sisaBulan || 0;

                TaxBasicAkhir.value = PayCal.TaxKomponen * PayCal.PercentBasic || 0;
                TaxInsuranceAkhir.value = PayCal.TaxKomponen * PayCal.PercentInsurance || 0;
                TaxJKKAkhir.value = PayCal.TaxKomponen * PayCal.PercentJKK || 0;
                TaxIncome1Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome1 || 0;
                TaxIncome2Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome2 || 0;
                TaxIncome3Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome3 || 0;
                TaxIncome4Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome4 || 0;
                TaxIncome5Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome5 || 0;
                TaxIncome6Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome6 || 0;
                TaxIncome7Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome7 || 0;

                TotalGrossBasicSalary.value = ( PayCal.NettBasic / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentBasic ) || 0;
                TotalGrossInsurance.value = ( PayCal.NettInsurance / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentInsurance ) || 0;
                TotalGrossJKK.value = ( PayCal.NettJKK / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentJKK ) || 0;
                TotalGrossIncome1.value = ( PayCal.NettIncome1 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome1 ) || 0;
                TotalGrossIncome2.value = ( PayCal.NettIncome2 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome2 ) || 0;
                TotalGrossIncome3.value = ( PayCal.NettIncome3 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome3 ) || 0;
                TotalGrossIncome4.value = ( PayCal.NettIncome4 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome4 ) || 0;
                TotalGrossIncome5.value = ( PayCal.NettIncome5 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome5 ) || 0;
                TotalGrossIncome6.value = ( PayCal.NettIncome6 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome6 ) || 0;
                TotalGrossIncome7.value = ( PayCal.NettIncome7 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome7 ) || 0;

                TotalTaxKomponen.value = PayCal.TaxKomponen;
                TotalTakeHomePay.value = ( PayCal.NettBasic / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentBasic ) +
                ( PayCal.NettIncome1 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome1 ) +
                ( PayCal.NettIncome2 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome2 ) +
                ( PayCal.NettIncome3 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome3 ) +
                ( PayCal.NettIncome4 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome4 ) +
                ( PayCal.NettIncome5 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome5 ) +
                ( PayCal.NettIncome6 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome6 ) +
                ( PayCal.NettIncome7 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome7 ) -
                PayCal.JHTValue - PayCal.TaxKomponen;
            } while ( PayCal.TaxPembanding - 12 * PayCal.TaxKomponen < 100 );        
        }
        </script> <!-- its begin here -->
         <!-- Start point for main form -->
        <form id="myForm" name="myForm">
            <!-- first part -->
            <table class="table table-striped table-hover" id="FirstGroup">
                <tbody>
                    <tr>
                        <td>
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            Tax Status
                                        </td>
                                        <td>
                                            <select class="form-control" id=
                                            "tax_status_combobox" name=
                                            "tax_status_combobox" onchange="CariPTKP()">
                                                <option disabled selected
                                                value="">
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
                                            </select>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" id=
                                                "ptkp_field" name=
                                                "ptkp_field" type=
                                                "text" >
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            JK/JKK/JPK (%)
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" id=
                                                "jkjkkjpk_field" name=
                                                "jkjkkjpk_field" type="number" onchange="SetJKJKKJPKValue()">
                                            </div>
                                        </td>
                                        <td>
                                            <label class=
                                            "col-lg-2 control-label" for=
                                            "select">From</label>
                                            <select class='form-control' id=
                                            "jkkjpk_combobox" name="jkkjpk_combobox" onchange="SetJKJKKJPKSource()">
                                                <option disabled selected
                                                value="">
                                                    </option>
                                                <option value="Basic Salary">
                                                    Basic Salary
                                                </option>
                                                <option value="Total Income">
                                                    Total Income
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            JHT Employee (%)
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" id=
                                                "jht_field" name="jht_field"
                                                type="number" onchange="SetJHTValue()">
                                            </div>
                                        </td>
                                        <td>
                                            <label class=
                                            "col-lg-2 control-label" for=
                                            "select">From</label>
                                            <select class='form-control' id=
                                            "jhtsource" name="jhtsource" onchange="SetJHTSource()">
                                                <option disabled selected
                                                value="">
                                                    </option>
                                                <option value="Basic Salary">
                                                    Basic Salary
                                                </option>
                                                <option value="Total Income">
                                                    Total Income
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            Insurance Premium
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" id=
                                                "insurance_premium_field" name=
                                                "insurance_premium_field" type=
                                                "number" onchange="SetInsurancePremiumValue()">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Starting month
                                        </td>
                                        <td>
                                            <select class='form-control' id=
                                            "starting_month_combobox" name=
                                            "starting_month_combobox" onchange="cariSisaBulan()">
                                                <option disabled selected
                                                value="">
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
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            Previous NETT Income
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" id=
                                                "prev_nett_income_field" name=
                                                "prev_nett_income_field" type=
                                                "number" onchange="SetPrevNettIncome()">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Previous Tax Collection
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control" id=
                                                "prev_tax_coll_field" name=
                                                "prev_tax_coll_field" type=
                                                "number" onchange="SetPrevTaxCollection()">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="btn btn-primary"
                                            onclick="GrossNettApproach_func()"
                                            type="button" value=
                                            "Gross/Nett Approach">
                                        </td>
                                        <td>
                                            <input class="btn btn-primary"
                                            onclick="THPApproach_func()" type=
                                            "button" value="THP Approach">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table><!-- part 2 -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>
                        THP Approach
                    </h4>
                </div>
            </div>
            <table class="table table-striped table-hover" id="SecondGroup">
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            Nett Component
                        </td>
                        <td>
                            Tax
                        </td>
                        <td>
                            Total GROSS
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Target THP
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "targetTHP_field" name="targetTHP_field" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            Adj. Income
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "Nett_adjIncome_field" name=
                                "Nett_adjIncome_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "Tax_adjIncome_field" name=
                                "Tax_adjIncome_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "totalGross_adjIncome" name=
                                "totalGross_adjIncome" type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Fixed Income1
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "fixedIncome1_field" name="fixedIncome1_field"
                                type="number">
                            </div>
                        </td>
                        <td>
                            Fixed Income1
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "nett_fixedIncome1_field" name=
                                "nett_fixedIncome1_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "tax_fixedIncome1_field" name=
                                "tax_fixedIncome1_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "totalGrossFixedIncome1" name=
                                "totalGrossFixedIncome1" type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Fixed Income2
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "fixedIncome2_field" name="fixedIncome2_field"
                                type="number">
                            </div>
                        </td>
                        <td>
                            Fixed Income2
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "nett_fixedIncome2_field" name=
                                "nett_fixedIncome2_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "tax_fixedIncome2_field" name=
                                "tax_fixedIncome2_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "totalGrossFixedIncome2" name=
                                "totalGrossFixedIncome2" type="number">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table><!-- Part 3 -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>
                        Gross / Nett Approach
                    </h4>
                </div>
            </div>
            <table class="table table-striped table-hover" id="ThirdGroup">
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            Nett Component
                        </td>
                        <td>
                            Tax
                        </td>
                        <td>
                            Total GROSS
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Basic Salary
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="gross_basic_salary_checkbox"
                                type="checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="nett_basic_salary_checkbox"
                                type="checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "basic_salary_field" name="basic_salary_field"
                                type="number" onchange="TextBox1BasicSalaryFocus()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "BS_nettComp_field" name="BS_nettComp_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "BS_tax_field" name="BS_tax_field" placeholder=
                                "" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="BS_totalGross"
                                name="BS_totalGross" type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Insurance
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="gross_insurance_checkbox"
                                type="checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="nett_insurance_checkbox"
                                type="checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "insurance_field" name="insurance_field" type=
                                "number" onchange="SetInsuranceApproach()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "insurance_NettComp_field" name=
                                "insurance_NettComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "insurance_Tax_field" name=
                                "insurance_Tax_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "insurance_totalGross" name=
                                "insurance_totalGross" type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            JK / JKK
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="gros_jkjkk_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="nett_jkjkk_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="jkkjkk_field"
                                name="jkkjkk_field" type="number" onchange="SetJKKValue()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "jkjkk_NettComp_field" name=
                                "jkjkk_NettComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "jkjkk_Tax_field" name="jkjkk_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "jkjkk_totalGross" name="jkjkk_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 1
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income1_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income1_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income1_field"
                                name="income1_field" type="number" onchange="SetNettIncome1()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income1_NetComp_field" name=
                                "income1_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income1_Tax_field" name="income1_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income1_totalGross" name="income1_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 2
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income2_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income2_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income2_field"
                                name="income2_field" type="number" onchange="SetNettIncome2()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income2_NetComp_field" name=
                                "income2_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income2_Tax_field" name="income2_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income2_totalGross" name="income2_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 3
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income3_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income3_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income3_field"
                                name="income3_field" type="number" onchange="SetNettIncome3()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income3_NetComp_field" name=
                                "income3_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income3_Tax_field" name="income3_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income3_totalGross" name="income3_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 4
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income4_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income4_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income4_field"
                                name="income4_field" type="number" onchange="SetNettIncome4()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income4_NetComp_field" name=
                                "income4_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income4_Tax_field" name="income4_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income4_totalGross" name="income4_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 5
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income5_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income5_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income5_field"
                                name="income5_field" type="number" onchange="SetNettIncome5()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income5_NetComp_field" name=
                                "income5_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income5_Tax_field" name="income5_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income5_totalGross" name="income5_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 6
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income6_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income6_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income6_field"
                                name="income6_field" type="number" onchange="SetNettIncome6()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income6_NetComp_field" name=
                                "income6_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income6_Tax_field" name="income6_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income6_totalGross" name="income6_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Income 7
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income7_gross_checkbox" type=
                                "checkbox"> Gross</label>
                            </div>
                        </td>
                        <td>
                            <div class="checkbox">
                                <label><input id="income7_net_checkbox" type=
                                "checkbox"> Nett</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id="income7_field"
                                name="income7_field" type="number" onchange="SetNettIncome7()">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income7_NetComp_field" name=
                                "income7_NetComp_field" placeholder="" type=
                                "number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" disabled id=
                                "income7_Tax_field" name="income7_Tax_field"
                                placeholder="" type="number">
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <input class="form-control" id=
                                "income7_totalGross" name="income7_totalGross"
                                type="number">
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <td>
                            <input class="btn btn-primary" id="hitung_button"
                            name="hitung_button" onclick="calculate();" type=
                            "button" value="Calculate">
                        </td>
                        <td>
                            <input class="btn btn-primary" onclick="result()"
                            type="button" value="Result">
                        </td>
                        <td>
                            <input class="btn btn-primary" onclick=
                            "resetForm()" type="button" value="Reset">
                        </td>
                        <td>
                            <table class="table table-striped table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            Total Tax Component
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control"
                                                disabled id="disabledInput"
                                                name="totalTaxComponent_field"
                                                placeholder="" type="number">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Total Take Home Pay
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input class="form-control"
                                                disabled id=
                                                "total_take_home_pay"
                                                placeholder="" type="number">
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