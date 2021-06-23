<?php

use Tygh\Registry;

if ($mode == 'show') {

    $params = [
        'page' => !empty($_REQUEST['page']) ? $_REQUEST['page'] : 1,
        'items_per_page' => !empty($_REQUEST['items_per_page']) ? $_REQUEST['items_per_page'] : Registry::get('settings.Appearance.admin_elements_per_page')
    ];

    list($order_status_histories, $search) = fn_get_order_status_histories($params);

    Tygh::$app['view']
        ->assign('order_status_histories', $order_status_histories)
        ->assign('search', $search);
}
