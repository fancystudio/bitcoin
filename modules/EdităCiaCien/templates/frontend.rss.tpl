<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet title="XSL_formatting" type="text/xsl" href="/modules/Edit„CiaCien/rss/style.xsl"?>
<rss version="2.0" >
	<channel>
		<title>Edit„CiaCien RSS feed</title>
		<link>{$root_url}</link>
		<description>Edit„CiaCien</description>
		<lastBuildDate>{$smarty.now|date_format:"%A, %B %e, %Y"}</lastBuildDate>
		<language>en-en</language>
		{foreach from=$items item=item}
		<item>
		<title>{$item->title}</title>
		<link>{$item->detail_link}</link>
		<guid>{$item->detail_link}</guid>
		 <pubDate>{$item->created_at|date_format:"%a, %d %b %Y %T GMT"}</pubDate>
		<description><![CDATA[ {$item->summary} ]]></description>
		</item>
		{/foreach}		
	</channel>
</rss>