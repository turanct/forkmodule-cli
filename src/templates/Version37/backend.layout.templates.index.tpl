{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
	<h2>
		{$lbl{{ moduleNameSafe }}|ucfirst}: {$lblOverview}
	</h2>

	<div class="buttonHolderRight">
		<a href="{$var|geturl:'Add'}" class="button icon iconAdd" title="{$lblAdd|ucfirst}">
			<span>{$lblAdd|ucfirst}</span>
		</a>
	</div>
</div>

{option:dataGrid}
	<div class="dataGridHolder">
		<div class="tableHeading">
			<h3>{$lbl{{ moduleNameSafe }}|ucfirst}</h3>
		</div>
		{$dataGrid}
	</div>
{/option:dataGrid}

{option:!dataGrid}
	{$msgNoItems}
{/option:!dataGrid}

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
