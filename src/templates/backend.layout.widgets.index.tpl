<div class="box" id="widget{{ moduleName|capitalize }}{{ widget|capitalize }}">
	<div class="heading">
		<h3><a href="{$var|geturl:'index':'{{ moduleName }}'}">{$lbl{{ moduleName|capitalize }}|ucfirst}: {$lbl{{ widget|capitalize }}|ucfirst}</a></h3>
	</div>

	{* Content goes here *}

	<div class="footer">
		<div class="buttonHolderRight">
			<a href="{$var|geturl:'index':'{{ moduleName }}'}" class="button"><span>{$lbl{{ widget|capitalize }}|ucfirst}</span></a>
		</div>
	</div>
</div>