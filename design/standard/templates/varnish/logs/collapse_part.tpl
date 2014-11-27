{default
    $css_class = 'info'
    $is_collapsed = true()
}
<div class="panel panel-{$css_class}">
    <div class="panel-heading">
        <h4 class="panel-title"><a data-toggle="collapse" href="#collapse{$id}" {if $is_collapsed}class="collapsed"{/if}>{$title|i18n( 'extension/nxc_varnish' )}</a></h4>
    </div>
    <div class="panel-collapse {if $is_collapsed}collapse{else}in{/if}" id="collapse{$id}">
        <div class="panel-body u-padding-a-n">
            <pre class="no-border u-margin-b-n">{$content|wash}</pre>
        </div>
    </div>
</div>
{/default}