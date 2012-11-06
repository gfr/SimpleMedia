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

/**
 * Operation method for amendments of the status field.
 *
 * @param array $obj
 * @param array, $params
 *
 * @return bool
 */
function SimpleMedia_operation_updateObjectStatus(&$obj, $params)
{
    // get attributes read from the workflow
    $objectType = isset($params['ot']) ? $params['ot'] : 'item'; /** TODO required? */
    $status = isset($params['status']) ? $params['status'] : 1;

    // assign value to the data object
    $obj['status'] = $status;

    /** TODO */
    //return {UPDATE}
    return true;
}
