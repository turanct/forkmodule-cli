{include:{$BACKEND_CORE_PATH}/layout/templates/head.tpl}
{include:{$BACKEND_CORE_PATH}/layout/templates/structure_start_module.tpl}

<div class="pageTitle">
    <h2>{$lbl{{ moduleNameSafe }}|ucfirst}: {$lbl{{ actionSafe }}}</h2>
</div>

<div class="formHolder">
{form:{{ action }}}

    <div class="form-group title">
        <label for="title">{$lblTitle|ucfirst}<abbr title="{$lblRequiredField}">*</abbr></label>
        <div>
            {$txtTitle}
            {$txtTitleError}
        </div>
{% if meta %}
        <div id="pageUrl">
            <div class="oneLiner">
            {option:detailURL}
                <p><span><a href="{$detailURL}{% if action == 'edit' %}/{$item.url}{% endif %}">{$detailURL}/<span id="generatedUrl">{% if action == 'edit' %}{$item.url}{% endif %}</span></a></span></p>
            {/option:detailURL}
            {option:!detailURL}
                <p class="infoMessage">{$errNoModuleLinked}</p>
            {/option:!detailURL}
            </div>
        </div>
{% endif %}
    </div>

    <div class="tabs">
        <ul>
            <li><a href="#tabContent">{$lblContent|ucfirst}</a></li>
{% if meta %}
            <li><a href="#tabSEO">{$lblSEO|ucfirst}</a></li>
{% endif %}
        </ul>

        <div id="tabContent">

            {* Your content goes here *}

        </div>
{% if meta %}

        <div id="tabSEO">
            {include:{$BACKEND_CORE_PATH}/layout/templates/seo.tpl}
        </div>
{% endif %}
    </div>

    <div class="fullwidthOptions">
{% if action == 'edit' %}
        <a href="{$var|geturl:'Delete'}&amp;id={$item.id}" data-message-id="confirmDelete" class="askConfirmation button linkButton icon iconDelete">
            <span>{$lblDelete|ucfirst}</span>
        </a>

        <div id="confirmDelete" title="{$lblDelete|ucfirst}?" style="display: none;">
            <p>
                {$msgAreYouSure|ucfirst}
            </p>
        </div>
{% endif %}
        <div class="buttonHolderRight">
            <div class="form-action">
                <input type="submit" class="inputButton button mainButton" name="ok" value="{$lblSave|ucfirst}">
            </div>
        </div>
    </div>

{/form:{{ action }}}
</div>

{include:{$BACKEND_CORE_PATH}/layout/templates/structure_end_module.tpl}
{include:{$BACKEND_CORE_PATH}/layout/templates/footer.tpl}
