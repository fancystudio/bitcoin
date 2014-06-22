<h1>Hello, World!</h1>


<div id="dialog" title="Tab data">
    <form>
        <fieldset class="ui-helper-reset">
            <label for="tab_title">Title</label>
            <input type="text" name="tab_title" id="tab_title" value="" class="ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>

<button id="add_tab">Add Tab</button>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Nunc tincidunt</a> <span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span></li>
    </ul>
    <div id="tabs-1">
        <p>Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu. Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliquet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vitae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius sollicitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tempus lectus.</p>
    </div>
</div>



{if isset($template_form)}
    {if $template_form->hasErrors()}<div style="color: red;">{$template_form->showErrors()}</div>{/if}
    {$template_form->getHeaders()}

    {foreach from=$fields item=field}
        <div id="field_{$field->getId()}" class="field">
            {$template_form->showWidget($field->getFieldName())}
        </div>
    {/foreach}

    {$template_form->showWidgets()}

    {$template_form->renderFieldsets()}

    <p>
        {$template_form->getButtons()}
    </p>
    {$template_form->getFooters()}
{/if}