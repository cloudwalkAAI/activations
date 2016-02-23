<?php
    echo '<div class="fb-comments" data-href="'.current_full_url().'" data-width="1058" data-numposts="5"></div>';

    function current_full_url()
    {
        $CI =& get_instance();

        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
?>

