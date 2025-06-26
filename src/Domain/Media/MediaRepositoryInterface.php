<?php

namespace Domain\Media;

interface MediaRepositoryInterface
{
    public function find(int $id): ?Media;

    /**
     * Сохраняет (вставляет/обновляет) сущность Media
     */
    public function save(Media $media): Media;

    public function findChildrenByParentIds(array $parentIds): array;

    /**
     * Удаляет сущность Media
     */
    public function delete(Media $media): void;

    /**
     * Найти медиа для конкретной сущности по mediable_type и mediable_id
     * @return Media[]
     */
    public function findByMediable(int $mediableType, int $mediableId): array;

    public function findByMediables(int $mediableType, array $mediableIds): array;
}
