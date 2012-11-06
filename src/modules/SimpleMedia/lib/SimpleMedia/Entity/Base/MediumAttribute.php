<?php
/**
 * SimpleMedia.
 *
 * @copyright Axel Guckelsberger
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package SimpleMedia
 * @author Axel Guckelsberger <info@guite.de>.
 * @link http://zikula.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.5 (http://modulestudio.de) at Mon Nov 05 23:27:05 CET 2012.
 */

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing medium attributes.
 *
 * This is the base attribute class for medium entities.
 */
class SimpleMedia_Entity_Base_MediumAttribute extends Zikula_Doctrine2_Entity_EntityAttribute
{
    /**
     * @ORM\ManyToOne(targetEntity="SimpleMedia_Entity_Medium", inversedBy="attributes")
     * @ORM\JoinColumn(name="entityId", referencedColumnName="id")
     * @var SimpleMedia_Entity_Medium
     */
    protected $entity;

    /**
     * Get reference to owning entity.
     *
     * @return SimpleMedia_Entity_Medium
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set reference to owning entity.
     *
     * @param SimpleMedia_Entity_Medium $entity
     */
    public function setEntity(/*SimpleMedia_Entity_Medium */$entity)
    {
        $this->entity = $entity;
    }
}
