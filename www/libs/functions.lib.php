<?php

function build_breadcrumb($trail)
{
  global $CFG;
  $breadcrumb[] = make_link('/', 'Home');
  foreach($trail AS $link => $name)
  {
    if(++$i < count($trail))
      $breadcrumb[] = make_link($link, $name);
    else
      $breadcrumb[] = '<strong>'.$name.'</strong>';
  }
  return implode(' / ', $breadcrumb);
}

function fatal_error($message)
{
  echo $message;
  exit();
}

function print_money($amount)
{
  if(!is_numeric($amount))
    return $amount;
  return '&euro; <span class="price">'.
    number_format($amount, 2, ',', '.').'</span>';
}

function set_highlights($haystack, $needle)
{
  return eregi_replace("($needle)", "<strong class=\"highlight\">\\1</strong>",
                      $haystack);
}

function generate_screenshot_filename($screenshot_id, $website = false)
{
 if(strpos($website,'http://')===false)
    $website='http://'.$website;

 $name = $screenshot_id.'_'.str_replace(array(':','/','&', '?'),'_',
         substr($website,7)).'.png';
 return $name;
}


function nl2p($text)
{
    
  // put all text into <p> tags
  $text = '<p>' . $text . '</p>';
  /* replace all newline characters with paragraph 
  ending and starting tags */
  $text = str_replace("\n",'</p><p>',$text);
  // remove any cariage return characters
  $text = str_replace("\r",'',$text);
  // remove empty paragraph tags
  $text = str_replace('<p></p>','',$text);
  /* optional replacement, if you need a nice-looking 
  HTML source and not all source in one line.*/
  $text = str_replace('</p><p>', "</p>\n       <p>", $text);
  
  /* Remove double <p>'s if source already included <p>'s */
  $text = preg_replace('/<p>([\s]+)?<p>/i', '<p>', $text);
  $text = preg_replace('/<\/p>([\s]+)?<\/p>/i', '</p>', $text);

  return $text;

}

function timer($start = false)
{
 $time = microtime();
 $time = explode(' ', $time);
 $time = $time[1] + $time[0];
 if (!$start) return $time;
 else {
   $total_time = round(($time - $start), 4);
   return $total_time;
 }
}

function meta_redirect($to, $sleep=0)
{
 echo "<meta http-equiv=\"Refersh\" content=\"$sleep; URL=$to\" /> ";
 echo "<script>window.setTimeout(\"self.location.href='$to'\",".
  ($sleep*1000).");</script>";
}

function delete_file($fullname)
{
 if(file_exists($fullname)) unlink($fullname);
}

function myaddslashes($str)
{
 return mysql_real_escape_string($str);
}

function make_link($url, $name='', $confirm='', $target='')
{
 if(empty($name))
  $name = $url;
 if(strlen($confirm)>0)
  $confirm=' onclick="return confirm(\''.$confirm.'\');"';
 if(strlen($target)>0)
  $target=' target='.$target;
 $ret='<a href="'.$url.'"'.$confirm.$target.'>'.$name.'</a>';
 return $ret;
}


function redirect($url, $status_code)
{
 switch($status_code) {
   case 404:  // not found
     $possible = array();
     if($i = find_provinces_by_slug_with_typo($_SERVER['REQUEST_URI']))
       $possible = $i;
     if($i = find_cities_by_slug_with_typo($_SERVER['REQUEST_URI']))
       $possible = array_merge($possible, $i);
     if($i = find_companies_by_slug_with_typo($_SERVER['REQUEST_URI']))
       $possible = array_merge($possible, $i);
    
     Header('HTTP/1.1 404 Not Found');
     include('_tpl/404.tpl.php');
     break;

   case 301:  // permanently moved
     Header("Location: $url", TRUE, 301);
     break;
  
   case 410:  // not avail. anymore
     Header('HTTP/1.0 410 Gone');
     include('_tpl/410.tpl.php');
     break;
 }
 exit();
}

function h3($str)
{
 # maakt een h3 om een string
 echo "<h3>$str</h3>\n";
}

function render_410_page()
{
 echo "<html>FOUT: 410 Gone</html>";
}

function echo_r($arr)
{
 // print een array, maar dan met PRE's
 echo "\n<PRE>\n";
 print_r($arr);
 echo "\n</PRE>\n";
} 

function human_readable($size)
{
 // print sizes in human readable format (e.g., 1K 234M 2G)
 $i=0;
 $iec = array("B", "KB", "<b>MB</b>", "<b><i>GB</i></b>", "TB", "PB", "EB", "ZB", "YB");
 while(($size/1024)>1)
 {
  $size=$size/1024;
  $i++;
 }
 # return substr($size,0,strpos($size,'.')+4).$iec[$i];
 # kleine verbetering, incl bold maken van MB
 if ($size / 1024 * 10 > 1) { 
   $i++; 
   $size /= 1024;
 }
 $ret = number_format($size, 2, ',','.').' '.$iec[$i];
 return $ret; 
}

function count_slashes($str)
{
  // telt het aantal slashes in een str (slug)
  $count = substr_count($str, "/");
  return $count;
}

function old_prep_rest_for_link($str)
{
 $r_url = str_replace("�", "e", $str);
 $r_url = str_replace("�", "E", $r_url);
 $r_url = str_replace("�", "E", $r_url);
 $r_url = str_replace("�", "e", $r_url);
 $r_url = str_replace("�", "e", $r_url);
 $r_url = str_replace("�", "e", $r_url);
 $r_url = str_replace("�", "a", $r_url);
 $r_url = str_replace("�", "a", $r_url);
 $r_url = str_replace("�", "a", $r_url);
 $r_url = str_replace("�", "a", $r_url);
 $r_url = str_replace("�", "a", $r_url);
 $r_url = str_replace("�", "A", $r_url);
 $r_url = str_replace("�", "A", $r_url);
 $r_url = str_replace("�", "C", $r_url);
 $r_url = str_replace("�", "c", $r_url);
 $r_url = str_replace("�", "o", $r_url);
 $r_url = str_replace("�", "o", $r_url);
 $r_url = str_replace("�", "o", $r_url);
 $r_url = str_replace("�", "O", $r_url);
 $r_url = str_replace("�", "O", $r_url);
 $r_url = str_replace("�", "o", $r_url);
 $r_url = str_replace("�", "i", $r_url);
 $r_url = str_replace("�", "I", $r_url);
 $r_url = str_replace("�", "i", $r_url);
 $r_url = str_replace("�", "i", $r_url);
 $r_url = str_replace("�", "U", $r_url);
 $r_url = str_replace("�", "u", $r_url);
 $r_url = str_replace("�", "u", $r_url);
 $r_url = str_replace("�", "u", $r_url);
 $r_url = str_replace("�", "n", $r_url);
 $r_url = str_replace(" ", "_", $r_url);
 $r_url = str_replace("&", "", $r_url);
 $r_url = str_replace("!", "", $r_url);
 return $r_url;
}

function old_prep_city_for_link($p)
{
 $city_url = str_replace("�", "e", $p);
 $city_url = str_replace("�", "e", $city_url);
 $city_url = str_replace("�", "e", $city_url);
 $city_url = str_replace("�", "e", $city_url);
 $city_url = str_replace("�", "a", $city_url);
 $city_url = str_replace("�", "a", $city_url);
 $city_url = str_replace("'", "", $city_url);
 $city_url = str_replace(" ", "-", $city_url);

 return $city_url;
}


function str2slug($str)
{
 // lower case
 // replace 1e char = ' met niks
 // replace spaces by dashes
 // replace slashes by dashes
 // alle andere speciale leestekens worden genormaliseerd
 // dubbele dashes ver-singelen
 // dan preg_replace: "/[^a-zA-Z0-9- ]/"

 if (substr($str,0,1) == "'") $str = substr($str,1);

// $str = unhtmlentities($str);

 $str = str_replace("�", "e", $str);
 $str = str_replace("�", "E", $str);
 $str = str_replace("�", "E", $str);
 $str = str_replace("�", "e", $str);
 $str = str_replace("�", "e", $str);
 $str = str_replace("�", "e", $str);
 $str = str_replace("�", "a", $str);
 $str = str_replace("�", "a", $str);
 $str = str_replace("�", "a", $str);
 $str = str_replace("�", "a", $str);
 $str = str_replace("�", "a", $str);
 $str = str_replace("�", "A", $str);
 $str = str_replace("�", "A", $str);
 $str = str_replace("�", "C", $str);
 $str = str_replace("�", "c", $str);
 $str = str_replace("�", "o", $str);
 $str = str_replace("�", "o", $str);
 $str = str_replace("�", "o", $str);
 $str = str_replace("�", "O", $str);
 $str = str_replace("�", "O", $str);
 $str = str_replace("�", "o", $str);
 $str = str_replace("�", "i", $str);
 $str = str_replace("�", "I", $str);
 $str = str_replace("�", "i", $str);
 $str = str_replace("�", "i", $str);
 $str = str_replace("�", "U", $str);
 $str = str_replace("�", "u", $str);
 $str = str_replace("�", "u", $str);
 $str = str_replace("�", "u", $str);
 $str = str_replace("�", "n", $str);
 $str = str_replace("  ", " ", $str);
 $str = str_replace(" '", "-", $str);
 $str = str_replace("'", "-", $str);
 $str = str_replace(" - ", "-", $str);

 // ending dash verwijderen
 if (substr($str, strlen($str)-1, 1) == "-")
    $str = substr($str, 0, strlen($str)-1);

 $str = preg_replace("/[^a-zA-Z0-9- ]/", "", $str);  // chop bad chars
 $str = str_replace(" ", "-", $str);                 // space to dashes
 $str = strtolower($str);                            // make it lowercase

 while (strpos($str, "--")) {
   $str = str_replace("--", "-", $str);
 }

 return $str;
}

function prep_rest_for_link($r)
{
$r_url = ereg_replace("è", "e", $r);
$r_url = ereg_replace("É", "E", $r_url);
$r_url = ereg_replace("È", "E", $r_url);
$r_url = ereg_replace("é", "e", $r_url);
$r_url = ereg_replace("ê", "e", $r_url);
$r_url = ereg_replace("ë", "e", $r_url);
$r_url = ereg_replace("â", "a", $r_url);
$r_url = ereg_replace("á", "a", $r_url);
$r_url = ereg_replace("ä", "a", $r_url);
$r_url = ereg_replace("à", "a", $r_url);
$r_url = ereg_replace("ã", "a", $r_url);
$r_url = ereg_replace("À", "A", $r_url);
$r_url = ereg_replace("Á", "A", $r_url);
$r_url = ereg_replace("Ç", "C", $r_url);
$r_url = ereg_replace("ç", "c", $r_url);
$r_url = ereg_replace("ó", "o", $r_url);
$r_url = ereg_replace("ö", "o", $r_url);
$r_url = ereg_replace("ô", "o", $r_url);
$r_url = ereg_replace("Ö", "O", $r_url);
$r_url = ereg_replace("Ó", "O", $r_url);
$r_url = ereg_replace("ø", "o", $r_url);
$r_url = ereg_replace("í", "i", $r_url);
$r_url = ereg_replace("Ï", "I", $r_url);
$r_url = ereg_replace("ï", "i", $r_url);
$r_url = ereg_replace("î", "i", $r_url);
$r_url = ereg_replace("Ü", "U", $r_url);
$r_url = ereg_replace("ü", "u", $r_url);
$r_url = ereg_replace("û", "u", $r_url);
$r_url = ereg_replace("ú", "u", $r_url);
$r_url = ereg_replace("ñ", "n", $r_url);
 
 $r_url = ereg_replace(" ", "_", $r_url);
 $r_url = ereg_replace("&", "", $r_url);
 $r_url = ereg_replace("@", "", $r_url);
 $r_url = ereg_replace("\.", "", $r_url);
 $r_url = ereg_replace(",", "", $r_url);
 $r_url = ereg_replace("\+", "", $r_url);
 $r_url = ereg_replace("�", "", $r_url);
 return $r_url;
}

function prep_city_for_link($p)
{

 // moet nieuw: eigenlijk alles strippen, behalve a-Z0-9 en spatie wordt -
 $city_url = ereg_replace("è", "e", $p);
 $city_url = ereg_replace("é", "e", $city_url);
 $city_url = ereg_replace("ê", "e", $city_url);
 $city_url = ereg_replace("ë", "e", $city_url);
 $city_url = ereg_replace("â", "a", $city_url);
 $city_url = ereg_replace("á", "a", $city_url);
 $city_url = ereg_replace(" ", "-", $city_url);
 $city_url = ereg_replace("'", "", $city_url);

 return $city_url;
}


function unhtmlentities($string)
{
 $string=html_entity_decode($string);
 // replace numeric entities
 $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);
 $string = preg_replace('~&#([0-9]+);~e', 'chr(\\1)', $string);
 return $string;
}

function write_file($fullname, &$data)
{
 $fi=fopen($fullname,'wb');
 if($fi)
 {
  fwrite($fi,$data);
  fclose($fi);
  return true;
 }
 return false;
}

function get_file_extension($filename)
{
 if(strpos($filename, '.') === false)
   return '';
 return substr(strrchr($filename, '.'), 1);
}

function chop_extension($filename)
{
  $ext = get_file_extension($filename);
	if($ext != $filename)
	  $filename = substr($filename, 0, strlen($filename) - strlen($ext) - 1);
	return $filename;
}

function make_code($length = 32)
{
 // generate random password
 $chars = "23456789abcdefghjmnpqrstuvwxyz";
 srand((double)microtime()*1000000);
 for ($a = 0; $a < $length; $a++) {
         $b = rand(0, strlen($chars) - 1);
         $rndstring .= substr($chars,$b,1);
 }
 return $rndstring;
}

function pluralize($count, $singular, $plural)
{
  // FIXME $plural zou optioneel kunnen zijn en zou je indien nodig kunnen
  // berekenen. leuk opdrachtje 
  if($count < 2)
    return $singular;
  return $plural;
}

function join_delimited($array, $delimiter, $end_delimiter = false)
{
  $res = '';
  for($i=0;$i<count($array);$i++)
  {
    if($i == 0)
      $res = $array[$i];
    elseif($i == count($array) -1 && $end_delimiter !== false)
      $res.=$end_delimiter.$array[$i];
    else
      $res.=$delimiter.$array[$i];
  }
  return $res;
}
?>
