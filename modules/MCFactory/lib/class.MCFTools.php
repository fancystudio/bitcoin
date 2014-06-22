<?php

/**
 * MCFTools Class
 *
 * This class provides some core tools for modules
 *
 * Author: Jean-Christophe Cuvelier <cybertotophe@gmail.com>
 *
 */

class MCFTools
{

    public static function IsModuleActive($module_name)
    {
        $module_operations = cmsms()->GetModuleOperations();
        if (method_exists($module_operations, 'IsModuleActive')) {
            return $module_operations->IsModuleActive($module_name);
        } else {
            // We are in pre 1.10 CMS versions
            global $gCms;
            if (isset($gCms->modules[$module_name])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function getFileSize($file, $readable = false)
    {
        if (is_file($file)) {
            $size = filesize($file);

            if ($readable) {
                return self::size_readable($size);
            } else {
                return $size;
            }
        } else {
            return null;
        }
    }

    public static function size_readable($size, $retstring = null)
    {
        $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if ($retstring === null) {
            $retstring = '%01.2f %s';
        }

        $lastsizestring = end($sizes);

        foreach ($sizes as $sizestring) {
            if ($size < 1024) {
                break;
            }
            if ($sizestring != $lastsizestring) {
                $size /= 1024;
            }
        }

        if ($sizestring == $sizes[0]) {
            $retstring = '%01d %s';
        } // Bytes aren't normally fractional

        return sprintf($retstring, $size, $sizestring);
    }

    public static function getFileExtension($filename)
    {
        $file = explode('.', $filename);
        if (count($file) > 1) {
            return end($file);
        } else {
            return null;
        }
    }

    public static function getFileIcon($file, $icon_type = 'small')
    {
        $module = cms_utils::get_module('MCFactory');
        $icon = $module->GetModuleURLPath() . '/images/icons/' . $icon_type . '/';

        switch (strtolower(self::getFileExtension($file))) {
            case 'pdf':
                $icon .= 'pdf.gif';
                break;
            case 'js':
                $icon .= 'js.gif';
                break;
            case 'eps':
                $icon .= 'eps.gif';
                break;
            case 'php':
                $icon .= 'php.gif';
                break;
            case 'rar':
                $icon .= 'rar.gif';
                break;
            case 'doc':
                $icon .= 'doc.gif';
                break;
            case 'docx':
                $icon .= 'doc.gif';
                break;
            case 'rtf':
                $icon .= 'rtf.gif';
                break;
            case 'gif':
                $icon .= 'gif.gif';
                break;
            case 'txt':
                $icon .= 'txt.gif';
                break;
            case 'xls':
                $icon .= 'xls.gif';
                break;
            case 'xlsx':
                $icon .= 'xls.gif';
                break;
            case 'ppt':
                $icon .= 'ppt.gif';
                break;
            case 'pps':
                $icon .= 'ppt.gif';
                break;
            case 'pptx':
                $icon .= 'ppt.gif';
                break;
            case 'jpg':
                $icon .= 'jpg.gif';
                break;
            case 'bmp':
                $icon .= 'bmp.gif';
                break;
            case 'html':
                $icon .= 'html.gif';
                break;
            case 'htm':
                $icon .= 'html.gif';
                break;
            case 'mov':
                $icon .= 'mov.gif';
                break;
            case 'zip':
                $icon .= 'zip.gif';
                break;
            default:
                $icon .= 'def.gif';
                break;
        }

        return $icon;
    }

    public static function retrieveContextId()
    {
        if (cmsms())
            if (cmsms()->GetContentOperations())
                if (cmsms()->GetContentOperations()->getContentObject())
                    return cmsms()->GetContentOperations()->getContentObject()->Id();
        return 'm1_'; // Force an id
    }


}