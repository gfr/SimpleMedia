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
 * Bootstrap called when application is first initialised at runtime.
 *
 * This is only called once, and only if the core has reason to initialise this module,
 * usually to dispatch a controller request or API.
 *
 * For example you can register additional AutoLoaders with ZLoader::addAutoloader($namespace, $path)
 * whereby $namespace is the first part of the PEAR class name
 * and $path is the path to the containing folder.
 */
// initialise doctrine extension listeners
$helper = ServiceUtil::getService('doctrine_extensions');
$helper->getListener('tree');
$helper->getListener('sluggable');
$helper->getListener('timestampable');
$helper->getListener('standardfields');
$translatableListener = $helper->getListener('translatable');
//$translatableListener->setTranslatableLocale(ZLanguage::getLanguageCode());
$currentLanguage = preg_replace('#[^a-z-].#', '', FormUtil::getPassedValue('lang', System::getVar('language_i18n', 'en'), 'GET'));
$translatableListener->setTranslatableLocale($currentLanguage);
/**
 * Sometimes it is desired to set a default translation as a fallback if record does not have a translation
 * on used locale. In that case Translation Listener takes the current value of Entity.
 * But there is a way to specify a default locale which would force Entity to not update it`s field
 * if current locale is not a default.
 */
//$translatableListener->setDefaultLocale(System::getVar('language_i18n', 'en'));

