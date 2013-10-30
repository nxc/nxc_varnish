<div class="context-block">
	<div class="box-header">
		<div class="box-tc">
			<div class="box-ml">
				<div class="box-mr">
					<div class="box-tl">
						<div class="box-tr">
							<div>
								<h1 class="context-title">{'Varnish Terminal'|i18n( 'extension/nxc_varnish' )}</h1>
							</div>
							<div class="header-mainline"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="box-ml">
		<div class="box-mr">
			<div class="box-content">
                <div>
                    <h2 class="context-title">{'Predefined types'|i18n( 'extension/nxc_varnish' )}</h2>
                </div>
                <div class="header-mainline"></div>
                <form method="post" action="{'/varnish/clear'|ezurl( 'no' )}" name="clearVarnishCache">
					<table class="list cache" cellspacing="0">
						<tbody>
							<tr>
								<th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} alt="{'Invert selection.'|i18n( 'design/admin/class/classlist' )}" title="{'Invert selection.'|i18n( 'design/admin/class/classlist' )}" onclick="ezjs_toggleCheckboxes( document.clearVarnishCache, 'ClearArray[]' ); return false;" /></th>
                                <th><lable>{'Cache Type'|i18n('nxc_varnish/clear')}</lable></th>
							</tr>
                            <tr class="bglight">
                                <th class="tight"><input type="checkbox" name="ClearArray[]" value=".css"/></th>
                                <th><lable>{'Stylesheets(.css)'|i18n('nxc_varnish/clear')}</lable></th>
							</tr>
                            <tr class="bgdark">
                                <th class="tight"><input type="checkbox" name="ClearArray[]" value=".js"/></th>
                                <th><lable>{'Javascript files(.js)'|i18n('nxc_varnish/clear')}</lable></th>
							</tr>
						</tbody>
					</table>
                    <input type="submit" class="button" name="ClearSelected" value="ClearSelected"/>
				</form>
                <div>
                    <h2 class="context-title">{'Custom request'|i18n( 'extension/nxc_varnish' )}</h2>
                </div>
                <div class="header-mainline"></div>
                <form method="post" action="{'/varnish/terminal'|ezurl( 'no' )}" class="list">
					<table class="list cache" cellspacing="0">
						<tbody>
							<tr class="bglight">
								<th width="1%">{'Request'|i18n( 'extension/nxc_varnish' )}:</th>
								<th width="98%"><input type="text" name="request" value="{if $request}{$request|wash}{else}ban obj.http.X-eZPublish-NodeID == 2{/if}" style="width: 100%;" /></th>
								<th width="1%"><input class="button" type="submit" value="{'Send'|i18n( 'extension/nxc_varnish' )}" name="RequestButton" /></th>
							</tr>
						</tbody>
					</table>
				</form>
                <table cellspacing="0" class="list">
					<tr>
						<td colspan="3">
							<pre>{if $response}{$response|wash()}{else}{'Result will be displayed here'|i18n( 'extension/nxc_varnish' )}{/if}</pre>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="controlbar">
		<div class="box-bc">
			<div class="box-ml">
				<div class="box-mr">
					<div class="box-tc">
						<div class="box-bl">
							<div class="box-br">
								&nbsp;
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
