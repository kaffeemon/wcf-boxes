{include file='header'}

<script type="text/javascript">
	//<![CDATA[
	$(function() {
		new WCF.Action.Delete('wcf\\data\\box\\BoxAction', $('.jsBoxRow'));
		new WCF.Action.Toggle('wcf\\data\\box\\BoxAction', $('.jsBoxRow'));
	});
	//]]>
</script>

<header class="wcf-container wcf-mainHeading">
	<img class="wcf-containerIcon" src="{@$__wcf->getPath()}icon/box1.svg" alt="" />
	<hgroup class="wcf-containerContent">
		<h1>{lang}wcf.acp.box.list{/lang}</h1>
	</hgroup>
</header>

{if $deletedBoxID}
	<p class="wcf-success">{lang}wcf.acp.box.delete.success{/lang}</p>
{/if}

<div class="wcf-contentHeader">
	{pages print=true assign=pagesLinks controller="BoxList" link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
	
	<nav>
		<ul class="wcf-largeButtons">
			<li>
				<a class="wcf-button" href="{link controller='BoxAdd'}{/link}" title="{lang}wcf.acp.box.add{/lang}">
					<img src="{@$__wcf->getPath()}icon/add1.svg" alt="" />
					<span>{lang}wcf.acp.box.add{/lang}</span>
				</a>
			</li>
			
			{event name='largeButtons'}
		</ul>
	</nav>
</div>

{hascontent}
	<div class="wcf-box wcf-boxTitle wcf-marginTop wcf-shadow1">
		<hgroup>
			<h1>{lang}wcf.acp.box.list{/lang} <span class="wcf-badge" title="{lang}wcf.acp.box.list.count{/lang}">{#$items}</span></h1>
		</hgroup>
		
		<table class="wcf-table big">
			<thead>
				<tr>
					<th class="columnID columnBoxID{if $sortField == 'boxID'} active{/if}" colspan="2">
						<a href="{link controller='BoxList'}pageNo={@$pageNo}&sortField=boxID&sortOrder={if $sortField == 'boxID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">
							{lang}wcf.global.objectID{/lang}
							
							{if $sortField == 'boxID'}
								<img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />
							{/if}
						</a>
					</th>
					
					<th class="columnText columnName{if $sortField == 'name'} active{/if}">
						<a href="{link controller='BoxList'}pageNo={@$pageNo}&sortField=name&sortOrder={if $sortField == 'name' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">
							{lang}wcf.acp.box.name{/lang}
							
							{if $sortField == 'name'}
								<img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />
							{/if}
						</a>
					</th>
					
					<th class="columnText columnURL columnTitle{if $sortField == 'title'} active{/if}">
						<a href="{link controller='BoxList'}pageNo={@$pageNo}&sortField=title&sortOrder={if $sortField == 'title' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">
							{lang}wcf.acp.box.title{/lang}
							
							{if $sortField == 'title'}
								<img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />
							{/if}
						</a>
					</th>
					
					<th class="columnText columnClassName{if $sortField == 'className'} active{/if}">
						<a href="{link controller='BoxList'}pageNo={@$pageNo}&sortField=className&sortOrder={if $sortField == 'className' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">
							{lang}wcf.acp.box.className{/lang}
							
							{if $sortField == 'title'}
								<img src="{@$__wcf->getPath()}icon/sort{@$sortOrder}.svg" alt="" />
							{/if}
						</a>
					</th>
					
					{event name='headColumns'}
				</tr>
			</thead>
			
			<tbody>
				{content}
					{foreach from=$objects item=box}
						<tr class="jsBoxRow">
							<td class="columnIcon">
								<img src="{@$__wcf->getPath()}icon/{if !$box->disabled}enabled{else}disabled{/if}1.svg" alt="" title="{lang}wcf.global.button.{if !$box->disabled}disable{else}enable{/if}{/lang}" class="jsToggleButton jsTooltip" data-object-id="{@$box->boxID}" data-disable-message="{lang}wcf.global.button.disable{/lang}" data-enable-message="{lang}wcf.global.button.enable{/lang}" />
								
								<a href="{link controller='BoxEdit' id=$box->boxID}{/link}"><img src="{@$__wcf->getPath()}icon/edit1.svg" alt="" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip" /></a>
								
								<img src="{@$__wcf->getPath()}icon/delete1.svg" alt="" title="{lang}wcf.global.button.delete{/lang}" class="jsDeleteButton jsTooltip" data-object-id="{@$box->boxID}" data-confirm-message="{lang}wcf.acp.box.delete.sure{/lang}" />
								
								{event name='buttons'}
							</td>
							
							<td class="columnID columnBoxID"><p>{@$box->boxID}</p></td>
							<td class="columnText columnName"><p>{$box->name}</p></td>
							<td class="columnText columnURL columnTitle"><p><a href="{link controller='BoxEdit' id=$box->boxID}{/link}" title="{lang}wcf.global.button.edit{/lang}">{$box->title|language}</a></p></td>
							<td class="columnText columnClassName"><p>{$box->getBoxTypeTitle()|language}</p></td>
							
							{event name='columns'}
						</tr>
					{/foreach}
				{/content}
			</tbody>
		</table>
		
	</div>
	
	<div class="wcf-contentFooter">
		{@$pagesLinks}
		
		<nav>
			<ul class="wcf-largeButtons">
				<li>
					<a class="wcf-button" href="{link controller='UpdateServerAdd'}{/link}" title="{lang}wcf.acp.updateServer.add{/lang}">
						<img src="{@$__wcf->getPath()}icon/add1.svg" alt="" />
						<span>{lang}wcf.acp.box.add{/lang}</span>
					</a>
				</li>
				
				{event name='largeButtons'}
			</ul>
		</nav>
	</div>
{hascontentelse}
	<p class="warning">{lang}wcf.acp.box.list.noneAvailable{/lang}</p>
{/hascontent}

{include file='footer'}
