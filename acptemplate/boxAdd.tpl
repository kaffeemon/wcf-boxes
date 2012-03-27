{include file='header'}

<script type="text/javascript">
	//<![CDATA[
	$(function() {
		WCF.Icon.addObject({
			'wcf.icon.delete': '{@$__wcf->getPath('wcf')}icon/delete1.svg'
		});
	});
	//]]>
</script>

<header class="wcf-mainHeading wcf-container">
	<img src="{@$__wcf->getPath('wcf')}icon/{$action}1.svg" alt="" class="wcf-containerIcon" />
	<hgroup class="wcf-containerContent">
		<h1>{lang}wcf.acp.box.{$action}{/lang}</h1>
	</hgroup>
</header>

{if $errorField}
	<p class="wcf-error">{lang}wcf.global.form.error{/lang}</p>
{/if}

{if $success|isset}
	<p class="wcf-success">{lang}wcf.global.form.{$action}.success{/lang}</p>	
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

<form method="post" action="{if $action == 'add'}{link controller='BoxAdd'}{/link}{else}{link controller='BoxEdit'}{/link}{/if}">
	<div class="wcf-box wcf-marginTop wcf-boxPadding wcf-shadow1">
		<fieldset>
			<legend>{lang}wcf.acp.box.data{/lang}</legend>
			
			<dl{if $errorField == 'name'} class="wcf-formError"{/if}>
				<dt><label for="name">{lang}wcf.acp.box.name{/lang}</label></dt>
				<dd>
					<input type="text" id="name" name="name" value="{$name}" pattern="^[a-zA-Z0-9]+$" {if $action == 'add'}autofocus="autofocus"{else}disabled="disabled"{/if} class="medium" />
					{if $errorField == 'name'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.acp.box.name.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl>
				<dt><label for="boxTypeID">{lang}wcf.acp.box.boxTypeID{/lang}</label></dt>
				<dd>
					<input type="text" id="boxTypeID" value="{$boxTypeTitle|language}" disabled="disabled" class="medium" />
				</dd>
			</dl>
			
			{event name='dataFields'}
		</fieldset>
		
		<fieldset>
			<legend>{lang}wcf.acp.box.display{/lang}</legend>
			
			<dl{if $errorField == 'title'} class="wcf-formError"{/if}>
				<dt><label for="title">{lang}wcf.acp.box.title{/lang}</label></dt>
				<dd>
					<input type="text" id="title" name="title" value="{$title}" required="required" {if $action == 'edit'}autofocus="autofocus"{/if} class="long" />
					{if $errorField == 'title'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.acp.box.title.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			{include file='multipleLanguageInputJavascript' elementIdentifier='title'}
			
			<dl{if $errorField == 'style'} class="wcf-formError"{/if}>
				<dt><label for="style">{lang}wcf.acp.box.style{/lang}</label></dt>
				<dd>
					{htmlOptions options=$availableStyles selected=$style name=style id=style}
					{if $errorField == 'display'}
						<small class="wcf-innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.acp.box.style.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			{event name='displayFields'}
		</fieldset>
		
		{if $options|count}
		<fieldset>
			<legend>{lang}wcf.acp.box.options{/lang}</legend>
			
			{include file='optionFieldList' options=$options langPrefix=$boxTypeTitle|concat:'.option.'}
			
			{event name='optionsFields'}
		</fieldset>
		{/if}
		
		{event name='fieldsets'}
	</div>
	
	<div class="wcf-formSubmit">
		<input type="reset" value="{lang}wcf.global.button.reset{/lang}" accesskey="r" />
		<input type="submit" value="{lang}wcf.global.button.submit{/lang}" accesskey="s" />
 		{if $boxID|isset}<input type="hidden" name="id" value="{@$boxID}" />{/if}
 		{if $action == 'add'}<input type="hidden" name="boxTypeID" value="{$boxTypeID}" />{/if}
 		{@SID_INPUT_TAG}
	</div>
</form>

{include file='footer'}
