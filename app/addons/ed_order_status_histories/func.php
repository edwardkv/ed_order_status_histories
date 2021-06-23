<?php

use Tygh\Navigation\LastView;

function fn_ed_order_status_histories_add_log($data = [])
{
    if (!empty($_SESSION['auth']['user_id'])) {
        $user_id = $_SESSION['auth']['user_id'];
    } else {
        $user_id = 0;
    }

    $row = [
        'user_id' => $user_id,
        'order_id' => $data['order_id'],
        'timestamp' => TIME,
        'status_from' => $data['status_from'],
        'status_to' => $data['status_to']
    ];

    $log_id = db_query("INSERT INTO ?:order_status_histories ?e", $row);
    return true;
}

/*
    function connect to the hook 'change_order_status' in fn.cart.php
*/
function fn_ed_order_status_histories_change_order_status($status_to, $status_from, $order_info, $force_notification, $order_statuses, $place_order)
{
    fn_ed_order_status_histories_add_log([
        'order_id' => $order_info['order_id'],
        'status_from' => $status_from,
        'status_to' => $status_to,
    ]);
    return true;
}

/*
 * get order status histories
*/
function fn_get_order_status_histories($params)
{
    $params = LastView::instance()->update('order_status_histories', $params);

    $default_params = [
        'page' => 1
    ];

    $params = array_merge($default_params, $params);

    $sortings = [
        'timestamp' => ['?:order_status_histories.timestamp', '?:order_status_histories.log_id'],
        'user' => ['?:users.lastname', '?:users.firstname'],
    ];

    $fields = [
        '?:order_status_histories.*',
        '?:users.firstname',
        '?:users.lastname'
    ];

    $sorting = db_sort($params, $sortings, 'timestamp', 'desc');

    $join = "LEFT JOIN ?:users USING(user_id)";

    $condition = '';
    $limit = '';

    if (!empty($params['items_per_page'])) {
        $params['total_items'] = db_get_field("SELECT COUNT(DISTINCT(?:order_status_histories.log_id)) FROM ?:order_status_histories ?p WHERE 1 ?p", $join, $condition);
        $limit = db_paginate($params['page'], $params['items_per_page']);
    }

    $items = db_get_array("SELECT " . join(', ', $fields) . " FROM ?:order_status_histories ?p WHERE 1 ?p $sorting $limit", $join, $condition);

    LastView::instance()->processResults('order_status_histories', $items, $params);

    return [$items, $params];
}
