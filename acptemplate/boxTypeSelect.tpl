{include file='header'}

<header class="box48 boxHeadline">
	<img src="{icon}add1.svg{/icon}" alt="" class="icon48" />
	<hgroup>
		<h1>{lang}wcf.acp.box.add{/lang}</h1>
	</hgroup>
</header>

{if $success|isset}
	<p class="success">{lang}wcf.global.form.add.success{/lang}</p>	
{/if}

<div class="wcf-contentHeader">
	<nav>
		<ul class="wcf-largeButtons">
			<li>
				<a href="{link controller='BoxList'}{/link}" title="{lang}wcf.acp.menu.link.box.list{/lang}" class="wcf-button">
					<img src="{@$__wcf->getPath('wcf')}icon/box1.svg" alt="" />
					<span>{lang}wcf.acp.menu.link.box.list{/lang}</span>
				</a>
			</li>
			
			{event name='largeButtons'}
		</ul>
	</nav>
</div>

<form method="get" action="{link controller='BoxAdd'}{/link}">
	<div class="container containerPadding marginTop shadow">
		<fieldset>
			<legend>{lang}wcf.acp.box.data{/lang}</legend>
			
			<dl>
				<dt><label for="boxTypeID">{lang}wcf.acp.box.boxTypeID{/lang}</label></dt>
				<dd>
					{htmlOptions options=$availableBoxTypes name=boxTypeID id=boxTypeID}
				</dd>
			</dl>
			
			{event name='dataFields'}
		</fieldset>
		
		{event name='fieldsets'}
	</div>
	
	<div class="formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
 		{@SID_INPUT_TAG}
	</div>
</form>

{include file='footer'}
