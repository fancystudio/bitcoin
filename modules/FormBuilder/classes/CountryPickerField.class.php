<?php
/* 
   FormBuilder. Copyright (c) 2005-2006 Samuel Goldstein <sjg@cmsmodules.com>
   More info at http://dev.cmsmadesimple.org/projects/formbuilder
   
   A Module for CMS Made Simple, Copyright (c) 2006 by Ted Kulp (wishy@cmsmadesimple.org)
  This project's homepage is: http://www.cmsmadesimple.org
*/
class fbCountryPickerField extends fbFieldBase {

	var $Countries;
	
	function __construct(&$form_ptr, &$params)
	{
        parent::__construct($form_ptr, $params);
        $mod = $form_ptr->module_ptr;
		$this->Type = 'CountryPickerField';
		$this->DisplayInForm = true;
		$this->ValidationTypes = array(
            );

        $this->Countries = array($mod->Lang('no_default')=>'',
		        $mod->Lang('AF') =>'AF',$mod->Lang('AX') =>'AX',$mod->Lang('AL') =>'AL',
				$mod->Lang('DZ') =>'DZ',$mod->Lang('AS') =>'AS',$mod->Lang('AD') =>'AD',
				$mod->Lang('AO') =>'AO',$mod->Lang('AI') =>'AI',$mod->Lang('AQ') =>'AQ',
				$mod->Lang('AG') =>'AG',$mod->Lang('AR') =>'AR',$mod->Lang('AM') =>'AM',
				$mod->Lang('AW') =>'AW',$mod->Lang('AU') =>'AU',$mod->Lang('AT') =>'AT',
				$mod->Lang('AZ') =>'AZ',$mod->Lang('BS') =>'BS',$mod->Lang('BH') =>'BH',
				$mod->Lang('BB') =>'BB',$mod->Lang('BD') =>'BD',$mod->Lang('BY') =>'BY',
				$mod->Lang('BE') =>'BE',$mod->Lang('BZ') =>'BZ',$mod->Lang('BJ') =>'BJ',
				$mod->Lang('BM') =>'BM',$mod->Lang('BT') =>'BT',$mod->Lang('BW') =>'BW',
				$mod->Lang('BO') =>'BO',$mod->Lang('BA') =>'BA',$mod->Lang('BV') =>'BV',
				$mod->Lang('BR') =>'BR',$mod->Lang('IO') =>'IO',$mod->Lang('BN') =>'BN',
				$mod->Lang('BG') =>'BG',$mod->Lang('BF') =>'BF',$mod->Lang('BI') =>'BI',
				$mod->Lang('KH') =>'KH',$mod->Lang('CM') =>'CM',$mod->Lang('CA') =>'CA',
				$mod->Lang('CV') =>'CV',$mod->Lang('KY') =>'KY',$mod->Lang('CF') =>'CF',
				$mod->Lang('TD') =>'TD',$mod->Lang('CL') =>'CL',$mod->Lang('CN') =>'CN',
				$mod->Lang('CX') =>'CX',$mod->Lang('CC') =>'CC',$mod->Lang('CO') =>'CO',
				$mod->Lang('KM') =>'KM',$mod->Lang('CG') =>'CG',$mod->Lang('CD') =>'CD',
				$mod->Lang('CK') =>'CK',$mod->Lang('CR') =>'CR',$mod->Lang('CI') =>'CI',
				$mod->Lang('HR') =>'HR',$mod->Lang('CU') =>'CU',$mod->Lang('CY') =>'CY',
				$mod->Lang('CZ') =>'CZ',$mod->Lang('DK') =>'DK',$mod->Lang('DJ') =>'DJ',
				$mod->Lang('DM') =>'DM',$mod->Lang('DO') =>'DO',$mod->Lang('TP') =>'TP',
				$mod->Lang('EC') =>'EC',$mod->Lang('EG') =>'EG',$mod->Lang('SV') =>'SV',
				$mod->Lang('GQ') =>'GQ',$mod->Lang('ER') =>'ER',$mod->Lang('EE') =>'EE',
				$mod->Lang('ET') =>'ET',$mod->Lang('FK') =>'FK',$mod->Lang('FO') =>'FO',
				$mod->Lang('FJ') =>'FJ',$mod->Lang('FI') =>'FI',$mod->Lang('FR') =>'FR',
				$mod->Lang('FX') =>'FX',$mod->Lang('GF') =>'GF',$mod->Lang('PF') =>'PF',
				$mod->Lang('TF') =>'TF',$mod->Lang('MK') =>'MK',$mod->Lang('GA') =>'GA',
				$mod->Lang('GM') =>'GM',$mod->Lang('GE') =>'GE',$mod->Lang('DE') =>'DE',
				$mod->Lang('GH') =>'GH',$mod->Lang('GI') =>'GI',$mod->Lang('GB') =>'GB',
				$mod->Lang('GR') =>'GR',$mod->Lang('GL') =>'GL',$mod->Lang('GD') =>'GD',
				$mod->Lang('GP') =>'GP',$mod->Lang('GU') =>'GU',$mod->Lang('GT') =>'GT',
				$mod->Lang('GF') =>'GF',$mod->Lang('GN') =>'GN',$mod->Lang('GW') =>'GW',
				$mod->Lang('GY') =>'GY',$mod->Lang('HT') =>'HT',$mod->Lang('HM') =>'HM',
				$mod->Lang('HN') =>'HN',$mod->Lang('HK') =>'HK',$mod->Lang('HU') =>'HU',
				$mod->Lang('IS') =>'IS',$mod->Lang('IN') =>'IN',$mod->Lang('ID') =>'ID',
				$mod->Lang('IR') =>'IR',$mod->Lang('IQ') =>'IQ',$mod->Lang('IE') =>'IE',
				$mod->Lang('IL') =>'IL',$mod->Lang('IM') =>'IM',$mod->Lang('IT') =>'IT',
				$mod->Lang('JE') =>'JE',$mod->Lang('JM') =>'JM',$mod->Lang('JP') =>'JP',
				$mod->Lang('JO') =>'JO',$mod->Lang('KZ') =>'KZ',$mod->Lang('KE') =>'KE',
				$mod->Lang('KI') =>'KI',$mod->Lang('KP') =>'KP',$mod->Lang('KR') =>'KR',
				$mod->Lang('KW') =>'KW',$mod->Lang('KG') =>'KG',$mod->Lang('LA') =>'LA',
				$mod->Lang('LV') =>'LV',$mod->Lang('LB') =>'LB',$mod->Lang('LI') =>'LI',
				$mod->Lang('LR') =>'LR',$mod->Lang('LY') =>'LY',$mod->Lang('LS') =>'LS',
				$mod->Lang('LT') =>'LT',$mod->Lang('LU') =>'LU',$mod->Lang('MO') =>'MO',
				$mod->Lang('MG') =>'MG',$mod->Lang('MW') =>'MW',$mod->Lang('MY') =>'MY',
				$mod->Lang('MV') =>'MV',$mod->Lang('ML') =>'ML',$mod->Lang('MT') =>'MT',
				$mod->Lang('MH') =>'MH',$mod->Lang('MQ') =>'MQ',$mod->Lang('MR') =>'MR',
				$mod->Lang('MU') =>'MU',$mod->Lang('YT') =>'YT',$mod->Lang('MX') =>'MX',
				$mod->Lang('FM') =>'FM',$mod->Lang('MC') =>'MC',$mod->Lang('MD') =>'MD',
				$mod->Lang('MA') =>'MA',$mod->Lang('MN') =>'MN',$mod->Lang('MS') =>'MS',
				$mod->Lang('MZ') =>'MZ',$mod->Lang('MM') =>'MM',$mod->Lang('NA') =>'NA',
				$mod->Lang('NR') =>'NR',$mod->Lang('NP') =>'NP',$mod->Lang('NL') =>'NL',
				$mod->Lang('AN') =>'AN',$mod->Lang('NT') =>'NT',$mod->Lang('NC') =>'NC',
				$mod->Lang('NZ') =>'NZ',$mod->Lang('NI') =>'NI',$mod->Lang('NE') =>'NE',
				$mod->Lang('NG') =>'NG',$mod->Lang('NU') =>'NU',$mod->Lang('NF') =>'NF',
				$mod->Lang('MP') =>'MP',$mod->Lang('NO') =>'NO',$mod->Lang('OM') =>'OM',
				$mod->Lang('PK') =>'PK',$mod->Lang('PW') =>'PW',$mod->Lang('PS') =>'PS',
				$mod->Lang('PA') =>'PA',$mod->Lang('PG') =>'PG',$mod->Lang('PY') =>'PY',
				$mod->Lang('PE') =>'PE',$mod->Lang('PH') =>'PH',$mod->Lang('PN') =>'PN',
				$mod->Lang('PL') =>'PL',$mod->Lang('PT') =>'PT',$mod->Lang('PR') =>'PR',
				$mod->Lang('QA') =>'QA',$mod->Lang('RE') =>'RE',$mod->Lang('RO') =>'RO',
				$mod->Lang('RU') =>'RU',$mod->Lang('RW') =>'RW',$mod->Lang('GS') =>'GS',
				$mod->Lang('KN') =>'KN',$mod->Lang('LC') =>'LC',$mod->Lang('VC') =>'VC',
				$mod->Lang('WS') =>'WS',$mod->Lang('SM') =>'SM',$mod->Lang('ST') =>'ST',
				$mod->Lang('SA') =>'SA',$mod->Lang('SN') =>'SN',$mod->Lang('SC') =>'SC',
				$mod->Lang('SL') =>'SL',$mod->Lang('SG') =>'SG',$mod->Lang('SI') =>'SI',
				$mod->Lang('SK') =>'SK',$mod->Lang('SB') =>'SB',$mod->Lang('SO') =>'SO',
				$mod->Lang('ZA') =>'ZA',$mod->Lang('ES') =>'ES',$mod->Lang('LK') =>'LK',
				$mod->Lang('SH') =>'SH',$mod->Lang('PM') =>'PM',$mod->Lang('SD') =>'SD',
				$mod->Lang('SR') =>'SR',$mod->Lang('SJ') =>'SJ',$mod->Lang('SZ') =>'SZ',
				$mod->Lang('SE') =>'SE',$mod->Lang('CH') =>'CH',$mod->Lang('SY') =>'SY',
				$mod->Lang('TW') =>'TW',$mod->Lang('TJ') =>'TJ',$mod->Lang('TZ') =>'TZ',
				$mod->Lang('TH') =>'TH',$mod->Lang('TG') =>'TG',$mod->Lang('TK') =>'TK',
				$mod->Lang('TO') =>'TO',$mod->Lang('TT') =>'TT',$mod->Lang('TN') =>'TN',
				$mod->Lang('TR') =>'TR',$mod->Lang('TM') =>'TM',$mod->Lang('TC') =>'TC',
				$mod->Lang('TV') =>'TV',$mod->Lang('UG') =>'UG',$mod->Lang('UA') =>'UA',
				$mod->Lang('AE') =>'AE',$mod->Lang('UK') =>'UK',$mod->Lang('US') =>'US',
				$mod->Lang('UM') =>'UM',$mod->Lang('UY') =>'UY',$mod->Lang('UZ') =>'UZ',
				$mod->Lang('VU') =>'VU',$mod->Lang('VA') =>'VA',$mod->Lang('VE') =>'VE',
				$mod->Lang('VN') =>'VN',$mod->Lang('VG') =>'VG',$mod->Lang('VI') =>'VI',
				$mod->Lang('WF') =>'WF',$mod->Lang('EH') =>'EH',$mod->Lang('YE') =>'YE',
				$mod->Lang('YU') =>'YU',$mod->Lang('ZM') =>'ZM',$mod->Lang('ZW') =>'ZW'
				);
		}

    function StatusInfo()
	{
		return '';
	}

	function GetHumanReadableValue($as_string=true)
	{
		$ret = array_search($this->Value,$this->Countries);
		if ($as_string)
			{
			return $ret;
			}
		else
			{
			return array($ret);
			}
	}

	function GetFieldInput($id, &$params, $returnid)
	{
		$mod = $this->form_ptr->module_ptr;

		unset($this->Countries[$mod->Lang('no_default')]);
		$js = $this->GetOption('javascript','');
		if ($this->GetOption('select_one','') != '')
			{
			$this->Countries = array_merge(array($this->GetOption('select_one','')=>''),$this->Countries);
			}
		else
			{
			$this->Countries = array_merge(array($mod->Lang('select_one')=>''),$this->Countries);
			}

		if (! $this->HasValue() && $this->GetOption('default_country','') != '')
		  {
		  $this->SetValue($this->GetOption('default_country',''));
		  }

		return $mod->CreateInputDropdown($id, 'fbrp__'.$this->Id, $this->Countries, -1,
         $this->Value, $js.$this->GetCSSIdTag());
	}

	function PrePopulateAdminForm($formDescriptor)
	{
		$mod = $this->form_ptr->module_ptr;
		ksort($this->Countries);

		$main = array(
			array($mod->Lang('title_select_default_country'),
            		$mod->CreateInputDropdown($formDescriptor, 'fbrp_opt_default_country',
            		$this->Countries, -1, $this->GetOption('default_country',''))),
			array($mod->Lang('title_select_one_message'),
            		$mod->CreateInputText($formDescriptor, 'fbrp_opt_select_one',
            		$this->GetOption('select_one',$mod->Lang('select_one'))))
		);
		return array('main'=>$main,array());
	}


}

?>