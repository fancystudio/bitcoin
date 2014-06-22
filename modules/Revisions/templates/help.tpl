<script type="text/javascript" language="javascript" src="{$rooturl}/modules/Revisions/js/lytebox.js"></script>
<link rel="stylesheet" href="{$rooturl}/modules/Revisions/css/lytebox.css" type="text/css" />
<link rel="stylesheet" href="{$rooturl}/modules/Revisions/css/backend.css" type="text/css" />
<script type="text/javascript">
PAGEBACK_URL = '{$pageback_url}';
PAGEBACK_TEXT = '{$pageback_text}';
</script>

{$donate}
<div id="page_tabs">
	<div id="general">
		{$mod->Lang('general')}
	</div>
	<div id="permissions">
		{$mod->Lang('permissions')}
	</div>
	<div id="about">
		{$mod->Lang('about')}
	</div>
</div>
<div class="clearb"></div>
<div id="page_content">  
	<div id="general_c">
		{$mod->Lang('help_general')}
	</div>
	<div id="permissions_c">
		{$mod->Lang('help_permissions')}
	</div>
	<div id="about_c">
		{$mod->Lang('help_about')}
	</div>  
</div>