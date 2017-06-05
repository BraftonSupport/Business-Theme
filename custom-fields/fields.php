<?php

require_once ABSPATH . 'wp-content/plugins/advanced-custom-fields/acf.php';
if(function_exists("register_field_group"))
{
    $dir = dirname(__FILE__);
    $files = glob("$dir/**/*.acf.php");
    foreach($files as $file){
		if(is_file($dir.'/'.$file)){
			require_once $dir.'/'.$file;
		}
    }
}