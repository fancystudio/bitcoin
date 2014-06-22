<?php
    if(!cmsms()) exit;

    function mcf_autoloader($classname)
    {
        cms_autoloader($classname);

        if(!class_exists($classname))
        {
            if(file_exists(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'class.'.$classname.'.php'))
            {
                require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'class.'.$classname.'.php');
                return;
            }
        }
    }

    spl_autoload_register('mcf_autoloader');