<?php
namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post 
{
    private $id;

    private $name;

    private $content;

    private $slug;
    
    private $created_at;

    private $categories = [];

    public function setName (string $name): self
    {   
        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setContent (string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(e($this->content));
    }

    public function getExcerpt(): ?string
    {
        if($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    public function getCreatedAt(): DateTime 
    {
        return new DateTime($this->created_at);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
    
    public function getID(): ?string
    {
        return $this->id;
    }
    
    /**
     * getCategories
     *
     * @return Category[]
     */
    public function getCategories (): array 
    {
        return $this->categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }
}