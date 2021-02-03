<?php

namespace App\Subscriber;

use App\Entity\ClientOrder;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class OrderSubscriber implements EventSubscriber
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        /** @var ClientOrder $order */
        $order = $args->getObject();

        if (!$order instanceof ClientOrder) {
            return;
        }

        $order
            ->setTime(new \DateTime())
            ->setState("Prise")
            ->setUser($this->security->getUser());

        $amount = $this->totalPrice($order);
        $order->setPrixTotal($amount);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        /** @var ClientOrder $order */
        $order = $args->getObject();

        if (!$order instanceof ClientOrder) {
            return;
        }

        $amount = $this->totalPrice($order);
        $order->setPrixTotal($amount);
    }

    private function totalPrice(ClientOrder $order): float
    {
        $amount = 0;
        foreach ($order->getDish() as $dish) {
            $amount += $dish->getPrice();
        }

        return $amount;
    }
}