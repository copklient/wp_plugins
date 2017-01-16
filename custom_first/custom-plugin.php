<?php
/*
    Plugin Name: Custom Plugin
    Plugin URI: http://wordpres.dev/
    Description: custom plugin by me
    Author: Tigran
    Version: 1.0
    Author URI: http://wordpres.dev/
 */


function custom_my_css(){
    wp_enqueue_style( 'custom-css-icon', plugins_url().'/custom/icon_custom.css' );
}
add_action('admin_menu', 'custom_my_css');

function style_custom_my(){
    wp_enqueue_style( 'custom-css', plugins_url().'/custom/custom-css.css' );
}
add_action('admin_menu', 'style_custom_my');

add_action('admin_menu', 'custom_plugin_admin_action');
function custom_plugin_admin_action(){
    $page_title = 'Post Manage';
    $menu_title = 'Post Manage';
    $capability = 'manage_options';
    $menu_slug = 'myplugin-settings';
    $function = 'custom_plugin_admin';
//    $icon_url = dirname(__FILE__).'/icon.png' ;
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function);
    add_options_page('custom-plugin','custom-plugin','manage_options', __FILE__,'custom_plugin_admin');

//    sub
//    $sub_menu_title = 'Settings';
//        add_submenu_page($menu_slug, $page_title, $sub_menu_title, $capability, $menu_slug, $function);
//
//    // Now add the submenu page for Help
//    $submenu_page_title = 'My Plugin Help';
//    $submenu_title = 'Help';
//    $submenu_slug = 'myplugin-help';
//    $submenu_function = 'myplugin_help';
//    add_submenu_page($menu_slug, $submenu_page_title, $submenu_title, $capability, $submenu_slug, $submenu_function);
}
function custom_plugin_admin(){
//    echo '<div style="float:left;"><img width="20" height = "20" src="'.site_url().'/wp-content/plugins/poll/images/poll_red.png" /></div>';
    ?>
    <div class="wrap">
        <h2>Plugin</h2>
        <h3>Search all posts</h3>
        <p>Click the button bellow to begin the search</p>
        <form action="" method="POST">
            <input type="submit" name="search_draft_posts" value="Show Drafts" class="button-primary" />
            <input type="submit" name="search_publish_posts" value="Show Publish" class="button-primary" />
            <input type="submit" name="search_trash_posts" value="Show Trash" class="button-primary" />
<!--            <input type="search" name="search_by_title" placeholder="Title" class="form-control">-->
<!--            <input type="search" name="search_by_id" placeholder="ID" class="form-control">-->
<!--            <input type="submit" name="search_by" value="Search" class="button-primary">-->
        </form>
        <br>
        <?php
            $count_drafts = 0;
        ?>
        <table class="custom-table">
            <thead>
                <tr>
                    <td>Post Title</td>
                    <td>Post ID</td>
                    <td>Post Edit</td>
                    <td><a href="<?php echo 'edit.php?post_status=draft&post_type=post'; ?>">All Drafts</a></td>
                    <td><a href="<?php echo 'edit.php?post_type=post'?>">All posts</a></td>
                    <td><a href="<?php echo 'edit.php?post_status=trash&post_type=post'?>">All trashes</a></td>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td>Post Title</td>
                    <td>Post ID</td>
                    <td>Post Edit</td>
                    <td><a href="<?php echo 'edit.php?post_status=draft&post_type=post'; ?>">All Drafts</a></td>
                    <td><a href="<?php echo 'edit.php?post_type=post'?>">All posts</a></td>
                    <td><a href="<?php echo 'edit.php?post_status=trash&post_type=post'?>">All trashes</a></td>
                </tr>
            </tfoot>
            <tbody>
                <?php
                    global $wpdb;
                    $mytestdrafts = array();
                    if(isset($_POST['search_draft_posts'])) {
                        $mytestdrafts = $wpdb->get_results(
                            "
                            SELECT ID, post_title
                            FROM  $wpdb->posts
                            WHERE post_status = 'draft'
                            "
                        );
                        update_option('custom_plugin_draft_posts',$mytestdrafts);


                        ?>
                        <?php
                        foreach ($mytestdrafts as $mytestdraft) {
                            ?>
                            <tr>
                                <?php
                                echo "<td>" . $mytestdraft->post_title . "</td>";
                                echo "<td>" . $mytestdraft->ID . "</td>";
                                $post_url_edit = admin_url( 'post.php?post=' . $mytestdraft->ID ) . '&action=edit';
                                ?>
                                <td><a href="<?php echo $post_url_edit; ?>">Edit</a></td>
                            </tr>
                            <?php
                            $count_drafts++;
                        }
                        if($count_drafts == 0){
                            echo 'Drafts not found.';
                        }
                        else if($count_drafts >= 1) {
                            echo 'Drafts found: ' . $count_drafts.'';
                        }
                        else{
                            echo '404 error. Please try again.';
                        }
                    }
                    else if(get_option('custom_plugin_draft_posts')){
                        $mytestdrafts = get_option('custom_plugin_draft_posts');
                    }


                    if(isset($_POST['search_publish_posts'])){
                        $mytestdrafts = $wpdb->get_results(
                            "
                            SELECT ID, post_title
                            FROM  $wpdb->posts
                            WHERE post_status = 'publish'
                            "
                        );
                        update_option('custom_plugin_publish_posts',$mytestdrafts);


                        ?>
                        <?php
                        foreach ($mytestdrafts as $mytestdraft) {
                            ?>
                            <tr>
                                <?php
                                echo "<td>" . $mytestdraft->post_title . "</td>";
                                echo "<td>" . $mytestdraft->ID . "</td>";
                                $post_url_edit = admin_url( 'post.php?post=' . $mytestdraft->ID ) . '&action=edit';
                                ?>
                                <td><a href="<?php echo $post_url_edit; ?>">Edit</a></td>
                            </tr>
                            <?php
                            $count_drafts++;
                        }
                        if($count_drafts == 0){
                            echo 'Publish Posts not found.';
                        }
                        else if($count_drafts >= 1) {
                            echo 'Publish Posts found: ' . $count_drafts.'';
                        }
                        else{
                            echo '404 error. Please try again.';
                        }
                    }
                    else if(get_option('custom_plugin_publish_posts')){
                        $mytestdrafts = get_option('custom_plugin_publish_posts');
                    }
                if(isset($_POST['search_trash_posts'])){
                    $mytestdrafts = $wpdb->get_results(
                        "
                            SELECT ID, post_title
                            FROM  $wpdb->posts
                            WHERE post_status = 'trash'
                            "
                    );
                    update_option('custom_plugin_trash_posts',$mytestdrafts);


                    ?>
                    <?php
                    foreach ($mytestdrafts as $mytestdraft) {
                        ?>
                        <tr>
                            <?php
                            echo "<td>" . $mytestdraft->post_title . "</td>";
                            echo "<td>" . $mytestdraft->ID . "</td>";
                            $post_url_edit = admin_url( 'post.php?post=' . $mytestdraft->ID ) . '&action=edit';
                            ?>
                            <td><a href="<?php echo $post_url_edit; ?>">Edit</a></td>
                        </tr>
                        <?php
                        $count_drafts++;
                    }
                    if($count_drafts == 0){
                        echo 'In Trash Posts not found.';
                    }
                    else if($count_drafts >= 1) {
                        echo 'In Trash Posts found: ' . $count_drafts.'';
                    }
                    else{
                        echo '404 error. Please try again.';
                    }
                }
                else if(get_option('custom_plugin_trash_posts')){
                    $mytestdrafts = get_option('custom_plugin_trash_posts');
                }

                ?>
            </tbody>
        </table>
    </div>

<?php
}
