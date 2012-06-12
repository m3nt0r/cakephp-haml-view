<?php
/**
 * HamlView for CakePHP
 * 
 * @version 0.1
 * @package app.views
 * @subpackage app.views.haml
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @license MIT License
 *
 * Rewriting is fun. Simplicity is bliss.
 *
 * @link http:://www.twig-project.org Twig Homepage
 * @link http://github.com/m3nt0r My GitHub
 * @link http://twitter.com/m3nt0r My Twitter
 * @link https://github.com/glasserc/phphaml Parser
 */

define('PHPHAML_VERSION', '');
define('PHPHAML_CACHE', TMP . 'cache' . DS . 'views');

define('HAML_EXTENSION', '.haml');

App::import('Core', 'Theme');
App::import('Vendors', 'Haml.phpHaml', array(
	'file' => 'phphaml' . DS . 'includes' . DS . 'haml' . DS . 'HamlParser.class.php'
));

/**
 * h2o-PHP CakePHP View Class
 *
 * @package haml.view
 * @author Kjell Bublitz <m3nt0r.de@gmail.com>
 * @license MIT
 */
class HamlView extends ThemeView {	
	/**
	 * Constructor
	 *
	 * @param Controller $controller A controller object to pull View::__passedArgs from.
	 * @param boolean $register Should the View instance be registered in the ClassRegistry
	 * @return View
	 */
	function __construct(&$controller, $register = true) {
		parent::__construct($controller, $register);
		$this->ext = HAML_EXTENSION;
	}
	
	/**
	 * Renders and returns output for given view filename with its
	 * array of data.
	 *
	 * @param string $___viewFn Filename of the view
	 * @param array $___dataForView Data to include in rendered view
	 * @param boolean $loadHelpers Boolean to indicate that helpers should be loaded.
	 * @param boolean $cached Whether or not to trigger the creation of a cache file.
	 * @return string Rendered output
	 * @access protected
	 */
	function _render($___viewFn, $___dataForView, $loadHelpers = true, $cached = false) {
		$loadedHelpers = array();
		
		if ($this->helpers != false && $loadHelpers === true) {
			$loadedHelpers = $this->_loadHelpers($loadedHelpers, $this->helpers);
			$helpers = array_keys($loadedHelpers);
			$helperNames = array_map(array('Inflector', 'variable'), $helpers);

			for ($i = count($helpers) - 1; $i >= 0; $i--) {
				$name = $helperNames[$i];
				$helper =& $loadedHelpers[$helpers[$i]];

				if (!isset($___dataForView[$name])) {
					${$name} =& $helper;
				}
				$this->loaded[$helperNames[$i]] =& $helper;
				$this->{$helpers[$i]} =& $helper;
			}
			$this->_triggerHelpers('beforeRender');
			unset($name, $loadedHelpers, $helpers, $i, $helperNames, $helper);
		}
		
		$___configDebug = (Configure::read() > 0);
		$___filename = basename($___viewFn);
		$___extension = '.'.array_pop(explode('.', $___filename));
		
		if ($___extension == HAML_EXTENSION) {
			ob_start();
			try {
				if (!is_array($___dataForView)) 
					$___dataForView = array();
				
				// Load Template and Set view data
				$hamlSource = file_get_contents($___viewFn);
				$__haml_parser = new HamlParser(null, PHPHAML_CACHE);
				$__haml_parser->setSource($hamlSource);
				$__haml_parser->append($___dataForView);
				
				// Expose helpers the "cakephp 1.2" way:
				if ($this->helpers != false && $loadHelpers === true) {
					$__haml_parser->append($this->loaded);
				}
				
				// Echo rendered html
				echo $__haml_parser->fetch();
			} 
			catch(Exception $e) {
				echo '<pre><h2>Haml Error</h2>'.htmlentities($e->getMessage()).'</pre>';
			}
			
		} else {
			extract($___dataForView, EXTR_SKIP);
			ob_start();
			
			if ($___configDebug) {
				include ($___viewFn);
			} else {
				@include ($___viewFn);
			}
		}
		
		if ($loadHelpers === true) {
			$this->_triggerHelpers('afterRender');
		}

		$out = ob_get_clean();
		$caching = (
			isset($this->loaded['cache']) &&
			(($this->cacheAction != false)) && (Configure::read('Cache.check') === true)
		);

		if ($caching) {
			if (is_a($this->loaded['cache'], 'CacheHelper')) {
				$cache =& $this->loaded['cache'];
				$cache->base = $this->base;
				$cache->here = $this->here;
				$cache->helpers = $this->helpers;
				$cache->action = $this->action;
				$cache->controllerName = $this->name;
				$cache->layout = $this->layout;
				$cache->cacheAction = $this->cacheAction;
				$cache->viewVars = $this->viewVars;
				$out = $cache->cache($___viewFn, $out, $cached);
			}
		}
		return $out;
	}
	
	
	
}