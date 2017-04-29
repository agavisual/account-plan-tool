<?php
function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch ($controller) {
        case 'pages':
            
            $controller = new PagesController();
            break;
//        case 'posts':
//            // we need the model to query the database later in the controller
//            require_once('models/post.php');
//            $controller = new PostsController();
//            break;
        case 'process':
            // we need the model to query the database later in the controller
            require_once('models/file_detail.php');
            require_once('models/file_detail1.php');
            require_once('models/transaction.php');
            require_once('models/transaction_error.php');
            require_once('models/account_plan.php');
            include_once('util.php');
            $controller = new ProcessController();
            break;
    }

    $controller->{ $action }();
}

// we're adding an entry for the new controller and its actions
$controllers = array('pages' => ['home', 'error'],
    //'posts' => ['index', 'show'],
    'process' => ['upload_image','main_file', 'second_file', 'process_result', 'error_detail', 'content', 'card_single', 'result_xml_process', 'list_xml_file']);

if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('pages', 'error');
    }
} else {
    call('pages', 'error');
}
?>