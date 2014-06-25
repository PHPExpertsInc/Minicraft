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
  
  public function __construct($infos) {
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
  
  public function getTopCountries() {
    // @todo Make this dynamic
    return array(
      'zz' => 'Unspecified',
      'fr' => 'France',
      'be' => 'Belgium',
      'ca' => 'Canada',
      'us' => 'United States',
      'gb' => 'United Kingdom',
      'au' => 'Australia'
    );
  }
  
  public function getMenuItems() {
    // @todo Make this dynamic
    return array(
      array(
        'url' => '/blog',
        'name' => 'News'
      ),
      array(
        'url' => '/forum',
        'name' => 'Forum'
      ),
      array(
        'url' => '/vote',
        'name' => 'Vote'
      ),
      array(
        'url' => '/store',
        'name' => 'Store'
      ),
      array(
        'url' => array(
          array(
            'url' => '/page/terms',
            'name' => 'Terms'
          ),
          array(
            'url' => '/page/banish',
            'name' => 'Banishments'
          ),
          array(
            'url' => '/support',
            'name' => 'Support'
          )
        ),
        'name' => 'Others'
      )
    );
  }
  
  public function isActive($bundle) {
    // @todo Code this
    return true;
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
}
