<?php
namespace App\Repository;

use App\Entity\Intervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<object>
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $r)
    {
        parent::__construct($r, Intervention::class);
    }

    public function findByFilters(?string $technician, ?string $status): mixed
    {
        $qb = $this->createQueryBuilder("i");

        if ($technician) {
            $qb->andWhere("i.technician = :tech")->setParameter(
                "tech",
                $technician,
            );
        }
        if ($status) {
            $qb->andWhere("i.status = :status")->setParameter(
                "status",
                $status,
            );
        }
        $qb->orderBy("i.scheduledAt", "DESC");
        return $qb->getQuery()->getResult();
    }

    public function findDistinctTechnicians(): array
    {
        $qb = $this->createQueryBuilder("i")
            ->select("i.technician")
            ->distinct()
            ->orderBy("i.technician", "ASC");

        $rows = $qb->getQuery()->getArrayResult();
        return array_map(fn($r) => $r["technician"], $rows);
    }
}
