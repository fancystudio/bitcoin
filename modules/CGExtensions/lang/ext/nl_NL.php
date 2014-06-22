<?php
$lang['prompt_memory_limit'] = 'Veronderstelde Memory Limit';
$lang['info_memory_limit'] = 'Er zijn functies in modules die proberen te testen of er voldoende werkgeheugen beschikbaar is. Echter, niet alle webhosts geven we deze informatie betrouwbaar vrij. U kunt een veronderstelde geheugen limiet <em> (in MB) </ em> om deze functionaliteit te helpen. Het niet invullen van het veld leeg zal proberen een waarde te lezen uit de systeem informatie.';
$lang['help'] = 'Help ';
$lang['error_missingparam'] = 'Een noodzakelijke parameter ontbreekt of is ongeldig';
$lang['param_nocache'] = 'Wordt gebruikt wanneer caching van module-aanvragen is ingeschakeld, met deze parameter is het mogelijk om caching uit te schakelen voor deze module-aanvraag.';
$lang['info_cache_modulecalls'] = 'Onder sommige omstandigheden kan de output van aanvragen van modules worden gecached. Als u dit inschakelt zal dit zorgen voor een significante snelheidsverbetering van uw website. Mogelijk ontstaan er wel problemen met sommige aanvragen. U kunt deze optie uitschakelen door de parameter &#039;nocache=1&#039; toe te voegen aan een moduletag.';
$lang['cache_modulecalls'] = 'Cache aanvragen van modules';
$lang['cache_halfhour'] = 'Half uur';
$lang['cache_1hr'] = 'Een uur';
$lang['cache_2hrs'] = 'Twee uur';
$lang['cache_6hrs'] = 'Zes uur';
$lang['cache_12hrs'] = 'Twaalf uur';
$lang['cache_24hrs'] = 'Een dag';
$lang['cache_noexpiry'] = 'Niet laten verlopen (wees voorzichtig)';
$lang['cache_filelock'] = 'Beveilig bestanden om rare omstandigheden te voorkomen';
$lang['cache_autoclean'] = 'Verwijder automatisch gebufferde bestanden';
$lang['cache_lifetime'] = 'Levensduur Buffer (seconden)';
$lang['cache_settings'] = 'Buffer Instellingen';
$lang['error_image_transform'] = 'Fout bij de bewerking van de afbeelding';
$lang['prompt_delete_orig_image'] = 'Verwijder de originele afbeelding na het verschalen en het aanbrengen van het watermerk?';
$lang['info_imageextensions'] = 'Benoem een komma gescheiden lijst van extensies van afbeeldingen die geschikt zijn voor verschalen, watermerken en miniaturen. <strong>Opmerking:</strong> Modules die gebruik maken van CGExtensions upload functionaliteiten kunnen deze instellingen overschrijven.';
$lang['allowed_upload_filetypes'] = 'Bestandextensies die mogen worden ge&uuml;pload';
$lang['info_allowed_upload_filetypes'] = 'Benoem een komma gescheiden lijst van extensies die mogen worden ge&uuml;pload.  <strong>Opmerking:</strong> Modules die gebruik maken van CGExtensions upload functionaliteiten kunnen deze instellingen overschrijven';
$lang['resize_image_to'] = 'Maximale afmeting van de verschaalde afbeelding';
$lang['resizing'] = 'Afbeelding Verschaling';
$lang['prompt_allow_resizing'] = 'Verschaal ge&uuml;ploade afbeeldingen?';
$lang['thumbnailing'] = 'Miniaturen:';
$lang['prompt_allow_thumbnailing'] = 'Maak miniaturen van ge&uuml;ploade afbeeldingen?';
$lang['info_graphicssettings'] = 'In deze tab kunt u de standaard waarden instellen voor modules die gebruik maken van CGExtensions functies voor het uploaden van afbeeldingen.  Deze functionaliteiten omvatten ook het verschalen van afbeeldingen, het aanbrengen van watermerken en het aanmaken van miniaturen.';
$lang['prompt_allow_watermarking'] = 'Voorzie ge&uuml;ploade afbeeldingen van een watermerk?';
$lang['info_sysdefault_templates'] = 'Dit sjabloon bepaalt de standaard inhoud van een sjabloon, wanneer een nieuw sjabloon wordt aangemaakt voor het specifieke type. Wijzigingen in deze inhoud heeft geen direct effect op je website.';
$lang['available'] = 'Beschikbaar';
$lang['selected'] = 'Geselecteerd';
$lang['up'] = 'Omhoog';
$lang['down'] = 'Omlaag';
$lang['sortablelist_templates'] = 'Sorteerbare lijst sjablonen';
$lang['default_templates'] = 'Standaard sjablonen';
$lang['sysdflt_sortablelist_template'] = 'Standaard sorteerbare lijst sjabloon';
$lang['info_sysdefault_template'] = 'Systeem standaard sjablonen worden gebruikt bij het maken van een nieuw sjabloon van een bepaald type. Het veranderen van de waarden hier zullen alleen effect hebben als u een nieuwe sjabloon in een ander tabblad aanmaakt.';
$lang['watermarkerror_1000'] = 'Watermerk aanbrengen is niet goed geconfigureerd';
$lang['watermarkerror_1001'] = 'Verkeerd of defect bestand gespecificeerd voor watermerken';
$lang['watermarkerror_1002'] = 'Niet ondersteund bestandstype';
$lang['watermarkerror_1003'] = 'Geen bestand opgegeven voor het plaatsen van een watermerk';
$lang['watermarkerror_1004'] = 'Probleem bij aanmaken watermerkbestand';
$lang['watermarkerror_1005'] = 'Probleem bij laden bestand voor het aanbrengen van een watermerk';
$lang['watermarkerror_1006'] = 'Andere watermerk fout';
$lang['translucency'] = 'Doorschijnendheid';
$lang['watermark_alignment'] = 'Lijn alle watermerken uit in deze relatieve positie';
$lang['align_ul'] = 'Top Links';
$lang['align_uc'] = 'Top Midden';
$lang['align_ur'] = 'Top Rechts';
$lang['align_ml'] = 'Midden Links';
$lang['align_mc'] = 'Midden';
$lang['align_mr'] = 'Midden Rechts';
$lang['align_ll'] = 'Onder Links';
$lang['align_lc'] = 'Onder Midden';
$lang['align_lr'] = 'Onder Rechts';
$lang['use_transparency'] = 'Gebruik Transparantie';
$lang['background_color'] = 'Achtergrondkleur';
$lang['none'] = 'Geen';
$lang['image'] = 'Foto';
$lang['text_color'] = 'Tekst kleur';
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
#9ACD32-YellowGreen ';
$lang['info_watermarks'] = 'Wanneer geen grafisch watermerk is opgegeven, of niet kan worden gevonden, en tekstinstellingen zijn opgegeven, worden deze gebruikt voor watermerken';
$lang['text_watermarks'] = 'Tekst watermerken';
$lang['graphic_watermarks'] = 'Grafische watermerken';
$lang['watermarking'] = 'Watermerken';
$lang['watermark_text'] = 'Watermerk tekst';
$lang['font'] = 'Font ';
$lang['font_size'] = 'Fontgrootte';
$lang['text_angle'] = 'Teksthoek';
$lang['general_settings'] = 'Algemene instellingen';
$lang['graphics_settings'] = 'Grafische instellingen';
$lang['CGFILEUPLOAD_NOFILE'] = 'Geen bestand met deze specificaties gevonden';
$lang['CGFILEUPLOAD_FILESIZE'] = 'Grootte van het opgegeven bestand is groter dan het maximum toegestane';
$lang['CGFILEUPLOAD_FILETYPE'] = 'Dit bestandstype kan niet worden ge&uuml;pload';
$lang['CGFILEUPLOAD_FILEEXISTS'] = 'Een bestand met deze naam bestaat reeds';
$lang['CGFILEUPLOAD_BADDESTDIR'] = 'De opgegeven folder bestaat niet';
$lang['CGFILEUPLOAD_BADPERMS'] = 'Permissies staat schrijven in deze folder niet toe';
$lang['CGFILEUPLOAD_MOVEFAILED'] = 'Poging om het bestand naar zijn definitieve folder te verplaatsen is mislukt';
$lang['CGFILEUPLOAD_PREPROCESSING_FAILED'] = 'Het voorbereiden van het ge&uuml;ploade bestand is mislukt';
$lang['thumbnail_size'] = 'Grootte van de miniatuur';
$lang['image_extensions'] = 'Afbeeldingsbestandextenties';
$lang['group'] = 'Groep';
$lang['template'] = 'Sjabloon';
$lang['select_one'] = 'Selecteer &eacute;&eacute;n';
$lang['priority_countries'] = 'Belangrijke Landen';
$lang['prompt_edittemplate'] = 'Bewerk sjabloon';
$lang['prompt_deletetemplate'] = 'Verwijder sjabloon';
$lang['prompt_templatename'] = 'Sjabloonnaam';
$lang['prompt_template'] = 'Sjabloontekst';
$lang['prompt_name'] = 'Sjabloonnaam';
$lang['prompt_newtemplate'] = 'Nieuw sjabloon';
$lang['prompt_default'] = 'Standaard';
$lang['yes'] = 'Ja';
$lang['no'] = 'Nee';
$lang['submit'] = 'Verstuur';
$lang['apply'] = 'Toepassen';
$lang['cancel'] = 'Annuleer';
$lang['edit'] = 'Bewerk';
$lang['areyousure'] = 'Weet u het zeker?';
$lang['resettofactory'] = 'Herstel naar fabrieksstandaard';
$lang['error_template'] = 'Foutensjabloon';
$lang['error_templatenamebad'] = 'Ongeldige sjabloon naam. Alleen alfanumerieke karakters en underscore (_) zijn toegestaan';
$lang['error_templatenameexists'] = 'Een sjabloon met die naam bestaat al';
$lang['friendlyname'] = 'CG Extensions';
$lang['postinstall'] = 'Deze module is gereed voor gebruik.';
$lang['postuninstall'] = 'Tot ziens';
$lang['uninstalled'] = 'Module gede&iuml;nstaleerd.';
$lang['installed'] = 'Moduleversie %s ge&iuml;nstalleerd.';
$lang['prefsupdated'] = 'Module voorkeuren bijgewerkt.';
$lang['accessdenied'] = 'Toegang geweigerd. Controleer uw rechten.';
$lang['error'] = 'Fout!';
$lang['upgraded'] = 'Module bijgewerkt naar versie %s.';
$lang['moddescription'] = 'De module is een bibliotheek met php-classes voor het bouwen van uitgebreide formulieren';
$lang['utma'] = '156861353.1652442735.1375624076.1375624076.1375624076.1';
$lang['utmz'] = '156861353.1375624076.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>