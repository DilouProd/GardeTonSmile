<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    private $urlGenerator;

    public function __construct(FlashBagInterface $flashBag ,UrlGeneratorInterface $urlGenerator){

        $this->flashBag = $flashBag;
        $this->urlGenerator = $urlGenerator;
    }

    public function onLogoutEvent(LogoutEvent $event)
    {
        $this->flashBag->add(
            'success',
            'Vous êtes maintenant déconnecter !'
        );

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_home')));
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
