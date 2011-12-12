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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Mon Nov 28 12:34:51 CET 2011.
 */

use Doctrine\ORM\Mapping as ORM;

/**

 * Entity extension domain class storing medium attributes.
 *
 * This is the concrete attribute class for medium entities.
 * @ORM\Entity(repositoryClass="SimpleMedia_Entity_Repository_Base_MediumAttribute")
 * @ORM\Table(name="simmed_medium_attribute",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="cat_unq", columns={"name", "entityId"})
 *     }
 * )
 */
class SimpleMedia_Entity_MediumAttribute extends SimpleMedia_Entity_Base_MediumAttribute
{
    // feel free to add your own methods here
}
