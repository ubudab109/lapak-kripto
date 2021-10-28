<?php
namespace App\Services;
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;

class CoinbaseService {

  private $apiKey, $apiSecret;

  public function __construct()
  {
    $this->apiKey = 'bU3xO0H5IhRrtsE4';
    $this->apiSecret = '2SNFrTVVhjf6dKSbYhXpN0zdx3DsS8TZ'; 
  }

  public function Client()
  {
    $configuration = Configuration::apiKey($this->apiKey, $this->apiSecret);
    $client = Client::create($configuration); 

    return $client;
  }

  public function GetCurrencies()
  {
    return $this->Client()->getCurrencies();
  }

  public function GetListAccounts()
  {
    return $this->Client()->getAccounts();
  }

  public function GetAuthorization()
  {
    return $this->Client()->getPrimaryAccount();
  }
}