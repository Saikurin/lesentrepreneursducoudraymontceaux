<?php

namespace App\Repository;

use App\Entity\DemandeAdhesion;
use App\Enum\EtatDemandeAdhesion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DemandeAdhesion>
 */
class DemandeAdhesionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DemandeAdhesion::class);
    }

    //    /**
    //     * @return DemandeAdhesion[] Returns an array of DemandeAdhesion objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DemandeAdhesion
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findAllAsArray()
    {
        $result =  $this->createQueryBuilder('u')
            ->select('u')
            ->getQuery()
            ->getResult();

        return array_map(function (DemandeAdhesion $item) {
            return [
                'id' => $item->getId(),
                'nom' => $item->getNomPrenom(),
                'raison' => $item->getRaisonSocial(),
                'adresse' => $item->getAdresse(),
                'profession' => $item->getProfession(),
                'contact' => $item->getContact(),
                'created_at' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
                'etat' => $item->getEtat()->value,
            ];
        },$result);
    }

    public function findPending()
    {
        $result =  $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.etat = :etat')
            ->setParameter('etat', EtatDemandeAdhesion::EN_ATTENTE)
            ->getQuery()
            ->getResult();

        return array_map(function (DemandeAdhesion $item) {
            return [
                'id' => $item->getId(),
                'nom' => $item->getNomPrenom(),
                'raison' => $item->getRaisonSocial(),
                'adresse' => $item->getAdresse(),
                'profession' => $item->getProfession(),
                'contact' => $item->getContact(),
                'created_at' => $item->getCreatedAt()->format('Y-m-d H:i:s'),
                'etat' => $item->getEtat()->value,
            ];
        },$result);
    }
}
