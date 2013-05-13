<?php

function setup_fVote(){
    
    
    global $wpdb;
    
    $table_name = $wpdb->prefix . "fVote";

$sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  vote TEXT DEFAULT '' NOT NULL,
  question TEXT DEFAULT '' NOT NULL,
  subjects TEXT DEFAULT '' NOT NULL,
  remarks TEXT DEFAULT '' NOT NULL,
  UNIQUE KEY id (id)
);";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );

}

function uninstall_fVote(){


     
    global $wpdb;
    
    $table_name = $wpdb->prefix . "fVote";

$sql = "DROP TABLE $table_name ;";

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

}





?>