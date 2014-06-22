<?php
$lang['prompt_memory_limit'] = 'Antatt minnebegrensning';
$lang['info_memory_limit'] = 'Noe funksjonalitet i enkelte moduler fors&oslash;ker &aring; teste om det er nok tilgjengelig minne til &aring; fortsette. Men noen verter tillater oss ikke &aring; lese denne informasjonen p&aring;litelig. Du kan angi en antatt minnegrense <em>(i MB)</em> for &aring; bist&aring; denne funksjonaliteten. &Aring; la dette feltet st&aring; tomt vil si &aring; fors&oslash;ke &aring; stole p&aring; &aring; lese informasjon fra systemet.';
$lang['help'] = 'Hjelp';
$lang['error_missingparam'] = 'En p&aring;krevd parameter manglet eller var ugyldig';
$lang['param_nocache'] = 'Brukes hvis caching av modulkall er aktivert, da vil denne parameteren deaktivere mellomlagring av denne modulens kall. Denne parameteren er nyttig';
$lang['info_cache_modulecalls'] = 'EKSPERIMENTELL: Under visse omstendigheter, kan resultat av kall til moduler bufres. Aktivering av denne kan ha en betydelig ytelsesforbedring for webomr&aring;det ditt. Imidlertid kan det f&oslash;re til vanskeligheter med noen kall. Du kan deaktivere dette alternativet ved &aring; legge til parameteren nocache=1 i modulkallet';
$lang['cache_modulecalls'] = 'Mellomlagring av modul kall';
$lang['cache_halfhour'] = 'En halv time';
$lang['cache_1hr'] = 'En time';
$lang['cache_2hrs'] = 'To timer';
$lang['cache_6hrs'] = 'Seks timer';
$lang['cache_12hrs'] = 'Tolv timer';
$lang['cache_24hrs'] = 'En dag';
$lang['cache_noexpiry'] = 'Ikke tillat tidsutl&oslash;p (benytt med forsiktighet)';
$lang['cache_filelock'] = 'L&aring;s filer for &aring; unng&aring; problem med konkurerende tilgang';
$lang['cache_autoclean'] = 'Rens automatisk utl&oslash;pte mellomlagringsfiler';
$lang['cache_lifetime'] = 'Mellomlagring livstid (sekunder)';
$lang['cache_settings'] = 'Mellomlagringsinstillinger';
$lang['error_image_transform'] = 'Feil i omgj&oslash;ring av bildet';
$lang['prompt_delete_orig_image'] = 'Fjern det orginale bildet etter innledende skalering og vannmerking?';
$lang['info_imageextensions'] = 'Oppgi en kommaseparert liste med filendelser som angir bildefiler som er egnede for skalering, vannmerking, og &aring; lage miniatyrbilder av. <strong>Merk:</strong> Moduler som bruker CGExtensions opplastingsegenskap kan overstyre disse innstillingene.';
$lang['allowed_upload_filetypes'] = 'Filendelser for filer som f&aring;r lastes opp';
$lang['info_allowed_upload_filetypes'] = 'Oppgi en kommaseparert liste med filendelser som angir filer som f&aring;r lastes opp. <strong>Merk:</strong> Moduler som bruker CGExtensions opplastingsegenskap kan overstyre disse innstillingene';
$lang['resize_image_to'] = 'Maksimal st&oslash;rrelse p&aring; det skalerte bildet';
$lang['resizing'] = 'Bildeskalering';
$lang['prompt_allow_resizing'] = 'Skaler opplastede bilder?';
$lang['thumbnailing'] = 'Miniatyrbilde:';
$lang['prompt_allow_thumbnailing'] = 'Opprett miniatyrbilder fra opplastede bilder?';
$lang['info_graphicssettings'] = 'Denne fanen tillater konfigurering av standard oppf&oslash;rsel for moduler som benytter CGExtensions funksjonaliteten for opplasting av bilder. Funksjonaliteten inkluderer automatisk skalering av innkommende bilde, vannmerking og oppretting av miniatyrbilde';
$lang['prompt_allow_watermarking'] = 'Vannmerk opplastede bilder?';
$lang['info_sysdefault_templates'] = 'Denne malen definerer standard innhold for en mal n&aring;r du oppretter en ny mal av denne typen. &Aring; endre dette innholdet vil ikke ha umiddelbar effekt p&aring; ditt nettsted.';
$lang['available'] = 'Tilgjengelig';
$lang['selected'] = 'Valgt';
$lang['up'] = 'Opp';
$lang['down'] = 'Ned';
$lang['sortablelist_templates'] = 'Sorterbare Listeomr&aring;de maler';
$lang['default_templates'] = 'Standard maler';
$lang['sysdflt_sortablelist_template'] = 'System standard sorterbar listemal';
$lang['info_sysdefault_template'] = 'System standard maler blir benyttet n&aring;r det opprettes en ny malen en bestemt type. &Aring; endre verdiene her vil kun ha effekt n&aring;r n&aring;r du lager en ny mal i en annen fane';
$lang['watermarkerror_1000'] = 'Vannmerking er ikke tilstrekkelig konfigurert';
$lang['watermarkerror_1001'] = 'D&aring;rlig eller korrupt fil spesifisert for vannmerking';
$lang['watermarkerror_1002'] = 'Filtype st&oslash;ttes ikke';
$lang['watermarkerror_1003'] = 'Ingen fil spesifisert for vannmerking';
$lang['watermarkerror_1004'] = 'Problem med &aring; lage vannmerkebilde';
$lang['watermarkerror_1005'] = 'Problem med &aring; laste bilde for vannmerking';
$lang['watermarkerror_1006'] = 'Annen vannmerkefeil';
$lang['translucency'] = 'Gjennomskinnelighet';
$lang['watermark_alignment'] = 'Juster alle vannmerker til denne relative posisjonen';
$lang['align_ul'] = 'Topp venstre';
$lang['align_uc'] = 'Topp senter';
$lang['align_ur'] = 'Topp h&oslash;yre';
$lang['align_ml'] = 'Midten venstre';
$lang['align_mc'] = 'Senter';
$lang['align_mr'] = 'Midten h&oslash;yre';
$lang['align_ll'] = 'Bunn venstre';
$lang['align_lc'] = 'Bunn senter';
$lang['align_lr'] = 'Bunn h&oslash;yre';
$lang['use_transparency'] = 'Benytt Transparens';
$lang['background_color'] = 'Bakgrunnsfarge';
$lang['none'] = 'Ingen';
$lang['image'] = 'Bilde';
$lang['text_color'] = 'Tekstfarge';
$lang['rgb_colors'] = '#F0F8FF-AliceBlue,
#FAEBD7-AntiqueWhite,
#00FFFF-Aqua,
#7FFFD4-Aquamarine,
#F0FFFF-Azure,
#F5F5DC-Beige,
#FFE4C4-Bisque,
#FFEBCD-BlanchedAlmond,
#000000-Black,
#0000FF-Blue,
#8A2BE2-BlueViolet,
#A52A2A-Brown,
#DEB887-BurlyWood,
#5F9EA0-CadetBlue,
#7FFF00-Chartreuse,
#D2691E-Chocolate,
#FF7F50-Coral,
#6495ED-CornflowerBlue,
#FFF8DC-Cornsilk,
#DC143C-Crimson,
#00FFFF-Cyan,
#00008B-DarkBlue,
#008B8B-DarkCyan,
#B8860B-DarkGoldenRod,
#A9A9A9-DarkGray,
#006400-DarkGreen,
#BDB76B-DarkKhaki,
#8B008B-DarkMagenta,
#556B2F-DarkOliveGreen,
#FF8C00-Darkorange,
#9932CC-DarkOrchid,
#8B0000-DarkRed,
#E9967A-DarkSalmon,
#8FBC8F-DarkSeaGreen,
#483D8B-DarkSlateBlue,
#2F4F4F-DarkSlateGray,
#00CED1-DarkTurquoise,
#9400D3-DarkViolet,
#FF1493-DeepPink,
#00BFFF-DeepSkyBlue,
#696969-DimGray,
#1E90FF-DodgerBlue,
#D19275-Feldspar,
#B22222-FireBrick,
#FFFAF0-FloralWhite,
#228B22-ForestGreen,
#FF00FF-Fuchsia,
#DCDCDC-Gainsboro,
#F8F8FF-GhostWhite,
#FFD700-Gold,
#DAA520-GoldenRod,
#808080-Gray,
#008000-Green,
#ADFF2F-GreenYellow,
#F0FFF0-HoneyDew,
#FF69B4-HotPink,
#CD5C5C-IndianRed,
#4B0082-Indigo,
#FFFFF0-Ivory,
#F0E68C-Khaki,
#E6E6FA-Lavender,
#FFF0F5-LavenderBlush,
#7CFC00-LawnGreen,
#FFFACD-LemonChiffon,
#ADD8E6-LightBlue,
#F08080-LightCoral,
#E0FFFF-LightCyan,
#FAFAD2-LightGoldenRodYellow,
#D3D3D3-LightGrey,
#90EE90-LightGreen,
#FFB6C1-LightPink,
#FFA07A-LightSalmon,
#20B2AA-LightSeaGreen,
#87CEFA-LightSkyBlue,
#8470FF-LightSlateBlue,
#778899-LightSlateGray,
#B0C4DE-LightSteelBlue,
#FFFFE0-LightYellow,
#00FF00-Lime,
#32CD32-LimeGreen,
#FAF0E6-Linen,
#FF00FF-Magenta,
#800000-Maroon,
#66CDAA-MediumAquaMarine,
#0000CD-MediumBlue,
#BA55D3-MediumOrchid,
#9370D8-MediumPurple,
#3CB371-MediumSeaGreen,
#7B68EE-MediumSlateBlue,
#00FA9A-MediumSpringGreen,
#48D1CC-MediumTurquoise,
#C71585-MediumVioletRed,
#191970-MidnightBlue,
#F5FFFA-MintCream,
#FFE4E1-MistyRose,
#FFE4B5-Moccasin,
#FFDEAD-NavajoWhite,
#000080-Navy,
#FDF5E6-OldLace,
#808000-Olive,
#6B8E23-OliveDrab,
#FFA500-Orange,
#FF4500-OrangeRed,
#DA70D6-Orchid,
#EEE8AA-PaleGoldenRod,
#98FB98-PaleGreen,
#AFEEEE-PaleTurquoise,
#D87093-PaleVioletRed,
#FFEFD5-PapayaWhip,
#FFDAB9-PeachPuff,
#CD853F-Peru,
#FFC0CB-Pink,
#DDA0DD-Plum,
#B0E0E6-PowderBlue,
#800080-Purple,
#FF0000-Red,
#BC8F8F-RosyBrown,
#4169E1-RoyalBlue,
#8B4513-SaddleBrown,
#FA8072-Salmon,
#F4A460-SandyBrown,
#2E8B57-SeaGreen,
#FFF5EE-SeaShell,
#A0522D-Sienna,
#C0C0C0-Silver,
#87CEEB-SkyBlue,
#6A5ACD-SlateBlue,
#708090-SlateGray,
#FFFAFA-Snow,
#00FF7F-SpringGreen,
#4682B4-SteelBlue,
#D2B48C-Tan,
#008080-Teal,
#D8BFD8-Thistle,
#FF6347-Tomato,
#40E0D0-Turquoise,
#EE82EE-Violet,
#D02090-VioletRed,
#F5DEB3-Wheat,
#FFFFFF-White,
#F5F5F5-WhiteSmoke,
#FFFF00-Yellow,
#9ACD32-YellowGreen';
$lang['info_watermarks'] = 'Vannmerking er en metode for &aring; unng&aring; bildetyveri. Enten et bilde, eller en spesifisert tekst blir lagt p&aring; toppen av opplastet bilde. Hvis et grafisk vannmerke ikke er angitt, eller ikke kan finnes, og tekstinnstillingene er angitt, vil disse bli brukt for vannmerking av bilder';
$lang['text_watermarks'] = 'Tekstbaserte vannmerker';
$lang['graphic_watermarks'] = 'Grafiske vannmerker';
$lang['watermarking'] = 'Vannmerking';
$lang['watermark_text'] = 'Vannmerke tekst';
$lang['font'] = 'Font ';
$lang['font_size'] = 'Fontst&oslash;rrelse';
$lang['text_angle'] = 'Tekstvinkel';
$lang['general_settings'] = 'Generelle innstillinger';
$lang['graphics_settings'] = 'Grafikk innstillinger';
$lang['CGFILEUPLOAD_NOFILE'] = 'Ingen av de opplastede filene passer til kriteriene';
$lang['CGFILEUPLOAD_FILESIZE'] = 'St&oslash;rrelsen p&aring; den opplastede filen overstiger det som er tillatt';
$lang['CGFILEUPLOAD_FILETYPE'] = 'Filer av denne type kan ikke lastes opp';
$lang['CGFILEUPLOAD_FILEEXISTS'] = 'En fil med samme navn eksisterer allerede';
$lang['CGFILEUPLOAD_BADDESTDIR'] = 'Destinasjonskatalogen som er spesifisert for opplastede filer eksisterer ikke';
$lang['CGFILEUPLOAD_BADPERMS'] = 'Filtillatelsene tillater ikke &aring; lagre den opplastede fila p&aring; det oppgitte m&aring;let';
$lang['CGFILEUPLOAD_MOVEFAILED'] = 'Fors&oslash;ket p&aring; &aring; flytte den opplastede fila til sitt endelige m&aring;l mislyktes.';
$lang['CGFILEUPLOAD_PREPROCESSING_FAILED'] = 'Forprosessering av den opplastede filen feilet';
$lang['thumbnail_size'] = 'St&oslash;rrelse p&aring; miniatyrbilder';
$lang['image_extensions'] = 'Bilde filendelser';
$lang['group'] = 'Gruppe';
$lang['template'] = 'Mal';
$lang['select_one'] = 'Velg en';
$lang['priority_countries'] = 'Prioriterte land';
$lang['prompt_edittemplate'] = 'Rediger mal';
$lang['prompt_deletetemplate'] = 'Slett mal';
$lang['prompt_templatename'] = 'Mal navn';
$lang['prompt_template'] = 'Mal tekst';
$lang['prompt_name'] = 'Mal navn';
$lang['prompt_newtemplate'] = 'Ny mal';
$lang['prompt_default'] = 'Standard';
$lang['yes'] = 'Ja';
$lang['no'] = 'Nei';
$lang['submit'] = 'Lagre';
$lang['apply'] = 'Bruk';
$lang['cancel'] = 'Avbryt';
$lang['edit'] = 'Rediger';
$lang['areyousure'] = 'Er du sikker?';
$lang['resettofactory'] = 'Tilbakestill til standard';
$lang['error_template'] = 'Feilmal';
$lang['error_templatenamebad'] = 'Ugyldig malnavn. Kun alfanummeriske bokstaver, og _ er tillatt';
$lang['error_templatenameexists'] = 'En mal med det navnet eksisterer allerede';
$lang['friendlyname'] = 'Calguys Module Extensions ';
$lang['postinstall'] = 'Denne modulen er ferdig til bruk. Kod i vei!';
$lang['postuninstall'] = 'Ser deg igjen en annen dag';
$lang['uninstalled'] = 'Modul avinstallert';
$lang['installed'] = 'Modul versjon %s installert';
$lang['prefsupdated'] = 'Modul innstillinger oppdatert.';
$lang['accessdenied'] = 'Tilgang nektet. Vennligst sjekk dine rettigheter.';
$lang['error'] = 'Feil!';
$lang['upgraded'] = 'Modul oppgradert til versjon %s.';
$lang['moddescription'] = 'Denne modulen er et bibliotek av php klasser brukt til &aring; bygge avanserte skjemaer';
$lang['qca'] = 'P0-536849115-1307983495210';
$lang['utma'] = '156861353.137516986.1374423446.1374771471.1374779282.12';
$lang['utmz'] = '156861353.1374423446.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['utmc'] = '156861353';
$lang['utmb'] = '156861353';
?>