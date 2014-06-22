<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE feu_group [
  <!ELEMENT feu_group (grp_name,grp_description,property*)>
  <!ELEMENT grp_name (#PCDATA)>
  <!ELEMENT grp_description (#PCDATA)>
  <!ELEMENT property (prop_name,prop_prompt,prop_type,prop_option?,prop_length?,prop_maxlength?,prop_sortorder,prop_status,prop_lostunflag)>
  <!ELEMENT prop_name (#PCDATA)>
  <!ELEMENT prop_prompt (#PCDATA)>
  <!ELEMENT prop_type (#PCDATA)>
  <!ELEMENT prop_option (op_name,op_text)>
  <!ELEMENT prop_length (#PCDATA)>
  <!ELEMENT prop_maxlength (#PCDATA)>
  <!ELEMENT prop_sortorder (#PCDATA)>
  <!ELEMENT prop_status (#PCDATA)>
  <!ELEMENT prop_lostunflag (#PCDATA)>
  <!ELEMENT op_name (#PCDATA)>
  <!ELEMENT op_text (#PCDATA)>
]>
<feu_group>
  <grp_name>{$group_name}</grp_name>
  <grp_description>{$group_description}</grp_description>
{foreach from=$properties item='prop'}
  <property>
    <prop_name>{$prop->name}</prop_name>
    <prop_prompt><![CDATA[{$prop->prompt}]]></prop_prompt>
    <prop_type>{$prop->type}</prop_type>
    {if isset($prop->options)}{foreach from=$prop->options item='option'}
    <prop_option>
      <op_name><![CDATA[{$option->name}]]></op_name>
      <op_text><![CDATA[{$option->text}]]></op_text>
    </prop_option>
    {/foreach}{/if}
    {if isset($prop->length)}
    <prop_length>{$prop->length}</prop_length>
    {/if}
    {if isset($prop->maxlength)}
    <prop_maxlength>{$prop->maxlength}</prop_maxlength>
    {/if}
    <prop_sortorder>{$prop->sortorder}</prop_sortorder>
    <prop_status>{$prop->status}</prop_status>
    <prop_lostunflag>{$prop->lostunflag}</prop_lostunflag>
  </property>
{/foreach}
</feu_group>