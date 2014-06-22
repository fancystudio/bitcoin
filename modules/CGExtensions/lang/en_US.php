<?php

## A
$lang['accessdenied'] = "Access Denied. Please check your permissions.";
$lang['align_lc'] = "Bottom Center";
$lang['align_ll'] = "Bottom Left";
$lang['align_lr'] = "Bottom Right";
$lang['align_mc'] = "Center";
$lang['align_ml'] = "Middle Left";
$lang['align_mr'] = "Middle Right";
$lang['align_uc'] = "Top Center";
$lang['align_ul'] = "Top Left";
$lang['align_ur'] = "Top Right";
$lang['allowed_upload_filetypes'] = "File Extensions that may be uploaded";
$lang['apply'] = "Apply";
$lang['areyousure'] = "Are you sure?";
$lang['available'] = "Available";

## B
$lang['background_color'] = "Background Color";

## C
$lang['cache_1hr'] = "One Hour";
$lang['cache_2hrs'] = "Two Hours";
$lang['cache_6hrs'] = "Six Hours";
$lang['cache_12hrs'] = "Twelve Hours";
$lang['cache_24hrs'] = "One Day";
$lang['cache_autoclean'] = "Automatically clean expired cache files";
$lang['cache_filelock'] = "Lock files to prevent race conditions";
$lang['cache_halfhour'] = "One half hour";
$lang['cache_lifetime'] = "Cache Lifetime (seconds)";
$lang['cache_modulecalls'] = "Cache module calls";
$lang['cache_noexpiry'] = "Do not expire (use with caution)";
$lang['cache_settings'] = "Cache Settings";
$lang['cancel'] = "Cancel";
$lang['CGFILEUPLOAD_BADDESTDIR'] = "The destination directory specified for uploaded files does not exist";
$lang['CGFILEUPLOAD_BADPERMS'] = "File permissions do not allow writing the uploaded file in its destination location";
$lang['CGFILEUPLOAD_FILEEXISTS'] = "A file with the same name already exists";
$lang['CGFILEUPLOAD_FILESIZE'] = "The size of the uploaded file exceeded the maximum allowed";
$lang['CGFILEUPLOAD_FILETYPE'] = "Files of this type cannot be uploaded";
$lang['CGFILEUPLOAD_MOVEFAILED'] = "Attempting to move the uploaded file to its final destination failed";
$lang['CGFILEUPLOAD_NOFILE'] = "No file uploaded matching the specifications";
$lang['CGFILEUPLOAD_PREPROCESSING_FAILED'] = "Preprocessing of the uploaded file failed";

## D
$lang['default_templates'] = "Default Templates";
$lang['down'] = "Down";

## E
$lang['edit'] = "Edit";
$lang['error'] = "Error!";
$lang['error_image_transform'] = "Error Transforming Image";
$lang['error_missingparam'] = "A required parameter was missing or invalid";
$lang['error_template'] = "Error Template";
$lang['error_templatenamebad'] = "Invalid template name.  Only alphanumeric characters, and _ are allowed";
$lang['error_templatenameexists'] = "A Template by that Name Already Exists";

## F
$lang['font'] = "Font";
$lang['font_size'] = "Font Size";
$lang['friendlyname'] = "Calguys Module Extensions";

## G
$lang['general_settings'] = "General Settings";
$lang['graphics_settings'] = "Graphics Settings";
$lang['graphic_watermarks'] = "Graphical Watermarks";
$lang['group'] = "Group";

## H
$lang['help'] = "Help";

## I
$lang['image'] = "Image";
$lang['image_extensions'] = "Image File Extensions";
$lang['info_allowed_upload_filetypes'] = "Specify a comma delimited list of file extensions that may be uploaded.  <strong>Note:</strong> Modules that use the CGExtensions upload capabilities may override these settings";
$lang['info_cache_modulecalls'] = "EXPERIMENTAL: Under some circumstances, the output of calls to modules can be cached.  Enabling this can have a significant performance boost to your site.  However may cause dificulties with some calls.   You can disable this option by adding the nocache=1 parameter to your module call";
$lang['info_graphicssettings'] = "This tab allows configuring the default behavour of modules that use CGExtensions functionality for uploading images.   Functionality includes automatic input image resizing, watermarking, and thumbnailing";
$lang['info_imageextensions'] = "Specify a comma delimited list of file extensions that denote image files that are suitable for resizing, watermarking, and thumbnailing. <strong>Note:</strong> Modules that use the CGExtensions upload capabilities may override these settings.";
$lang['info_memory_limit'] = "Some functionality in some modules attempts to test if there is enough available memory to proceed.  However, some hosts dont allow us to read this information reliably.  You may enter an assumed memory limit <em>(in MB)</em> to assist this functionality.  Leaving the field empty will attempt to rely on the reading that information from the system.";
$lang['info_sysdefault_template'] = "System default templates are used when creating a new template of a certain type.  Changing the values here will only have effect when you create a new template in another tab";
$lang['info_sysdefault_templates'] = "This template defines the default content of the template when you create a new template of the appropriate type.  Adjusting this content will have no immediate effect on your website";
$lang['info_watermarks'] = "Watermarking is a method to prevent image theft.  Either an image, or some specified text is overlayed on top of the uploaded image.  If a graphical watermark is not specified, or cannot be found, and the text settings are specified, they will be used for watermarking of images";
$lang['installed'] = "Module version %s installed.";

## M
$lang['moddescription'] = "This module is a library of php classes used to build advanced forms";
$lang['msg_templatesaved'] = "Template saved";

## N
$lang['no'] = "No";
$lang['none'] = "None";

## P
$lang['param_nocache'] = "Used if caching of module calls is enabled, this parameter will disable caching of this module call.  This parameter is useful ";
$lang['postinstall'] = "This module is ready to use.  Code away!";
$lang['postuninstall'] = "See you again some day";
$lang['prefsupdated'] = "Module preferences updated.";
$lang['priority_countries'] = "Priority Countries";
$lang['prompt_allow_resizing'] = "Resize uploaded images?";
$lang['prompt_allow_thumbnailing'] = "Create thumbnails from uploaded images?";
$lang['prompt_allow_watermarking'] = "Watermark uploaded images?";
$lang['prompt_default'] = "Default";
$lang['prompt_deletetemplate'] = "Delete Template";
$lang['prompt_delete_orig_image'] = "Remove the original image after initial resizing and watermarking?";
$lang['prompt_edittemplate'] = "Edit Template";
$lang['prompt_memory_limit'] = "Assumed Memory Limit";
$lang['prompt_name'] = "Template Name";
$lang['prompt_newtemplate'] = "New Template from Prototype";
$lang['prompt_template'] = "Template Text";
$lang['prompt_templatename'] = "Template Name";

## R
$lang['resettofactory'] = "Reset to factory defaults";
$lang['resize_image_to'] = "Maximum dimension of the resized image";
$lang['resizing'] = "Image Resizing";
$lang['rgb_colors'] = "#F0F8FF-AliceBlue,
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
#9ACD32-YellowGreen";

## S
$lang['selected'] = "Selected";
$lang['select_one'] = "Select One";
$lang['sortablelist_templates'] = "Sortable List Area Templates";
$lang['submit'] = "Submit";
$lang['sysdflt_sortablelist_template'] = "System default sortable list template";

## T
$lang['template'] = "Template";
$lang['text_angle'] = "Text Angle";
$lang['text_color'] = "Text Color";
$lang['text_watermarks'] = "Text Watermarks";
$lang['thumbnailing'] = "Thumbnailing";
$lang['thumbnail_size'] = "Size of thumbnails";
$lang['translucency'] = "Translucency";

## U
$lang['uninstalled'] = "Module Uninstalled.";
$lang['up'] = "Up";
$lang['upgraded'] = "Module upgraded to version %s.";
$lang['use_transparency'] = "Use Transparency";

## W
$lang['watermarkerror_1000'] = "Watermarking is not properly configured";
$lang['watermarkerror_1001'] = "Bad or corrupt file specified for watermarking";
$lang['watermarkerror_1002'] = "Unsupported File Type";
$lang['watermarkerror_1003'] = "No file specified for watermarking";
$lang['watermarkerror_1004'] = "Problem creating watermark image";
$lang['watermarkerror_1005'] = "Problem loading image for watermarking";
$lang['watermarkerror_1006'] = "Other watermark error";
$lang['watermarking'] = "Watermarking";
$lang['watermark_alignment'] = "Align all watermarks in this relative position";
$lang['watermark_text'] = "Watermark Text";
$lang['whatsthis'] = 'What is this?';

## Y
$lang['yes'] = "Yes";
?>