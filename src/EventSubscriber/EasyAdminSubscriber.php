<?php
namespace App\EventSubscriber;

use DateTimeImmutable;
use App\Entity\Activites;
use App\Entity\Excursions;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private  $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setActivitesSlugAndDate'],
        ];
    }

    public function setActivitesSlugAndDate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Activites) && !($entity instanceof Excursions)) {
            return;
        }

        $today = new DateTimeImmutable('now');
        $slug = $this->slugger->slug(strtolower($entity->getTitre()));
        $entity
            ->setSlug($slug)
            ->setCreatedAt($today)
            ->setEditedAt($today)
            ;
    }
}