<?php

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
