<?php
/*============================================================================ 
Module: EventListing
============================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;

// Get var
$current_version = $oldversion;

// Get db handle
$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$message = '';

// upgrade workflow
switch($current_version){

	case '1.0':
		// Set new current version
		$current_version = '1.1';

	case '1.1':
		// Set new current version
		$current_version = '1.2';

	case '1.2':
		// insert hcdefault template (for microformats
		$entry_id = $db->GenID(cms_db_prefix()."module_eventslisting_templates_seq");
		$query = 'UPDATE ' . cms_db_prefix() . 'module_eventslisting_templates SET name=?,content=? WHERE entry_id=' . $entry_id;
		$result = $db->Execute($query, array('hcdefault',
'<dl>
{foreach from=$items item="item"}
<div class="eventslist">
<dt{if $item.past eq "true"} style="color:gray"{/if} class="summary">{$item.short}</dt>
<dd{if $item.past eq "true"} style="color:gray"{/if}>
{if $item.start|date_format:"%Y-%m-%d" == $item.end|date_format:"%Y-%m-%d"}
<p><b>Date:</b> {$item.start|date_format:"%b %e, %Y"} - 
<b>Time:</b> 
{if $item.start|date_format:"%I:%M" == $item.end|date_format:"%I:%M"}
<abbr class="dtstart" title="{$item.hcstart}">{$item.start|date_format:"%I:%M %p"}</abbr></p>
{else}
<abbr class="dtstart" title="{$item.hcstart}">{$item.start|date_format:"%I:%M %p"}</abbr> to 
<abbr class="dtend" title="{$item.hcend}">{$item.end|date_format:"%I:%M %p"}</abbr></p>
{/if}
{else}
<p><b>Dates:</b> 
<abbr class="dtstart" title="{$item.hcstart}">{$item.start|date_format:"%b %e, %Y"}</abbr> 
to 
<abbr class="dtend" title="{$item.hcend}">{$item.end|date_format:"%b %e, %Y"}</abbr></p>
{/if}
<div class="eventdesc">{$item.long}</div>
</dd>
</div>
{/foreach}
</dl>'));
		if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');
		// insert default template
		$entry_id = '1';
		$query = 'UPDATE ' . cms_db_prefix() . 'module_eventslisting_templates SET name=?,content=? WHERE entry_id=' . $entry_id;
		$result = $db->Execute($query, array('default', 
'<dl>
{foreach from=$items item="item"}
<div class="eventslist">
<dt{if $item.past eq "true"} style="color:gray"{/if} class="summary">{$item.short}</dt>
<dd{if $item.past eq "true"} style="color:gray"{/if}>
{if $item.start|date_format:"%Y-%m-%d" == $item.end|date_format:"%Y-%m-%d"}
<p><b>Date:</b> {$item.start|date_format:"%b %e, %Y"} - 
<b>Time:</b> 
{if $item.start|date_format:"%I:%M" == $item.end|date_format:"%I:%M"}
{$item.start|date_format:"%I:%M %p"}</p>
{else}
{$item.start|date_format:"%I:%M %p"} to {$item.end|date_format:"%I:%M %p"}</p>
{/if}
{else}
<p><b>Dates:</b> {$item.start|date_format:"%b %e, %Y"} to {$item.end|date_format:"%b %e, %Y"}</p>
{/if}
<div class="eventdesc">{$item.long}</div>
</dd>
</div>
{/foreach}
</dl>'));
		if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');
		// Set new current version
		$current_version = '1.3';

	case '1.3':
		// insert new hc default template
		$entry_id = $db->GenID(cms_db_prefix()."module_eventslisting_templates_seq");
		$flds = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (entry_id,name,content) VALUES(?,?,?)';
		$result = $db->Execute($flds, array($entry_id, 'newhcdefault',
'<dl class="vcalendar">
{foreach from=$items item="item"}
<div class="eventslist vevent">
<dt{if $item.past eq "true"} style="color:gray"{/if} class="summary">{$item.short}</dt>
<dd{if $item.past eq "true"} style="color:gray"{/if}>
{if $item.start|date_format:"%Y-%m-%d" == $item.end|date_format:"%Y-%m-%d"}
<p><b>Date:</b> {$item.start|date_format:"%b %e, %Y"} - 
<b>Time:</b> 
{if $item.start|date_format:"%I:%M" == $item.end|date_format:"%I:%M"}
{$item.start|date_format:"%I:%M %p"}</p>
{else}
{$item.start|date_format:"%I:%M %p"} to {$item.end|date_format:"%I:%M %p"}</p>
{/if}
{else}
<p><b>Dates:</b> {$item.start|date_format:"%b %e, %Y"} to {$item.end|date_format:"%b %e, %Y"}</p>
{/if}
<div class="eventdesc">{$item.long}</div>
</dd>
</div>
{/foreach}
</dl>'));
		if(!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');
		// Set new current version
		$current_version = '1.4';

	case '1.4':
		// Add permission for categories
		$this->CreatePermission('EventsListing: modify categories', $this->Lang('modcategories'));
		// Add column for link in event table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_events','detail_link I');
		$dict->ExecuteSQLArray($sqlarray);
		// create tables for categories
		$flds = '
			entry_id I KEY,
			short_desc C(255),
			long_desc X';
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_eventslisting_category', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		$db->CreateSequence(cms_db_prefix().'module_eventslisting_category_seq');
		$flds = '
			cat_id I,
			event_id I,
			modified_date '.CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_eventslisting_category_events', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Set new current version
		$current_version = '1.5';

	case '1.5':
		// Add column for image to category table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_category','image_url C(255)');
		$dict->ExecuteSQLArray($sqlarray);
		// Add column for order to category table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_category','sort_order I');
		$dict->ExecuteSQLArray($sqlarray);
		// Add column for active to category table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_category','active I');
		$dict->ExecuteSQLArray($sqlarray);
		// Set all entries to active
		$db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_category SET active=1', array());
		// Set ID column to autoincrement
		$db->Execute('ALTER TABLE '.cms_db_prefix().'module_eventslisting_category CHANGE COLUMN entry_id entry_id INT(11) NOT NULL AUTO_INCREMENT FIRST', array());
		// Add column for image to events table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_events','image_url C(255)');
		$dict->ExecuteSQLArray($sqlarray);
		// Add column for order to events table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_events','sort_order I');
		$dict->ExecuteSQLArray($sqlarray);
		// Add column for active to events table
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_eventslisting_events','active I');
		$dict->ExecuteSQLArray($sqlarray);
		// Set all entries to active
		$db->Execute('UPDATE '.cms_db_prefix().'module_eventslisting_events SET active=1', array());
		// Set ID column to autoincrement
		$db->Execute('ALTER TABLE '.cms_db_prefix().'module_eventslisting_events CHANGE COLUMN entry_id entry_id INT(11) NOT NULL AUTO_INCREMENT FIRST', array());
		// Set ID column to autoincrement
		$db->Execute('ALTER TABLE '.cms_db_prefix().'module_eventslisting_templates CHANGE COLUMN entry_id entry_id INT(11) NOT NULL AUTO_INCREMENT FIRST', array());
		// create image folders
		$newdir = cms_join_path($config['image_uploads_path'],'Events');
		if (!is_dir($newdir)) if (!mkdir($newdir)) { echo "Error creating dir $newdir"; }
		$newdir = cms_join_path($config['image_uploads_path'],'Events','categories');
		if (!is_dir($newdir)) if (!mkdir($newdir)) { echo "Error creating dir $newdir"; }
		$newdir = cms_join_path($config['image_uploads_path'],'Events','events');
		if (!is_dir($newdir)) if (!mkdir($newdir)) { echo "Error creating dir $newdir"; }
		// Drop useless tables
		$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_events_seq');
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_category_seq');
		$dict->ExecuteSQLArray($sqlarray);
		$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_eventslisting_templates_seq');
		$dict->ExecuteSQLArray($sqlarray);
		// insert new default template
		$flds = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (name,content) VALUES(?,?)';
		$result = $db->Execute($flds, array('newerdefault',
'<div class="events">
	{foreach from=$events item=\'event\'}
		<div class="eventitem">
			<span class="eventdate">
			{if $event->start|date_format:"%Y-%m-%d" == $event->end|date_format:"%Y-%m-%d"}
				{$event->start|date_format:"%e.%m.%Y"}{if $event->start|date_format:"%H:%M" == $event->end|date_format:"%H:%M"}
					{*{$event->start|date_format:"%H:%M"} Uhr*}
				{else},
					{$event->start|date_format:"%H:%M"} - {$event->end|date_format:"%H:%M"} Uhr
				{/if}
			{else}
				{$event->start|date_format:"%e.%m.%Y"} - {$event->end|date_format:"%e.%m.%Y"}
			{/if}
			</span>
			{if $event->linkid>1}<a href="{cms_selflink href=$event->linkid}" class="eventlink" title="{$event->short|strip_tags|replace:\'"\':\'\'}"><h2 class="eventtitle">{$event->short}</h2></a>{else}<h2 class="eventtitle">{$event->short}</h2>{/if}
			{if $event->long}<div class="eventcontent">{$event->long}</div>{/if}
		</div>
	{/foreach}
</div>'));
		if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');

		// insert hcdefault template (for microformats)
		$flds = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (name,content) VALUES(?,?)';
		$result = $db->Execute($flds, array('newerhcdefault',
'<dl class="vcalendar">
{foreach from=$events item=\'event\'}
<div class="eventslist vevent">
<dt{if $event->past eq "true"} style="color:gray"{/if} class="summary">{$event->short}</dt>
<dd{if $event->past eq "true"} style="color:gray"{/if}>
{if $event->start|date_format:"%Y-%m-%d" == $event->end|date_format:"%Y-%m-%d"}      <p><b>Date:</b> {$event->start|date_format:"%b %e, %Y"} - 
<b>Time:</b> 
{if $event->start|date_format:"%I:%M" == $event->end|date_format:"%I:%M"}
<abbr class="dtstart" title="{$event->hcstart}">{$event->start|date_format:"%I:%M %p"}</abbr></p>
{else}
<abbr class="dtstart" title="{$event->hcstart}">{$event->start|date_format:"%I:%M %p"}</abbr> to 
<abbr class="dtend" title="{$event->hcend}">{$event->end|date_format:"%I:%M %p"}</abbr></p>
{/if}
{else}
<p><b>Dates:</b> 
<abbr class="dtstart" title="{$event->hcstart}">{$event->start|date_format:"%b %e, %Y"}</abbr> 
to 
<abbr class="dtend" title="{$event->hcend}">{$event->end|date_format:"%b %e, %Y"}</abbr></p>
{/if}
<div class="eventdesc">{$event->long}</div>
</dd>
</div>
{/foreach}
</dl>'));
		if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');

		// Set new current version
		$current_version = '1.6';

		case '1.6':
		// Set new current version
		$current_version = '1.6.1';

		case '1.6.1':

				// insert new default template
		$flds = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (name,content) VALUES(?,?)';
		$result = $db->Execute($flds, array('default2',
'<div class="events">
	{foreach from=$events item=\'event\'}
		<div class="eventitem">
			<span class="eventdate">
			{if $event->start|date_format:"%Y-%m-%d" == $event->end|date_format:"%Y-%m-%d"}
				{$event->start|date_format:"%e.%m.%Y"}{if $event->start|date_format:"%H:%M" == $event->end|date_format:"%H:%M"}
					{*{$event->start|date_format:"%H:%M"} Uhr*}
				{else},
					{$event->start|date_format:"%H:%M"} - {$event->end|date_format:"%H:%M"} Uhr
				{/if}
			{else}
				{$event->start|date_format:"%e.%m.%Y"} - {$event->end|date_format:"%e.%m.%Y"}
			{/if}
			</span>
			{if $event->linkid>1}<a href="{cms_selflink href=$event->linkid}" class="eventlink" title="{$event->title|strip_tags|replace:\'"\':\'\'}"><h2 class="eventtitle">{$event->title}</h2></a>{else}<h2 class="eventtitle">{$event->title}</h2>{/if}
			{if $event->content}<div class="eventcontent">{$event->content}</div>{/if}
		</div>
	{/foreach}
</div>'));
		if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');

		// insert hcdefault template (for microformats)
		$flds = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (name,content) VALUES(?,?)';
		$result = $db->Execute($flds, array('hcdefault2',
'<dl class="vcalendar">
{foreach from=$events item=\'event\'}
<div class="eventslist vevent">
<dt{if $event->past eq "true"} style="color:gray"{/if} class="summary">{$event->title}</dt>
<dd{if $event->past eq "true"} style="color:gray"{/if}>
{if $event->start|date_format:"%Y-%m-%d" == $event->end|date_format:"%Y-%m-%d"}      <p><b>Date:</b> {$event->start|date_format:"%b %e, %Y"} - 
<b>Time:</b> 
{if $event->start|date_format:"%I:%M" == $event->end|date_format:"%I:%M"}
<abbr class="dtstart" title="{$event->hcstart}">{$event->start|date_format:"%I:%M %p"}</abbr></p>
{else}
<abbr class="dtstart" title="{$event->hcstart}">{$event->start|date_format:"%I:%M %p"}</abbr> to 
<abbr class="dtend" title="{$event->hcend}">{$event->end|date_format:"%I:%M %p"}</abbr></p>
{/if}
{else}
<p><b>Dates:</b> 
<abbr class="dtstart" title="{$event->hcstart}">{$event->start|date_format:"%b %e, %Y"}</abbr> 
to 
<abbr class="dtend" title="{$event->hcend}">{$event->end|date_format:"%b %e, %Y"}</abbr></p>
{/if}
<div class="eventdesc">{$event->content}</div>
</dd>
</div>
{/foreach}
</dl>'));
		if (!$result) die('Installation Error:' . $db->ErrorMsg() . ' with(' . $db->sql .')');

		// Print message that there are new templates
		$message.= $this->Lang('newtemplates');

		// Set new current version
		$current_version = '1.6.2';

}

// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('postupgrade',$this->GetVersion()).$message);

// EOF