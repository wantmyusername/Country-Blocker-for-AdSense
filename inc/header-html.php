<?php
global $wp;
$current_url = parse_url(home_url());
?>

<!-- Country Blocker for AdSense -->


<?php

$access_key = isset( $settings['api_key'] ) ? wp_kses_post( $settings['api_key'] ) : ''; 
$ip_address = wp_kses_post( $_SERVER['REMOTE_ADDR'] );

$response = wp_remote_get( "https://api.ipgeolocation.io/ipgeo?apiKey=$access_key&ip=$ip_address" );

if ( is_wp_error( $response ) ) {
    echo '<!-- Ups, API call error :( -->';
} else {
    $body = wp_remote_retrieve_body( $response );
    $api = json_decode( $body );

    $blocked_countries = explode(',', isset( $settings['pais'] ) ? wp_kses_post( $settings['pais'] ) : '' ); // Convertir la cadena de países en un array

    if (in_array($api->country_code2, $blocked_countries)) { // Verificar si el país está en el array de países bloqueados
        echo '<!-- Sorry, there are no ads available in your country. Country blocked: ' . wp_kses_post($settings['pais']) . ' -->';
    } else {
        echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-' . esc_html( $settings['id'] ) . '" crossorigin="anonymous"></script>';
    }
}

?>


<!-- // Country Blocker for AdSense -->
