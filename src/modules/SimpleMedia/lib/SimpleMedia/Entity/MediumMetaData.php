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
 * Entity extension domain class storing medium meta data.
 *
 * This is the concrete meta data class for medium entities.
* @ORM\Entity(repositoryClass="SimpleMedia_Entity_Repository_Base_MediumMetaData")
   * @ORM\Table(name="simmed_medium_metadata")
 */
class SimpleMedia_Entity_MediumMetaData extends SimpleMedia_Entity_Base_MediumMetaData
{
    // feel free to add your own methods here
}
