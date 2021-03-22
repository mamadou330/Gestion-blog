<?php
namespace App\Model;

class User 
{    
    /**
     * id
     *
     * @var int
     */
    private $id;
        
    /**
     * username
     *
     * @var string
     */
    private $username;
    
    /**
     * password
     *
     * @var string
     */
    private $password;

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Get the value of username
     *
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
    
    /**
     * Set the value of Username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get the value of Password
     *
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of Password
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
}