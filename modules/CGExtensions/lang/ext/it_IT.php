<?php
$lang['msg_templatesaved'] = 'Modello salvato';
$lang['prompt_memory_limit'] = 'Limite di Memoria presunto';
$lang['info_memory_limit'] = 'Alcune funzionalit&agrave; di alcuni moduli cercano di verificare se ci sia abbastanza memoria disponibile per procedere. Tuttavia alcuni servizi di hosting non ci permettono di leggere la disponibilit&agrave; di questa informazione. Potete inserire un limite di memoria presunta <em>(in MB)</em> per aiutare questa funzionalit&agrave;. Lasciando questo campo vuoto verr&agrave; tentato di basarsi sulla lettura dell&#039;informazione dal sistema.';
$lang['help'] = 'Aiuto';
$lang['error_missingparam'] = 'Un paramentro necessario non &egrave; presente oppure non &egrave; valido';
$lang['param_nocache'] = 'Utilizzato se &egrave; abilitata la memorizzazione in cache delle chiamate ai moduli, questo parametro disabiliter&agrave; la memorizzazione in cache di questa chiamata modulo.  &amp;Egrave; un parametro utile';
$lang['info_cache_modulecalls'] = 'SPERIMENTALE: In alcune circostanze l&#039;output di chiamate ai moduli pu&ograve; essere memorizzato in cache.  Abilitando quest&#039;opzione si potrebbe ottenere un aumento significativo delle prestazioni del vostro sito. Tuttavia si potrebbero verificare delle difficolt&agrave; con alcune richieste.   Potete disabilitare quest&#039;opzione aggiungendo il parametro nocache=1 alla stringa di utilizzo del modulo';
$lang['cache_modulecalls'] = 'usa Cache per chiamate modulo';
$lang['cache_halfhour'] = 'Mezzora';
$lang['cache_1hr'] = 'Un&#039;Ora';
$lang['cache_2hrs'] = 'Due Ore';
$lang['cache_6hrs'] = 'Sei Ore';
$lang['cache_12hrs'] = 'Dodici Ore';
$lang['cache_24hrs'] = 'Un Giorno';
$lang['cache_noexpiry'] = 'Nessuna scadenza (usare con cautela)';
$lang['cache_filelock'] = 'Blocca i file per prevenire sprechi di risorse';
$lang['cache_autoclean'] = 'Pulisce automaticamente i file di cache scaduti';
$lang['cache_lifetime'] = 'Durata Cache (secondi)';
$lang['cache_settings'] = 'Impostazioni Cache';
$lang['error_image_transform'] = 'Errore nella trasformazione dell&#039;immagine';
$lang['prompt_delete_orig_image'] = 'Rimuovere l&#039;immagine originale dopo il ridimensionamento e watermarking iniziale?';
$lang['info_imageextensions'] = 'Specifica un lista delimitata da virgola delle estensioni file che definiscono immagini adatte per ridimensionamento, watermarking e creazione miniature. <strong>Nota:</strong> I moduli che usano la funzionalit&ugrave; di caricamento di CGExtensions potrebbero avere la precedenza su queste impostazioni.';
$lang['allowed_upload_filetypes'] = 'Estensioni del file che possono essere caricati';
$lang['info_allowed_upload_filetypes'] = 'Specifica un lista delimitata da virgola delle estensioni file che possono essere caricati. <strong>Nota:</strong> I moduli che usano la funzionalit&ugrave; di caricamento di CGExtensions potrebbero avere la precedenza su queste impostazioni';
$lang['resize_image_to'] = 'Massima dimensione dell&#039;immagine ridimensionata';
$lang['resizing'] = 'Ridimensionamento immagine';
$lang['prompt_allow_resizing'] = 'Ridimensionare l&#039;immagine caricata?';
$lang['thumbnailing'] = 'Creazione miniatura';
$lang['prompt_allow_thumbnailing'] = 'Creare una miniatura dell&#039;immagine caricata?';
$lang['info_graphicssettings'] = 'Questo pannello permette di impostare il comportamento predefinito dei moduli che usano le funzionalit&agrave; di CGExtensions per il caricamento delle immagini. Le funzionalit&agrave; includono il ridimensionamento automatico dell&#039;immagine, watermarking e creazione miniature';
$lang['prompt_allow_watermarking'] = 'Applicare un Watermark all&#039;immagine caricata?';
$lang['info_sysdefault_templates'] = 'Questo modello definisce il contenuto predefinito quando viene creato un nuovo modello di tipo appropriato. Modificare questo contenuto non avr&agrave; effetti immediati sul vostro sito.';
$lang['available'] = 'Disponibile';
$lang['selected'] = 'Selezionato';
$lang['up'] = 'Su';
$lang['down'] = 'Gi&ugrave;';
$lang['sortablelist_templates'] = 'Modelli di riquadri di Lista Ordinabile';
$lang['default_templates'] = 'Modelli predefiniti';
$lang['sysdflt_sortablelist_template'] = 'Modello di lista ordinabile predefinita di sistema';
$lang['info_sysdefault_template'] = 'I modelli predefiniti si sistema vengono utilizzati quando viene creato un nuovo modello di un certo tipo. Modificare i valori qui avr&agrave; effetto soltanto nella creazione di un nuovo modello in un altro tab';
$lang['watermarkerror_1000'] = 'Watermarking non configurato correttamente';
$lang['watermarkerror_1001'] = 'File non corretto o corrotto specificato per il watermarking';
$lang['watermarkerror_1002'] = 'Tipo file non supportato';
$lang['watermarkerror_1003'] = 'Nessun file specificato per il watermarking';
$lang['watermarkerror_1004'] = 'Problema nella creazione dell&#039;immagine watermark';
$lang['watermarkerror_1005'] = 'Problema nel caricare l&#039;immagine per watermarking';
$lang['watermarkerror_1006'] = 'Altro errore per watermark';
$lang['translucency'] = 'Trasparenza';
$lang['watermark_alignment'] = 'Allinea tutti watermark in questa posizione relativa';
$lang['align_ul'] = 'Alto Sinistra';
$lang['align_uc'] = 'Alto Centrato';
$lang['align_ur'] = 'Alto Destra';
$lang['align_ml'] = 'Medio Sinistra';
$lang['align_mc'] = 'Centro';
$lang['align_mr'] = 'Medio Destra';
$lang['align_ll'] = 'Basso Sinistra';
$lang['align_lc'] = 'Basso Centrato';
$lang['align_lr'] = 'Basso Destra';
$lang['use_transparency'] = 'Usa Trasparenza';
$lang['background_color'] = 'Colore sottofondo';
$lang['none'] = 'Nessuno';
$lang['image'] = 'Immagine';
$lang['text_color'] = 'Colore testo';
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
$lang['info_watermarks'] = 'Il watermark &egrave; un metodo per prevenire il furto delle immagini. Una immagine o uno specifico testo &egrave; sovrapposto all&#039;immagine inviata. Se la immagine grafica non &egrave; specificata o non trovata e le configurazioni del testo sono specificate allora saranno usati per il watermark delle immagini';
$lang['text_watermarks'] = 'Watermark Testuale';
$lang['graphic_watermarks'] = 'Watermark Grafico';
$lang['watermarking'] = 'Watermark';
$lang['watermark_text'] = 'Testo del Watermark';
$lang['font'] = 'Font';
$lang['font_size'] = 'Dimensione Font';
$lang['text_angle'] = 'Angolo del Testo';
$lang['general_settings'] = 'Impostazioni Generali';
$lang['graphics_settings'] = 'Impostazioni Grafiche';
$lang['CGFILEUPLOAD_NOFILE'] = 'Nessun file caricato che corrisponda alle specifiche';
$lang['CGFILEUPLOAD_FILESIZE'] = 'La dimensione del file caricato supera il limite massimo consentito';
$lang['CGFILEUPLOAD_FILETYPE'] = 'I file di questo tipo non possono essere caricati';
$lang['CGFILEUPLOAD_FILEEXISTS'] = 'Esiste gi&agrave; un file con lo stesso nome';
$lang['CGFILEUPLOAD_BADDESTDIR'] = 'La cartella di destinazione specificata per il caricamento dei file non esiste';
$lang['CGFILEUPLOAD_BADPERMS'] = 'I permessi del file non permettono la scrittura del file caricato nella posizione di destinazione';
$lang['CGFILEUPLOAD_MOVEFAILED'] = 'Tentativo di spostare il file caricato nella sua posizione finale fallito';
$lang['CGFILEUPLOAD_PREPROCESSING_FAILED'] = 'Preprocesso delle immagini da inviare fallito';
$lang['thumbnail_size'] = 'Dimensione della miniatura';
$lang['image_extensions'] = 'Estensioni dei file immagine';
$lang['group'] = 'Gruppo';
$lang['template'] = 'Modello';
$lang['select_one'] = 'Seleziona Uno';
$lang['priority_countries'] = 'Nazioni Prioritarie';
$lang['prompt_edittemplate'] = 'Modifica Modello';
$lang['prompt_deletetemplate'] = 'Cancella Modello';
$lang['prompt_templatename'] = 'Nome Modello';
$lang['prompt_template'] = 'Testo Modello';
$lang['prompt_name'] = 'Nome Modello';
$lang['prompt_newtemplate'] = 'Nuovo Modello';
$lang['prompt_default'] = 'Predefinito';
$lang['yes'] = 'S&igrave;';
$lang['no'] = 'No';
$lang['submit'] = 'Invia';
$lang['apply'] = 'Applica';
$lang['cancel'] = 'Annulla';
$lang['edit'] = 'Modifica';
$lang['areyousure'] = 'Siete sicuri?';
$lang['resettofactory'] = 'Reimposta ai valori predefiniti';
$lang['error_template'] = 'Modello di Errore';
$lang['error_templatenamebad'] = 'Nome Modello non valido. Sono accettati solo caratteri alfanumerici e _';
$lang['error_templatenameexists'] = 'Un Modello con quel nome esiste gi&agrave;';
$lang['friendlyname'] = 'Calguys Module Extensions';
$lang['postinstall'] = 'Questo modulo &egrave; pronto all&#039;uso. Partenza!';
$lang['postuninstall'] = 'Arrivederci';
$lang['uninstalled'] = 'Modulo disinstallato.';
$lang['installed'] = 'Versione del modulo %s installata.';
$lang['prefsupdated'] = 'Preferenze modulo aggiornate.';
$lang['accessdenied'] = 'Accesso negato. Si prega di contollare i vostri permessi.';
$lang['error'] = 'Errore!';
$lang['upgraded'] = 'Modulo aggiornato alla versione %s.';
$lang['moddescription'] = 'Questo modulo &egrave; una libreria di classi php usate per costruire form avanzati';
$lang['utma'] = '156861353.838811379.1385129143.1389198872.1389707124.4';
$lang['utmz'] = '156861353.1389198872.3.3.utmcsr=solgea.net|utmccn=(referral)|utmcmd=referral|utmcct=/cmsms/admin/index.php';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>