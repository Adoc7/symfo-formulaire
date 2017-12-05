<?php
namespace JG\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use JG\PlatformBundle\Email\ApplicationMailer;
use JG\PlatformBundle\Entity\Application;


class ApplicationCreationListener
{
    /**
     * @var ApplicationMailer
     */

    public function __construct(ApplicationMailer $applicationMailer)
    {
        $this->applicationMailer = $applicationMailer;
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        // On ne veut envoyer un email que pour les entités Application

        if (!$entity instanceof Application) {
            return;
        }
        $this->applicationMailer->sendNewNotification($entity);
    }
}
