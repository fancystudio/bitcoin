<?php

abstract class MCFModuleObject
{

    protected $id;
    protected $user_id;

    protected $created_at;
    protected $created_by;
    protected $updated_at;
    protected $updated_by;
    protected $mcfi_created_timestamp;
    protected $mcfi_updated_timestamp;

    protected $vars = array();
    protected $is_modified = false;

    const MODULE_NAME = 'MCFModule';
    const MODULE_OBJECT_NAME = 'MCFModuleObject';

    public function __set($var, $val)
    {
        $this->is_modified = true;
        $this->vars[$var] = $val;
    }

    public function __get($var)
    {
        try {
            if (method_exists($this, $var)) {
                return $this->$var();
            } elseif (array_key_exists($var, $this->vars)) {
                return $this->vars[$var];
            } else {
                throw new Exception("Property $var does not exist");
            }
        } catch (Exception $e) {
            audit('', self::MODULE_NAME, $e->getMessage());
        }
    }

    public function __toString()
    {
        return (string)$this->id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($value)
    {
        $this->is_modified = true;
        $this->id = $value;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($value)
    {
        $this->is_modified = true;
        $this->user_id = $value;
    }

    public function getUser()
    {
        return CMSUser::retrieveByPk($this->user_id);
    }

    public function setUser(CMSUser $user)
    {
        $this->setUserId($user->getId());
    }

    public function getMcfiCreatedTimestamp()
    {
        return $this->mcfi_created_timestamp;
    }

    public function setMcfiCreatedTimestamp($value)
    {
        $this->is_modified = true;
        $this->mcfi_created_timestamp = $value;
    }

    public function getMcfiUpdatedTimestamp()
    {
        return $this->mcfi_updated_timestamp;
    }

    public function setMcfiUpdatedTimestamp($value)
    {
        $this->is_modified = true;
        $this->mcfi_updated_timestamp = $value;
    }


    // FUNCTIONS TO CLEAN

    public static function cleanFilename($filename)  {
        $result = strtolower($filename);
        // Remove accents
        $result = strtr($result,  "�����������������������������������������������������",  "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");

        // Soft way
        $result = str_replace("#", "No.", $result);
        $result = str_replace("$", "Dollar", $result);
        $result = str_replace("%", "Percent", $result);
        $result = str_replace("^", " ", $result);
        $result = str_replace("&", "and", $result);
        $result = str_replace("*", " ", $result);
        $result = str_replace("?", " ", $result);
        $result = str_replace(",", " ", $result);

        // strip all non word chars
        //$result = preg_replace('/\W/', ' ', $result); // HARD WAY...

        // replace all white space sections with a dash
        $result = preg_replace('/\ +/', '-', $result);
        // trim dashes
        $result = preg_replace('/\-$/', '', $result);
        $result = preg_replace('/^\-/', '', $result);
        return $result;
    }

    protected static function getMimeType($filename) {
        $extension = strtolower(end(explode('.',$filename)));
        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
        );
        if (isset($mime_types[$extension])) {
            return $mime_types[$extension];
        }
        return 'application/octet-stream';
    }
}