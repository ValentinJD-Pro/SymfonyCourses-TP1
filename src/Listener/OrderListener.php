<?php


namespace App\Listener;


use App\Entity\ClientOrder;
use App\Event\OrderPayedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class OrderListener
{
    private $dispatcher;
    private $mailer;

    public function __construct(MailerInterface $mailer, EventDispatcherInterface $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }

    public function postPersist(ClientOrder $order): void
    {
        $email = (new Email())
            ->from('admin@restau.fr')
            ->to('cuisines@restau.fr')
            ->subject(sprintf('Prise de commande n°%d', $order->getId()))
            ->text('Commande prise !');

        $this->mailer->send($email);
    }

    public function postUpdate(ClientOrder $order): void
    {
        $email = (new Email())
            ->from('admin@restau.fr');

        switch ($order->getState()) {
            case "Préparée":
                $email->to('serveur@restau.fr')
                    ->subject(sprintf('Préparation de commande n°%d', $order->getId()))
                    ->text('Commande prête !');
                $this->mailer->send($email);
                break;
            case "Servie":
                $email->to('accueil@restau.fr')
                    ->subject(sprintf('Service commande n°%d', $order->getId()))
                    ->text('Commande servie !');
                $this->mailer->send($email);
                break;
            case "Payée":
                $event = new OrderPayedEvent($order);
                $this->dispatcher->dispatch($event, OrderPayedEvent::NAME);

                $email->to('serveur@restau.fr')
                    ->subject(sprintf('Paiement commande n°%d', $order->getId()))
                    ->text('Commande payée !');
                $this->mailer->send($email);
                break;
        }
    }
}