<?php

namespace MillmanPhotography\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;

use MillmanPhotography\Entity\PostImage;
use MillmanPhotography\Entity\GalleryImage;

class RemoveImageListener
{
    public function preRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof GalleryImage) {
            $galleryImage = $args->getEntity();

            $galleryImage->setGallery(null);
            $galleryImage->setImage(null);
        }

        if ($args->getEntity() instanceof PostImage) {
            $postImage = $args->getEntity();

            $postImage->setPost(null);
            $postImage->setImage(null);
        }
    }
}
