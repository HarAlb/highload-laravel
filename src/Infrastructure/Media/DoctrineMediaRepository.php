<?php

namespace Infrastructure\Media;

use Domain\Media\Media;
use Domain\Media\MediaRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineMediaRepository implements MediaRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {}

    public function find(int $id): ?Media
    {
        return $this->em->find(Media::class, $id);
    }

    public function save(Media $media): Media
    {
        $this->em->persist($media);
        $this->em->flush();

        return $media;
    }

    public function findChildrenByParentIds(array $parentIds): array
    {
        return $this->em->getRepository(Media::class)
            ->createQueryBuilder('m')
            ->where('m.parentId IN (:parentIds)')
            ->setParameter('parentIds', $parentIds)
            ->getQuery()
            ->getResult();
    }


    public function delete(Media $media): void
    {
        $this->em->remove($media);
        $this->em->flush();
    }

    public function findByMediable(int $mediableType, int $mediableId): array
    {
        $qb = $this->em->createQueryBuilder();

        $qb->select('m')
            ->from(Media::class, 'm')
            ->where('m.mediableType = :type')
            ->andWhere('m.parentId IS NULL')
            ->andWhere('m.mediableId = :id')
            ->setParameter('id', $mediableId)
            ->setParameter('type', $mediableType);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $mediableType
     * @param int[] $mediableIds
     * @return Media[]
     */
    public function findByMediables(int $mediableType, array $mediableIds): array
    {
        return $this->em->createQueryBuilder()
            ->select('m')
            ->from(Media::class, 'm')
            ->where('m.mediableType = :type')
            ->andWhere('m.mediableId IN (:ids)')
            ->andWhere('m.parentId IS NULL')
            ->setParameter('type', $mediableType)
            ->setParameter('ids', $mediableIds)
            ->getQuery()
            ->getResult();
    }

}
