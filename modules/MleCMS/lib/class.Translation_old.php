<?php

/**
 * Basic translation environment
 *
 * @author malware
 * @package Translator
 */
class Translation_old {

    /** possible languages to translate */
    protected static $languages = null;
    /** secondary language */
    protected $secondaryLanguage;
    /** locale folder (relative) location */
    protected static $folder = null;
    /** default key file */
    public static $defFile = 'keys';

    /** static class */
    private function __construct() {
        
    }

    public static function getLanguages() {
        return self::$languages;
    }

    public static function setLanguages(array $langs) {
        self::$languages = $langs;
    }

    public static function getFolderLocation() {
        // set cms uploads/MleCMS path
        if (!self::$folder) {
            self::setFolderLocation();
        }

        // create dir
        if (!is_dir(self::$folder))
            cge_dir::mkdirr(self::$folder);

        return self::$folder;
    }

    public static function setFolderLocation($folder = '') {
        // set folder
        if ($folder) {
            self::$folder = $folder;
            return;
        }
        // default folder
        $config = cmsms()->GetConfig();
        $module = cge_utils::get_module('MleCMS');
        self::$folder = cms_join_path($config["uploads_path"], $module->GetName());
    }

    public static function remove($key) {
        if ($key) {
            /** remove key from keys file */
            $keysFile = self::getFolderLocation() . '/' . self::$defFile . '.xml';
            self::removeKeyFromFile($keysFile, $key);

            /** remove key from all lang files */
            foreach (self::getLanguages() as $language) {
                $langFile = self::getFolderLocation() . '/' . $language['locale'] . '.xml';
                self::removeKeyFromFile($langFile, $key);
            }

            return true;
        }

        return false;
    }

    protected static function removeKeyFromFile($file, $key) {
        $xml = simplexml_load_file($file);
        foreach ($xml->items[0]->item as $item)
            if ((string) $item['key'] == $key) {
                $dom = dom_import_simplexml($item);
                $dom->parentNode->removeChild($dom);
            }

        $xml->asXML($file);
    }

    protected static function getFileContent($filename) {
        self::checkFile($filename);

        $filePath = self::getFolderLocation() . '/' . $filename;

        if (!is_readable($filePath))
            throw new Exception(__CLASS__ . ' :: File "' . $filename . '" is not readable!');
//        if (!is_writeable($filePath))
//            throw new Exception(__CLASS__ . ' :: File "' . $fileName . '" is not writeable!');

        $items = array();

        $xml = simplexml_load_file($filePath);
        foreach ($xml->items[0]->item as $item)
            $items[(string) $item['key']] = (string) $item;

        return $items;
    }

    public static function getKeysTable() {
        return self::getFileContent(self::$defFile . '.xml');
    }

    public static function getContentTable() {
        $items['langs'] = self::getLanguages();

        foreach (self::$languages as $lang) {
            $filename = $lang['locale'] . '.xml';
            $items['xml'][$lang['locale']]['items'] = self::getFileContent($filename);
        }

        return $items;
    }

    public static function getFromKeys() {
        
    }

    public static function checkKeysFile() {
        self::checkFile(self::$defFile . '.xml');
    }

    /**
     *  get file location
     * @return string
     */
    public static function getFileLocation() {
        return self::getFolderLocation() . '/' . self::$defFile . '.xml';
    }

    public static function getValue(&$params) {
        $editLang = self::$defFile;
        $key = $params['editKey'];

        $filePath = self::getFolderLocation() . '/' . $editLang . '.xml';

        self::checkFile($editLang . '.xml');

        // cache
        $xpath = cms_utils::get_app_data($filePath);
        if (!$xpath) {
            $xml = new DOMDocument();
            $xml->load($filePath);
            $xpath = new DOMXPath($xml);
            cms_utils::set_app_data($filePath, $xpath);
        }
        $result = $xpath->query('//root/items/item[@key="' . $key . '"]');

        if ($result->item(0) != NULL) {
            return ($result->item(0)->nodeValue != "") ? $result->item(0)->nodeValue : $key;
        } else {
            $params['editLang'] = & $editLang;
            $params['editValue'] = & $key;
            self::update($params);

            return $key;
        }
    }

    public static function update(&$post) {
        $editLang = $post['editLang'];
        $key = $post['editKey'];
        $value = $post['editValue'];

        $filePath = self::getFolderLocation() . '/' . $editLang . '.xml';

        self::checkFile($editLang . '.xml');

        $xml = new DOMDocument();
        $xml->load($filePath);

        $xpath = new DOMXPath($xml);
        $result = $xpath->query('//root/items/item[@key="' . $key . '"]');

        if ($result->item(0) != NULL) {
            $result->item(0)->nodeValue = "";
            $cdata = $xml->createCDATASection($value);
            $result->item(0)->appendChild($cdata);
        } else {
            $root = $xml->getElementsByTagName('items')->item(0);

            $cdata = $xml->createCDATASection($value);

            $item = $xml->createElement('item');
            $item->appendChild($cdata);

            $newNode = $root->appendChild($item);
            $newNode->setAttribute('key', $key);
        }

        $xml->save($filePath);
    }

    protected static function checkFile($filename) {
        /** check filename */
        if (!$filename)
            throw new Exception(__CLASS__ . ' :: Filename is empty');

        $storePath = self::getFolderLocation();

        /** check if store folder exist */
        if (!file_exists($storePath))
            if (!cge_dir::mkdirr($storePath))
                throw new Exception(__CLASS__ . ' :: Cannot create store folder');

            
        if (!file_exists($storePath . DIRECTORY_SEPARATOR . $filename))
            if (!file_put_contents($storePath . DIRECTORY_SEPARATOR . $filename, "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\" ?><root><items lang=\"" . substr($filename, 0, 5) . "\"></items></root>"))
                throw new Exception(__CLASS__ . ' :: Cannot create new language file with filename "' . $filename . '"');

        return true;
    }

    public static function translate($params) {
        $smarty = cmsms()->GetSmarty();

        // do nothing
        if (!isset($params['text']))
            return;

        $vars['editKey'] = $params['text'];

        self::$defFile = 'keys';
        $lang_value = self::getValue($vars);
        // set lang key
        if ($smarty->get_template_vars('lang_locale'))
            self::$defFile = $smarty->get_template_vars('lang_locale');
        
        $lang_value = self::getValue($vars);

        if (isset($params["assign"]))
            $smarty->assign($params["assign"], $lang_value);
        else
            echo $lang_value;
    }

}

?>
