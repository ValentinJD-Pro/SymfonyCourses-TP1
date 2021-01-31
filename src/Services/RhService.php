<?php

namespace App\Services;

use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RhService
{
    private $client;
    private $logger;
    private $rhServiceUrl;

    public function __construct(HttpClientInterface $client, UserRepository $userRepository, LoggerInterface $logger, string $rhServiceUrl)
    {
        $this->client = $client;
        $this->userRepository = $userRepository;
        $this->logger = $logger;
        $this->rhServiceUrl = $rhServiceUrl;
    }

    public function getPeople()
    {
        return json_decode(
            $this->client
                ->request('GET', $this->rhServiceUrl . '?method=people')
                ->getContent(),
            true
        );
    }

    public function getDayTeam()
    {
        return json_decode(
            $this->client
                ->request('GET', $this->rhServiceUrl . '?method=planning')
                ->getContent(),
            true
        );
    }
}