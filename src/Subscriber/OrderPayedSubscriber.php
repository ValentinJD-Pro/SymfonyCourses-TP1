<?php

namespace App\Subscriber;

use App\Event\OrderPayedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class OrderPayedSubscriber implements EventSubscriberInterface
{
    private $rhServiceUrl;

    public function __construct(string $rhServiceUrl)
    {
        $this->rhServiceUrl = $rhServiceUrl;
    }

    public static function getSubscribedEvents()
    {
        return [
            OrderPayedEvent::NAME => 'setOrderPayed'
        ];
    }

    public function setOrderPayed(OrderPayedEvent $event) {
        $order = $event->getClientOrder();

        $url = $this->rhServiceUrl .
            '?method=order&order='.$order->getId().
            '&amount'.$order->getPrixTotal().
            '&server='.$order->getUser()->getUsername();

        return json_decode(file_get_contents($url));
    }
}