<?php
/**
 * Created by PhpStorm.
 * User: linpoo
 * Date: 2018/11/16
 * Time: 上午10:30.
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class WebSetting
{
    private $em;

    private $obj;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->obj = $this->getWebsetting();
    }

    public function getWebsetting()
    {
        return $this->em->getRepository(\App\Entity\WebSetting::class)->findOneBy([]);
    }

    public function getId(): ?int
    {
        return $this->obj->getId();
    }

    public function getName(): ?string
    {
        return $this->obj->getName();
    }

    public function getIcp(): ?string
    {
        return $this->obj->getIcp();
    }

    public function getContact(): ?string
    {
        return $this->obj->getContact();
    }

    public function getEmail(): ?string
    {
        return $this->obj->getEmail();
    }

    public function getPhone(): ?string
    {
        return $this->obj->getPhone();
    }

    public function getDescription(): ?string
    {
        return $this->obj->getDescription();
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->obj->getCreatedAt();
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->obj->getUpdatedAt();
    }
}
