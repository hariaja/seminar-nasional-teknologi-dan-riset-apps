<?php

namespace App\Services\Client;

use App\Http\Requests\Users\ClientRequest;
use LaravelEasyRepository\Service;
use App\Repositories\Client\ClientRepository;

class ClientServiceImplement extends Service implements ClientService
{

  /**
   * don't change $this->mainRepository variable name
   * because used in extends service class
   */
  protected $mainRepository;

  public function __construct(ClientRepository $mainRepository)
  {
    $this->mainRepository = $mainRepository;
  }

  public function handleCreateClient($request)
  {
    // 
  }
}
