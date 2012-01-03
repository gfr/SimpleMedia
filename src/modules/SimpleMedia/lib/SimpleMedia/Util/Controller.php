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

/**
 * Utility implementation class for controller helper methods.
 */
class SimpleMedia_Util_Controller extends SimpleMedia_Util_Base_Controller
{
    // feel free to add your own convenience methods here

    /**
     * Create directories for uploaded media
     * @param string $dir
     */
    public static function mkdir($dir) {
        $dom = ZLanguage::getModuleDomain('SimpleMedia');
        if ($dir[0] == '/') {
            LogUtil::registerError(__f("Warning! The media upload directory at [%s] appears to be 'above' the DOCUMENT_ROOT. Please choose a path relative to the webserver (e.g. userdata/SimpleMedia/media).", $dir, $dom));
        } else {
            if (is_dir($dir)) {
                if (!is_writable($dir)) {
                    LogUtil::registerError(__f('Warning! The media upload directory at [%s] exists but is not writable by the webserver.', $dir, $dom));
                }
            } else {
                // Try to create the specified directory
                if (FileUtil::mkdirs($dir, 0777)) {
                    // write a htaccess file in the image upload directory
                    //$allowedExtensions = ModUtil::getVar('SimpleMedia', 'allowedExtensions');
                    $htaccessContent = str_replace('__EXTENSIONS__', 'gif|jpeg|jpg|png|pdf|doc|xls|ppt|docx|xlsx|pptx|odt|ods|odp|arj|zip|rar|tar|tgz|gz|bz2|txt|rtf|swf|flv|mp3|mp4|avi|mpg|mpeg|mov', FileUtil::readFile('modules/SimpleMedia/docs/htaccess'));
                    if (FileUtil::writeFile($dir . '/.htaccess', $htaccessContent)) {
                        LogUtil::registerStatus(__f('SimpleMedia created a media upload directory successfully at [%s] and wrote an .htaccess file there for security.', $dir, $dom));
                    } else {
                        LogUtil::registerStatus(__f('SimpleMedia created a media upload directory successfully at [%s], but could not write the .htaccess file there.', $dir, $dom));
                    }
                } else {
                    LogUtil::registerStatus(__f('Warning! SimpleMedia could not create the specified media upload directory [%s]. Try to create it yourself and make sure that this folder is accessible via the web and writable by the webserver.', $dir, $dom));
                }
            }
        }
    }
}
