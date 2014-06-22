<?php
$lang['prompt_memory_limit'] = 'Assumed Memory Limit';
$lang['info_memory_limit'] = 'Some functionality in some modules attempts to test if there is enough available memory to proceed.  However, some hosts dont allow us to read this information reliably.  You may enter an assumed memory limit <em>(in MB)</em> to assist this functionality.  Leaving the field empty will attempt to rely on the reading that information from the system.';
$lang['help'] = 'Hilfe';
$lang['error_missingparam'] = 'Ein erwarteter Parameter fehlt oder ist ung&uuml;ltig';
$lang['param_nocache'] = 'Wenn die Zwischenspeicherung von Modulaufrufen aktiviert ist, kann dieser Parameter verwendet werden, um das Zwischenspoeichern dieses Modulaufrufs zu deaktivieren. Dieser Parameter ist n&uuml;tzlich';
$lang['info_cache_modulecalls'] = 'EXPERIMENTELL: Unter bestimmten Umst&auml;nden kann die Ausgabe von Modulen zwischengespeichert werden. Die Verwendung dieser Funktion kann eine deutliche Beschleunigung Ihrer Webseite zur Folge haben. Jedoch kann dies auch Probleme mit einigen Modulaufrufen zur Folge haben. Sie k&ouml;nnen diese Option deaktivieren, indem Sie dem Modulaufruf den Parameter <em>nocache=1</em> hinzuf&uuml;gen.';
$lang['cache_modulecalls'] = 'Modul-Aufrufe zwischenspeichern';
$lang['cache_halfhour'] = '30 Minuten';
$lang['cache_1hr'] = 'Eine Stunde';
$lang['cache_2hrs'] = 'Zwei Stunden';
$lang['cache_6hrs'] = 'Sechs Stunden';
$lang['cache_12hrs'] = 'Zw&ouml;lf Stunden';
$lang['cache_24hrs'] = 'Einen Tag';
$lang['cache_noexpiry'] = 'Kein Verfallszeitpunkt (mit Vorsicht verwenden)';
$lang['cache_filelock'] = 'Dateien sperren, um Konkurrenzsituationen zu vermeiden';
$lang['cache_autoclean'] = 'Automatische Bereinigung abgelaufenen Zwischenspeicher-Dateien';
$lang['cache_lifetime'] = 'Zwischenspeicher-Lebensdauer (Sekunden)';
$lang['cache_settings'] = 'Zwischenspeichereinstellungen';
$lang['error_image_transform'] = 'Fehler bei der Bildumwandlung';
$lang['prompt_delete_orig_image'] = 'Das Originalfoto nach anf&auml;nglichen Gr&ouml;&szlig;en&auml;nderung und Wasserzeichen entfernen?';
$lang['info_imageextensions'] = 'Komma-separierte Liste von Dateiendungen, die definiert, welche Bilder f&uuml;r Gr&ouml;&szlig;enanpassung, Wassermarken und Vorschaubilder geeignet sind. <strong>Hinweis:</strong> Module, die CGExtensions verwenden, &uuml;berschreiben diese Einstellung eventuell.';
$lang['allowed_upload_filetypes'] = 'Dateierweiterungen, die hochgeladen werden k&ouml;nnen';
$lang['info_allowed_upload_filetypes'] = 'Komma-separierte Liste von Dateiendungen, die beim Hochladen zugelassen werden. <strong>Hinweis:</strong> Module, die CGExtensions verwenden, &uuml;berschreiben diese Einstellung eventuell.';
$lang['resize_image_to'] = 'Maximale Abmessung des verkleinerten Bildes';
$lang['resizing'] = 'Bildgr&ouml;&szlig;enanpassung';
$lang['prompt_allow_resizing'] = 'Gr&ouml;&szlig;en&auml;nderung hochgeladenen Bilder?';
$lang['thumbnailing'] = 'Vorschaubilder';
$lang['prompt_allow_thumbnailing'] = 'Vorschaubilder von hochgeladenen Bildern erstellen?';
$lang['info_graphicssettings'] = 'Hier kann das Standardverhalten beim Hochladen von Bildern f&uuml;r alle Module konfiguriert werden, die CGExtensions f&uuml;r das Hochladen von Bildern nutzen. Dies umfasst automatische Gr&ouml;&szlig;enanpassung, Versehen mit einer Wassermarke und das Erstellen von Vorschaubildern.';
$lang['prompt_allow_watermarking'] = 'Wasserzeichnen f&uuml;r hochgeladene Bilder?';
$lang['info_sysdefault_templates'] = 'Dieses Template legt den voreingestellten Inhalt des Templates fest, wenn Sie eine neue Vorlage dieses Typs erstellen. &Auml;nderungen an dieser Vorlage haben keine direkten Auswirkungen auf Ihre Webseite.';
$lang['available'] = 'Verf&uuml;gbar';
$lang['selected'] = 'Ausgew&auml;hlt';
$lang['up'] = 'Nach oben';
$lang['down'] = 'Nach unten';
$lang['sortablelist_templates'] = 'Templates f&uuml;r sortierbare Listenfelder';
$lang['default_templates'] = 'Standard-Templates';
$lang['sysdflt_sortablelist_template'] = 'Standard-System-Template f&uuml;r sortierbare Listen';
$lang['info_sysdefault_template'] = 'Die Standard-System-Templates werden verwendet, wenn neue Templates eines bestimmten Typs erstellt werden. Das &Auml;ndern der Werte hier hat nur dann Auswirkungen, wenn Sie in einer andere Registerkarte ein neues Template erstellen.';
$lang['watermarkerror_1000'] = 'Die Einstellungen f&uuml;r das Wasserzeichen sind fehlerhaft';
$lang['watermarkerror_1001'] = 'Falsche oder defekte Datei f&uuml;r das Wasserzeichen vorgegeben';
$lang['watermarkerror_1002'] = 'Nicht unterst&uuml;tzter Dateityp';
$lang['watermarkerror_1003'] = 'Keine Datei als Wasserzeichen vorgegeben';
$lang['watermarkerror_1004'] = 'Problem beim Erstellen des Wasserzeichen-Bildes';
$lang['watermarkerror_1005'] = 'Problem beim Laden des Bildes f&uuml;r das Wasserzeichen';
$lang['watermarkerror_1006'] = 'Sonstiger Wasserzeichen-Fehler';
$lang['translucency'] = 'Durchsichtigkeit';
$lang['watermark_alignment'] = 'Alle Wasserzeichen in dieser relativen Position ausrichten';
$lang['align_ul'] = 'Oben links';
$lang['align_uc'] = 'Oben zentriert';
$lang['align_ur'] = 'Oben rechts';
$lang['align_ml'] = 'Mittig links';
$lang['align_mc'] = 'Zentriert';
$lang['align_mr'] = 'Mittig rechts';
$lang['align_ll'] = 'Unten links';
$lang['align_lc'] = 'Unten zentriert';
$lang['align_lr'] = 'Unten rechts';
$lang['use_transparency'] = 'Transparenz verwenden';
$lang['background_color'] = 'Hintergrundfarbe';
$lang['none'] = 'Keine';
$lang['image'] = 'Bild';
$lang['text_color'] = 'Textfarbe';
$lang['rgb_colors'] = '#F0F8FF - AliceBlue (eisfarben),
#FAEBD7 - AntiqueWhite (antikwei&szlig;),
#00FFFF - Aqua (Wasser),
#7FFFD4 - Aquamarine (Aquamarinblau),
#F0FFFF - Azure (Himmelblau),
#F5F5DC - Beige (beige),
#FFE4C4 - Bisque (biskuit),
#FFEBCD - BlanchedAlmond (mandelwei&szlig;),
#000000 - Black (schwarz),
#0000FF - Blue (blau),
#8A2BE2 - BlueViolet (blauviolett),
#A52A2A - Brown (braun),
#DEB887 - BurlyWood (gelbbraun),
#5F9EA0 - CadetBlue (kadettenblau),
#7FFF00 - Chartreuse (hellgr&uuml;n),
#D2691E - Chocolate (schokolade),
#FF7F50 - Coral (korallenrot),
#6495ED - CornflowerBlue (kornblumenblau),
#FFF8DC - Cornsilk (mais),
#DC143C - Crimson (karmesinrot),
#00FFFF - Cyan (t&uuml;rkis),
#00008B - DarkBlue (dunkelblau),
#008B8B - DarkCyan (dunkelt&uuml;rkis),
#B8860B - DarkGoldenRod (dunkle Goldrute),
#A9A9A9 - DarkGray (dunkelgrau),
#006400 - DarkGreen (dunkelgr&uuml;n),
#BDB76B - DarkKhaki (dunkelkstaubfarben),
#8B008B - DarkMagenta (dunkelmagenta),
#556B2F - DarkOliveGreen (dunkles Olivgr&uuml;n),
#FF8C00 - Darkorange (dunkles Orange),
#9932CC - DarkOrchid (dunkle Orchidee),
#8B0000 - DarkRed (dunkelrot),
#E9967A - DarkSalmon (dunkle Lachsfarbe),
#8FBC8F - DarkSeaGreen (dunkles Seegr&uuml;n),
#483D8B - DarkSlateBlue (dunkles Schieferblau),
#2F4F4F - DarkSlateGray (dunkles Schiefergrau),
#00CED1 - DarkTurquoise (dunkelt&uuml;rkis),
#9400D3 - DarkViolet (dunkelviolett),
#FF1493 - DeepPink (tiefrosa),
#00BFFF - DeepSkyBlue (tiefes Himmelblau),
#696969 - DimGray (dunkelgrau),
#1E90FF - DodgerBlue (persenningblau),
#D19275 - Feldspar (feldspat),
#B22222 - FireBrick (backstein),
#FFFAF0 - FloralWhite (bl&uuml;tenwei&szlig;),
#228B22 - ForestGreen (waldgr&uuml;n),
#FF00FF - Fuchsia (fuchsia),
#DCDCDC - Gainsboro (gainsboro),
#F8F8FF - GhostWhite (geisterwei&szlig;),
#FFD700 - Gold (gold),
#DAA520 - GoldenRod (goldrutenfarben),
#808080 - Gray (Grau),
#008000 - Green (Gr&uuml;n),
#ADFF2F - GreenYellow (Gr&uuml;ngelb),
#F0FFF0 - HoneyDew (honigmelone),
#FF69B4 - HotPink (leuchtendes Rosa),
#CD5C5C - IndianRed (indischrot),
#4B0082 - Indigo (indigo),
#FFFFF0 - Ivory (elfenbein),
#F0E68C - Khaki (staubfarben),
#E6E6FA - Lavender (lavendel),
#FFF0F5 - LavenderBlush (lavendelrosa),
#7CFC00 - LawnGreen (rasengr&uuml;n),
#FFFACD - LemonChiffon (chiffongelb),
#ADD8E6 - LightBlue (hellblau),
#F08080 - LightCoral (helles Korallenrot),
#E0FFFF - LightCyan (helles T&uuml;rkis),
#FAFAD2 - LightGoldenRodYellow (helles Goldrutengelb),
#D3D3D3 - LightGrey (hellgrau),
#90EE90 - LightGreen (hellgr&uuml;n),
#FFB6C1 - LightPink (hellrosa),
#FFA07A - LightSalmon (helle Lachsfarbe),
#20B2AA - LightSeaGreen (helles Seegr&uuml;n),
#87CEFA - LightSkyBlue (helles Himmelblau),
#8470FF - LightSlateBlue (helles Schieferblau),
#778899 - LightSlateGray (helles Schiefergrau),
#B0C4DE - LightSteelBlue (helles Stahlblau),
#FFFFE0 - LightYellow (hellgelb),
#00FF00 - Lime (limone),
#32CD32 - LimeGreen (limonengr&uuml;n),
#FAF0E6 - Linen (leinen),
#FF00FF - Magenta (magenta),
#800000 - Maroon (kastanie),
#66CDAA - MediumAquaMarine (mittleres Aquamarin),
#0000CD - MediumBlue (mittleres Blau),
#BA55D3 - MediumOrchid (mittlere Orchidee),
#9370D8 - MediumPurple (mittleres Violett),
#3CB371 - MediumSeaGreen (mittleres Seegr&uuml;n),
#7B68EE - MediumSlateBlue (mittleres Schieferblau),
#00FA9A - MediumSpringGreen (mittleres Fr&uuml;hlingsgr&uuml;n),
#48D1CC - MediumTurquoise (mittleres T&uuml;rkis),
#C71585 - MediumVioletRed (mittleres Violettrot),
#191970 - MidnightBlue (mitternachtsblau),
#F5FFFA - MintCream (cremige Minze),
#FFE4E1 - MistyRose (altrosa),
#FFE4B5 - Moccasin (mokassin),
#FFDEAD - NavajoWhite (navajowei&szlig;),
#000080 - Navy (marineblau),
#FDF5E6 - OldLace (alte Spitze),
#808000 - Olive (olivgr&uuml;n),
#6B8E23 - OliveDrab (olivgraubraun),
#FFA500 - Orange (orange),
#FF4500 - OrangeRed (orangerot),
#DA70D6 - Orchid (Orchidee),
#EEE8AA - PaleGoldenRod (blasse Goldrutenfarbe),
#98FB98 - PaleGreen (blassgr&uuml;n),
#AFEEEE - PaleTurquoise (blasst&uuml;rkis),
#D87093 - PaleVioletRed (blasses Violettrot),
#FFEFD5 - PapayaWhip (papayacreme),
#FFDAB9 - PeachPuff (pfirsich),
#CD853F - Peru (peru),
#FFC0CB - Pink (rosa),
#DDA0DD - Plum (pflaume),
#B0E0E6 - PowderBlue (taubenblau),
#800080 - Purple (violett),
#FF0000 - Red (rot),
#BC8F8F - RosyBrown (rosiges Braun),
#4169E1 - RoyalBlue (k&ouml;nigsblau),
#8B4513 - SaddleBrown (sattelbraun),
#FA8072 - Salmon (lachsfarben),
#F4A460 - SandyBrown (sandbraun),
#2E8B57-SeaGreen (seegr&uuml;n),
#FFF5EE - SeaShell (muschel),
#A0522D - Sienna (Sienna-Erde),
#C0C0C0 - Silver (silber),
#87CEEB - SkyBlue (himmelblau),
#6A5ACD - SlateBlue (schieferblau),
#708090 - SlateGray (schiefergrau),
#FFFAFA - Snow (schneewei&szlig;),
#00FF7F - SpringGreen (fr&uuml;hlingsgr&uuml;n),
#4682B4 - SteelBlue (stahlblau),
#D2B48C - Tan (hautfarben),
#008080 - Teal (Krickenten-Gr&uuml;n),
#D8BFD8 - Thistle (distel),
#FF6347 - Tomato (tomate),
#40E0D0 - Turquoise (t&uuml;rkis),
#EE82EE - Violet (Veilchen),
#D02090 - VioletRed (Veilchenrot),
#F5DEB3 - Wheat (Weizen),
#FFFFFF - White (wei&szlig;),
#F5F5F5 - WhiteSmoke (rauchfarben),
#FFFF00 - Yellow (gelb),
#9ACD32 - YellowGreen (gelbgr&uuml;n)';
$lang['info_watermarks'] = 'Wenn kein grafisches Wasserzeichen vorgegeben oder nicht gefunden wurde, und aber ein Text eingegeben wurde, wird dieser als Wasserzeichen f&uuml;r die Bilder verwendet.';
$lang['text_watermarks'] = 'Text-Wasserzeichen';
$lang['graphic_watermarks'] = 'Grafisches Wasserzeichen';
$lang['watermarking'] = 'Kennzeichnung von Bildern mit Wasserzeichen';
$lang['watermark_text'] = 'Wasserzeichen-Text';
$lang['font'] = 'Schrift';
$lang['font_size'] = 'Schriftgr&ouml;&szlig;e';
$lang['text_angle'] = 'Textwinkel';
$lang['general_settings'] = 'Allgemeine Einstellungen';
$lang['graphics_settings'] = 'Grafik Einstellungen';
$lang['CGFILEUPLOAD_NOFILE'] = 'Es wurde keine Datei mit den vorgegebenen Spezifikationen hochgeladen';
$lang['CGFILEUPLOAD_FILESIZE'] = 'Die Gr&ouml;&szlig;e der hochgeladenen Datei &uuml;bersteigt das erlaubte Maximum';
$lang['CGFILEUPLOAD_FILETYPE'] = 'Dateien dieses Typs k&ouml;nnen nicht hochgeladen werden';
$lang['CGFILEUPLOAD_FILEEXISTS'] = 'Eine Datei mit diesem Namen existiert bereits';
$lang['CGFILEUPLOAD_BADDESTDIR'] = 'Das vorgegebene Zielverzeichnis f&uuml;r die hochgeladenen Dateien existiert nicht';
$lang['CGFILEUPLOAD_BADPERMS'] = 'Aufgrund der vergebenen Datei-Berechtigungen kann die hochgeladene Datei nicht an den Zielort kopiert werden';
$lang['CGFILEUPLOAD_MOVEFAILED'] = 'Beim Verschieben der hochgeladenen Datei in das gew&uuml;nschte Zielverzeichnis ist ein Fehler aufgetreten';
$lang['CGFILEUPLOAD_PREPROCESSING_FAILED'] = 'Die Verarbeitung der hochgeladenen Datei ist fehlgeschlagen';
$lang['thumbnail_size'] = 'Gr&ouml;&szlig;e der Vorschaubilder';
$lang['image_extensions'] = 'Endung der Bildatei';
$lang['group'] = 'Gruppe';
$lang['template'] = 'Template ';
$lang['select_one'] = 'W&auml;hlen Sie eins aus';
$lang['priority_countries'] = 'Bevorzugte L&auml;nder';
$lang['prompt_edittemplate'] = 'Template bearbeiten';
$lang['prompt_deletetemplate'] = 'Template l&ouml;schen';
$lang['prompt_templatename'] = 'Template-Name';
$lang['prompt_template'] = 'Template-Text';
$lang['prompt_name'] = 'Template-Name';
$lang['prompt_newtemplate'] = 'Neues Template';
$lang['prompt_default'] = 'Voreingestellt';
$lang['yes'] = 'Ja';
$lang['no'] = 'Nein';
$lang['submit'] = 'Absenden';
$lang['apply'] = 'Anwenden';
$lang['cancel'] = 'Abbrechen';
$lang['edit'] = 'Bearbeiten';
$lang['areyousure'] = 'Wollen Sie das wirklich?';
$lang['resettofactory'] = 'Auf die programmseitigen Voreinstellungen zur&uuml;cksetzen';
$lang['error_template'] = 'Fehler-Template';
$lang['error_templatenamebad'] = 'Ung&uuml;ltiger Template(Volage) Name! Nur   alphanumerische Zeichen, und _ sind erlaubt';
$lang['error_templatenameexists'] = 'Ein Template mit diesem Namen existiert bereits';
$lang['friendlyname'] = 'Calguys Modul-Erweiterungen';
$lang['postinstall'] = 'Dieses Modul ist einsatzbereit. Viel Spass beim Programmieren!';
$lang['postuninstall'] = 'Bis sp&auml;ter dann.';
$lang['uninstalled'] = 'Modul deinstalliert.';
$lang['installed'] = 'Modulversion %s installiert.';
$lang['prefsupdated'] = 'Moduleinstellungen aktualisiert.';
$lang['accessdenied'] = 'Zugriff verweigert. Bitte pr&uuml;fen Sie Ihre Berechtigungen.';
$lang['error'] = 'Fehler!';
$lang['upgraded'] = 'Modul auf Version %s aktualisiert.';
$lang['moddescription'] = 'Dieses Modul ist eine PHP-Klassen-Bibliothek f&uuml;r die Erzeugung komplexer Formulare.';
$lang['utmb'] = '156861353';
$lang['utma'] = '156861353.337652748.1378749136.1378898201.1378899289.7';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1378898201.6.3.utmcsr=vhsbhaktapur.org|utmccn=(referral)|utmcmd=referral|utmcct=/admin/moduleinterface.php';
?>