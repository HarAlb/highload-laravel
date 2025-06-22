<?php
namespace Infrastructure\Post;

use Doctrine\ORM\EntityManagerInterface;
use Domain\Post\Post;
use Domain\Post\PostRepositoryInterface;

class DoctrinePostRepository implements PostRepositoryInterface
{
    private EntityManagerInterface $em;
    private string $entityClass = Post::class;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Post $post): Post
    {
        $this->em->persist($post);
        $this->em->flush();

        return $post;
    }

    public function findById(int $id): ?Post
    {
        return $this->em->find($this->entityClass, $id);
    }

    public function findAll(int $limit, int $offset): array
    {
        return $this->em->getRepository($this->entityClass)
            ->findBy([], ['createdAt' => 'DESC'], $limit, $offset);
    }

    public function paginate(int $page, int $perPage): array
    {
        return $this->em->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage)
            ->getQuery()
            ->getResult();
    }

    public function countAll(): int
    {
        return $this->em->getRepository(Post::class)
            ->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function delete(Post $post): void
    {
        $this->em->remove($post);
        $this->em->flush();
    }
}
