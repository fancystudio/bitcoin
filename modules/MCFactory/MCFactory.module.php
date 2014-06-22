<?php
#-------------------------------------------------------------------------
# Module: MCFactory - This module is a sort of &quot;Super&quot; ModuleMaker with lots of functionalities
# Version: 0.0.1, Jean-Christophe Cuvelier
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
# This file originally created by ModuleMaker module, version 0.3.1
# Copyright (c) 2008 by Samuel Goldstein (sjg@cmsmadesimple.org) 
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

class MCFactory extends CMSModule
{

    protected $action;

    public function GetName()
    {
        return 'MCFactory';
    }

    public function GetFriendlyName()
    {
        return 'M&C Factory';
    }

    public function GetVersion()
    {
        return '3.4.92';
    }

    public function GetAuthor()
    {
        return 'Jean-Christophe Cuvelier';
    }

    public function GetAuthorEmail()
    {
        return 'jcc@morris-chapman.com';
    }

    public function GetHelp()
    {
        return $this->Lang('help');
    }

    public function GetChangeLog()
    {
        return $this->Lang('changelog');
    }

    public function HasAdmin()
    {
        return true;
    }

    public function GetAdminDescription()
    {
        return $this->Lang('admindescription');
    }

    public function VisibleToAdminUser()
    {
        return $this->CheckAccess();
    }

    public function CheckAccess()
    {
        return $this->CheckPermission('Manage MCFactory');
    }

    public function DisplayErrorPage()
    {
        echo $this->Lang('display_error');
    }

    public function GetDependencies()
    {
        return array('CMSForms' => '1.10.14');
    }

    public function InstallPostMessage()
    {
        return $this->Lang('installpostmessage');
    }

    public function UninstallPreMessage()
    {
        return $this->Lang('uninstallpremessage');
    }

    public function UninstallPostMessage()
    {
        return $this->Lang('uninstallpostmessage');
    }

    public function HandlesEvents()
    {
        return true;
    }

    public function MinimumCMSVersion()
    {
        // TODO: Cut to 1.10 with MCF 3.10
        return '1.9';
    }


    function InitializeFrontend()
    {
        // NOTICE: Due to the dynamic behind MCFactory, it is not possible to clean parameters properly. Although it is not possible to have the admin logs full of alert. For the moment, this is the only alternative.
        // TODO: NOT WORKING !!!
        $this->RestrictUnknownParams(true);
        $this->SetParameterType('module_id', CLEAN_STRING);


        // To remove one day
        $this->SetParameterType(CLEAN_REGEXP . '/[-a-zA-Z0-9_]*/', CLEAN_NONE);
    }

    public function DoEvent($originator, $eventname, &$params)
    {
        if ($eventname == 'ContentEditPost') {
            $this->setAttribute('last_modified_date', time());
        }
    }

    public function getAttribute($name, $default = null)
    {
        $db = cms_utils::get_db();
        $result = $db->execute('SELECT attribute_value FROM ' . cms_db_prefix() . 'module_mcfactory_attributes WHERE attribute_name = ?', array($name));
        if ($result && ($row = $result->FetchRow())) {
            return $row['attribute_value'];
        } else {
            return $default;
        }
    }

    public function DisplayImage($image, $title = '')
    {
        $config = cms_utils::get_config();

        return '<img src="' . $config['root_url'] . '/modules/MCFactory/images/' . $image . '" title="' . $title . '" alt="' . $title . '" />';

//		('icons/system/edit.gif', 'Edit', '', '', 'systemicon')
    }

    public function getImage($image)
    {
        return $this->GetModuleURLPath() . '/images/' . $image;
    }

    public function setAttribute($name, $value)
    {
        $db = cms_utils::get_db();
        $result = $db->execute('SELECT id FROM ' . cms_db_prefix() . 'module_mcfactory_attributes WHERE attribute_name = ?', array($name));
        if ($result && ($row = $result->FetchRow())) {
            $db->execute('UPDATE ' . cms_db_prefix() . 'module_mcfactory_attributes SET attribute_value = ? WHERE id = ?', array($value, $row['id']));
        } else {
            $db->execute('INSERT INTO ' . cms_db_prefix() . 'module_mcfactory_attributes SET id = ?, attribute_name = ?, attribute_value = ?', array($db->GenID(cms_db_prefix() . 'module_mcfactory_attributes_seq'), $name, $value));
        }
    }

    public function GetHeaderHTML()
    {
        $this->ShowMessages();

        $config = cms_utils::get_config();

        $html = '';
//        $html .= '<link rel="stylesheet" type="text/css" href="' . $this->loadResource('public/css/jquery-ui.min.css') . '" />';
//        $html .= '<script type="text/javascript" src="' . $this->loadResource('public/js/jquery-ui.min.js') . '"></script>';
//        $html .= '<script type="text/javascript" src="' . $this->loadResource('public/js/jquery-1.10.2.min.js') . '"></script>';
//        $html .= '<script type="text/javascript" src="' . $this->loadResource('public/js/jquery-ui.min.js') . '"></script>';

//        $html .= '<script type="text/javascript" src="' . $config['root_url'] . '/lib/jquery/js/jquery.ui.nestedSortable-1.3.4.js"></script>';
//        $html .= '<script type="text/javascript" src="' . $config['root_url'] . '/lib/jquery/js/jquery.json-2.3.min.js"></script>';
//        $html .= '<script type="text/javascript" src="' . $this->loadResource('public/js/jquery.ui.tabs.js') . '"></script>';


        return $html;
    }

    public function loadResource($file)
    {
        return $this->GetModuleURLPath() . '/resources/' . $file;
    }

    /**
     * Display Flash messages from the module
     */

    public function ShowMessages()
    {
        $messages = $this->GetFlashMessages();

        if (count($messages)) {
            /** @var AdminTheme $themeObject */
            $themeObject = cms_utils::get_theme_object();

            foreach ($messages as $type => $msgs) {
                foreach ($msgs as $message) {
                    switch ($type) {
                        case 'error':
                            $themeObject->ShowErrors($message);
                            break;
                        default:
                            $themeObject->ShowMessage($message);
                            break;
                    }
                }
            }
        }
    }

    /**
     * Store messages for the next display
     * @param $message The message to store for next display
     * @param string $type alert, info
     */

    public function SetFlashMessage($message, $type = 'info')
    {
        $_SESSION['CMSMS']['Modules'][$this->GetName()]['Messages'][$type][] = $message;
    }

    /**
     * Return the messages for the current display and clear it
     * @return array
     */

    public function GetFlashMessages()
    {
        if (isset($_SESSION['CMSMS']['Modules'][$this->GetName()]['Messages'])) {
            $messages = $_SESSION['CMSMS']['Modules'][$this->GetName()]['Messages'];
            unset($_SESSION['CMSMS']['Modules'][$this->GetName()]['Messages']);
            return $messages;
        } else {
            return null;
        }
    }

    static $countries = array(
        'AD' => 'Andorra',
        'AE' => 'United Arab Emirates',
        'AF' => 'Afghanistan',
        'AG' => 'Antigua and Barbuda',
        'AI' => 'Anguilla',
        'AL' => 'Albania',
        'AM' => 'Armenia',
        'AN' => 'Netherlands Antilles',
        'AO' => 'Angola',
        'AQ' => 'Antarctica',
        'AR' => 'Argentina',
        'AS' => 'American Samoa',
        'AT' => 'Austria',
        'AU' => 'Australia',
        'AW' => 'Aruba',
        'AZ' => 'Azerbaijan',
        'BA' => 'Bosnia and Herzegovina',
        'BB' => 'Barbados',
        'BD' => 'Bangladesh',
        'BE' => 'Belgium',
        'BF' => 'Burkina Faso',
        'BG' => 'Bulgaria',
        'BH' => 'Bahrain',
        'BI' => 'Burundi',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BN' => 'Brunei',
        'BO' => 'Bolivia',
        'BR' => 'Brazil',
        'BS' => 'Bahamas',
        'BT' => 'Bhutan',
        'BV' => 'Bouvet Island',
        'BW' => 'Botswana',
        'BY' => 'Belarus',
        'BZ' => 'Belize',
        'CA' => 'Canada',
        'CC' => 'Cocos (Keeling) Islands',
        'CD' => 'Democratic Republic of the Congo',
        'CF' => 'Central African Republic',
        'CG' => 'Congo',
        'CH' => 'Switzerland',
        'CI' => 'Côte d\'Ivoire',
        'CK' => 'Cook Islands',
        'CL' => 'Chile',
        'CM' => 'Cameroon',
        'CN' => 'China',
        'CO' => 'Colombia',
        'CR' => 'Costa Rica',
        'CU' => 'Cuba',
        'CV' => 'Cape Verde',
        'CX' => 'Christmas Island',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DE' => 'Germany',
        'DJ' => 'Djibouti',
        'DK' => 'Denmark',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'DZ' => 'Algeria',
        'EC' => 'Ecuador',
        'EE' => 'Estonia',
        'EG' => 'Egypt',
        'EH' => 'Western Sahara',
        'ER' => 'Eritrea',
        'ES' => 'Spain',
        'ET' => 'Ethiopia',
        'FI' => 'Finland',
        'FJ' => 'Fiji',
        'FK' => 'Falkland Islands',
        'FM' => 'Micronesia',
        'FO' => 'Faroe Islands',
        'FR' => 'France',
        'GA' => 'Gabon',
        'GB' => 'United Kingdom',
        'GD' => 'Grenada',
        'GE' => 'Georgia',
        'GF' => 'French Guiana',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GL' => 'Greenland',
        'GM' => 'Gambia',
        'GN' => 'Guinea',
        'GP' => 'Guadeloupe',
        'GQ' => 'Equatorial Guinea',
        'GR' => 'Greece',
        'GS' => 'South Georgia and the South Sandwich Islands',
        'GT' => 'Guatemala',
        'GU' => 'Guam',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HK' => 'Hong Kong S.A.R., China',
        'HM' => 'Heard Island and McDonald Islands',
        'HN' => 'Honduras',
        'HR' => 'Croatia',
        'HT' => 'Haiti',
        'HU' => 'Hungary',
        'ID' => 'Indonesia',
        'IE' => 'Ireland',
        'IL' => 'Israel',
        'IN' => 'India',
        'IO' => 'British Indian Ocean Territory',
        'IQ' => 'Iraq',
        'IR' => 'Iran',
        'IS' => 'Iceland',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JO' => 'Jordan',
        'JP' => 'Japan',
        'KE' => 'Kenya',
        'KG' => 'Kyrgyzstan',
        'KH' => 'Cambodia',
        'KI' => 'Kiribati',
        'KM' => 'Comoros',
        'KN' => 'Saint Kitts and Nevis',
        'KP' => 'North Korea',
        'KR' => 'South Korea',
        'KW' => 'Kuwait',
        'KY' => 'Cayman Islands',
        'KZ' => 'Kazakhstan',
        'LA' => 'Laos',
        'LB' => 'Lebanon',
        'LC' => 'Saint Lucia',
        'LI' => 'Liechtenstein',
        'LK' => 'Sri Lanka',
        'LR' => 'Liberia',
        'LS' => 'Lesotho',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'LV' => 'Latvia',
        'LY' => 'Libya',
        'MA' => 'Morocco',
        'MC' => 'Monaco',
        'MD' => 'Moldova',
        'MG' => 'Madagascar',
        'MH' => 'Marshall Islands',
        'MK' => 'Macedonia',
        'ML' => 'Mali',
        'MM' => 'Myanmar',
        'MN' => 'Mongolia',
        'MO' => 'Macao S.A.R., China',
        'MP' => 'Northern Mariana Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MS' => 'Montserrat',
        'MT' => 'Malta',
        'MU' => 'Mauritius',
        'MV' => 'Maldives',
        'MW' => 'Malawi',
        'MX' => 'Mexico',
        'MY' => 'Malaysia',
        'MZ' => 'Mozambique',
        'NA' => 'Namibia',
        'NC' => 'New Caledonia',
        'NE' => 'Niger',
        'NF' => 'Norfolk Island',
        'NG' => 'Nigeria',
        'NI' => 'Nicaragua',
        'NL' => 'Netherlands',
        'NO' => 'Norway',
        'NP' => 'Nepal',
        'NR' => 'Nauru',
        'NU' => 'Niue',
        'NZ' => 'New Zealand',
        'OM' => 'Oman',
        'PA' => 'Panama',
        'PE' => 'Peru',
        'PF' => 'French Polynesia',
        'PG' => 'Papua New Guinea',
        'PH' => 'Philippines',
        'PK' => 'Pakistan',
        'PL' => 'Poland',
        'PM' => 'Saint Pierre and Miquelon',
        'PN' => 'Pitcairn',
        'PR' => 'Puerto Rico',
        'PS' => 'Palestinian Territory',
        'PT' => 'Portugal',
        'PW' => 'Palau',
        'PY' => 'Paraguay',
        'QA' => 'Qatar',
        'RE' => 'Réunion',
        'RS' => 'Serbia',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'RW' => 'Rwanda',
        'SA' => 'Saudi Arabia',
        'SB' => 'Solomon Islands',
        'SC' => 'Seychelles',
        'SD' => 'Sudan',
        'SE' => 'Sweden',
        'SG' => 'Singapore',
        'SH' => 'Saint Helena',
        'SI' => 'Slovenia',
        'SJ' => 'Svalbard and Jan Mayen',
        'SK' => 'Slovakia',
        'SL' => 'Sierra Leone',
        'SM' => 'San Marino',
        'SN' => 'Senegal',
        'SO' => 'Somalia',
        'SP' => 'Serbia',
        'SR' => 'Suriname',
        'ST' => 'Sao Tome and Principe',
        'SV' => 'El Salvador',
        'SY' => 'Syria',
        'SZ' => 'Swaziland',
        'TC' => 'Turks and Caicos Islands',
        'TD' => 'Chad',
        'TF' => 'French Southern Territories',
        'TG' => 'Togo',
        'TH' => 'Thailand',
        'TJ' => 'Tajikistan',
        'TK' => 'Tokelau',
        'TL' => 'Timor-Leste',
        'TM' => 'Turkmenistan',
        'TN' => 'Tunisia',
        'TO' => 'Tonga',
        'TR' => 'Turkey',
        'TT' => 'Trinidad and Tobago',
        'TV' => 'Tuvalu',
        'TW' => 'Taiwan',
        'TZ' => 'Tanzania',
        'UA' => 'Ukraine',
        'UG' => 'Uganda',
        'UM' => 'United States Minor Outlying Islands',
        'US' => 'United States',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VA' => 'Vatican',
        'VC' => 'Saint Vincent and the Grenadines',
        'VE' => 'Venezuela',
        'VG' => 'British Virgin Islands',
        'VI' => 'U.S. Virgin Islands',
        'VN' => 'Vietnam',
        'VU' => 'Vanuatu',
        'WF' => 'Wallis and Futuna',
        'WS' => 'Samoa',
        'YE' => 'Yemen',
        'YT' => 'Mayotte',
        'YU' => 'Yugoslavia',
        'ZA' => 'South Africa',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',

        // TODO : CHECK FOR KOSOVO ISO CODE. IN THE MEANTIME, WE'LL USE THE CIA World Factbook code.
        'KV' => 'Kosovo'
    );

}

