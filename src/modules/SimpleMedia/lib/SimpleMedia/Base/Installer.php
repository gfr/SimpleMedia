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
 * Installer base class
 */
class SimpleMedia_Base_Installer extends Zikula_AbstractInstaller
{
    /**
     * Install the SimpleMedia application.
     *
     * @return boolean True on success, or false.
     */
    public function install()
    {
        $basePath = SimpleMedia_Util_Controller::getFileBaseFolder('medium', 'theFile');
        if (!is_dir($basePath)) {
            return LogUtil::registerError($this->__f('The upload folder "%s" does not exist. Please create it before installing this application.', array($basePath)));
        }
        if (!is_writable($basePath)) {
            return LogUtil::registerError($this->__f('The upload folder "%s" is not writable. Please change permissions accordingly before installing this application.', array($basePath)));
        }

        // create all tables from according entity definitions
        try {
            DoctrineHelper::createSchema($this->entityManager, $this->listEntityClasses());
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while creating the tables for the %s module.', array($this->getName())));
        }

        // set up all our vars with initial values
        $this->setVar('pageSize', 20);
        $this->setVar('thumbDimensions', '');
        $this->setVar('defaultThumbNumber', 1);
        $this->setVar('enableShrinking', false);
        $this->setVar('shrinkDimensions', '');
        $this->setVar('useThumbCropper', false);
        $this->setVar('cropSizeMode', 0);

        // create the default data for SimpleMedia
        $this->createDefaultData();

        // add entries to category registry
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/Global');
        CategoryRegistryUtil::insertEntry('SimpleMedia', 'Medium', 'Main', $rootcat['id']);

        // register persistent event handlers
        $this->registerPersistentEventHandlers();

        // register hook subscriber bundles
        HookUtil::registerSubscriberBundles($this->version->getHookSubscriberBundles());


        // initialisation successful
        return true;
    }

    /**
     * Upgrade the SimpleMedia application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldversion Version to upgrade from.
     *
     * @return boolean True on success, false otherwise.
     */
    public function upgrade($oldversion)
    {
    /*
        // Upgrade dependent on old version number
        switch ($oldversion) {
            case 1.0.0:
                // do something
                // ...
                // update the database schema
                try {
                    DoctrineHelper::updateSchema($this->entityManager, $this->listEntityClasses());
                } catch (Exception $e) {
                    if (System::isDevelopmentMode()) {
                        LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
                    }
                    return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %s module.', array($this->getName())));
                }
        }
    */

        // update successful
        return true;
    }

    /**
     * Uninstall SimpleMedia.
     *
     * @return boolean True on success, false otherwise.
     */
    public function uninstall()
    {
        // delete stored object workflows
        $result = Zikula_Workflow_Util::deleteWorkflowsForModule($this->getName());
        if ($result === false) {
            return LogUtil::registerError($this->__f('An error was encountered while removing stored object workflows for the %s module.', array($this->getName())));
        }

        try {
            DoctrineHelper::dropSchema($this->entityManager, $this->listEntityClasses());
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %s module.', array($this->getName())));
        }

        // unregister persistent event handlers
        EventUtil::unregisterPersistentModuleHandlers('SimpleMedia');

        // unregister hook subscriber bundles
        HookUtil::unregisterSubscriberBundles($this->version->getHookSubscriberBundles());


        // remove all module vars
        $this->delVars();

        // remove category registry entries
        ModUtil::dbInfoLoad('Categories');
        DBUtil::deleteWhere('categories_registry', "modname = 'SimpleMedia'");

        // deletion successful
        return true;
    }

    /**
     * Build array with all entity classes for SimpleMedia.
     *
     * @return array list of class names.
     */
    protected function listEntityClasses()
    {
        $classNames = array();
        $classNames[] = 'SimpleMedia_Entity_Medium';
        $classNames[] = 'SimpleMedia_Entity_MediumMetaData';
        $classNames[] = 'SimpleMedia_Entity_MediumAttribute';
        $classNames[] = 'SimpleMedia_Entity_MediumCategory';

        return $classNames;
    }
    /**
     * Create the default data for SimpleMedia.
     *
     * @return void
     */
    protected function createDefaultData()
    {
        // Ensure that tables are cleared
        $this->entityManager->transactional(function($entityManager) {
            $entityManager->getRepository('SimpleMedia_Entity_Medium')->truncateTable();
        });

        // Insertion successful
        return true;
    }

    /**
     * Register persistent event handlers.
     * These are listeners for external events of the core and other modules.
     */
    protected function registerPersistentEventHandlers()
    {
        // core
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'api.method_not_found', array('SimpleMedia_Listener_Core', 'apiMethodNotFound'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'core.preinit', array('SimpleMedia_Listener_Core', 'preInit'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'core.init', array('SimpleMedia_Listener_Core', 'init'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'core.postinit', array('SimpleMedia_Listener_Core', 'postInit'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'controller.method_not_found', array('SimpleMedia_Listener_Core', 'controllerMethodNotFound'));

        // installer
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'installer.module.installed', array('SimpleMedia_Listener_Installer', 'moduleInstalled'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'installer.module.upgraded', array('SimpleMedia_Listener_Installer', 'moduleUpgraded'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'installer.module.uninstalled', array('SimpleMedia_Listener_Installer', 'moduleUninstalled'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'installer.subscriberarea.uninstalled', array('SimpleMedia_Listener_Installer', 'subscriberAreaUninstalled'));

        // modules
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module_dispatch.postloadgeneric', array('SimpleMedia_Listener_ModuleDispatch', 'postLoadGeneric'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module_dispatch.preexecute', array('SimpleMedia_Listener_ModuleDispatch', 'preExecute'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module_dispatch.postexecute', array('SimpleMedia_Listener_ModuleDispatch', 'postExecute'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module_dispatch.custom_classname', array('SimpleMedia_Listener_ModuleDispatch', 'customClassname'));

        // mailer
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.mailer.api.sendmessage', array('SimpleMedia_Listener_Mailer', 'sendMessage'));

        // page
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'pageutil.addvar_filter', array('SimpleMedia_Listener_Page', 'pageutilAddvarFilter'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'system.outputfilter', array('SimpleMedia_Listener_Page', 'systemOutputfilter'));

        // errors
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'setup.errorreporting', array('SimpleMedia_Listener_Errors', 'setupErrorReporting'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'systemerror', array('SimpleMedia_Listener_Errors', 'systemError'));

        // theme
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'theme.preinit', array('SimpleMedia_Listener_Theme', 'preInit'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'theme.init', array('SimpleMedia_Listener_Theme', 'init'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'theme.load_config', array('SimpleMedia_Listener_Theme', 'loadConfig'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'theme.prefetch', array('SimpleMedia_Listener_Theme', 'preFetch'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'theme.postfetch', array('SimpleMedia_Listener_Theme', 'postFetch'));

        // view
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'view.init', array('SimpleMedia_Listener_View', 'init'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'view.postfetch', array('SimpleMedia_Listener_View', 'postFetch'));

        // user login
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.login.started', array('SimpleMedia_Listener_UserLogin', 'started'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.login.veto', array('SimpleMedia_Listener_UserLogin', 'veto'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.login.succeeded', array('SimpleMedia_Listener_UserLogin', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.login.failed', array('SimpleMedia_Listener_UserLogin', 'failed'));

        // user logout
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.logout.succeeded', array('SimpleMedia_Listener_UserLogout', 'succeeded'));

        // user
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.gettheme', array('SimpleMedia_Listener_User', 'getTheme'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.account.create', array('SimpleMedia_Listener_User', 'create'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.account.update', array('SimpleMedia_Listener_User', 'update'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.account.delete', array('SimpleMedia_Listener_User', 'delete'));

        // registration
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.registration.started', array('SimpleMedia_Listener_UserRegistration', 'started'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.registration.succeeded', array('SimpleMedia_Listener_UserRegistration', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.ui.registration.failed', array('SimpleMedia_Listener_UserRegistration', 'failed'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.registration.create', array('SimpleMedia_Listener_UserRegistration', 'create'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.registration.update', array('SimpleMedia_Listener_UserRegistration', 'update'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'user.registration.delete', array('SimpleMedia_Listener_UserRegistration', 'delete'));

        // users module
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.users.config.updated', array('SimpleMedia_Listener_Users', 'configUpdated'));

        // group
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'group.create', array('SimpleMedia_Listener_Group', 'create'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'group.update', array('SimpleMedia_Listener_Group', 'update'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'group.delete', array('SimpleMedia_Listener_Group', 'delete'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'group.adduser', array('SimpleMedia_Listener_Group', 'addUser'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'group.removeuser', array('SimpleMedia_Listener_Group', 'removeUser'));

        // special purposes and 3rd party api support
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'get.pending_content', array('SimpleMedia_Listener_ThirdParty', 'pendingContentListener'));
        EventUtil::registerPersistentModuleHandler('SimpleMedia', 'module.content.gettypes', array('SimpleMedia_Listener_ThirdParty', 'contentGetTypes'));
    }
}
