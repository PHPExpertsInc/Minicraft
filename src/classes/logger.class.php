<?php

class Logger {
  public static function logFile() {
    $today = strtolower(@date('d_M_y'));
    if (!file_exists(LOGS . $today . '.html')) {
      $template = file_get_contents(LOGS . 'logs.html.dist');
      file_put_contents(LOGS . $today . '.html', $template);
    }
    
    return LOGS . $today . '.html';
  }
  
  public static function log($error_file, $str, $priority = 0) {
    $file = new DOMDocument;
    $file->loadHtmlFile(self::logFile());
    
    $parent = $file->getElementById('logs');
    
    $child = $file->createElement('li', @date('[Y-m-d H:i:s] ') . ' <code>' . $error_file . '</code> : ' . $str);
    
    $child->setAttribute('class', 'list-group-item');
    
    switch ($priority) {
      case 1:
        $child->setAttribute('class', 'list-group-item-warning');
        break;
      case 2:
        $child->setAttribute('class', 'list-group-item-danger');
        break;
      default:
        break;
    }
    
    $parent->appendChild($child);
    
    $file->saveHTML();
  }
}