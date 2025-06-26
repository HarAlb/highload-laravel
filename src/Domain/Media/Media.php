<?php


namespace Domain\Media;

use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Facades\Storage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'medias')]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $mediableType;

    #[ORM\Column(type: 'integer')]
    private int $mediableId;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $parentId;

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isComplied = false;

    #[ORM\Column(type: 'string')]
    private string $disk;

    #[ORM\Column(type: 'string')]
    private string $filename;

    #[ORM\Column(type: 'string')]
    private string $path;

    #[ORM\Column(type: 'string')]
    private string $extension;

    #[ORM\Column(type: 'string', nullable: true)]
    private int $size;

    #[ORM\Column(type: 'integer')]
    private int $position;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: Media::class, cascade: ['persist'])]
    private Collection $children;

    #[ORM\ManyToOne(targetEntity: Media::class, inversedBy: 'children')]
    #[ORM\JoinColumn(name: 'parent_id', referencedColumnName: 'id', nullable: true, onDelete: 'CASCADE')]
    private ?Media $parent = null;

    public function __construct(
        int $mediableType,
        int $mediableId,
        ?int $parentId,
        string $disk,
        string $filename,
        string $path,
        string $extension,
        int $size,
        int $position,
        bool $isComplied = false,
    ) {
        $this->mediableType = $mediableType;
        $this->mediableId = $mediableId;
        $this->parentId = $parentId;
        $this->disk = $disk;
        $this->filename = $filename;
        $this->path = $path;
        $this->extension = $extension;
        $this->size = $size;
        $this->position = $position;
        $this->isComplied = $isComplied;

        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediableType(): string
    {
        return $this->mediableType;
    }

    public function getMediableId(): int
    {
        return $this->mediableId;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function isComplied(): bool
    {
        return $this->isComplied;
    }

    public function markAsComplied(): void
    {
        $this->isComplied = true;
    }

    public function getDisk(): string
    {
        return $this->disk;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function isVideo(): bool
    {
        $videoExtensions = ['mp4', 'avi', 'mov', 'mkv'];
        return in_array(strtolower($this->extension), $videoExtensions);
    }

    public function isImage(): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        return in_array(strtolower($this->extension), $imageExtensions);
    }

    public function getFilePath(): string
    {
        return url(Storage::disk($this->disk)->url("{$this->path}/{$this->filename}.{$this->extension}"));
    }

    public function createChild(
        string $filename,
        string $extension,
        int $size,
        bool $isComplied = false
    ): self {
        return new self(
            mediableType: $this->mediableType,
            mediableId: $this->mediableId,
            parentId: $this->id,
            disk: $this->disk,
            filename: $filename,
            path: $this->path,
            extension: $extension,
            size: $size,
            position: $this->position,
            isComplied: $isComplied
        );
    }

    /**
     * Установить детей вручную
     * @param Media $child
     */
    public function addChild(self $child): void
    {
        if (!isset($this->children)){
            $this->children = new ArrayCollection();
        }

        $this->children->add($child);
    }

    /**
     * Получить детей
     * @return Collection
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function setParent(?Media $parent): void
    {
        $this->parent = $parent;
    }
}
