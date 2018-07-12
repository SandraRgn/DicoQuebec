<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TermRepository")
 */
class Term extends TermParent
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="term")
     */
    private $commentaires;


    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="terms")
     */
    private $users;

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setTerm($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getTerm() === $this) {
                $commentaire->setTerm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUsers(User $users): self
    {
        if (!$this->users->contains($users)) {
            $this->users[] = $users;
        }

        return $this;
    }

    public function removeUsers(User $users): self
    {
        if ($this->users->contains($users)) {
            $this->users->removeElement($users);
        }

        return $this;
    }

}
