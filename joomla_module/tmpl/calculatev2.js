		function resetForm() {
            document.getElementById("PayrollCalculator").reset();
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

        Number.prototype.formatMoney = function(c, d, t){
        var n = this, 
            c = isNaN(c = Math.abs(c)) ? 0 : c, 
            d = d == undefined ? "," : d, 
            t = t == undefined ? "." : t, 
            s = n < 0 ? "-" : "", 
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };       

        //function for gross nett approach button as button1 in vb script
        function GrossNettApproach_func(){
            var _comboboxMonth = document.getElementById('starting_month_combobox');
            if ( _comboboxMonth.value ==""){
                alert('Bulan Mulai belum dimasukan');
            }
            else{
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
                var BS_field = document.getElementById('basic_salary_field');
                BS_field.focus();
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

	var PayCal = {};
	
	function resetForm() {
		document.getElementById("PayrollCalculator").reset();
	}
	
	//button function - start
	//calculate button
	function calculate(){
		SimpanJkJkkJpk();
		SimpanJkJkkJpkSource();
		SimpanJhtEmployee();
		SimpanJhtSource();
		SimpanInsurancePremium();
		SimpanStartingMonth();
		SimpanPrevNettIncome();
		SimpanPrevTaxCollection();
		SimpanTargetTHP();
		SimpanFixedIncome1();
		SimpanFixedIncome2();
		SimpanBSGrossCb();
		SimpanInsuranceGrossCb();
		SimpanJkJkkGrossCb();
		SimpanIncome1GrossCb();
		SimpanIncome2GrossCb();
		SimpanIncome3GrossCb();
		SimpanIncome4GrossCb();
		SimpanIncome5GrossCb();
		SimpanIncome6GrossCb();
		SimpanIncome7GrossCb();
		SimpanBSnettCb();
		SimpanInsurancenettCb();
		SimpanJkJkknettCb()
		SimpanIncome1nettCb();
		SimpanIncome2nettCb();
		SimpanIncome3nettCb();
		SimpanIncome4nettCb();
		SimpanIncome5nettCb();
		SimpanIncome6nettCb();
		SimpanIncome7nettCb();
		SimpanBasicSalary();
		SimpanIncome1();
		SimpanIncome2();
		SimpanIncome3();
		SimpanIncome4();
		SimpanIncome5();
		SimpanIncome6();
		SimpanIncome7();
		HitungInsurance();
		CariPengaliJkJkk();
		CariBasicSetahun();
		CariJKJKKBulanan();
		CariPengaliJkJkk();
		CariPTKP();
		CariPercent();
		CariNett();
        CariBasicSetahun();
        TotalNettSementara();
        CariBiayaJabatan();
        CariPKP();
        HitungPajak();
		HitungInsurance();
		CariPengaliJkJkk();
		CariBasicSetahun();
		CariJKJKKBulanan();
		CariPengaliJkJkk();
		CariPTKP();
		CariPercent();
		CariNett();
        CariBasicSetahun();
        TotalNettSementara();
        CariBiayaJabatan();
        CariPKP();
        HitungPajak();
		PayCal.txtTaxPembanding = PayCal.TaxPembanding;
		console.log("calculate::txtTaxPembanding :",PayCal.txtTaxPembanding);
	}
	
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
		PayCal.TaxPembanding = 1;
		PayCal.TaxKomponen = 1;
		CariTaxKomponenAwalLooping();
		var pembandingnya = PayCal.TaxPembanding - 12 * PayCal.TaxKomponen;
		console.log("looping awal : ", pembandingnya);
		var pengali = 1.00025;
		if(pembandingnya === 0)
		{
			alert('Cek kembali input anda')
		}
		else{
			do {
				PayCal.TaxKomponen = PayCal.TaxKomponen * pengali;
				CariPercent();  
				CariNett();
				CariPTKP();
				CariBasicSetahun();
				TotalNettSementara();
				CariBiayaJabatan();
				CariPengaliJkJkk();
				CariSisaBulan();
				CariPKP();
				HitungPajak();
				PayCal.txtTaxPembanding = PayCal.TaxPembanding;
				console.log("calculate::txtTaxPembanding :",PayCal.txtTaxPembanding);
				NettBasicAkhir.value = PayCal.NettBasic / PayCal.sisaBulan || 0;
				NettInsuranceAkhir.value = (PayCal.NettInsurance / PayCal.sisaBulan) || 0;
				NettJKKAkhir.value = PayCal.NettJKK / PayCal.sisaBulan || 0;
				NettIncome1Akhir.value = PayCal.NettIncome1 / PayCal.sisaBulan || 0;
				NettIncome2Akhir.value = PayCal.NettIncome2 / PayCal.sisaBulan || 0;
				NettIncome3Akhir.value = PayCal.NettIncome3 / PayCal.sisaBulan || 0;
				NettIncome4Akhir.value = PayCal.NettIncome4 / PayCal.sisaBulan || 0;
				NettIncome5Akhir.value = PayCal.NettIncome5 / PayCal.sisaBulan || 0;
				NettIncome6Akhir.value = PayCal.NettIncome6 / PayCal.sisaBulan || 0;
				NettIncome7Akhir.value = PayCal.NettIncome7 / PayCal.sisaBulan || 0;

				TaxBasicAkhir.value = (PayCal.TaxKomponen * PayCal.PercentBasic) || 0;
				TaxInsuranceAkhir.value = (PayCal.TaxKomponen * PayCal.PercentInsurance) || 0;
				TaxJKKAkhir.value = PayCal.TaxKomponen * PayCal.PercentJKK || 0;
				TaxIncome1Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome1 || 0;
				TaxIncome2Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome2 || 0;
				TaxIncome3Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome3 || 0;
				TaxIncome4Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome4 || 0;
				TaxIncome5Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome5 || 0;
				TaxIncome6Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome6 || 0;
				TaxIncome7Akhir.value = PayCal.TaxKomponen * PayCal.PercentIncome7 || 0;

				TotalGrossBasicSalary.value = parseInt(( PayCal.NettBasic / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentBasic )) || 0;
				TotalGrossInsurance.value = parseInt(( PayCal.NettInsurance / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentInsurance )) || 0;
				TotalGrossJKK.value = ( PayCal.NettJKK / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentJKK ) || 0;
				TotalGrossIncome1.value = ( PayCal.NettIncome1 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome1 ) || 0;
				TotalGrossIncome2.value = ( PayCal.NettIncome2 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome2 ) || 0;
				TotalGrossIncome3.value = ( PayCal.NettIncome3 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome3 ) || 0;
				TotalGrossIncome4.value = ( PayCal.NettIncome4 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome4 ) || 0;
				TotalGrossIncome5.value = ( PayCal.NettIncome5 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome5 ) || 0;
				TotalGrossIncome6.value = ( PayCal.NettIncome6 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome6 ) || 0;
				TotalGrossIncome7.value = ( PayCal.NettIncome7 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome7 ) || 0;

				TotalTaxKomponen.value = (PayCal.TaxKomponen).formatMoney();
				TotalTakeHomePay.value = (( PayCal.NettBasic / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentBasic ) +
				( PayCal.NettIncome1 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome1 ) +
				( PayCal.NettIncome2 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome2 ) +
				( PayCal.NettIncome3 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome3 ) +
				( PayCal.NettIncome4 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome4 ) +
				( PayCal.NettIncome5 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome5 ) +
				( PayCal.NettIncome6 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome6 ) +
				( PayCal.NettIncome7 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome7 ) -
				PayCal.JHTValue - PayCal.TaxKomponen).formatMoney();
				pembandingnya++;
				console.log("looping akhir : ", PayCal.TaxPembanding - 12 * PayCal.TaxKomponen);
				console.log("TotalTakeHomePay: ",TotalTakeHomePay.value);
			} 
			while ( pembandingnya < 100 );    
		}
			
	}
	//button function end
	
	//fungsi main table or first table - start
	//find ptkp value based on ptkp combobox / tax status combobox
	function CariPTKP(){
		var _combobox = document.PayrollCalculator.tax_status_combobox;
		var _ptkp_boxValue = _combobox.options[_combobox.selectedIndex].text;
		var _ptkp_field = document.PayrollCalculator.ptkp_field;
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
		PayCal.PTKP = parseInt(_ptkp_field.value) || 0;
		console.log("CariPTKP::PTKP : ",PayCal.PTKP);      
	}
	
	//persen jk-jkk-jpk
	function SimpanJkJkkJpk(){
		PayCal.JKJKKJPKValue = parseInt(document.PayrollCalculator.jkjkkjpk_field.value) || 0;
		console.log("SimpanJkJkkJpk::JKJKKJPKValue : ",PayCal.JKJKKJPKValue);
	}
	
	//source dari jk-jkk-jpk
	function SimpanJkJkkJpkSource(){
		PayCal.JKJKKJPKSource = document.PayrollCalculator.jkkjpk_combobox.value;
		console.log("SimpanJkJkkJpkSource::JKJKKJPKSource : ",PayCal.JKJKKJPKSource);
	}
	
	//persen jht employee
	function SimpanJhtEmployee(){
		PayCal.JHTValue = parseInt(document.PayrollCalculator.jht_field.value) || 0;
		console.log("SimpanJhtEmployee::JHTValue : ",PayCal.JHTValue); 
	}
	
	//source dari jht employee
	function SimpanJhtSource(){
		PayCal.JHTSource = document.PayrollCalculator.jhtsource.value;
		console.log("SimpanJhtSource::JHTSource : ",PayCal.JHTSource); 
	}
	
	//nilai insurance premium
	function SimpanInsurancePremium(){
		PayCal.AsuransiSetahun = parseInt(document.PayrollCalculator.insurance_premium_field.value) || 0;
		console.log("SimpanInsurancePremium::AsuransiSetahun : ",PayCal.AsuransiSetahun);
	}
	
	//nilai starting month
	function SimpanStartingMonth(){
		var _StartingMonth_boxValue = document.PayrollCalculator.starting_month_combobox.value;
		if ( _StartingMonth_boxValue == "January" )
			PayCal.SisaBulan = 12;
		else if ( _StartingMonth_boxValue == "February" )
		   PayCal.SisaBulan = 11;
		else if ( _StartingMonth_boxValue == "March" )
			PayCal.SisaBulan = 10;
		else if ( _StartingMonth_boxValue == "April" )
			PayCal.SisaBulan = 9;
		else if ( _StartingMonth_boxValue == "May" )
			PayCal.SisaBulan = 8;
		else if ( _StartingMonth_boxValue == "June" )
			PayCal.SisaBulan = 7;
		else if ( _StartingMonth_boxValue == "July" )
			PayCal.SisaBulan = 6;
		else if ( _StartingMonth_boxValue == "August" )
			PayCal.SisaBulan = 5;
		else if ( _StartingMonth_boxValue == "September" )
			PayCal.SisaBulan = 4;
		else if ( _StartingMonth_boxValue == "October" )
			PayCal.SisaBulan = 3;
		else if ( _StartingMonth_boxValue == "November" )
			PayCal.SisaBulan = 2;
		else if ( _StartingMonth_boxValue == "December" )
			PayCal.SisaBulan = 1;
		console.log("SimpanStartingMonth::SisaBulan : ",PayCal.SisaBulan);
	}
	
	//nilai previuous nett income
	function SimpanPrevNettIncome(){
		PayCal.PrevNettIncome = parseInt(document.PayrollCalculator.prev_nett_income_field.value) || 0;
		console.log("SimpanPrevNettIncome::PrevNettIncome : ",PayCal.PrevNettIncome);
	}
	
	//nilai previous tax collection
	function SimpanPrevTaxCollection(){
		PayCal.PrevTaxCollection = parseInt(document.PayrollCalculator.prev_tax_coll_field.value) ||0 ;
		console.log("SimpanPrevTaxCollection::PrevTaxCollection : ",PayCal.PrevTaxCollection);            
	}
	//fungsi main table or first table - end
	
	//fungsi dalam table thp approach - start
	//nilai target thp
	function SimpanTargetTHP(){
		PayCal.THP = parseInt(document.PayrollCalculator.targetTHP_field.value) || 0;
		console.log("SimpanTargetTHP::targetTHP : ",PayCal.THP);            
	}
	
	//nilai fixed income1
	function SimpanFixedIncome1(){
		PayCal.FixedIncome1 = parseInt(document.PayrollCalculator.fixedIncome1_field.value) || 0;
		console.log("SimpanFixedIncome1::FixedIncome1 : ",PayCal.FixedIncome1);  
	}
	
	//nilai fixed income2
		function SimpanFixedIncome2(){
		PayCal.FixedIncome2 = parseInt(document.PayrollCalculator.fixedIncome2_field.value) || 0;
		console.log("SimpanFixedIncome2::FixedIncome2 : ",PayCal.FixedIncome2);  
	}
	//fungsi dalam table thp approach - end
	
	//fungsi dalam table gross/nett approach
	//basic salary gross checkbox
	function SimpanBSGrossCb(){
		PayCal.isBSGrossCB = document.PayrollCalculator.gross_basic_salary_checkbox.checked;
		console.log("SimpanBSGrossCb::isBSGrossCB : ",PayCal.isBSGrossCB);
	}
	
	//insurance gross checkbox
	function SimpanInsuranceGrossCb(){
		PayCal.isInsuranceGrossCB = document.PayrollCalculator.gross_insurance_checkbox.checked;
		console.log("SimpanInsuranceGrossCb::isInsuranceGrossCB : ",PayCal.isInsuranceGrossCB);
	}
	
	//jk-jkk gross checkbox
	function SimpanJkJkkGrossCb(){
		PayCal.isJkJkkGrossCB = document.PayrollCalculator.gros_jkjkk_checkbox.checked;
		console.log("SimpanInsuranceGrossCb::isJkJkkGrossCB : ",PayCal.isJkJkkGrossCB);
	}
	
	//income1 gross checkbox
	function SimpanIncome1GrossCb(){
		PayCal.isIncome1GrossCB = document.PayrollCalculator.income1_gross_checkbox.checked;
		console.log("SimpanIncome1GrossCb::isIncome1GrossCB : ",PayCal.isIncome1GrossCB);
	}
	
	//income2 gross checkbox
	function SimpanIncome2GrossCb(){
		PayCal.isIncome2GrossCB = document.PayrollCalculator.income2_gross_checkbox.checked;
		console.log("SimpanIncome2GrossCb::isIncome2GrossCB : ",PayCal.isIncome2GrossCB);
	}
	
	//income3 gross checkbox
	function SimpanIncome3GrossCb(){
		PayCal.isIncome3GrossCB = document.PayrollCalculator.income3_gross_checkbox.checked;
		console.log("SimpanIncome3GrossCb::isIncome3GrossCB : ",PayCal.isIncome3GrossCB);
	}
	
	//income4 gross checkbox
	function SimpanIncome4GrossCb(){
		PayCal.isIncome4GrossCB = document.PayrollCalculator.income4_gross_checkbox.checked;
		console.log("SimpanIncome4GrossCb::isIncome4GrossCB : ",PayCal.isIncome4GrossCB);
	}
	
	//income5 gross checkbox
	function SimpanIncome5GrossCb(){
		PayCal.isIncome5GrossCB = document.PayrollCalculator.income5_gross_checkbox.checked;
		console.log("SimpanIncome5GrossCb::isIncome5GrossCB : ",PayCal.isIncome5GrossCB);
	}
	
	//income6 gross checkbox
	function SimpanIncome6GrossCb(){
		PayCal.isIncome6GrossCB = document.PayrollCalculator.income6_gross_checkbox.checked;
		console.log("SimpanIncome6GrossCb::isIncome6GrossCB : ",PayCal.isIncome6GrossCB);
	}
	
	//income7 gross checkbox
	function SimpanIncome7GrossCb(){
		PayCal.isIncome7GrossCB = document.PayrollCalculator.income7_gross_checkbox.checked;
		console.log("SimpanIncome7GrossCb::isIncome7GrossCB : ",PayCal.isIncome7GrossCB);
	}
	
		//basic salary nett checkbox
	function SimpanBSnettCb(){
		PayCal.isBSnettCB = document.PayrollCalculator.nett_basic_salary_checkbox.checked;
		console.log("SimpanBSnettCb::isBSnettCB : ",PayCal.isBSnettCB);
	}
	
	//insurance nett checkbox
	function SimpanInsurancenettCb(){
		PayCal.isInsurancenettCB = document.PayrollCalculator.nett_insurance_checkbox.checked;
		console.log("SimpanInsurancenettCb::isInsurancenettCB : ",PayCal.isInsurancenettCB);
	}
	
	//jk-jkk nett checkbox
	function SimpanJkJkknettCb(){
		PayCal.isJkJkknettCB = document.PayrollCalculator.nett_jkjkk_checkbox.checked;
		console.log("SimpanInsurancenettCb::isJkJkknettCB : ",PayCal.isJkJkknettCB);
	}
	
	//income1 nett checkbox
	function SimpanIncome1nettCb(){
		PayCal.isIncome1nettCB = document.PayrollCalculator.income1_nett_checkbox.checked;
		console.log("SimpanIncome1nettCb::isIncome1nettCB : ",PayCal.isIncome1nettCB);
	}
	
	//income2 nett checkbox
	function SimpanIncome2nettCb(){
		PayCal.isIncome2nettCB = document.PayrollCalculator.income2_nett_checkbox.checked;
		console.log("SimpanIncome2nettCb::isIncome2nettCB : ",PayCal.isIncome2nettCB);
	}
	
	//income3 nett checkbox
	function SimpanIncome3nettCb(){
		PayCal.isIncome3nettCB = document.PayrollCalculator.income3_nett_checkbox.checked;
		console.log("SimpanIncome3nettCb::isIncome3nettCB : ",PayCal.isIncome3nettCB);
	}
	
	//income4 nett checkbox
	function SimpanIncome4nettCb(){
		PayCal.isIncome4nettCB = document.PayrollCalculator.income4_nett_checkbox.checked;
		console.log("SimpanIncome4nettCb::isIncome4nettCB : ",PayCal.isIncome4nettCB);
	}
	
	//income5 nett checkbox
	function SimpanIncome5nettCb(){
		PayCal.isIncome5nettCB = document.PayrollCalculator.income5_nett_checkbox.checked;
		console.log("SimpanIncome5nettCb::isIncome5nettCB : ",PayCal.isIncome5nettCB);
	}
	
	//income6 nett checkbox
	function SimpanIncome6nettCb(){
		PayCal.isIncome6nettCB = document.PayrollCalculator.income6_nett_checkbox.checked;
		console.log("SimpanIncome6nettCb::isIncome6nettCB : ",PayCal.isIncome6nettCB);
	}
	
	//income7 nett checkbox
	function SimpanIncome7nettCb(){
		PayCal.isIncome7nettCB = document.PayrollCalculator.income7_nett_checkbox.checked;
		console.log("SimpanIncome7nettCb::isIncome7nettCB : ",PayCal.isIncome7nettCB);
	}
	
	//nilai basic salary field
	function SimpanBasicSalary(){
		PayCal.BasicSalaryValue = parseInt(document.PayrollCalculator.basic_salary_field.value) || 0;
		console.log("SimpanBasicSalary::BasicSalaryValue : ",PayCal.BasicSalaryValue);
	}
	
	//nilai income1
	function SimpanIncome1(){
		PayCal.Income1Value = parseInt(document.PayrollCalculator.income1_field.value) || 0;
		console.log("SimpanIncome1::Income1Value : ",PayCal.Income1Value);
	}
	
	//nilai income2
	function SimpanIncome2(){
		PayCal.Income2Value = parseInt(document.PayrollCalculator.income2_field.value) || 0;
		console.log("SimpanIncome2::Income2Value : ",PayCal.Income2Value);
	}
	
	//nilai income3
	function SimpanIncome3(){
		PayCal.Income3Value = parseInt(document.PayrollCalculator.income3_field.value) || 0;
		console.log("SimpanIncome3::Income3Value : ",PayCal.Income3Value);
	}
	
	//nilai income4
	function SimpanIncome4(){
		PayCal.Income4Value = parseInt(document.PayrollCalculator.income4_field.value) || 0;
		console.log("SimpanIncome4::Income4Value : ",PayCal.Income4Value);
	}
	
	//nilai income5
	function SimpanIncome5(){
		PayCal.Income5Value = parseInt(document.PayrollCalculator.income5_field.value) || 0;
		console.log("SimpanIncome1::Income5Value : ",PayCal.Income5Value);
	}
	
	//nilai income6
	function SimpanIncome6(){
		PayCal.Income6Value = parseInt(document.PayrollCalculator.income6_field.value) || 0;
		console.log("SimpanIncome6::Income6Value : ",PayCal.Income6Value);
	}
	
	//nilai income1
	function SimpanIncome7(){
		PayCal.Income7Value = parseInt(document.PayrollCalculator.income7_field.value) || 0;
		console.log("SimpanIncome7::Income7Value : ",PayCal.Income7Value);
	}
	
	//perhitungan dimulai.
	//hitung Insurance value
	function HitungInsurance(){
		PayCal.InsuranceValue = PayCal.AsuransiSetahun / 12;
		document.PayrollCalculator.insurance_field.value = PayCal.InsuranceValue;
		console.log("HitungInsurance::InsuranceValue : ",PayCal.InsuranceValue);
	}

	function CariTaxKomponenAwalLooping(){
		if ( PayCal.txtTaxPembanding === 0 )
			PayCal.TaxKomponen = 0;
		else{
			if ( PayCal.txtTaxPembanding <= 120000 ) 
				PayCal.TaxKomponen = 100;
			else if ( PayCal.txtTaxPembanding <= 240000 )
				PayCal.TaxKomponen = 1000;
			else if ( PayCal.txtTaxPembanding <= 360000 )
				PayCal.TaxKomponen = 2000;
			else if ( PayCal.txtTaxPembanding <= 480000 )
				PayCal.TaxKomponen = 3000;
			else if ( PayCal.txtTaxPembanding <= 600000 )
				PayCal.TaxKomponen = 4000;
			else if ( PayCal.txtTaxPembanding <= 720000 ) 
				PayCal.TaxKomponen = 5000;
			else if ( PayCal.txtTaxPembanding <= 840000 )
				PayCal.TaxKomponen = 6000;
			else if ( PayCal.txtTaxPembanding <= 960000 )
				PayCal.TaxKomponen = 7000;
			else if ( PayCal.txtTaxPembanding <= 1080000 )
				PayCal.TaxKomponen = 8000;
			else if ( PayCal.txtTaxPembanding <= 1200000 )
				PayCal.TaxKomponen = 9000;
			else if ( PayCal.txtTaxPembanding <= 1500000 )
				PayCal.TaxKomponen = 10000;
			else if ( PayCal.txtTaxPembanding <= 3000000 )
				PayCal.TaxKomponen = 125000;
			else if ( PayCal.txtTaxPembanding <= 5000000 ) 
				PayCal.TaxKomponen = 250000;
			else if ( PayCal.txtTaxPembanding <= 9000000 )
				PayCal.TaxKomponen = 400000;
			else if ( PayCal.txtTaxPembanding <= 20000000 )
				PayCal.TaxKomponen = 750000;
			else if ( PayCal.txtTaxPembanding <= 50000000 )
				PayCal.TaxKomponen = 1650000;
			else if ( PayCal.txtTaxPembanding <= 75000000 )
				PayCal.TaxKomponen = 4100000;
		}
		
		console.log("==========CariTaxKomponenAwalLooping==========");
		console.log("CariTaxKomponenAwalLooping::TaxKomponen :", PayCal.TaxKomponen);
		console.log("CariTaxKomponenAwalLooping::txtTaxPembanding :",PayCal.txtTaxPembanding);
		console.log("==========CariTaxKomponenAwalLooping==========");
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
	
	function CariBasicSetahun(){
		if(PayCal.isBSGrossCB){
			PayCal.BasicSetahun = (PayCal.SisaBulan * PayCal.BasicSalaryValue) || 0;
		}
		else{
			PayCal.BasicSetahun = (PayCal.SisaBulan * (PayCal.BasicSalaryValue + PayCal.PercentBasic * PayCal.TaxKomponen)) || 0;
		}
		console.log("CariBasicSetahun::BasicSetahun : ",PayCal.BasicSetahun);
	}
	
	function CariNett(){
		if(PayCal.isBSnettCB){
			PayCal.NettBasic = (PayCal.SisaBulan * PayCal.BasicSalaryValue);
		}
		else if(!PayCal.isBSnettCB){
			PayCal.NettBasic = (PayCal.SisaBulan * (PayCal.BasicSalaryValue - PayCal.PercentBasic * PayCal.TaxKomponen));
		}
		
		if(PayCal.isInsurancenettCB){
			PayCal.NettInsurance = (PayCal.SisaBulan * PayCal.InsuranceValue);
		}
		else if(!PayCal.isInsurancenettCB){
			PayCal.NettInsurance = (PayCal.SisaBulan * (PayCal.InsuranceValue - PayCal.PercentInsurance * PayCal.TaxKomponen));
		}
		
		if(PayCal.isJkJkknettCB){
			PayCal.NettJKK = (PayCal.SisaBulan * PayCal.JKJKKBulanan);
		}
		else if(!PayCal.isJkJkknettCB){
			PayCal.NettJKK = (PayCal.SisaBulan * (PayCal.JKJKKBulanan - PayCal.PercentJKK * PayCal.TaxKomponen));
		}
		
		if(PayCal.isIncome1nettCB){
			PayCal.NettIncome1 = (PayCal.SisaBulan * PayCal.Income1Value) || 0;
		}
		else if(!PayCal.isIncome1nettCB){
			PayCal.NettIncome1 = (PayCal.SisaBulan * (PayCal.Income1Value - PayCal.PercentIncome1 * PayCal.TaxKomponen)) || 0;
		}
		
		if(PayCal.isIncome2nettCB){
			PayCal.NettIncome2 = (PayCal.SisaBulan * PayCal.Income2Value) || 0;
		}
		else if(!PayCal.isIncome2nettCB){
			PayCal.NettIncome2 = (PayCal.SisaBulan * (PayCal.Income2Value - PayCal.PercentIncome2 * PayCal.TaxKomponen)) || 0;
		}
		
		if(PayCal.isIncome3nettCB){
			PayCal.NettIncome3 = (PayCal.SisaBulan * PayCal.Income3Value) || 0;
		}
		else if(!PayCal.isIncome3nettCB){
			PayCal.NettIncome3 = (PayCal.SisaBulan * (PayCal.Income3Value - PayCal.PercentIncome3 * PayCal.TaxKomponen)) || 0;
		}
		
		if(PayCal.isIncome4nettCB){
			PayCal.NettIncome4 = (PayCal.SisaBulan * PayCal.Income4Value) || 0;
		}
		else if(!PayCal.isIncome4nettCB){
			PayCal.NettIncome4 = (PayCal.SisaBulan * (PayCal.Income4Value - PayCal.PercentIncome4 * PayCal.TaxKomponen)) || 0;
		}
		
		if(PayCal.isIncome5nettCB){
			PayCal.NettIncome5 = (PayCal.SisaBulan * PayCal.Income5Value) || 0;
		}
		else if(!PayCal.isIncome5nettCB){
			PayCal.NettIncome5 = (PayCal.SisaBulan * (PayCal.Income5Value - PayCal.PercentIncome5 * PayCal.TaxKomponen)) || 0;
		}
		
		if(PayCal.isIncome6nettCB){
			PayCal.NettIncome6 = (PayCal.SisaBulan * PayCal.Income6Value) || 0;
		}
		else if(!PayCal.isIncome6nettCB){
			PayCal.NettIncome6 = (PayCal.SisaBulan * (PayCal.Income6Value - PayCal.PercentIncome6 * PayCal.TaxKomponen)) || 0;
		}
		
		if(PayCal.isIncome7nettCB){
			PayCal.NettIncome7 = (PayCal.SisaBulan * PayCal.Income7Value) || 0;
		}
		else if(!PayCal.isIncome7nettCB){
			PayCal.NettIncome7 = (PayCal.SisaBulan * (PayCal.Income7Value - PayCal.PercentIncome7 * PayCal.TaxKomponen)) || 0;
		}
		
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

	//total nett
	function TotalNettSementara(){
		PayCal.TotalNett = parseInt(PayCal.NettBasic + PayCal.NettInsurance + PayCal.NettJKK + PayCal.NettIncome1 + PayCal.NettIncome2 + PayCal.NettIncome3 + PayCal.NettIncome4 + PayCal.NettIncome5 + PayCal.NettIncome6 + PayCal.NettIncome7) || 0;
		console.log("TotalNettSementara::TotalNett : ", PayCal.TotalNett);
	}
	
	function CariBiayaJabatan(){
		if( (PayCal.TotalNett + (12 * PayCal.TaxKomponen)) * 0.05 > 6000000 ){
			PayCal.BiayaJabatan = 6000000;
		}
		else{
			PayCal.BiayaJabatan = (( PayCal.TotalNett + PayCal.SisaBulan * PayCal.TaxKomponen) * 0.05) || 0;
		}
		console.log("CariBiayaJabatan::BiayaJabatan : ",PayCal.BiayaJabatan);
	}
	
	function CariPKP(){
		var TotalSementaraPlusSBLM = (PayCal.TotalNett + PayCal.PrevNettIncome + PayCal.SisaBulan * PayCal.TaxKomponen) || 0;
		PayCal.PKP = (TotalSementaraPlusSBLM - PayCal.PTKP - (0.02 * PayCal.PengaliJkJkk) - PayCal.BiayaJabatan) ||0;	
		if(PayCal.PKP < 0 ){
			PayCal.PKP = 0;
		}
		PayCal.JHT = (0.02 * PayCal.PengaliJkJkk) || 0;
		
		console.log("==========CariPKP==========");
		console.log("CariPKP::PKP : ",PayCal.PKP);
		console.log("CariPKP::JHT : ",PayCal.JHT);
		console.log("CariPKP::TotalSementaraPlusSBLM : ", TotalSementaraPlusSBLM);
		console.log("==========CariPKP==========");
	}
	
	//hitung pengali jkjkk
	function CariPengaliJkJkk(){
		if ( PayCal.JKJKKJPKSource == "Basic Salary" )
		{
			PayCal.pengaliJkJkk = PayCal.BasicSetahun;
		}
		else if ( PayCal.JKJKKJPKSource == "Total Income" ){
			PayCal.PengaliJkJkk = (PayCal.NettBasic + PayCal.NettInsurance + PayCal.NettIncome1 + PayCal.NettIncome2 + PayCal.NettIncome3 + PayCal.NettIncome4 + PayCal.NettIncome5 + PayCal.NettIncome6 + PayCal.NettIncome7 + (PayCal.SisaBulan * PayCal.TaxKomponen ) - ( PayCal.SisaBulan * PayCal.PercentJKK * PayCal.TaxKomponen));
		}
		console.log("CariPengaliJkJkk::PengaliJkJkk : ",PayCal.pengaliJkJkk);
	}

	function HitungPajak(){
		if (PayCal.PKP <= 50000000){
			PayCal.TaxPembanding = (0.05 * PayCal.PKP);
		}
		else{
			if(PayCal.PKP <= 250000000 && PayCal.PKP > 50000000){
				PayCal.TaxPembanding = (2500000 + (0.15 * (PayCal.PKP - 50000000)));
			}
			else{
				if(PayCal.PKP >= 500000000 && PayCal.PKP > 250000000 ){
					PayCal.TaxPembanding = (32500000 + (0.25 * (PayCal.PKP - 250000000)));
				}
				else{
					if(PayCal.PKP >= 500000000){
						PayCal.TaxPembanding = 95000000 + (0.3 * (PayCal.PKP - 500000000));
					}
				}
			}
		}
		console.log("==========HitungPajak==========");
		console.log("HitungPajak::TaxPembanding :",PayCal.TaxPembanding);
		console.log("HitungPajak::PKP :",PayCal.PKP);
		console.log("==========HitungPajak==========");
	}
	
	//hitung JKJKK
	function CariJKJKKBulanan(){
		PayCal.JKJKKBulanan = (PayCal.pengaliJkJkk / PayCal.SisaBulan * (PayCal.JKJKKJPKValue / 100));
		document.PayrollCalculator.jkkjkk_field.value = PayCal.JKJKKBulanan;
		console.log("CariJKJKKBulanan::JKJKKBulanan : ",PayCal.JKJKKBulanan);
	}
	
	        //find month left :?
        function CariSisaBulan(){
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
            console.log("CariSisaBulan::sisaBulan : ",PayCal.sisaBulan);
        }
	