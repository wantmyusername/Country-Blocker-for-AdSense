# Country Blocker for AdSense

Plugin de **WordPress** que **bloquea los anuncios de AdSense en países concretos**: geolocaliza al visitante y, si su país está en tu lista, **no carga el script de AdSense** (no muestra anuncios).

- **Autor:** Jesús Rodríguez
- **Licencia:** GPLv3
- **Requiere:** WordPress 5.3+ · PHP 7.4+
- Solo funciona con **AdSense Auto Ads**.

## Características

- **Bloquea anuncios por país** usando códigos de 2 letras separados por coma (`US,MX,CA`).
- **Ligero** (< 8 KB) comparado con plugins similares.
- Configuración simple: **Publisher ID**, **países a bloquear** y **API key** de [ipgeolocation.io](https://ipgeolocation.io).
- Aviso en el admin si no está configurado.

## Cómo funciona

1. En `wp_head` (`inc/header-html.php`) se pide la geolocalización del visitante:
   ```php
   wp_remote_get("https://api.ipgeolocation.io/ipgeo?apiKey=$access_key&ip=$ip_address")
   ```
   donde `$ip_address` es `$_SERVER['REMOTE_ADDR']`.
2. Si el `country_code2` está **en la lista de países bloqueados** → **no se imprime** el script de AdSense.
3. Si **no** está bloqueado → imprime el script de **AdSense Auto Ads** con tu publisher ID:
   ```html
   <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-<PUBLISHER_ID>" crossorigin="anonymous"></script>
   ```

## Configuración

En **Ajustes → Country Blocker for AdSense**:

| Campo | Clave | Descripción |
|---|---|---|
| **Publisher ID** | `trid` | Tu ID de AdSense (`pub-…`). |
| **Country to block** | `toe` | Códigos ISO de 2 letras separados por coma, **sin espacios** (p. ej. `US,MX,CA`). |
| **API KEY** | `apikeyfor` | API key de **ipgeolocation.io** (cuenta propia). |

La config se guarda por **AJAX** en la opción `cbfa_settings` (`wp_ajax_CBFA_guardar_cbfa`).

## Estructura

```
index.php              Bootstrap del plugin (admin, AJAX, hooks, wp_head)
inc/admin-html.php     Página de ajustes (tabs General / Instructions + JS)
inc/header-html.php    Geolocalización + inyección (o no) del script de AdSense
readme.txt             Readme en formato WordPress (GPLv3)
```

## Instalación

1. Sube la **carpeta** a `/wp-content/plugins/` **o** el **`.zip`** desde *Plugins → Añadir nuevo → Subir plugin*.
2. **Actívalo** y ve a **Ajustes → Country Blocker for AdSense**.
3. Crea una cuenta en **ipgeolocation.io**, copia tu API key y pégala en los ajustes.
4. **Quita cualquier código de AdSense** que hayas insertado a mano y no uses otros plugins de AdSense (Ad Inserter, Site Kit, etc.).

## Notas y advertencias

- **Solo Auto Ads.** No aplica a anuncios insertados manualmente ni convive con otros plugins de AdSense.
- La geolocalización se hace **en cada carga de página, del lado del servidor** → añade **latencia** y **consume cuota** de la API (una llamada por visita). Conviene **cachear** el resultado por IP.
- Detrás de **proxy/CDN (p. ej. Cloudflare)**, `$_SERVER['REMOTE_ADDR']` puede ser la IP del proxy, no la del usuario → la geolocalización sería incorrecta. Habría que usar la IP real (`CF-Connecting-IP` / `X-Forwarded-For`).
- La **API key** se guarda en `wp_options` y viaja en la query hacia ipgeolocation.io (no se expone al navegador, pero es un secreto de servidor).
- ⚠️ **Seguridad del guardado AJAX:** `CBFA_guardar_cbfa` **no verifica nonce ni capacidad**; cualquier usuario logueado podría cambiar los ajustes. Recomendable añadir `check_ajax_referer()` + `current_user_can('manage_options')`.

## Licencia

**GPLv3** — ver `readme.txt`. Autor: **Jesús Rodríguez**.
