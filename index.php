<?php

/**
 * ###################################################
 * # __  __  _         _                     __  _   #
 * #|  \/  |(_)       (_)                   / _|| |  #
 * #| \  / | _  _ __   _   ___  _ __  __ _ | |_ | |_ #
 * #| |\/| || || '_ \ | | / __|| '__|/ _` ||  _|| __|#
 * #| |  | || || | | || || (__ | |  | (_| || |  | |_ #
 * #|_|  |_||_||_| |_||_| \___||_|   \____||_|   \__|#
 * #                                                 #
 * ###################################################
 *
 * ==============================
 * INFORMATIONS
 * @author Charles Tatibouët - http://charlestati.com
 * @licence http://opensource.org/licenses/MIT - MIT License
 * http://minicraft.io
 * https://github.com/CharlesTati/Minicraft
 * ==============================
 */

/* ============================== */
// Constants
// Full URL:
define('URL', '//' . $_SERVER['HTTP_HOST']);
// Root:
define('ROOT', substr_count(URL, '/') > 2 ? basename(dirname(__FILE__)) . '/' : '');
// Note: You might need to edit the following constants from
// define('NAME', 'folder/'); to define('NAME', ROOT . 'folder/');
// if Minicraft is not in the root folder.
// app/ directory:
define('APP', 'app/');
define('CACHE', APP . 'cache/');
define('CONFIG', APP . 'config/');
define('LOGS', APP . 'logs/');
// src/ directory:
define('SOURCES', 'src/');
define('CLASSES', SOURCES . 'classes/');
define('CONTROLLERS', SOURCES . 'controllers/');
// vendors/ directory:
define('VENDORS', 'vendors/');
// lang/ directory:
define('LANGUAGE', CONFIG . 'lang/');
// install/ directory:
define('INSTALL', 'install/');
// bundles/ directory:
define('BUNDLES', 'bundles/');
// SQLite 3 Database
define('DB', CONFIG . 'database/minicraft.db');
/* ============================== */

/* ============================== */
// Class autoloader
function autoloader($class) {
  $class_file = strtolower(preg_replace('#([a-z])([A-Z])#', '$1_$2', $class)) . '.class.php';
  $bundles    = glob(BUNDLES . '*', GLOB_ONLYDIR);
  
  // Checks in the Bundles directory
  foreach ($bundles as $bundle) {
    if (file_exists($bundle . '/classes/' . $class_file)) {
      $require = $bundle . '/classes/' . $class_file;
      require_once($require);
      break;
    }
  }
  
  // Checks in the classes directory
  if (empty($require) and file_exists(CLASSES . $class_file)) {
    require_once(CLASSES . $class_file);
  }
}
spl_autoload_register('autoloader');
/* ============================== */

/* ============================== */
$checker = new Checker;
$checker->lowlevelChecks(true);
/* ============================== */

/* ============================== */
$ticraft = new Ticraft;
$config_infos = $ticraft->call('getConfig');
if (!empty($config_infos)) {
  $config  = new Config($config_infos);
}
if (!file_exists(LANGUAGE . $config->getLang() . '.php')) {
  $config->setLanguage('en');
}
/* ============================== */

/* ============================== */
if ($config->getDebugMode()) {
  error_reporting(E_ALL & ~E_NOTICE);
} else {
  error_reporting(0);
}
/* ============================== */

/* ============================== */
// Templates directory
define('TEMPLATE_DIR', is_dir('themes/' . $config->getTemplateName()) ? 'themes/' . $config->getTemplateName() . '/' : APP . 'theme_defaults/');
// Twig templates
define('VIEWS', TEMPLATE_DIR . 'views/');
// Email templates
define('EMAIL_TEMPLATES', TEMPLATE_DIR . 'email_templates/');
// Public files
define('PUBLIC_FILES', TEMPLATE_DIR . 'public/');
/* ============================== */

/* ============================== */
// Creates the Translator
$translator = new Translator(LANGUAGE);
/* ============================== */

/* ============================== */
// Router
$router = new Router;
$router->addController(new Controller('index', '#^/' . ROOT . '$#', ''));
$router->addController(new Controller('assets', '#^/' . ROOT . PUBLIC_FILES . '(.+)#', PUBLIC_FILES . '%m1%'));
$router->addController(new Controller('admin', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_ADMIN') . '/?$#', $translator->getTranslation($config->getLang(), 'URL_ADMIN')));
$router->addController(new Controller('manage', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_ADMIN') . '/' . $translator->getTranslation($config->getLang(), 'URL_MANAGE') . '-([\w\-]+)/?$#', $translator->getTranslation($config->getLang(), 'URL_ADMIN') . '/' . $translator->getTranslation($config->getLang(), 'URL_MANAGE') . '-%m1%'));
$router->addController(new Controller('action', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_ADMIN') . '/' . $translator->getTranslation($config->getLang(), 'URL_MANAGE') . '-([\w\-]+)/([\w\-]+)/?#', $translator->getTranslation($config->getLang(), 'URL_ADMIN') . '/' . $translator->getTranslation($config->getLang(), 'URL_MANAGE') . '-%m1%/%m2%'));
$router->addController(new Controller('login', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_SIGN_IN') . '/?#', $translator->getTranslation($config->getLang(), 'URL_SIGN_IN')));
$router->addController(new Controller('logout', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_SIGN_OUT') . '/?#', $translator->getTranslation($config->getLang(), 'URL_SIGN_OUT')));
$router->addController(new Controller('register', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_REGISTER') . '/?#', $translator->getTranslation($config->getLang(), 'URL_REGISTER')));
$router->addController(new Controller('verify', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_VERIFY') . '/([\w-%.]+)/([\w\-]+)/?#', $translator->getTranslation($config->getLang(), 'URL_VERIFY') . '/%m1%/%m2%'));
$router->addController(new Controller('resend', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_RESEND') . '/?#', $translator->getTranslation($config->getLang(), 'URL_VERIFY') . '/' . $translator->getTranslation($config->getLang(), 'URL_RESEND')));
$router->addController(new Controller('reset', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_RESET') . '/?$#', $translator->getTranslation($config->getLang(), 'URL_RESET')));
$router->addController(new Controller('reset_token', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_RESET') . '/?#', $translator->getTranslation($config->getLang(), 'URL_RESET')));
$router->addController(new Controller('profile', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_PROFILE') . '/?#', $translator->getTranslation($config->getLang(), 'URL_PROFILE')));
$router->addController(new Controller('player', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_PLAYER') . '/([\w\-]+)/?#', $translator->getTranslation($config->getLang(), 'URL_PLAYER') . '/%m1%'));
$router->addController(new Controller('out', '#^/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_OUT') . '/(.+)#', $translator->getTranslation($config->getLang(), 'URL_OUT') . '/%m1%'));
/* ============================== */

/* ============================== */
$bundles = glob(BUNDLES . '*', GLOB_ONLYDIR);
foreach ($bundles as $bundle) {
  if (file_exists($bundle . '/core.php')) {
    require_once($bundle . '/core.php');
    $translator->mergeWithTranslator($bundle_translator);
    $router->mergeWithRouter($bundle_router);
  }
}
/* ============================== */

/* ============================== */
// Imports and initialises Twig
require_once(VENDORS . 'Twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(VIEWS);
$twig   = new Twig_Environment($loader, array(
  'cache' => $config->getDebugMode() ? false : CACHE
));
$twig->getExtension('core')->setTimezone('Europe/Paris');
if (!empty($_SERVER['REQUEST_URI'])) {
  $twig->addGlobal('currentUri', $_SERVER['REQUEST_URI']);
}
if (!empty($_SERVER['HTTP_HOST'])) {
  $twig->addGlobal('currentDomain', $_SERVER['HTTP_HOST']);
} elseif (!empty($_SERVER['SERVER_NAME'])) {
  $twig->addGlobal('currentDomain', $_SERVER['SERVER_NAME']);
}
/* ============================== */

/* ============================== */
// Creates the Twig url() function
$twig_url_function = new Twig_SimpleFunction('url', function() {
  $arguments = func_get_args();
  $action    = $arguments[0];
  global $router;
  foreach ($router->getControllers() as $controller) {
    if ($controller->getName() == $action) {
      $url = $controller->getUrl();
      if (preg_match('#%m1%#', $url)) {
        for ($i = 1; $i < count($arguments); $i++) {
          $url = preg_replace('#%m' . $i . '%#', $arguments[$i], $url);
        }
      }
      break;
    }
  }
  
  return URL . '/' . $url;
});

// Adds the url() function to Twig
$twig->addFunction($twig_url_function);
/* ============================== */

/* ============================== */
// Creates the Twig lang() function
$twig_lang_function = new Twig_SimpleFunction('lang', function() {
  global $translator;
  global $config;
  $arguments   = func_get_args();
  $key         = $arguments[0];
  $translation = $translator->getTranslation($config->getLang(), $key);
  
  if (preg_match('#%m1%#', $translation)) {
    for ($i = 1; $i < count($arguments); $i++) {
      $translation = preg_replace('#%m' . $i . '%#', $arguments[$i], $translation);
    }
  }
  
  return $translation;
});

// Adds the lang() function to Twig
$twig->addFunction($twig_lang_function);
/* ============================== */

/* ============================== */
// Creates the Twig chat() function
$twig_chat_function = new Twig_SimpleFunction('chat', function($line) {
  $patterns = array(
    '#§0(.+)§r#',
    '#§1(.+)§r#',
    '#§2(.+)§r#',
    '#§3(.+)§r#',
    '#§4(.+)§r#',
    '#§5(.+)§r#',
    '#§6(.+)§r#',
    '#§7(.+)§r#',
    '#§8(.+)§r#',
    '#§9(.+)§r#',
    '#§a(.+)§r#',
    '#§b(.+)§r#',
    '#§c(.+)§r#',
    '#§d(.+)§r#',
    '#§e(.+)§r#',
    '#§f(.+)§r#',
    '#§l(.+)§r#',
    '#§m(.+)§r#',
    '#§n(.+)§r#',
    '#§o(.+)§r#'
  );
  
  $replacements = array(
    '<span style="color: #000000;">$1</span>',
    '<span style="color: #0000aa;">$1</span>',
    '<span style="color: #00aa00;">$1</span>',
    '<span style="color: #00aaaa;">$1</span>',
    '<span style="color: #aa0000;">$1</span>',
    '<span style="color: #aa00aa;">$1</span>',
    '<span style="color: #0000aa;">$1</span>',
    '<span style="color: #ffaa00;">$1</span>',
    '<span style="color: #aaaaaa;">$1</span>',
    '<span style="color: #555555;">$1</span>',
    '<span style="color: #5555ff;">$1</span>',
    '<span style="color: #55ff55;">$1</span>',
    '<span style="color: #55ffff;">$1</span>',
    '<span style="color: #ff5555;">$1</span>',
    '<span style="color: #ff55ff;">$1</span>',
    '<span style="color: #ffff55;">$1</span>',
    '<span style="color: #ffffff;">$1</span>',
    '<strong>$1</strong>',
    '<s>$1</s>',
    '<u>$1</u>',
    '<em>$1</em>'
  );
  
  return preg_replace($patterns, $replacements, $line);
});

// Adds the lang() function to Twig
$twig->addFunction($twig_chat_function);
/* ============================== */

/* ============================== */
session_start();
// Validates the session
$user = Security::validateSession($ticraft);
/* ============================== */


/* ============================== */
$servers = $ticraft->call('getAllServers');
$login_url = '/' . $router->getController('login')->getUrl();
$add_url = '/' . ROOT . $translator->getTranslation($config->getLang(), 'URL_ADMIN') . '/' . $translator->getTranslation($config->getLang(), 'URL_MANAGE') . '-servers/add';

if ($_SERVER['REQUEST_URI'] != $login_url and empty($servers) and !is_object($user)) {
  header('Location: ' . $login_url);
  die();
} elseif ($_SERVER['REQUEST_URI'] != $add_url and empty($servers) and is_object($user)) {
  header('Location: ' . $add_url);
  die();
}
/* ============================== */

// Here we go!
require_once(APP . 'router.php');