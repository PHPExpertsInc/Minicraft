<?php

class Config {
  protected $site_name;
  protected $site_email;
  protected $site_url;
  protected $site_description;
  protected $site_keywords;
  protected $language;
  protected $template_name;
  protected $twitter_url;
  protected $facebook_url;
  protected $youtube_url;
  protected $debug_mode;
  protected $api_key;
  protected $smtp_server;
  protected $smtp_port;
  protected $smtp_username;
  protected $smtp_password;
  protected $imgur_id;
  protected $disqus_id;
  protected $currency_singular;
  protected $currency_plural;
  protected $money_add;
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^c_#', $key)) {
          $key    = str_replace('c_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
      
      $this->setDebugMode = !empty($this->debug_mode);
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function setSmtpServer($server) {
    $this->smtp_server = $server;
  }
  
  public function setSmtpPort($port) {
    $this->smtp_port = $port;
  }
  
  public function setSmtpUsername($username) {
    $this->smtp_username = $username;
  }
  
  public function setSmtpPassword($password) {
    $this->smtp_password = $password;
  }
  
  public function getSmtpServer() {
    return $this->smtp_server;
  }
  
  public function getSmtpPort() {
    return $this->smtp_port;
  }
  
  public function getSmtpUsername() {
    return $this->smtp_username;
  }
  
  public function getSmtpPassword() {
    return $this->smtp_password;
  }
  
  public function getSiteName() {
    return $this->site_name;
  }
  
  public function setSiteName($site_name) {
    $this->site_name = $site_name;
  }
  
  public function getSiteEmail() {
    return $this->site_email;
  }
  
  public function setSiteEmail($site_email) {
    $this->site_email = $site_email;
  }
  
  public function getSiteUrl() {
    return $this->site_url;
  }
  
  public function setSiteUrl($site_url) {
    $this->site_url = $site_url;
  }
  
  public function getSiteDescription() {
    return $this->site_description;
  }
  
  public function setSiteDescription($site_description) {
    $this->site_description = $site_description;
  }
  
  public function getKeywords() {
    return $this->site_keywords;
  }
  
  public function setKeywords($site_keywords) {
    $this->site_keywords = $site_keywords;
  }
  
  public function getTemplateName() {
    return $this->template_name;
  }
  
  public function setTemplateName($template_name) {
    $this->template_name = $template_name;
  }
  
  public function getLanguage() {
    return $this->language;
  }
  
  // Short version of getLanguage
  public function getLang() {
    return $this->getLanguage();
  }
  
  public function setLanguage($language) {
    $this->language = $language;
  }
  
  public function getTwitterUrl() {
    return $this->twitter_url;
  }
  
  public function setTwitterUrl($twitter_url) {
    $this->twitter_url = $twitter_url;
  }
  
  public function getFacebookUrl() {
    return $this->facebook_url;
  }
  
  public function setFacebookUrl($facebook_url) {
    $this->facebook_url = $facebook_url;
  }
  
  public function getYoutubeUrl() {
    return $this->youtube_url;
  }
  
  public function setYoutubeUrl($youtube_url) {
    $this->youtube_url = $youtube_url;
  }
  
  public function getDebugMode() {
    return $this->debug_mode;
  }
  
  public function setDebugMode($debug_mode) {
    $this->debug_mode = $debug_mode;
  }
  
  public function getApiKey() {
    return $this->api_key;
  }
  
  public function setApiKey($api_key) {
    $this->api_key = $api_key;
  }
  
  public function getCookieExpires() {
    return Database::getCookieExpires();
  }
  
  public function getSessionExpires() {
    return Database::getSessionExpires();
  }
  
  public function setImgurId($id) {
    $this->imgur_id = $id;
  }
  
  public function setDisqusId($id) {
    $this->disqus_id = $id;
  }
  
  public function getImgurId() {
    return $this->imgur_id;
  }
  
  public function getDisqusId() {
    return $this->disqus_id;
  }
  
  // @todo Make this editable from the administration panel
  public function getTopCountries() {
    return array(
      'zz' => 'Non spécifié',
      'fr' => 'France',
      'be' => 'Belgique',
      'ca' => 'Canada'
    );
  }
  
  // @todo Make this editable from the administration panel
  public function getMenuItems() {
    return array(
      array(
        'url' => '/blog',
        'name' => 'Blog'
      ),
//      array(
//        'url' => '/forum',
//        'name' => 'Forum'
//      ),
      array(
        'url' => '/boutique',
        'name' => 'Boutique'
      )
//      array(
//        'url' => array(
//          array(
//            'url' => '/page/terms',
//            'name' => 'Terms'
//          ),
//          array(
//            'url' => '/page/banish',
//            'name' => 'Banishments'
//          ),
//          array(
//            'url' => '/support',
//            'name' => 'Support'
//          )
//        ),
//        'name' => 'Autres'
//      )
    );
  }
  
  // @todo Make this editable from the administration panel
  public function getCarouselItems() {
    return array(
      array(
        'img' => '/themes/bootcraft/public/img/slider/1.jpg',
        'headline' => 'Titre du slide 1',
        'text' => 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.',
      ),
      array(
        'img' => '/themes/bootcraft/public/img/slider/2.jpg',
        'headline' => 'Titre du slide 1',
        'text' => 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.',
      ),
      array(
        'img' => '/themes/bootcraft/public/img/slider/3.jpg',
        'headline' => 'Titre du slide 3',
        'text' => 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.',
        'button' => array(
          'text' => 'En savoir plus',
          'link' => '/boutique'
        )
      )
    );
  }
  
  // @todo Make this editable from the administration panel
  public function isActive($bundle) {
    $bundles = array(
      'blog',
      'store'
    );
    
    return in_array($bundle, $bundles);
  }
  
  // @todo Make this editable from the administration panel
  public function getVoteSites() {
    $sites = array(
      array(
        'name' => 'MCServ',
        'url' => 'http://www.mcserv.org/',
        'logo' => 'http://www.mcserv.org/Medias/interface/mcserv_logo.png'
      ),
      array(
        'name' => 'Top Minecraft',
        'url' => 'http://www.top-minecraft.net/',
        'logo' => 'http://www.top-minecraft.net/css/img/logo.png'
      )
    );
    
    return $sites;
  }
  
  // @todo Make this editable from the administration panel
  public function getPartners() {
    $sites = array(
      array(
        'name' => 'Partenaire Google',
        'url' => 'https://www.google.fr/',
        'logo' => 'https://www.google.fr/images/srpr/logo11w.png'
      ),
      array(
        'name' => 'Partenaire Yahoo',
        'url' => 'https://fr.yahoo.com/',
        'logo' => 'http://shoalsworks.com/wp-content/uploads/2013/11/yahoo_logo1.png'
      )
    );
    
    return $sites;
  }
  
  // @todo Make this editable from the administration panel
  public function getAds() {
    $sites = array(
      array(
        'name' => 'Publicité',
        'url' => 'http://www.google.fr/',
        'logo' => 'http://placehold.it/300x100&text=Publicité'
      )
    );
    
    return $sites;
  }
  
  public function setCurrencySingular($name) {
    $this->currency_singular = $name;
  }
  
  public function setCurrencyPlural($name) {
    $this->currency_plural = $name;
  }
  
  public function getCurrencySingular() {
    return $this->currency_singular;
  }
  
  public function getCurrencyPlural() {
    return $this->currency_plural;
  }
  
  public function getCurrencyName() {
    return array(
      'singular' => $this->getCurrencySingular(),
      'plural' => $this->getCurrencyPlural()
    );
  }
  
  // @todo Make this editable from the administration panel
  public function getMoneyAddedPerCode() {
    return 10;
  }
  
  // @todo Make this editable from the administration panel
  public function getStarpassInfos() {
    return array(
      'idd' => 236446,
      'idp' => 147650
    );
  }
  
  // @todo Make this editable from the administration panel
  public function getAllopassInfos() {
    return array(
      'ids' => 316262,
      'idd' => 1373678,
      'full' => '316262/1373678/5932368'
    );
  }
  
  public function getBundles() {
    $bundle_names = array();
    $bundles = glob(BUNDLES . '*', GLOB_ONLYDIR);
    
    foreach ($bundles as $bundle) {
      preg_match('#^bundles/(.+)#', $bundle, $match);
      array_push($bundle_names, $match[1]);
    }
    
    return $bundle_names;
  }
}
