<h3>{lang}wcf.box.type.usersOnline.info{/lang}</h3>

<p>{implode from=$box->boxCache.usersOnline item=$user}
	<a href="{link controller='User' id=$user.userID}{/link}">
		{$user.username}
	</a>
{/implode}</p>
