<?php

/*
 * https://github.com/alecgorge/jsonapi/wiki/How-to-use-the-standard-api-over-http
 * http://mcjsonapi.com/apidocs/
 */

class Server {
  protected $id;
  protected $name;
  protected $slug;
  protected $description;
  protected $type;
  protected $ip;
  protected $jsonapi_port;
  protected $jsonapi_username;
  protected $jsonapi_password;
  protected $jsonapi = null;
  
  public function __construct($infos) {
    if (!empty($infos)) {
      foreach ($infos as $key => $value) {
        if (preg_match('#^s_#', $key)) {
          $key    = str_replace('s_', '', $key);
          $method = 'set' . Helpers::camelCase($key);
          if (method_exists($this, $method)) {
            $this->$method($value);
          }
        }
      }
      
      $this->setServerType(new ServerType($infos));
    } else {
      Logger::log(__FILE__, 'Array empty for class constructor.');
    }
  }
  
  public function __toString() {
    return $this->name;
  }
  
  public function connect() {
    if ($this->jsonapi == null) {
      try {
        $jsonapi_vendor = VENDORS . 'jsonapi.php';
        require_once($jsonapi_vendor);
        $this->jsonapi = new JSONAPI($this->ip, $this->jsonapi_port, $this->jsonapi_username, $this->jsonapi_password);
      }
      catch (Exception $e) {
        Logger::log(__FILE__, $e);
        return false;
      }
    }
  }
  
  public function sendItemToUser($user, $item, $drop = false) {
    if ($drop) {
      $json = $this->jsonapi->call('players.name.drop_item', array(
        $user->getMinecraftUsername(),
        $item->getMinecraftId(),
        $item->getQuantity(),
        $item->getMinecraftMeta()
      ));
    } else {
      $json = $this->jsonapi->call('players.name.inventory.give_item', array(
        $user->getMinecraftUsername(),
        $item->getMinecraftId(),
        $item->getQuantity(),
        $item->getMinecraftMeta()
      ));
    }
    if ($json[0]['is_success']) {
      return true;
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function isPlaying($username) {
    $players = $this->getPlayersOnline();
    
    if (!empty($players)) {
      foreach ($players as $key => $value) {
        if ($value['name'] == $username) {
          return true;
        }
      }
    }
    
    return false;
  }
  
  public function getVersion() {
    $infos = $this->getInfos();
    preg_match('#\(MC: (.+)\)#', $infos['version'], $matches);
    $version = $matches[1];
    
    return $version;
  }
  
  public function getMotd() {
    $json = $this->jsonapi->call('server.settings.motd');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getInfos() {
    $json = $this->jsonapi->call('server');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getPlayerCount() {
    $json = $this->jsonapi->call('getPlayerCount');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getPlayerLimit() {
    $json = $this->jsonapi->call('getPlayerLimit');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getPlayersOnline() {
    $json = $this->jsonapi->call('players.online');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getPlayersOffline() {
    $json = $this->jsonapi->call('players.offline');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getPlayersOnlineNames() {
    $json = $this->jsonapi->call('players.online.names');
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getPlayer($name) {
    $json = $this->jsonapi->call('players.name', array(
      $name
    ));
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getOfflinePlayer($name) {
    $json = $this->jsonapi->call('players.offline.name', array(
      $name
    ));
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function banPlayer($username, $reason = '') {
    $json = $this->jsonapi->call('players.name.ban', array(
      $username,
      $reason
    ));
    if ($json[0]['result'] == 'success') {
      return $json[0]['success'];
    } else {
      Logger::log(__FILE__, $json[0]['error']['message']);
      return false;
    }
  }
  
  public function getId() {
    return $this->id;
  }
  
  public function setId($id) {
    $this->id = $id;
  }
  
  public function setName($name) {
    $this->name = $name;
  }
  
  public function getName() {
    return $this->name;
  }
  
  public function setSlug($slug) {
    $this->slug = $slug;
  }
  
  public function getSlug() {
    return $this->slug;
  }
  
  public function getDescription() {
    return $this->description;
  }
  
  public function setDescription($description) {
    $this->description = $description;
  }
  
  public function getServerType() {
    return $this->type;
  }
  
  public function setServerType($type) {
    $this->type = $type;
  }
  
  public function getIp() {
    return $this->ip;
  }
  
  public function setIp($ip) {
    $this->ip = $ip;
  }
  
  public function getJsonapiPort() {
    return $this->jsonapi_port;
  }
  
  public function setJsonapiPort($jsonapi_port) {
    $this->jsonapi_port = $jsonapi_port;
  }
  
  public function getJsonapiUsername() {
    return $this->jsonapi_username;
  }
  
  public function setJsonapiUsername($jsonapi_username) {
    $this->jsonapi_username = $jsonapi_username;
  }
  
  public function getJsonapiPassword() {
    return $this->jsonapi_password;
  }
  
  public function setJsonapiPassword($jsonapi_password) {
    $this->jsonapi_password = $jsonapi_password;
  }
  
  public function getApi() {
    return $this->jsonapi;
  }
}
