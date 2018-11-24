<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $keyword;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contents;

    /**
     * @ORM\Column(type="datetime")
     */
    private $pulic_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_show;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="articles",fetch="EAGER")
     */
    private $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $this->CloseTags($this->contents);
        return $this;
    }

    public function getKeyword()
    {
        return $this->keyword;
    }

    public function setKeyword($keyword): self
    {
        $this->keyword = $keyword;

        return $this;
    }

    public function getContents(): ?string
    {
        return $this->contents;
    }

    public function setContents(?string $contents): self
    {
        $this->description = $this->CloseTags($contents);
        $this->contents = $contents;

        return $this;
    }

    public function getPulicAt(): ?\DateTimeInterface
    {
        return $this->pulic_at;
    }

    public function setPulicAt(\DateTimeInterface $pulic_at): self
    {
        $this->pulic_at = $pulic_at;

        return $this;
    }

    public function getIsShow(): ?bool
    {
        return $this->is_show;
    }

    public function setIsShow(bool $is_show): self
    {
        $this->is_show = $is_show;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }


    function CloseTags($html) {
        // 直接过滤错误的标签 <[^>]的含义是 匹配只有<而没有>的标签
        // 而preg_replace会把匹配到的用''进行替换
        $html = preg_replace('/<[^>]*$/','',$html);

        // 匹配开始标签，这里添加了1-6，是为了匹配h1~h6标签
        preg_match_all('#<([a-z1-6]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $opentags = $result[1];
        // 匹配结束标签
        preg_match_all('#</([a-z1-6]+)>#iU', $html, $result);
        $closetags = $result[1];
        $len_opened = count($opentags);
        // 如何两种标签数目一致 说明截取正好
        if (count($closetags) == $len_opened) { return $html; }

        $opentags = array_reverse($opentags);
        // 过滤自闭和标签，也可以在正则中过滤 <(?!meta|img|br|hr|input)>
        $sc = array('br','input','img','hr','meta','link');

        for ($i=0; $i < $len_opened; $i++) {
            $ot = strtolower($opentags[$i]);
            if (!in_array($opentags[$i], $closetags) && !in_array($ot,$sc)) {
                $html .= '</'.$opentags[$i].'>';
            } else {
                unset($closetags[array_search($opentags[$i], $closetags)]);
            }
        }
        return $html;
    }
}
