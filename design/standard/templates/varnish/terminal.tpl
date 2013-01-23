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
				<form method="post" action="{'/varnish/terminal'|ezurl( 'no' )}">
					<table class="list cache" cellspacing="0">
						<tbody>
							<tr class="bglight">
								<th width="1%">{'Request'|i18n( 'extension/nxc_varnish' )}:</th>
								<th width="98%"><input type="text" name="request" value="{if $request}{$request|wash}{else}ban obj.http.X-eZP-NodeID == 2{/if}" style="width: 100%;" /></th>
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
