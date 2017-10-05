<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mlang module request class
 * From the module https://github.com/GeertDD/kohana-lang
 */

class Mlang_Request extends Kohana_Request {

	/**
	 * @var string request language code
	 */
	static public $lang = '';

	/**	
	 *
	 * Extension of the request factory method. If none given, the URI will
	 * be automatically detected. If the URI contains no language segment, the user
	 * will be redirected to the same URI with the default language prepended.
	 * If the URI does contain a language segment, I18n and locale will be set.
	 * Also, a cookie with the current language will be set. Finally, the language
	 * segment is chopped off the URI and normal request processing continues.
	 *
	 * @param   string   URI of the request
	 * @param	Kohana_Cache cache object
	 * @return  Request
	 */
	public static function factory($uri = TRUE, HTTP_Cache $cache = NULL, $injected_routes = array())
	{
		if(!Kohana::$is_cli)
		{
			// Get the list of supported languages
			$langs = (array) Kohana::$config->load('mlang.languages');

			if($uri === TRUE)
			{
				// We need the current URI
				$uri = Request::detect_uri();
			}
			//detect the url to show translation module
			//if ($uri == '/CutDeLuxe/Kolding/Frisoerer/byguidested/3658') {
// Normalize URI
				$uri = ltrim($uri, '/');

				// Look for a supported language in the first URI segment
				if(!preg_match('~^(?:'.implode('|', array_keys($langs)).')(?=/|$)~i', $uri, $matches))
				{

					// If we don't have any, we look whether it's normal (is it in the no lang routes ?) or we need to append it
					/*if(Request::process_uri($uri, Route::nolang_routes()))
					{
						return parent::factory($uri, $cache);
					}*/

					// We can't find a language, we're gonna need to look deeper
                    if (Mlang::find_default() != 'da') {
                        Request::$lang = $lang = 'da';
                    } else {
                        Request::$lang = $lang = Mlang::find_default();
                    }
					// Use the default server protocol
					$protocol = (isset($_SERVER['SERVER_PROTOCOL'])) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1';
					// Redirect to the same URI, but with language prepended
                    if ($lang != 'da') {
                        header($protocol.' 302 Found');
                        header('Location: '.URL::base(TRUE, TRUE).$lang.'/'.$uri);
                        // Stop execution
                        exit;
                    }

				}

				// Language found in the URI
				Request::$lang = isset($matches[0]) ? strtolower($matches[0]) : 'da';


				// Remove language from URI
            if (Request::$lang != 'da') {
                Mlang::factory();
                $uri = (string) substr($uri, strlen(Request::$lang));
            }

			/*} elseif ($uri == '/da/CutDeLuxe/Kolding/Frisoerer/byguidested/3658') {
				Request::$lang = 'da';
				$uri = '/CutDeLuxe/Kolding/Frisoerer/byguidested/3658';
			} elseif ($uri == '/en/CutDeLuxe/Kolding/Frisoerer/byguidested/3658') {
				Request::$lang = 'en';
				$uri = '/CutDeLuxe/Kolding/Frisoerer/byguidested/3658';
			}*/
		}
		// Continue normal request processing with the URI without language*/
		return parent::factory($uri, $cache, $injected_routes);
	}



}