<?php
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    // print custom success html
    echo 'Pay Success';
} else {
    // do some thing about order failed
    echo 'Pay failed';
}

echo 'Debug: <br>', str_replace("\n", '<br>', print_r($_GET, true));