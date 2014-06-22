<table class="calendar">
	<thead>
		<tr>
			<th class="previous"><a href="{$previous_month}">&lt;</a></th>
			<th class="month" colspan="5">{$current_month|date_format:"%b %Y"}</th>
			<th class="next"><a href="{$next_month}">&gt;</a></th>
		</tr>
		<tr>
			<td>Mon</td>
			<td>Tue</td>
			<td>Wed</td>
			<td>Thu</td>
			<td>Fri</td>
			<td>Sat</td>
			<td>Sun</td>
		</tr>
	</thead>
	<tbody>
		{foreach from=$mcfcalendar item=week}
			<tr>
				{foreach from=$week item=day}
				<td class="{if $day.current}current {/if}{if $day.today}today {/if}{if $day.events|@count} has-events{/if}">
					<p>{$day.date|date_format:"%e"}</p>
					{if $day.events|@count}
					<ul>
						{foreach from=$day.events item=item}
						<li><a href="{$item->detail_link}">{$item->title}</a></li>
						{/foreach}
					</ul>
					{/if}
					{* Alternative: Link to all events of the current date }
						{if $day.events|@count}
							<a href="{{literal}}{{{/literal}}{{$module->getModuleName()}} action="url_for" maction="default" calendar=1 start_date=$day.date|date_format:"%Y-%m-%d" end_date=$day.date|date_format:"%Y-%m-%d"}">{$day.date|date_format:"%e"}</a>
						{else}
							{$day.date|date_format:"%e"}
						{/if}
					{**}
				</td>
				{/foreach}
			</tr>
		{/foreach}
	</tbody>
</table>
