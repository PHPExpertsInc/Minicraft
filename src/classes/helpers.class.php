<?php

class Helpers {
  public static $icon_collapse = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEJGlDQ1BJQ0MgUHJvZmlsZQAAOBGFVd9v21QUPolvUqQWPyBYR4eKxa9VU1u5GxqtxgZJk6XtShal6dgqJOQ6N4mpGwfb6baqT3uBNwb8AUDZAw9IPCENBmJ72fbAtElThyqqSUh76MQPISbtBVXhu3ZiJ1PEXPX6yznfOec7517bRD1fabWaGVWIlquunc8klZOnFpSeTYrSs9RLA9Sr6U4tkcvNEi7BFffO6+EdigjL7ZHu/k72I796i9zRiSJPwG4VHX0Z+AxRzNRrtksUvwf7+Gm3BtzzHPDTNgQCqwKXfZwSeNHHJz1OIT8JjtAq6xWtCLwGPLzYZi+3YV8DGMiT4VVuG7oiZpGzrZJhcs/hL49xtzH/Dy6bdfTsXYNY+5yluWO4D4neK/ZUvok/17X0HPBLsF+vuUlhfwX4j/rSfAJ4H1H0qZJ9dN7nR19frRTeBt4Fe9FwpwtN+2p1MXscGLHR9SXrmMgjONd1ZxKzpBeA71b4tNhj6JGoyFNp4GHgwUp9qplfmnFW5oTdy7NamcwCI49kv6fN5IAHgD+0rbyoBc3SOjczohbyS1drbq6pQdqumllRC/0ymTtej8gpbbuVwpQfyw66dqEZyxZKxtHpJn+tZnpnEdrYBbueF9qQn93S7HQGGHnYP7w6L+YGHNtd1FJitqPAR+hERCNOFi1i1alKO6RQnjKUxL1GNjwlMsiEhcPLYTEiT9ISbN15OY/jx4SMshe9LaJRpTvHr3C/ybFYP1PZAfwfYrPsMBtnE6SwN9ib7AhLwTrBDgUKcm06FSrTfSj187xPdVQWOk5Q8vxAfSiIUc7Z7xr6zY/+hpqwSyv0I0/QMTRb7RMgBxNodTfSPqdraz/sDjzKBrv4zu2+a2t0/HHzjd2Lbcc2sG7GtsL42K+xLfxtUgI7YHqKlqHK8HbCCXgjHT1cAdMlDetv4FnQ2lLasaOl6vmB0CMmwT/IPszSueHQqv6i/qluqF+oF9TfO2qEGTumJH0qfSv9KH0nfS/9TIp0Wboi/SRdlb6RLgU5u++9nyXYe69fYRPdil1o1WufNSdTTsp75BfllPy8/LI8G7AUuV8ek6fkvfDsCfbNDP0dvRh0CrNqTbV7LfEEGDQPJQadBtfGVMWEq3QWWdufk6ZSNsjG2PQjp3ZcnOWWing6noonSInvi0/Ex+IzAreevPhe+CawpgP1/pMTMDo64G0sTCXIM+KdOnFWRfQKdJvQzV1+Bt8OokmrdtY2yhVX2a+qrykJfMq4Ml3VR4cVzTQVz+UoNne4vcKLoyS+gyKO6EHe+75Fdt0Mbe5bRIf/wjvrVmhbqBN97RD1vxrahvBOfOYzoosH9bq94uejSOQGkVM6sN/7HelL4t10t9F4gPdVzydEOx83Gv+uNxo7XyL/FtFl8z9ZAHF4bBsrEwAAAOBJREFUWAljZACCnW5ussycnF1MTEz2QK4kSIyG4Pm/f/8O/v3+vcx9167HjCDLWbm4LjIwMgrS0FIMo//9///u77dvBiwgn9PbcpBrmBgZhRggoQ4OdgwX0kMAFOVMQItoHef4/CIJcsCAglEHjIbAaAiMhgALrlLIaf16Rlxy5IjvCwz8j03faBQMeAgw4oobbPFFC7EBD4FRB4yGwGgIjIYAKASe06KEI9LM50ygjiKRiqmuDGQ3E6iXCuooUt10AgaCO6dAu5lAXWRQLxXomhVAPfSIDlD3fAXITpDdAJ15S33Dmu5GAAAAAElFTkSuQmCC';
  
  public static $icon_expand = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAEJGlDQ1BJQ0MgUHJvZmlsZQAAOBGFVd9v21QUPolvUqQWPyBYR4eKxa9VU1u5GxqtxgZJk6XtShal6dgqJOQ6N4mpGwfb6baqT3uBNwb8AUDZAw9IPCENBmJ72fbAtElThyqqSUh76MQPISbtBVXhu3ZiJ1PEXPX6yznfOec7517bRD1fabWaGVWIlquunc8klZOnFpSeTYrSs9RLA9Sr6U4tkcvNEi7BFffO6+EdigjL7ZHu/k72I796i9zRiSJPwG4VHX0Z+AxRzNRrtksUvwf7+Gm3BtzzHPDTNgQCqwKXfZwSeNHHJz1OIT8JjtAq6xWtCLwGPLzYZi+3YV8DGMiT4VVuG7oiZpGzrZJhcs/hL49xtzH/Dy6bdfTsXYNY+5yluWO4D4neK/ZUvok/17X0HPBLsF+vuUlhfwX4j/rSfAJ4H1H0qZJ9dN7nR19frRTeBt4Fe9FwpwtN+2p1MXscGLHR9SXrmMgjONd1ZxKzpBeA71b4tNhj6JGoyFNp4GHgwUp9qplfmnFW5oTdy7NamcwCI49kv6fN5IAHgD+0rbyoBc3SOjczohbyS1drbq6pQdqumllRC/0ymTtej8gpbbuVwpQfyw66dqEZyxZKxtHpJn+tZnpnEdrYBbueF9qQn93S7HQGGHnYP7w6L+YGHNtd1FJitqPAR+hERCNOFi1i1alKO6RQnjKUxL1GNjwlMsiEhcPLYTEiT9ISbN15OY/jx4SMshe9LaJRpTvHr3C/ybFYP1PZAfwfYrPsMBtnE6SwN9ib7AhLwTrBDgUKcm06FSrTfSj187xPdVQWOk5Q8vxAfSiIUc7Z7xr6zY/+hpqwSyv0I0/QMTRb7RMgBxNodTfSPqdraz/sDjzKBrv4zu2+a2t0/HHzjd2Lbcc2sG7GtsL42K+xLfxtUgI7YHqKlqHK8HbCCXgjHT1cAdMlDetv4FnQ2lLasaOl6vmB0CMmwT/IPszSueHQqv6i/qluqF+oF9TfO2qEGTumJH0qfSv9KH0nfS/9TIp0Wboi/SRdlb6RLgU5u++9nyXYe69fYRPdil1o1WufNSdTTsp75BfllPy8/LI8G7AUuV8ek6fkvfDsCfbNDP0dvRh0CrNqTbV7LfEEGDQPJQadBtfGVMWEq3QWWdufk6ZSNsjG2PQjp3ZcnOWWing6noonSInvi0/Ex+IzAreevPhe+CawpgP1/pMTMDo64G0sTCXIM+KdOnFWRfQKdJvQzV1+Bt8OokmrdtY2yhVX2a+qrykJfMq4Ml3VR4cVzTQVz+UoNne4vcKLoyS+gyKO6EHe+75Fdt0Mbe5bRIf/wjvrVmhbqBN97RD1vxrahvBOfOYzoosH9bq94uejSOQGkVM6sN/7HelL4t10t9F4gPdVzydEOx83Gv+uNxo7XyL/FtFl8z9ZAHF4bBsrEwAAAPxJREFUWAljZACCnW5ussycnF1MTEz2QK4kSIyG4Pm/f/8O/v3+vcx9167HjCDLWbm4LjIwMgrS0FIMo//9///u77dvBiwgn9PbcpBrmBgZhRggoQ4OdgwX0kMAFOVMQItoHef4/CIJcsCAAhZybXdav54RWe++wMD/yHxi2QMeAqMOGA2B0RBgxJV/0fM5sfkalzpc9oxGwYCHAM40gCsuYeLoaQRXHMPU46IHPARGHTAaAqMhQHY5gCtfkyo+KKLgOamupqL650ygjiIVDSTJKJDdTKBeKqijSJJOKigGd06BdjOBusigXirQNSuA5tIjOkDd8xUgO0F2AwDAIFg55NaPHAAAAABJRU5ErkJggg==';
  
  // Bolt - http://bolt.cm
  public static function htmlentities($str, $preserve_encoded_entities = false) {
    if ($preserve_encoded_entities) {
      $translation_table          = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
      $translation_table[chr(38)] = '&';
      return preg_replace('#&(?![A-Za-z]{0,4}\w{2,3};|\#[0-9]{2,3};)#', '&amp;', strtr($str, $translation_table));
    } else {
      return htmlentities($str, ENT_QUOTES);
    }
  }
  
  // http://stackoverflow.com/a/3349792
  public static function removeDirectory($path) {
    if (is_dir($path)) {
      if (substr($path, strlen($pth) - 1, 1) != '/') {
        $dirPath .= '/';
      }
      $files = glob($path . '*', GLOB_MARK);
      foreach ($files as $file) {
        if (is_dir($file)) {
          self::removeDirectory($file);
        } else {
          unlink($file);
        }
      }
      $result = rmdir($path);
    }
    
    return $result;
  }
  
  public static function camelCase($str) {
    $str = lcfirst(str_replace(' ', '', ucwords(str_replace(array(
      '-',
      '_'
    ), ' ', $str))));
    
    return $str;
  }
  
  public static function underscoreCase($str) {
    return strtolower(preg_replace('#([a-z])([A-Z])#', '$1_$2', $str));
  }
  
  static function generateSlug($str, $replace = array('\''), $delimiter = '-', $limit = 64, $css_mode = false) {
    // Replaces some characters (such as apostrophes) with spaces
    if (!empty($replace)) {
      $str = str_replace((array) $replace, ' ', $str);
    }
    
    // Transforms unknown characters into a similar letter
    $clean = self::removeAccents($str);
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
    $clean = preg_replace('#[^a-zA-Z0-9/_|+ -]#', '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace('#[/_|+ -]+#', $delimiter, $clean);
    
    // Smart trim
    if (strlen($clean) > $limit) {
      $clean  = substr($clean, 0, $limit);
      $hyphen = strrpos($clean, '-');
      $clean  = substr($clean, 0, $hyphen);
    }
    
    if ($css_mode) {
      $digits = array(
        'zero',
        'one',
        'two',
        'three',
        'four',
        'five',
        'six',
        'seven',
        'eight',
        'nine'
      );
      
      if (is_numeric(substr($clean, 0, 1))) {
        $clean = $digits[substr($slug, 0, 1)] . substr($clean, 1);
      }
    }
    
    return $clean;
  }
  
  // Bolt - http://bolt.cm
  public static function generateExtract($str, $length = 64, $append = '…') {
    $ret        = substr($str, 0, $length);
    $last_space = strrpos($ret, ' ');
    
    if ($last_space and $str != $ret) {
      $ret = substr($ret, 0, $last_space);
    }
    
    if ($ret != $str) {
      $ret .= $append;
    }
    
    return $ret;
  }
  
  public static function addHTTP($url) {
    return preg_match("#^(?:f|ht)tps?://#i", $url) ? $url : 'http://' . $url;
  }
  
  // Bolt - http://bolt.cm
  public static function getClientIp($trust_proxy_headers = false) {
    if (!$trust_proxy_headers) {
      return ip2long($_SERVER['REMOTE_ADDR']);
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      return ip2long($_SERVER['HTTP_CLIENT_IP']);
    } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      return ip2long($_SERVER['HTTP_X_FORWARDED_FOR']);
    } else {
      return ip2long($_SERVER['REMOTE_ADDR']);
    }
  }
  
  public static function tooShort($str, $min) {
    return strlen($str) < $min;
  }
  
  public static function tooLong($str, $max) {
    return strlen($str) > $max;
  }
  
  public static function usernameIsValid($username) {
    $regex_username = '#^(?![_-])(?!.*[_-]{2})([\wàáâãäåçèéêëìíîïðòóôõöùúûüýÿñ-]+)(?<![_-])$#';
    return preg_match($regex_username, $username);
  }
  
  public static function emailIsValid($email) {
    if (function_exists('idn_to_ascii')) {
      $parts  = explode('@', $email);
      $user   = $parts[0];
      $domain = idn_to_ascii($parts[1]);
      $email  = $user . '@' . $domain;
    }
    
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
  
  public static function setFlash($type, $message) {
    $_SESSION['MinicraftFlash'] = array(
      'type' => $type,
      'message' => $message
    );
  }
  
  // Générer une clé
  public static function randomKey($length = 32) {
    return substr(sha1(uniqid(rand(), true)), 0, $length > 40 ? 40 : $length);
  }
  
  /* ========== */
  
  // Wordpress - https://wordpress.org
  public static function removeAccents($str) {
    if (!preg_match('/[\x80-\xff]/', $str)) {
      return $str;
    }
    
    if (self::seemsUtf8($str)) {
      $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(194) . chr(170) => 'a',
        chr(194) . chr(186) => 'o',
        chr(195) . chr(128) => 'A',
        chr(195) . chr(129) => 'A',
        chr(195) . chr(130) => 'A',
        chr(195) . chr(131) => 'A',
        chr(195) . chr(132) => 'A',
        chr(195) . chr(133) => 'A',
        chr(195) . chr(134) => 'AE',
        chr(195) . chr(135) => 'C',
        chr(195) . chr(136) => 'E',
        chr(195) . chr(137) => 'E',
        chr(195) . chr(138) => 'E',
        chr(195) . chr(139) => 'E',
        chr(195) . chr(140) => 'I',
        chr(195) . chr(141) => 'I',
        chr(195) . chr(142) => 'I',
        chr(195) . chr(143) => 'I',
        chr(195) . chr(144) => 'D',
        chr(195) . chr(145) => 'N',
        chr(195) . chr(146) => 'O',
        chr(195) . chr(147) => 'O',
        chr(195) . chr(148) => 'O',
        chr(195) . chr(149) => 'O',
        chr(195) . chr(150) => 'O',
        chr(195) . chr(153) => 'U',
        chr(195) . chr(154) => 'U',
        chr(195) . chr(155) => 'U',
        chr(195) . chr(156) => 'U',
        chr(195) . chr(157) => 'Y',
        chr(195) . chr(158) => 'TH',
        chr(195) . chr(159) => 's',
        chr(195) . chr(160) => 'a',
        chr(195) . chr(161) => 'a',
        chr(195) . chr(162) => 'a',
        chr(195) . chr(163) => 'a',
        chr(195) . chr(164) => 'a',
        chr(195) . chr(165) => 'a',
        chr(195) . chr(166) => 'ae',
        chr(195) . chr(167) => 'c',
        chr(195) . chr(168) => 'e',
        chr(195) . chr(169) => 'e',
        chr(195) . chr(170) => 'e',
        chr(195) . chr(171) => 'e',
        chr(195) . chr(172) => 'i',
        chr(195) . chr(173) => 'i',
        chr(195) . chr(174) => 'i',
        chr(195) . chr(175) => 'i',
        chr(195) . chr(176) => 'd',
        chr(195) . chr(177) => 'n',
        chr(195) . chr(178) => 'o',
        chr(195) . chr(179) => 'o',
        chr(195) . chr(180) => 'o',
        chr(195) . chr(181) => 'o',
        chr(195) . chr(182) => 'o',
        chr(195) . chr(184) => 'o',
        chr(195) . chr(185) => 'u',
        chr(195) . chr(186) => 'u',
        chr(195) . chr(187) => 'u',
        chr(195) . chr(188) => 'u',
        chr(195) . chr(189) => 'y',
        chr(195) . chr(190) => 'th',
        chr(195) . chr(191) => 'y',
        chr(195) . chr(152) => 'O',
        
        // Decompositions for Latin Extended-A
        chr(196) . chr(128) => 'A',
        chr(196) . chr(129) => 'a',
        chr(196) . chr(130) => 'A',
        chr(196) . chr(131) => 'a',
        chr(196) . chr(132) => 'A',
        chr(196) . chr(133) => 'a',
        chr(196) . chr(134) => 'C',
        chr(196) . chr(135) => 'c',
        chr(196) . chr(136) => 'C',
        chr(196) . chr(137) => 'c',
        chr(196) . chr(138) => 'C',
        chr(196) . chr(139) => 'c',
        chr(196) . chr(140) => 'C',
        chr(196) . chr(141) => 'c',
        chr(196) . chr(142) => 'D',
        chr(196) . chr(143) => 'd',
        chr(196) . chr(144) => 'D',
        chr(196) . chr(145) => 'd',
        chr(196) . chr(146) => 'E',
        chr(196) . chr(147) => 'e',
        chr(196) . chr(148) => 'E',
        chr(196) . chr(149) => 'e',
        chr(196) . chr(150) => 'E',
        chr(196) . chr(151) => 'e',
        chr(196) . chr(152) => 'E',
        chr(196) . chr(153) => 'e',
        chr(196) . chr(154) => 'E',
        chr(196) . chr(155) => 'e',
        chr(196) . chr(156) => 'G',
        chr(196) . chr(157) => 'g',
        chr(196) . chr(158) => 'G',
        chr(196) . chr(159) => 'g',
        chr(196) . chr(160) => 'G',
        chr(196) . chr(161) => 'g',
        chr(196) . chr(162) => 'G',
        chr(196) . chr(163) => 'g',
        chr(196) . chr(164) => 'H',
        chr(196) . chr(165) => 'h',
        chr(196) . chr(166) => 'H',
        chr(196) . chr(167) => 'h',
        chr(196) . chr(168) => 'I',
        chr(196) . chr(169) => 'i',
        chr(196) . chr(170) => 'I',
        chr(196) . chr(171) => 'i',
        chr(196) . chr(172) => 'I',
        chr(196) . chr(173) => 'i',
        chr(196) . chr(174) => 'I',
        chr(196) . chr(175) => 'i',
        chr(196) . chr(176) => 'I',
        chr(196) . chr(177) => 'i',
        chr(196) . chr(178) => 'IJ',
        chr(196) . chr(179) => 'ij',
        chr(196) . chr(180) => 'J',
        chr(196) . chr(181) => 'j',
        chr(196) . chr(182) => 'K',
        chr(196) . chr(183) => 'k',
        chr(196) . chr(184) => 'k',
        chr(196) . chr(185) => 'L',
        chr(196) . chr(186) => 'l',
        chr(196) . chr(187) => 'L',
        chr(196) . chr(188) => 'l',
        chr(196) . chr(189) => 'L',
        chr(196) . chr(190) => 'l',
        chr(196) . chr(191) => 'L',
        chr(197) . chr(128) => 'l',
        chr(197) . chr(129) => 'L',
        chr(197) . chr(130) => 'l',
        chr(197) . chr(131) => 'N',
        chr(197) . chr(132) => 'n',
        chr(197) . chr(133) => 'N',
        chr(197) . chr(134) => 'n',
        chr(197) . chr(135) => 'N',
        chr(197) . chr(136) => 'n',
        chr(197) . chr(137) => 'N',
        chr(197) . chr(138) => 'n',
        chr(197) . chr(139) => 'N',
        chr(197) . chr(140) => 'O',
        chr(197) . chr(141) => 'o',
        chr(197) . chr(142) => 'O',
        chr(197) . chr(143) => 'o',
        chr(197) . chr(144) => 'O',
        chr(197) . chr(145) => 'o',
        chr(197) . chr(146) => 'OE',
        chr(197) . chr(147) => 'oe',
        chr(197) . chr(148) => 'R',
        chr(197) . chr(149) => 'r',
        chr(197) . chr(150) => 'R',
        chr(197) . chr(151) => 'r',
        chr(197) . chr(152) => 'R',
        chr(197) . chr(153) => 'r',
        chr(197) . chr(154) => 'S',
        chr(197) . chr(155) => 's',
        chr(197) . chr(156) => 'S',
        chr(197) . chr(157) => 's',
        chr(197) . chr(158) => 'S',
        chr(197) . chr(159) => 's',
        chr(197) . chr(160) => 'S',
        chr(197) . chr(161) => 's',
        chr(197) . chr(162) => 'T',
        chr(197) . chr(163) => 't',
        chr(197) . chr(164) => 'T',
        chr(197) . chr(165) => 't',
        chr(197) . chr(166) => 'T',
        chr(197) . chr(167) => 't',
        chr(197) . chr(168) => 'U',
        chr(197) . chr(169) => 'u',
        chr(197) . chr(170) => 'U',
        chr(197) . chr(171) => 'u',
        chr(197) . chr(172) => 'U',
        chr(197) . chr(173) => 'u',
        chr(197) . chr(174) => 'U',
        chr(197) . chr(175) => 'u',
        chr(197) . chr(176) => 'U',
        chr(197) . chr(177) => 'u',
        chr(197) . chr(178) => 'U',
        chr(197) . chr(179) => 'u',
        chr(197) . chr(180) => 'W',
        chr(197) . chr(181) => 'w',
        chr(197) . chr(182) => 'Y',
        chr(197) . chr(183) => 'y',
        chr(197) . chr(184) => 'Y',
        chr(197) . chr(185) => 'Z',
        chr(197) . chr(186) => 'z',
        chr(197) . chr(187) => 'Z',
        chr(197) . chr(188) => 'z',
        chr(197) . chr(189) => 'Z',
        chr(197) . chr(190) => 'z',
        chr(197) . chr(191) => 's',
        
        // Decompositions for Latin Extended-B
        chr(200) . chr(152) => 'S',
        chr(200) . chr(153) => 's',
        chr(200) . chr(154) => 'T',
        chr(200) . chr(155) => 't',
        
        // Euro Sign
        chr(226) . chr(130) . chr(172) => 'E',
        // GBP (Pound) Sign
        chr(194) . chr(163) => ''
      );
      
      $str = strtr($str, $chars);
    } else {
      // Assume ISO-8859-1 if not UTF-8
      $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158) . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194) . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202) . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210) . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218) . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227) . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235) . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243) . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251) . chr(252) . chr(253) . chr(255);
      
      $chars['out'] = 'EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy';
      
      $str = strtr($str, $chars['in'], $chars['out']);
      
      $double_chars['in'] = array(
        chr(140),
        chr(156),
        chr(198),
        chr(208),
        chr(222),
        chr(223),
        chr(230),
        chr(240),
        chr(254)
      );
      
      $double_chars['out'] = array(
        'OE',
        'oe',
        'AE',
        'DH',
        'TH',
        'ss',
        'ae',
        'dh',
        'th'
      );
      
      $str = str_replace($double_chars['in'], $double_chars['out'], $str);
    }
    
    return $str;
  }
  
  // Bolt - http://bolt.cm
  public static function seemsUtf8($str) {
    if (function_exists('mb_check_encoding')) {
      // If mbstring is available, this is significantly faster than
      // using PHP regexps.
      return mb_check_encoding($str, 'UTF-8');
    }
    
    $regex = '/(
      | [\xF8-\xFF] # Invalid UTF-8 Bytes
      | [\xC0-\xDF](?![\x80-\xBF]) # Invalid UTF-8 Sequence Start
      | [\xE0-\xEF](?![\x80-\xBF]{2}) # Invalid UTF-8 Sequence Start
      | [\xF0-\xF7](?![\x80-\xBF]{3}) # Invalid UTF-8 Sequence Start
      | (?<=[\x0-\x7F\xF8-\xFF])[\x80-\xBF] # Invalid UTF-8 Sequence Middle
      | (?<![\xC0-\xDF]|[\xE0-\xEF]|[\xE0-\xEF][\x80-\xBF]|[\xF0-\xF7]|[\xF0-\xF7][\x80-\xBF]|[\xF0-\xF7][\x80-\xBF]{2})[\x80-\xBF] # Overlong Sequence
      | (?<=[\xE0-\xEF])[\x80-\xBF](?![\x80-\xBF]) # Short 3 byte sequence
      | (?<=[\xF0-\xF7])[\x80-\xBF](?![\x80-\xBF]{2}) # Short 4 byte sequence
      | (?<=[\xF0-\xF7][\x80-\xBF])[\x80-\xBF](?![\x80-\xBF]) # Short 4 byte sequence (2)
      )/x';
    
    return !preg_match($regex, $str);
  }
  
  // Bolt - http://bolt.cm
  public static function forceDownload($filename, $content = false) {
    if (!headers_sent()) {
      // Required for some browsers
      if (ini_get('zlib.output_compression')) {
        @ini_set('zlib.output_compression', 'Off');
      }
      
      header('Pragma: public');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      
      // Required for certain browsers
      header('Cache-Control: private', false);
      
      header('Content-Disposition: attachment; filename="' . basename(str_replace('"', '', $filename)) . '";');
      header('Content-Type: application/force-download');
      header('Content-Transfer-Encoding: binary');
      
      if ($content) {
        header('Content-Length: ' . strlen($content));
      }
      
      ob_clean();
      flush();
      
      if ($content) {
        echo $content;
      }
      
      return true;
    } else {
      return false;
    }
  }
  
  // Bolt - http://bolt.cm
  public static function randomString($length, $human_friendly = true, $include_symbols = false, $no_duplicate_chars = false) {
    $nice_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefhjkmnprstuvwxyz23456789';
    $all_an     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $symbols    = '!@#$%^&*()~_-=+{}[]|:;<>,.?/"\'\\`';
    $str        = '';
    
    // Determines the pool of available characters based on the given parameters
    if ($human_friendly) {
      $pool = $nice_chars;
    } else {
      $pool = $all_an;
      
      if ($include_symbols) {
        $pool .= $symbols;
      }
    }
    
    // Don't allow duplicate letters to be disabled if the length is longer than the available characters
    if ($no_duplicate_chars and strlen($pool) < $length) {
      throw new LengthException('$length exceeds the size of the pool and $no_duplicate_chars is enabled');
    }
    
    // Converts the pool of characters into an array of characters and shuffle the array
    $pool = str_split($pool);
    shuffle($pool);
    
    // Generates the string
    for ($i = 0; $i < $length; $i++) {
      if ($no_duplicate_chars) {
        $str .= array_shift($pool);
      } else {
        $str .= $pool[0];
        shuffle($pool);
      }
    }
    
    return $str;
  }
  
  public static function getGravatar($email, $size = 32) {
    return 'http://www.gravatar.com/avatar/' . md5($email) . '?s=' . self::absint($size);
  }
  
  // Bolt - http://bolt.cm
  public static function absint($maybeint) {
    return abs(intval($maybeint));
  }
  
  // Bolt - http://bolt.cm
  function emailIsValidAlt($email) {
    if (!empty($email) or is_string($email)) {
      $mail_array = explode('@', $email);
    }
    
    if (!is_array($mail_array)) {
      return false;
    }
    
    if (count($mail_array) == 2) {
      $localpart    = $mail_array[0];
      $domain_array = explode('.', $mail_array[1]);
    } else {
      return false;
    }
    
    if (!is_array($domain_array)) {
      return false;
    }
    
    if (count($domain_array) == 1) {
      return false;
    }
    
    $domain_toplevel = array_pop($domain_array);
    
    if (is_string($domain_toplevel) and (strlen($domain_toplevel) > 1)) {
      $domain_array[] = $domain_toplevel;
      $domain         = implode('', $domain_array);
      $domain         = preg_replace('/[a-z0-9]/i', '', $domain);
      $domain         = preg_replace('/[-|\_]/', '', $domain);
      $localpart      = preg_replace('/[a-z0-9]/i', '', $localpart);
      $localpart      = preg_replace('#[-.|\!|\#|\$|\%|\&|\'|\*|\+|\/|\=|\? |\^|\_|\`|\{|\or\}|\~]#', '', $localpart);
      
      // If there are no characters left in localpart or domain, the email address is valid
      if (empty($domain) and empty($localpart)) {
        return true;
      }
    }
    
    return false;
  }
  
  public static function blockAccess() {
    if (!in_array(@$_SERVER['REMOTE_ADDR'], array(
      '127.0.0.1',
      '109.24.159.180',
      '46.246.34.235',
      '::1'
    ))) {
      header('HTTP/1.0 403 Forbidden');
      die('<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Unauthorized access</title></head><body><h1>Unauthorized access</h1><p>You can\'t see this page.</p></body></html>');
    }
  }
  
  // Bolt - http://bolt.cm
  public static function var_dump($var, $return = false) {
    $html = '<pre style="margin: 0 0 10px;' . 'background: #373b41;' . 'padding: 9.5px;' . 'border: 1px solid #1d1f21;' . 'border-radius: 4px;' . 'display: block;' . 'font-size: 13px;' . 'white-space: pre-wrap;' . 'word-wrap: break-word;' . 'word-break: break-all;' . 'color: #c5c8c6;' . 'text-align: left;' . 'line-height: 1.42857143;' . 'page-break-inside: avoid;' . 'max-height: 340px;' . 'overflow-y: scroll;' . 'font-family: Menlo, Monaco, Consolas, "Courier New", monospace;">';
    $html .= self::var_dump_plain($var, true);
    $html .= '</pre>';
    
    if (!$return) {
      echo $html;
    } else {
      return $html;
    }
  }
  
  // Bolt - http://bolt.cm
  public static function var_dump_plain($var, $traversedeeper = false) {
    $html = '';
    
    if (is_bool($var)) {
      $html .= '<span style="color:#81a2be;">boo</span><span style="color:#c5c8c6;">(</span><span style="color: #cc6666;">' . (($var) ? 'true' : 'false') . '</span><span style="color:#c5c8c6;">)</span>';
    } else if (is_int($var)) {
      $html .= '<span style="color:#81a2be;">int</span><span style="color:#c5c8c6;">(</span><span style="color: #cc6666;">' . $var . '</span><span style="color:#c5c8c6;">)</span>';
    } else if (is_float($var)) {
      $html .= '<span style="color:#81a2be;">flo</span><span style="color:#c5c8c6;">(</span><span style="color: #cc6666;">' . $var . '</span><span style="color:#c5c8c6;">)</span>';
    } else if (is_string($var)) {
      $html .= '<span style="color:#81a2be;">str</span><span style="color:#c5c8c6;">(</span><span style="color: #cc6666;">' . strlen($var) . '</span><span style="color:#c5c8c6;">)</span>"<span style="color: #df9f4f;">' . self::htmlentities($var) . '</span>"';
    } else if (is_null($var)) {
      $html .= 'NULL';
    } else if (is_resource($var)) {
      $html .= '<span style="color:#81a2be;">res</span>("' . get_resource_type($var) . '") "' . $var;
    } else if (is_array($var)) {
      $uuid = uniqid('include-php-', true);
      
      $html .= '<span style="color:#81a2be;">arr</span>(<span style="color: #cc6666;">' . count($var) . '</span>)';
      
      if (!empty($var)) {
        $html .= ' <img id="' . $uuid . '" data-collapse="data:image/png;base64,' . self::$icon_collapse . '" style="position:relative;cursor:pointer;width:16px!important;height:16px!important;" src="data:image/png;base64,' . self::$icon_expand . '"> <span id="' . $uuid . '-collapsable" style="display: none;">[<br>';
        
        $indent      = 2;
        $longest_key = 0;
        
        foreach ($var as $key => $value) {
          if (is_string($key)) {
            $longest_key = max($longest_key, strlen($key) + 2);
          } else {
            $longest_key = max($longest_key, strlen($key));
          }
        }
        
        foreach ($var as $key => $value) {
          if (is_numeric($key)) {
            $html .= str_repeat(' ', $indent) . str_pad($key, $longest_key, '_');
          } else {
            $html .= str_repeat(' ', $indent) . str_pad('"<span style="color: #8abeb7;">' . self::htmlentities($key) . '</span>"', $longest_key, ' ');
          }
          
          $html .= ' => ';
          
          $value = explode('<br>', self::var_dump_plain($value));
          
          foreach ($value as $line => $val) {
            if ($line != 0) {
              $value[$line] = str_repeat(' ', $indent * 2) . $val;
            }
          }
          
          $html .= implode('<br>', $value) . '<br>';
        }
        
        $html .= ']</span>';
        
        $html .= preg_replace('/ +/', ' ', '<script type="text/javascript">(function() {
          var img = document.getElementById("' . $uuid . '");
          img.onclick = function() {
            if ( document.getElementById("' . $uuid . '-collapsable").style.display == "none" ) {
              document.getElementById("' . $uuid . '-collapsable").style.display = "inline";
              img.setAttribute( "data-expand", img.getAttribute("src") );
              img.src = img.getAttribute("data-collapse");
              var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;
            } else {
              document.getElementById("' . $uuid . '-collapsable").style.display = "none";
              img.src = img.getAttribute("data-expand");
              var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;
            }
          };
        })();
        </script>');
      }
      
    } else if (is_object($var)) {
      $uuid = uniqid('include-php-', true);
      
      $html .= '<span style="color:#81a2be;">object</span>(' . get_class($var) . ') <img id="' . $uuid . '" data-collapse="data:image/png;base64,' . self::$icon_collapse . '" style="position:relative;vertical-align:middle;cursor:pointer;width:16px!important;height:16px!important;" src="data:image/png;base64,' . self::$icon_expand . '"> <span id="' . $uuid . '-collapsable" style="display: none;">[<br>';
      
      $original = $var;
      $var      = (array) $var;
      
      $indent      = 2;
      $longest_key = 0;
      
      foreach ($var as $key => $value) {
        if (substr($key, 0, 2) == "\0*") {
          unset($var[$key]);
          $key       = 'protected:' . substr($key, 2);
          $var[$key] = $value;
        } else if (substr($key, 0, 1) == "\0") {
          unset($var[$key]);
          $key       = 'private:' . substr($key, 1, strpos(substr($key, 1), "\0")) . ':' . substr($key, strpos(substr($key, 1), "\0") + 1);
          $var[$key] = $value;
        }
        
        if (is_string($key)) {
          $longest_key = max($longest_key, strlen($key) + 2);
        } else {
          $longest_key = max($longest_key, strlen($key));
        }
      }
      
      foreach ($var as $key => $value) {
        if (is_numeric($key)) {
          $html .= str_repeat(' ', $indent) . str_pad($key, $longest_key, ' ');
        } else {
          $html .= str_repeat(' ', $indent) . str_pad('"<span style="color: #8abeb7;">' . self::htmlentities($key) . '</span>"', $longest_key, ' ');
        }
        
        $html .= ' => ';
        
        $value = explode('<br>', self::var_dump_plain($value));
        
        foreach ($value as $line => $val) {
          if ($line != 0) {
            $value[$line] = str_repeat(' ', $indent * 2) . $val;
          }
        }
        
        $html .= implode('<br>', $value) . '<br>';
      }
      
      $html .= ']</span>';
      
      $html .= preg_replace('/ +/', ' ', '<script type="text/javascript">(function() {
        var img = document.getElementById("' . $uuid . '");
        img.onclick = function() {
          if ( document.getElementById("' . $uuid . '-collapsable").style.display == "none" ) {
            document.getElementById("' . $uuid . '-collapsable").style.display = "inline";
            img.setAttribute( "data-expand", img.getAttribute("src") );
            img.src = img.getAttribute("data-collapse");
            var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;
          } else {
            document.getElementById("' . $uuid . '-collapsable").style.display = "none";
            img.src = img.getAttribute("data-expand");
            var previousSibling = document.getElementById("' . $uuid . '-collapsable").previousSibling;
          }
        };
      })();
      </script>');
    }
    
    return $html;
  }
  
  public static function isHttps() {
    return isset($_SERVER['HTTPS']) and !empty($_SERVER['HTTPS']) and $_SERVER['HTTPS'] != 'off';
  }
  
  function checkVersion($currentversion, $requiredversion) {
    return version_compare($currentversion, $requiredversion) > -1;
  }
  
  public static function generateUniqueId() {
    $data = $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['LOCAL_ADDR'];
    $data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = sha1($data);
  }
  
  // Bolt - http://bolt.cm
  function generateToken() {
    $seed  = $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] . $_SESSION['Minicraft'];
    $token = substr(md5($seed), 0, 8);
    
    return $token;
  }
  
  // Bolt - http://bolt.cm
  function checkToken($token = '') {
    return $token === generateToken();
  }
  
  //Bolt
  function stripTrailingSlash($path) {
    if (substr($path, -1, 1) == '/') {
      $path = substr($path, 0, -1);
    }
    
    return $path;
  }
  
  // Bolt - http://bolt.cm
  function getExtension($filename) {
    $pos = strrpos($filename, '.');
    if ($pos === false) {
      return '';
    } else {
      $ext = substr($filename, $pos + 1);
      
      return $ext;
    }
  }
  
  // Bolt - http://bolt.cm
  function isHtml($html) {
    $len = strlen($html);
    
    $trimlen = strlen(strip_tags($html));
    
    $factor = $trimlen / $len;
    
    if ($factor < 0.97) {
      return true;
    } else {
      return false;
    }
    
  }
  
  // http://stackoverflow.com/a/2606638
  function strReplaceFirst($search, $replace, $subject) {
    $pos = strpos($subject, $search);
    if ($pos !== false) {
      $subject = substr_replace($subject, $replace, $pos, strlen($search));
    }
    return $subject;
  }
  
  // Bolt - http://bolt.cm
  public static function createDirectory($path) {
    if (file_exists($path)) {
      return true;
    }
    
    if (dirname($path) != '.') {
      $success = makeDir(dirname($path));
      if (!$success) {
        return false;
      }
    }
    
    $mode_dec = octdec('0777');
    $oldumask = umask(0);
    $success  = @mkdir($path, $mode_dec);
    @chmod($name, $mode_dec);
    umask($oldumask);
    
    return $success;
  }
  
  public static function throw404($twig, $config, $user) {
    header('HTTP/1.0 404 Not Found');
    die($twig->render('misc/404.twig', array(
      'pageTitle' => '404',
      'config' => $config,
      'user' => $user,
      'flash' => new Flash
    )));
  }
  
  public static function redirect($router, $page, $args = array()) {
    $url = $router->getController($page)->getUrl();
    
    if (!empty($args)) {
      for ($i = 0; $i < count($args); $i++) {
        $url = preg_replace('#%m' . ($i + 1) . '%#', $args[$i], $url);
      }
    }
    
    header('Location: ' . URL . '/' . $url);
    die();
  }
}