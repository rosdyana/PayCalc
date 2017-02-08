		function resetForm() {
            //document.getElementById("PayrollCalculator").reset();
			window.location.reload(true);
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
                                    "jkjkk_NettComp_field","jkjkk_Tax_field","income1_NetComp_field","income1_Tax_field"];
                
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
			var severanceTaxFirstTouch = document.PayrollCalculator.totalSeverance_field;
			severanceTaxFirstTouch.focus();
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
	PayCal.TaxKomponen = 0;
	PayCal.TaxPembanding = 0;
	
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
		//SimpanTargetTHP();
		//SimpanFixedIncome1();
		SimpanBSGrossCb();
		SimpanInsuranceGrossCb();
		SimpanJkJkkGrossCb();
		SimpanIncome1GrossCb();
		SimpanBSnettCb();
		SimpanInsurancenettCb();
		SimpanJkJkknettCb()
		SimpanIncome1nettCb();
		SimpanBasicSalary();
		SimpanIncome1();
		CariSisaBulan();
		HitungInsurance();
		CariBasicSetahun();
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

		var TaxBasicAkhir = document.getElementById('BS_tax_field');
		var TaxInsuranceAkhir = document.getElementById('insurance_Tax_field');
		var TaxJKKAkhir = document.getElementById('jkjkk_Tax_field'); 
		var TaxIncome1Akhir = document.getElementById('income1_Tax_field'); 

		var TotalGrossBasicSalary = document.getElementById('BS_totalGross');
		var TotalGrossInsurance = document.getElementById('insurance_totalGross');
		var TotalGrossJKK = document.getElementById('jkjkk_totalGross');
		var TotalGrossIncome1 = document.getElementById('income1_totalGross');

		var TotalTaxKomponen = document.getElementById('totalTaxComponent_field');
		var TotalTakeHomePay = document.getElementById('total_take_home_pay');

		CariTaxKomponenAwalLooping();
		var pembandingnya = PayCal.TaxPembanding - 12 * PayCal.TaxKomponen;
		console.log("looping awal : ", pembandingnya);
		
		if(pembandingnya === 0)
		{
			alert('Cek kembali input anda')
		}
		else{
			do {
				PayCal.TaxKomponen = PayCal.TaxKomponen * 1.00025;
				console.log("result::TaxKomponen :",PayCal.TaxKomponen);
				CariPercent();  
				CariNett();
				CariPTKP();
				CariBasicSetahun();
				TotalNettSementara();
				CariBiayaJabatan();
				CariPengaliJkJkk();
				CariPKP();
				HitungPajak();
				PayCal.txtTaxPembanding = PayCal.TaxPembanding;
				console.log("result::txtTaxPembanding :",PayCal.txtTaxPembanding);
				PayCal.txtTaxkomponen = PayCal.TaxKomponen * 12;
				console.log("result::txtTaxkomponen :",PayCal.txtTaxkomponen);
				NettBasicAkhir.value = parseInt(PayCal.NettBasic / PayCal.sisaBulan).formatMoney() || 0;
				NettInsuranceAkhir.value = parseInt(PayCal.NettInsurance / PayCal.sisaBulan).formatMoney() || 0;
				NettJKKAkhir.value = parseInt(PayCal.NettJKK / PayCal.sisaBulan).formatMoney() || 0;
				NettIncome1Akhir.value = parseInt(PayCal.NettIncome1 / PayCal.sisaBulan).formatMoney() || 0;

				TaxBasicAkhir.value = parseInt(PayCal.TaxKomponen * PayCal.PercentBasic).formatMoney() || 0;
				TaxInsuranceAkhir.value = parseInt(PayCal.TaxKomponen * PayCal.PercentInsurance).formatMoney() || 0;
				TaxJKKAkhir.value = parseInt(PayCal.TaxKomponen * PayCal.PercentJKK).formatMoney() || 0;
				TaxIncome1Akhir.value = parseInt(PayCal.TaxKomponen * PayCal.PercentIncome1).formatMoney() || 0;

				TotalGrossBasicSalary.value = parseInt(( PayCal.NettBasic / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentBasic )).formatMoney() || 0;
				TotalGrossInsurance.value = parseInt(( PayCal.NettInsurance / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentInsurance )).formatMoney() || 0;
				TotalGrossJKK.value = parseInt(( PayCal.NettJKK / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentJKK )).formatMoney() || 0;
				TotalGrossIncome1.value = parseInt(( PayCal.NettIncome1 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome1 )).formatMoney() || 0;

				TotalTaxKomponen.value = parseInt(PayCal.TaxKomponen).formatMoney();
				TotalTakeHomePay.value = parseInt(( PayCal.NettBasic / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentBasic ) +
				( PayCal.NettIncome1 / PayCal.sisaBulan ) + ( PayCal.TaxKomponen * PayCal.PercentIncome1 )-
				PayCal.JHTValue + PayCal.TaxKomponen).formatMoney();
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
			_ptkp_field.value = 54000000;
		else if ( _ptkp_boxValue == "TK/1")
			_ptkp_field.value = 58500000;
		else if ( _ptkp_boxValue == "TK/2")
			_ptkp_field.value = 63000000;
		else if ( _ptkp_boxValue == "TK/3")
			_ptkp_field.value = 67500000;
		else if ( _ptkp_boxValue == "K/0")
			_ptkp_field.value = 58500000;
		else if ( _ptkp_boxValue == "K/1")
			_ptkp_field.value = 63000000;
		else if ( _ptkp_boxValue == "K/2")
			_ptkp_field.value = 67500000;
		else if ( _ptkp_boxValue == "K/3")
			_ptkp_field.value = 72000000;
		else if ( _ptkp_boxValue == "PH/0")
			_ptkp_field.value = 112500000;
		else if ( _ptkp_boxValue == "PH/1")
			_ptkp_field.value = 117000000;
		else if ( _ptkp_boxValue == "PH/2")
			_ptkp_field.value = 121500000;
		else if ( _ptkp_boxValue == "PH/3")
			_ptkp_field.value = 126000000; 
		PayCal.PTKP = parseInt(_ptkp_field.value) || 0;
		console.log("CariPTKP::PTKP : ",PayCal.PTKP);      
	}
	
	//persen jk-jkk-jpk
	function SimpanJkJkkJpk(){
		PayCal.JKJKKJPKValue = (document.PayrollCalculator.jkjkkjpk_field.value) || 0;
		console.log("SimpanJkJkkJpk::JKJKKJPKValue : ",PayCal.JKJKKJPKValue);
	}
	
	//source dari jk-jkk-jpk
	function SimpanJkJkkJpkSource(){
		PayCal.JKJKKJPKSource = document.PayrollCalculator.jkkjpk_combobox.value;
		console.log("SimpanJkJkkJpkSource::JKJKKJPKSource : ",PayCal.JKJKKJPKSource);
	}
	
	//persen jht employee
	function SimpanJhtEmployee(){
		PayCal.JHTValue = (document.PayrollCalculator.jht_field.value) || 0;
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
	//function SimpanTargetTHP(){
		//PayCal.THP = parseInt(document.PayrollCalculator.targetTHP_field.value) || 0;
		//console.log("SimpanTargetTHP::targetTHP : ",PayCal.THP);            
	//}
	
	//nilai fixed income1
	//function SimpanFixedIncome1(){
		//PayCal.FixedIncome1 = parseInt(document.PayrollCalculator.fixedIncome1_field.value) || 0;
		//console.log("SimpanFixedIncome1::FixedIncome1 : ",PayCal.FixedIncome1);  
	//}
	
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
			if ( PayCal.txtTaxPembanding <= 120000 ) {
				PayCal.TaxKomponen = 100;				
			}
			else if ( PayCal.txtTaxPembanding <= 240000 ){
				PayCal.TaxKomponen = 1000;				
			}

			else if ( PayCal.txtTaxPembanding <= 360000 ){
				PayCal.TaxKomponen = 2000;				
			}
			else if ( PayCal.txtTaxPembanding <= 480000 ){
				PayCal.TaxKomponen = 3000;	
			}
			else if ( PayCal.txtTaxPembanding <= 600000 ){
				PayCal.TaxKomponen = 4000;	
			}
			else if ( PayCal.txtTaxPembanding <= 720000 ){
				PayCal.TaxKomponen = 5000;	
			} 
			else if ( PayCal.txtTaxPembanding <= 840000 ){
				PayCal.TaxKomponen = 6000;
			}
			else if ( PayCal.txtTaxPembanding <= 960000 ){
				PayCal.TaxKomponen = 7000;
			}
			else if ( PayCal.txtTaxPembanding <= 1080000 ){
				PayCal.TaxKomponen = 8000;
			}	
			else if ( PayCal.txtTaxPembanding <= 1200000 ){
				PayCal.TaxKomponen = 9000;
			}		
			else if ( PayCal.txtTaxPembanding <= 1500000 ){
				PayCal.TaxKomponen = 10000;
			}	
			else if ( PayCal.txtTaxPembanding <= 3000000 ){
				PayCal.TaxKomponen = 125000;
			}	
			else if ( PayCal.txtTaxPembanding <= 5000000 ){
				PayCal.TaxKomponen = 250000;
			} 
			else if ( PayCal.txtTaxPembanding <= 9000000 ){
				PayCal.TaxKomponen = 400000;
			}	
			else if ( PayCal.txtTaxPembanding <= 20000000 ){
				PayCal.TaxKomponen = 750000;
			}	
			else if ( PayCal.txtTaxPembanding <= 50000000 ){
				PayCal.TaxKomponen = 1650000;
			}
			else if ( PayCal.txtTaxPembanding <= 75000000 ){
				PayCal.TaxKomponen = 4100000;
			}
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
		var TotalSementara = parseInt(BS_field + insurance_field + jkjkk_field + income1_field) || 0;

		PayCal.PercentBasic = BS_field / TotalSementara || 0;
		PayCal.PercentInsurance = insurance_field / TotalSementara || 0;
		PayCal.PercentJKK = jkjkk_field / TotalSementara || 0;
		PayCal.PercentIncome1 = income1_field / TotalSementara || 0;
		console.log("==========CariPercent==========");
		console.log("CariPercent::PercentBasic :",PayCal.PercentBasic);
		console.log("CariPercent::PercentInsurance :",PayCal.PercentInsurance);
		console.log("CariPercent::PercentJKK :",PayCal.PercentJKK);
		console.log("CariPercent::PercentIncome1 :",PayCal.PercentIncome1);
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
			//PayCal.GrossBasic = PayCal.sisaBulan * ( PayCal.BasicSalaryValue - PayCal.PercentBasic * PayCal.TaxKomponen);
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
		
		console.log("==========CariNett==========");
		console.log("CariNett::NettBasic :",PayCal.NettBasic);
		console.log("CariNett::NettInsurance :",PayCal.NettInsurance);
		console.log("CariNett::NettJKK :",PayCal.NettJKK);
		console.log("CariNett::NettIncome1 :",PayCal.NettIncome1);
		console.log("CariNett::TaxKomponen :",PayCal.TaxKomponen);
		console.log("==========CariNett==========");
	}

	//total nett
	function TotalNettSementara(){
		PayCal.TotalNett = parseInt(PayCal.NettBasic + PayCal.NettInsurance + PayCal.NettJKK + PayCal.NettIncome1) || 0;
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
	
	//hitung pengali jkjkk
	function CariPengaliJkJkk(){
		if ( PayCal.JKJKKJPKSource == "Basic Salary" )
		{
			PayCal.PengaliJkJkk = PayCal.BasicSetahun;
		}
		else if ( PayCal.JKJKKJPKSource == "Total Income" ){
			PayCal.PengaliJkJkk = (PayCal.NettBasic + PayCal.NettInsurance + PayCal.NettIncome1 + (PayCal.SisaBulan * PayCal.TaxKomponen ) - ( PayCal.SisaBulan * PayCal.PercentJKK * PayCal.TaxKomponen));
		}
		console.log("CariPengaliJkJkk::PengaliJkJkk : ",PayCal.PengaliJkJkk);
	}
	
	function CariPKP(){
		var TotalSementaraPlusSBLM = (PayCal.TotalNett + PayCal.PrevNettIncome + PayCal.SisaBulan * PayCal.TaxKomponen) || 0;
		var asu = 0.02 * PayCal.PengaliJkJkk;
		PayCal.PKP = (TotalSementaraPlusSBLM - PayCal.PTKP - asu - PayCal.BiayaJabatan) ||0;	
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

	function HitungPajak(){
		if (PayCal.PKP <= 50000000){
			PayCal.TaxPembanding = (0.05 * PayCal.PKP);
		}
		else{
			if(PayCal.PKP <= 250000000 && PayCal.PKP > 50000000){
				PayCal.TaxPembanding = (2500000 + (0.15 * (PayCal.PKP - 50000000)));
			}
			else{
				if(PayCal.PKP <= 500000000 && PayCal.PKP > 250000000 ){
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
		PayCal.JKJKKBulanan = (PayCal.PengaliJkJkk / PayCal.SisaBulan * (PayCal.JKJKKJPKValue / 100));
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
	
	//get total severance
	function SimpanTotalSeverance(){
		PayCal.TotalSeverance = parseInt(document.PayrollCalculator.totalSeverance_field.value) || 0;
		console.log("SimpanTotalSeverance::TotalSeverance : ",PayCal.TotalSeverance);
	}
	
	//find severance tax
	function CalculateSeveranceTax(){
		if ( PayCal.TotalSeverance >= 500000000){
			PayCal.SeveranceTax = (0.05 * 50000000) + (0.15 * 150000000) + (0.2*250000000) + ((PayCal.TotalSeverance - 500000000) * 0.3);
		}
		else if ( PayCal.TotalSeverance >= 250000000 && PayCal.TotalSeverance <= 500000000){
			PayCal.SeveranceTax = (0.05 * 50000000) + (0.15*150000000) + ((PayCal.TotalSeverance - 250000000)*0.25);
		}
		else if ( PayCal.TotalSeverance >= 100000000 && PayCal.TotalSeverance <= 250000000){
			PayCal.SeveranceTax = (0.5*50000000) + ((PayCal.TotalSeverance - 100000000)*0.15);
		}
		else if ( PayCal.TotalSeverance < 50000000){
			PayCal.SeveranceTax = 0;
		}
		console.log("CalculateSeveranceTax::SeveranceTax : ",PayCal.SeveranceTax);
	}
	
	function calculate_severance(){
		SimpanTotalSeverance();
		CalculateSeveranceTax();
		document.PayrollCalculator.totalSeverance_field.value = (PayCal.TotalSeverance).formatMoney();
		document.PayrollCalculator.SeveranceTax_field.value = (PayCal.SeveranceTax).formatMoney();
	}
