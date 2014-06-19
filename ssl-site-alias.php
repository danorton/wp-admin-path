<?php
/**
 * Plugin Name: SSL site alias
 * Plugin URI: https://github.com/danorton/wp-ssl-site-alias
 * Description: Use a different domain/path for serving your website over SSL, set with <code>SSL_SITE_ALIAS</code> in your <code>wp-config.php</code>.
 * Author: Weirdosoft, derived from SSL Domain Alias by TheDeadMedic
 * Author URI: weirdosoft.com
 *
 * @package SSL_site_alias
 */

/**
 * Swap out the current site domain and path with {@see SSL_SITE_ALIAS} if the
 * protocol is HTTPS.
 *
 * This function expects both {@see WP_SITEURL} and {@see SSL_SITE_ALIAS} to be defined.
 *
 * @todo The replacement is a simple string replacement (for speed). If the
 * domain/path is matching other parts of the URL other than the host, we'll
 * need to switch to a more rigid regex.
 *
 * @param string $url
 * @return string
 */
function _use_ssl_site_alias_for_https( $url )
{
	static $site;
	if ( ! isset( $site ) ) {
		$site = defined( 'SSL_SITE_ALIAS' ) ? parse_url( SSL_SITE_ALIAS ) : false;
		if ( $site ) {
			$site = SSL_SITE_ALIAS;
		}
	}

	if ( $site && strpos( $url, 'https://' ) === 0 ) {
		$url = str_replace( $site, SSL_SITE_ALIAS, $url );
	}

	return $url;
}

add_filter( 'plugins_url', '_use_ssl_site_alias_for_https', 1 );
add_filter( 'content_url', '_use_ssl_site_alias_for_https', 1 );
add_filter( 'site_url', '_use_ssl_site_alias_for_https', 1 );

