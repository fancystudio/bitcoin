<?php

function smarty_cms_function_country_name($params, &$smarty) {
	if ($params['code']) {
		$code = strtoupper($params['code']);
		if (isset(MCFactory::$countries[$code])) {
			return MCFactory::$countries[$code];
		}
        return null;
	}
}

