<?php

require_once('../src/ReportGrid.php');
require_once('simpletest/autorun.php');


function skipgeneration()
{
	if(PHP_SAPI === 'cli')
	{
		global $argc;
		global $argv;
		for($i = 0; $i < $argc; $i++) {
			if($argv[$i] == '-skipgeneration')
				return true;
		}
		return false;
	} else
		return isset($_GET['skipgeneration']) && $_GET['skipgeneration'];
}

abstract class BaseTest extends UnitTestCase {
	static $id = 'A3BC1539-E8A9-4207-BB41-3036EC2C6E6D';
	public static function createApi()
	{
		$HOST  = "devapi.reportgrid.com";
		$PORT  = 80;
		$PATH  = "/services/analytics/v1/";
		$TOKEN = BaseTest::$id;

		$options = getopt("", array("host:", "port:", "path:", "token:"));

		foreach ($options as $option => $value) {
			switch($option) {
				case "host":
					$HOST = $value;
					break;
				case "port":
					$PORT = $value;
					break;
				case "path":
					$PATH = $value;
					break;
				case "token":
					$TOKEN = $value;
					break;
			}
		}

		$URL = "http://$HOST:$PORT$PATH";
		echo "Starting test against $URL\n";

		return new ReportGridAPI($TOKEN, $URL);
	}

	var $rg;
	function setUp()
	{
		$this->rg = BaseTest::createApi();
	}
}
