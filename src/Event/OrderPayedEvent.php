<?php

namespace App\Event;

use App\Entity\ClientOrder;
use Symfony\Contracts\EventDispatcher\Event;

class OrderPayedEvent extends Event
{
    public const NAME = 'order.payed';

    protected $clientOrder;

    public function __construct(ClientOrder $clientOrder)
    {
        $this->clientOrder = $clientOrder;
    }

    public function getClientOrder(): ClientOrder
    {
        return $this->clientOrder;
    }
}