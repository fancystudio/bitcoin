<?php

class {{$module->getModuleName()}}Object extends {{$module->getModuleName()}}ObjectBase {

{{$module->getModuleLogic()|replace:'<?php':''}}

}

?>