{if $box->style == 'title' || $box->style == 'border'}
<div class="border{if $box->style == 'title'} titleBarPanel{/if}">
	{if $box->style == 'title'}
	<div class="containerHead">
		<div class="containerContent">
			<h3>{$box->title|language}</h3>
		</div>
	</div>
	{/if}
	
	<div class="container-1">
		<div class="containerContent">
			{@$box->render()}
		</div>
	</div>
</div>
{else}
{@$box->render()}
{/if}
