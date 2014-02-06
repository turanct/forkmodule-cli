<div class="box" id="widget{{ moduleNameSafe }}{{ widgetSafe }}">
	<div class="heading">
		<h3><a href="{$var|geturl:'index':'{{ moduleName }}'}">{$lbl{{ moduleNameSafe }}|ucfirst}: {$lbl{{ widgetSafe }}|ucfirst}</a></h3>
	</div>

	{* Content goes here *}

	<div class="footer">
		<div class="buttonHolderRight">
			<a href="{$var|geturl:'index':'{{ moduleName }}'}" class="button"><span>{$lbl{{ widgetSafe }}|ucfirst}</span></a>
		</div>
	</div>
</div>
