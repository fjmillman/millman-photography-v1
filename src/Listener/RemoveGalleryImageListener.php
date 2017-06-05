<?php

namespace MillmanPhotography\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use MillmanPhotography\Entity\GalleryImage;

class RemoveGalleryImageListener
{
    public function preRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof GalleryImage) {
            $gallery_image = $args->getEntity();

            $gallery_image->setGallery(null);
            $gallery_image->setImage(null);
        }
    }
}
