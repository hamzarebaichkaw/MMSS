<?php
/**
 * Created by PhpStorm.
 * User: hamza
 * Date: 25/04/17
 * Time: 00:03
 */

namespace LogementBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity
 *
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     *@ORM\ManyToOne(targetEntity="Logement")
     *@ORM\JoinColumn(name="Logment_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $Logment_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogmentId()
    {
        return $this->Logment_id;
    }

    /**
     * @param mixed $Logment_id
     */
    public function setLogmentId($Logment_id)
    {
        $this->Logment_id = $Logment_id;
    }


    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="SVP, charger l'image de votre logement.")
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" })
     */
    private $brochure;

    public function getBrochure()
    {
        return $this->brochure;
    }

    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }
}