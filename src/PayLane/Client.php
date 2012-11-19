<?php

namespace PayLane;

use \SoapClient, \SoapFault;

require_once 'PayLaneClient.php';

class Client extends \PayLaneClient
{
	const WSDL = 'https://direct.paylane.com/wsdl/production/Direct.wsdl';

	/**
	 * @var SoapClient
	 */
	protected $soapclient;

	/**
	 * @var SoapFault
	 */
	protected $fault;
	protected $error;


	/**
	 * @param string $login
	 * @param string $password
	 * @param string $wsdl (optional)
	 *
	 * @throws SoapFault
	 */
	public function __construct($login, $password, $wsdl = null)
	{
		$this->login = $login;
		$this->password = $password;
		if (null === $wsdl)
		{
			$wsdl = self::WSDL;
		}

		$this->soapclient = new SoapClient($wsdl, array("login" => $login, "password" => $password));
	}

	/**
	 * @deprecated
	 *
	 * @return bool
	 */
	public function init()
	{
		return true;
	}
	protected function handleFault($fault)
	{
		$this->fault = $fault;
		$this->error = "SOAPFault: " . $fault->faultcode . " - " . $fault->faultstring;
	}

	/**
	 * @return \SoapFault
	 */
	public function getLastFault()
	{
		return $this->fault;
	}

}
