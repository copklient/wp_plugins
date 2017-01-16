<?php
/*
    Plugin Name: Tic Tac Toe
    Plugin URI: http://wordpres.dev/
    Description: My tic tac toe :) funy game
    Author: Tigran
    Version: 1.5
    Author URI: http://wordpres.dev/
 */

add_action('admin_menu', 'tic_tac_toe');
function tic_tac_toe(){
    add_options_page('Tic Tac Toe','Tic Tac Toe','manage_options', __FILE__,'tic_tac_toe_game');
}
function tic_tac_toe_game(){
    ?>
        <a href="<?php echo plugins_url(); ?>/tic tac toe/game.html">Click for start game :)</a>
    <?php
}