<?php
/*======================================================================================
Module: EventListing
======================================================================================*/

// Check authorisation
if(!is_object(cmsms())) exit;

// Get db handle
$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

// create tables for events
$flds = '
	entry_id I KEY AUTO,
	short_desc C(255),
	long_desc X,
	detail_link I,
	start_date '.CMS_ADODB_DT.',
	end_date '.CMS_ADODB_DT.',
	image_url C(255),
	sort_order I,
	active I';
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_eventslisting_events', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// create tables for categories
$flds = '
	entry_id I KEY AUTO,
	short_desc C(255),
	long_desc X,
	image_url C(255),
	sort_order I,
	active I';
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_eventslisting_category', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$flds = '
	cat_id I,
	event_id I,
	modified_date '.CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_eventslisting_category_events', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// create tables for templates
$flds = '
	entry_id I KEY AUTO,
	name C(255),
	content X';
$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_eventslisting_templates', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// insert default template
$flds = 'INSERT INTO '.cms_db_prefix().'module_eventslisting_templates (name,content) VALUES(?,?)';
$result = $db->Execute($flds, array($entry_id, 'default',
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
$result = $db->Execute($flds, array($entry_id, 'hcdefault',
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

// Set permissions
$this->CreatePermission('EventsListing: modify events', $this->Lang('modeventslisting'));
$this->CreatePermission('EventsListing: modify categories', $this->Lang('modcategories'));

// create image folders
$newdir = cms_join_path($config['image_uploads_path'],'Events');
if (!is_dir($newdir)) if (!mkdir($newdir)) { echo "Error creating dir $newdir"; }
$newdir = cms_join_path($config['image_uploads_path'],'Events','categories');
if (!is_dir($newdir)) if (!mkdir($newdir)) { echo "Error creating dir $newdir"; }
$newdir = cms_join_path($config['image_uploads_path'],'Events','events');
if (!is_dir($newdir)) if (!mkdir($newdir)) { echo "Error creating dir $newdir"; }

// Preferences
#$this->SetPreference('defaultdomain',0);

// Write message to admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('postinstall',$this->GetVersion()));

// EOF