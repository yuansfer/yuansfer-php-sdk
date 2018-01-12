<?php
if (isset($_REQUEST['status']) && $_REQUEST['status'] === 'success') {
    // print custom success html
    echo 'success';
} else {
    // do some thing about order failed
    echo 'failed';
}