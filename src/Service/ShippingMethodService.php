<?php


namespace App\Service;


use App\Entity\ShippingMethod;
use App\Entity\ShippingMethodInterface;
use Doctrine\ORM\EntityManagerInterface;

class ShippingMethodService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    /**
     * ShippingMethodService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function storeOrderShippingInfo(ShippingMethodInterface $shippingMethod): ?ShippingMethodInterface
    {
        if(null === $shippingMethod){
            throw new \Exception("Shipping Method is null");
        }

        $this->entityManager->persist($shippingMethod);
        $this->entityManager->flush();

        return $shippingMethod;
    }
}