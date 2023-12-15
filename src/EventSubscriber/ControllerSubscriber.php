<?php

namespace App\EventSubscriber;

use App\Entity\Invitation;
use DateTimeImmutable;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Uid\Uuid;

class ControllerSubscriber implements EventSubscriberInterface
{
    public function setUuid(BeforeEntityPersistedEvent $event): void
    {
        $invitaion = $event->getEntityInstance();
        if ($invitaion instanceof Invitation) {
            $invitaion->setUuid(Uuid::v4());
            $invitaion->setCreatedAt(new DateTimeImmutable());
        }
        return;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => 'setUuid'
        ];
    }
}
