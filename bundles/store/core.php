<?php

require_once('config/settings.php');

$bundle_router     = new Router;
$bundle_translator = new Translator(BUNDLES . $bundle_name . '/config/lang/');

if (file_exists(BUNDLES . $bundle_name . '/config/lang/' . $config->getLang() . '.php')) {
  $blanguage = $config->getLang();
} else {
  $blanguage = $bundle_translator->getDefaultLanguage();
}

$bundle_router->addController(new Controller('store', '#^/' . ROOT . $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/?$#', $bundle_translator->getTranslation($blanguage, 'URL_STORE'), 'store'));
$bundle_router->addController(new Controller('vault', '#^/' . ROOT . $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/' . $bundle_translator->getTranslation($blanguage, 'URL_VAULT') . '/?$#', $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/' . $bundle_translator->getTranslation($blanguage, 'URL_VAULT'), 'store'));
$bundle_router->addController(new Controller('buy', '#^/' . ROOT . $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/' . $bundle_translator->getTranslation($blanguage, 'URL_BUY') . '/?$#', $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/' . $bundle_translator->getTranslation($blanguage, 'URL_BUY'), 'store'));
$bundle_router->addController(new Controller('store_category', '#^/' . ROOT . $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/' . $bundle_translator->getTranslation($blanguage, 'URL_CATEGORY') . '/(\d+)-([\w\-]+)/?$#', $bundle_translator->getTranslation($blanguage, 'URL_STORE') . '/' . $bundle_translator->getTranslation($blanguage, 'URL_CATEGORY') . '/%m1%-%m2%', 'store'));
$bundle_router->addController(new Controller('starpass', '#^/' . ROOT . 'starpass/?#', 'starpass', 'store'));

/* ============================== */
// Imports and initialises Twig
require_once(VENDORS . 'Twig/Autoloader.php');
Twig_Autoloader::register();
$loader    = new Twig_Loader_Filesystem(BUNDLES . 'store/views/');
$store_twig = new Twig_Environment($loader, array(
  'cache' => $config->getDebugMode() ? false : CACHE
));
$store_twig->getExtension('core')->setTimezone('Europe/Paris');
if (!empty($_SERVER['REQUEST_URI'])) {
  $store_twig->addGlobal('currentUri', $_SERVER['REQUEST_URI']);
}
if (!empty($_SERVER['HTTP_HOST'])) {
  $store_twig->addGlobal('currentDomain', $_SERVER['HTTP_HOST']);
} elseif (!empty($_SERVER['SERVER_NAME'])) {
  $store_twig->addGlobal('currentDomain', $_SERVER['SERVER_NAME']);
}
/* ============================== */

/* ============================== */
// Creates the Twig url() function
$store_twig_url_function = new Twig_SimpleFunction('url', function() {
  global $router;
  $arguments = func_get_args();
  $action    = $arguments[0];
  
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
$store_twig->addFunction($store_twig_url_function);
/* ============================== */

/* ============================== */
// Creates the Twig internal_asset() function
$store_twig_asset_function = new Twig_SimpleFunction('asset', function($path) {
  return URL . '/' . BUNDLES . 'store/public/' . $path;
});

// Adds the internal_asset() function to Twig
$store_twig->addFunction($store_twig_asset_function);
/* ============================== */

/* ============================== */
// Creates the Twig lang() function
$store_twig_lang_function = new Twig_SimpleFunction('lang', function() {
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
$store_twig->addFunction($store_twig_lang_function);
/* ============================== */