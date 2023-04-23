<?php
global $wp;
$current_url = parse_url(home_url());
?>

<!-- Country Blocker for AdSense -->


<?php

$access_key = $settings['api_key']; // Reemplaza esto con tu clave de acceso
$ip_address = $_SERVER['REMOTE_ADDR'];

$json = file_get_contents("https://api.ipgeolocation.io/ipgeo?apiKey=$access_key&ip=$ip_address");
$api = json_decode($json);

$blocked_countries = explode(',', $settings['pais']); // Convertir la cadena de países en un array


if (in_array($api->country_code2, $blocked_countries)) { // Verificar si el país está en el array de países bloqueados
    echo '<!-- Sorry, there are no ads available in your country. Country blocked: ' . $settings['pais'] . ' -->';
} else {
    echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-' . $settings['id'] . '" crossorigin="anonymous"></script>';
}

?>


<!-- // Country Blocker for AdSense -->