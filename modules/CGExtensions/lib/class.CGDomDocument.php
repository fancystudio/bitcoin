<?php

/*
 * A simple domdocument extension that includes abilities for js like innerHTML functionality in its elements
 */
class CGDomDocument extends DOMDocument
{
  public function __construct($version = '', $encoding = '')
  {
    parent::__construct($version,$encoding);

    $this->registerNodeClass('DOMElement', 'JSLikeHTMLElement');
  }
}

?>
