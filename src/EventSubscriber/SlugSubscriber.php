<?php

namespace App\EventSubscriber;

use App\Entity\Article;
use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Event\PrePersistEventArgs;
use Doctrine\Bundle\DoctrineBundle\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\String\Slugger\AsciiSlugger;

class SlugSubscriber
{
    private AsciiSlugger $slugger;

    public function __construct()
    {
        $this->slugger = new AsciiSlugger();
    }

    #[AsEventListener(event: Events::prePersist)]
    public function prePersist(PrePersistEventArgs $args): void
    {
        $this->genererSlug($args->getObject());
    }

    #[AsEventListener(event: Events::preUpdate)]
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $this->genererSlug($args->getObject());
    }

    private function genererSlug(object $entity): void
    {
        if ($entity instanceof Article && empty($entity->getSlug())) {
            $entity->setSlug(strtolower($this->slugger->slug($entity->getTitre())));
        }

        if ($entity instanceof Livre && empty($entity->getSlug())) {
            $entity->setSlug(strtolower($this->slugger->slug($entity->getTitre())));
        }
    }
}