<?php

class Checker {
  protected $errors = array();
  
  public function lowlevelChecks($debug = false) {
    // Checks the PHP version
    if (!Helpers::checkVersion(PHP_VERSION, '5.3.2')) {
      $this->addError('Minicraft requires PHP <u>5.3.2</u> or higher. You have PHP <u>' . htmlspecialchars(PHP_VERSION, ENT_QUOTES) . '</u> so Minicraft will not run on your current setup.');
    }
    
    // Checks if the install folder was removed
    if (is_dir(INSTALL)) {
      if (!file_exists(DB)) {
        header('Location: ' . INSTALL);
        die();
      } else if (!Helpers::removeDirectory(INSTALL)) {
        $this->addError('Minicraft does not have permission to remove the install folder. You need to remove it manually.');
      }
    } elseif (!file_exists(DB)) {
      $this->addError('The install folder could not be found. You should reinstall Minicraft.');
    }
    
    // Checks if the .htaccess file is present
    if (!is_file(ROOT . '.htaccess')) {
      $this->addError('The <code>.htaccess</code> file does not exist. Make sure it is present.');
    }
    
    // Checks if the cache folder is present and writable
    if (!is_dir(CACHE)) {
      $this->addError('The folder <code>' . CACHE . '</code> does not exist. Make sure it is present and writable.');
    } elseif (!is_writable(CACHE)) {
      $this->addError('The folder <code>' . CACHE . '</code> is not writable. Make sure it is present and writable.');
    }
    
    // Checks if the app folder is present
    if (!is_dir(APP)) {
      $this->addError('The folder <code>' . APP . '</code> does not exist. Make sure it was correctly uploaded.');
    }
    
    // Checks if the vendors folder is present
    if (!is_dir(VENDORS)) {
      $this->addError('The folder <code>' . VENDORS . '</code> does not exist. Make sure it was correctly uploaded.');
    }
    
    // Show errors
    if (!empty($this->errors)) {
      foreach ($this->errors as $error) {
        if ($debug) {
          echo ($error);
        }
        Logger::log(__FILE__, $error);
      }
    }
  }
  
  public function addError($error) {
    $this->errors[] = $error;
  }
}
