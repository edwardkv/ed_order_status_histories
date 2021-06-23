{capture name="mainbox"}

    {include file="common/pagination.tpl"  }

    {assign var="order_status_descr" value=$smarty.const.STATUSES_ORDER|fn_get_simple_statuses:true:true}

    {if $order_status_histories}
        <table width="100%" class="table">
            <thead>
            <tr>
                <th width="20%">{__("order_status_histories_order_id")}</th>
                <th width="20%">{__("order_status_histories_old_status")}</th>
                <th width="20%">{__("order_status_histories_new_status")}</th>
                <th width="20%">{__("order_status_histories_user")}</th>
                <th width="20%">{__("order_status_histories_date_change")}</th>
            </tr>
            </thead>
            {foreach from=$order_status_histories item="oh" key="key"}
                <tr valign="top">
                    <td nowrap="nowrap">
                        <a href="{"orders.details&order_id=`$oh.order_id`"|fn_url}"" target="_blank" >{$oh.order_id}</a>
                    </td>
                    <td nowrap="nowrap">
                        <div  class="text-center o-status-{$oh.status_from|lower} order-status ">
                            {$order_status_descr[$oh.status_from]}
                        </div>
                    </td>
                    <td class="nowrap">
                        <div class="text-center o-status-{$oh.status_to|lower} order-status ">
                            {$order_status_descr[$oh.status_to]}
                        </div>
                    </td>
                    <td nowrap="nowrap">
                        {if $oh.user_id}
                            <a href="{"profiles.update?user_id=`$oh.user_id`"|fn_url}" target="_blank">{$oh.lastname}{if $oh.lastname}&nbsp;{/if}{$oh.firstname}</a>
                        {else}
                            &mdash;
                        {/if}
                    </td>
                    <td class="nowrap">
                        {$oh.timestamp|date_format:"`$settings.Appearance.date_format`, `$settings.Appearance.time_format`"}
                    </td>
                </tr>
                {foreachelse}
                <tr>
                    <td colspan="4"><p class="no-items">{__("no_data")}</p></td>
                </tr>
            {/foreach}
        </table>
        {include file="common/pagination.tpl" }
    {else}
        <p class="no-items">{__("no_data")}</p>
    {/if}

{/capture}

{include file="common/mainbox.tpl" title=__("ed_order_status_histories") content=$smarty.capture.mainbox buttons=$smarty.capture.buttons sidebar=$smarty.capture.sidebar content_id="ed_order_status_histories"}