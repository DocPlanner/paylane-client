<?php

namespace PayLane;

use \SoapClient, \SoapFault;

class Client
{
	const WSDL = 'https://direct.paylane.com/wsdl/production/Direct.wsdl';

	/**
	 * @var SoapClient
	 */
	protected $soapClient;


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

		$this->soapClient = new SoapClient($wsdl, array("login" => $login, "password" => $password));
	}

	/**
	 * Performs sale
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function multiSale($params)
	{
		return $this->soapClient->multiSale($params);
	}

	/**
	 * Performs refund
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function refund($params)
	{
		return $this->soapClient->refund($params['id_sale'], $params['amount'], $params['reason']);
	}

	/**
	 * Performs resale
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function resale($params)
	{
		$byAuthorization = false;
		if (isset ($params['resale_by_authorization']))
		{
			$byAuthorization = (bool) $params['resale_by_authorization'];
		}
		return $this->soapClient->resale($params['id_sale'], $params['amount'], $params['currency'], $params['description'], null, null, $byAuthorization);
	}

	/**
	 * Performs sale capture
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function captureSale($params)
	{
		return $this->soapClient->captureSale($params['id_sale_authorization'], $params['amount'], $params['description']);
	}

	/**
	 * Performs sale authorization closing
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function closeSaleAuthorization($params)
	{
		return $this->soapClient->closeSaleAuthorization($params['id_sale_authorization']);
	}

	/**
	 * Checks if card participates in 3D Secure
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function checkCard3DSecureEnrollment($params)
	{
		return $this->soapClient->checkCard3DSecureEnrollment($params);
	}

	/**
	 * Checks status of multiple sales
	 *
	 * @param array $params
	 * @return Object
	 * @throws SoapFault
	 */
	public function checkSales($params)
	{
		return $this->soapClient->checkSales(array("id_sale_list" => $params));
	}
}
