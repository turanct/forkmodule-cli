{include:{$BACKEND_CORE_PATH}/Layout/Templates/Head.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureStartModule.tpl}

<div class="pageTitle">
    <h2>{$lblJelmer|ucfirst}: {$lblEdit}</h2>
</div>

<div class="formHolder">
{form:edit}

    <div class="form-group title">
        <label for="title">{$lblTitle|ucfirst}<abbr title="{$lblRequiredField}">*</abbr></label>
        <div>
            {$txtTitle}
            {$txtTitleError}
        </div>
        <div id="pageUrl">
            <div class="oneLiner">
            {option:detailURL}
                <p><span><a href="{$detailURL}/{$item.url}">{$detailURL}/<span id="generatedUrl">{$item.url}</span></a></span></p>
            {/option:detailURL}
            {option:!detailURL}
                <p class="infoMessage">{$errNoModuleLinked}</p>
            {/option:!detailURL}
            </div>
        </div>
    </div>

    <div class="tabs">
        <ul>
            <li><a href="#tabContent">{$lblContent|ucfirst}</a></li>
            <li><a href="#tabSEO">{$lblSEO|ucfirst}</a></li>
        </ul>

        <div id="tabContent">

            {* Your content goes here *}

        </div>

        <div id="tabSEO">
            {include:{$BACKEND_CORE_PATH}/Layout/Templates/seo.tpl}
        </div>
    </div>

    <div class="fullwidthOptions">
        <a href="{$var|geturl:'Delete'}&amp;id={$item.id}" data-message-id="confirmDelete" class="askConfirmation button linkButton icon iconDelete">
            <span>{$lblDelete|ucfirst}</span>
        </a>

        <div id="confirmDelete" title="{$lblDelete|ucfirst}?" style="display: none;">
            <p>
                {$msgAreYouSure|ucfirst}
            </p>
        </div>
        <div class="buttonHolderRight">
            <div class="form-action">
                <input type="submit" class="inputButton button mainButton" name="ok" value="{$lblSave|ucfirst}">
            </div>
        </div>
    </div>

{/form:edit}
</div>

{include:{$BACKEND_CORE_PATH}/Layout/Templates/StructureEndModule.tpl}
{include:{$BACKEND_CORE_PATH}/Layout/Templates/Footer.tpl}
