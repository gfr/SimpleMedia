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
 * This handler class handles the page events of the Form called by the simpleMedia_admin_edit() function.
 * It aims on the medium object type.
 */
class SimpleMedia_Form_Handler_Admin_Medium_Edit extends SimpleMedia_Form_Handler_Admin_Medium_Base_Edit
{
    // feel free to extend the base handler class here
    public function initialize(Zikula_Form_View $view)
    {
        // Check if upload directories exist and if needed create them
        try {
            $controllerHelper = new SimpleMedia_Util_Controller(ServiceUtil::getManager());
            $result = $controllerHelper->checkAndCreateUploadFolder('medium', 'theFile', 'gif, jpeg, jpg, png, pdf, doc, xls, ppt, docx, xlsx, pptx, odt, ods, odp, arj, zip, rar, tar, tgz, gz, bz2, txt, rtf, swf, flv, mp3, mp4, avi, mpg, mpeg, mov');
        }
        catch (Exception $e) {
            return LogUtil::registerError($e->getMessage());
        }
        
        //There is no upload directory or something is wrong
        if($result != true){
            throw new Zikula_Exception_Fatal(__("You can not upload media as long the upload directory is not set up correctly!"));
        }
        parent::initialize($view);
    }
}
