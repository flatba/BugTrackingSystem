<!-- テンプレートが読み込まれる直前で実行される -->
<?php

function _my_create_thread(){
    if(is_page('create-thread')
       && isset($_POST['_wpnonce'])
       && wp_verify_nonce($_POST['_wpnonce'], 'create_thread')){
        //POSTデータを表示して終了
        var_dump($_POST);
        die();
    }
}
add_action('template_redirect', '_my_create_thread');

?>
