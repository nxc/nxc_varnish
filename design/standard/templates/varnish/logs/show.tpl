{ezcss_load( array( 'bootstrap.css', 'helpers.css' ) )}
{ezscript_load( array( 'collapse.js' ) )}

<div class="bootstrap-wrapper">
    <h2 class="h3 u-margin-t-m">{'Varnish Logs'|i18n( 'extension/nxc_varnish' )} ({$total_count})</h2>

    <form class="panel panel-primary" action="{'varnish/logs'|ezurl( 'no' )}" method="get">
        <div class="panel-heading">
            <h3 class="panel-title">{'Filter logs'|i18n( 'extension/nxc_varnish' )}</h3>
        </div>
        <div class="panel-body">
            <div class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Server'|i18n( 'extension/nxc_varnish' )}:</label>
                    <div class="col-lg-10">
                        <select class="form-control" name="filter[server]">
                            <option value="">{'- Not selected -'|i18n( 'extension/nxc_varnish' )}</option>
                            {foreach $servers as $server}
                                <option value="{$server}"{if eq( $filter.server, $server )} selected="selected"{/if}>{$server}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Error'|i18n( 'extension/nxc_varnish' )}:</label>
                    <div class="col-lg-10">
                        <select class="form-control" name="filter[error]">
                            <option value="">{'- Not selected -'|i18n( 'extension/nxc_varnish' )}</option>
                            <option value="1"{if eq( $filter.error, '1' )} selected="selected"{/if}>{'Yes'|i18n( 'extension/nxc_varnish' )}</option>
                            <option value="0"{if eq( $filter.error, '0' )} selected="selected"{/if}>{'No'|i18n( 'extension/nxc_varnish' )}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Request filter'|i18n( 'extension/nxc_varnish' )}:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="{$filter.request}" name="filter[request]">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-2">{'Response filter'|i18n( 'extension/nxc_varnish' )}:</label>
                    <div class="col-lg-10">
                        <input class="form-control" type="text" value="{$filter.response}" name="filter[response]">
                    </div>
                </div>
                <div class="form-group u-margin-b-n">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input class="btn btn-primary" type="submit" value="{'Filter'|i18n( 'extension/nxc_varnish' )}" />
                    </div>
                </div>
            </div>

        </div>
    </form>

    {include
        uri='design:navigator/google.tpl'
        page_uri='varnish/logs'
        item_count=$total_count
        view_parameters=hash( 'limit', $limit, 'offset', $offset )
        item_limit=$limit
    }
    {def
        $response = ''
        $response_css_class = ''
    }
    {foreach $logs as $log}
        <div>
            <h3>{$log.date|datetime( 'custom', '%d.%m.%Y %H:%i:%s' )} [{$log.server}] {if $log.is_completed}{$log.duration} sec.{else}{'in progress...'|i18n( 'extension/nxc_varnish' )}{/if}</h3>

            <div class="panel-group" id="accordion-{$log.id}">
                {if $log.response}
                    {set $response = $log.response}
                    {set $response_css_class = 'danger'}
                {else}
                    {set $response = '[Empty line]'}
                    {set $response_css_class = 'info'}
                {/if}
                {include uri='design:varnish/logs/collapse_part.tpl' id=concat( '1-', $log.id ) title='Request' content=$log.request is_collapsed=false()}
                {include uri='design:varnish/logs/collapse_part.tpl' id=concat( '2-', $log.id ) title='Response' content=$response css_class=$response_css_class is_collapsed=false()}
                {include uri='design:varnish/logs/collapse_part.tpl' id=concat( '3-', $log.id ) title='Backtrace' content=$log.backtrace_output}
            </div>
        </div>
        <hr>
    {/foreach}
    {include
        uri='design:navigator/google.tpl'
        page_uri='varnish/logs'
        item_count=$total_count
        view_parameters=hash( 'limit', $limit, 'offset', $offset )
        item_limit=$limit
    }
</div>