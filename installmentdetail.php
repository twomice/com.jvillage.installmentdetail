<?php

require_once 'installmentdetail.civix.php';

/**
 * Implementation of hook_civicrm_pageRun
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pageRun
 */
function installmentdetail_civicrm_pageRun(&$page) {
  if ($page->getVar('_name') == 'CRM_Contribute_Page_Tab' && $page->_action == CRM_Core_Action::BROWSE) {

    // Get a list of all possible financial types.
    $api_params = array(
      'options' => array(
        'limit' => 0
      ),
    );
    $result = civicrm_api3('financial_type', 'get', $api_params);
    $financial_types = $result['values'];

    // Get all recurring contributions for this contact, including all completed
    // contributions for each one.
    $api_params = array(
      'sequential' => 1,
      'contact_id' => $page->_contactId,
      'options' => array(
        'limit' => 0
      ),
      'api.contribution.get' => array(
        'contribution_status_id' => 1,
        'options' => array(
          'limit' => 0
        ),
      )
    );
    $result = civicrm_api3('contribution_recur', 'get', $api_params);

    // Compile an array of details for each recurring contribution.
    $installmentdetail = array();
    foreach ($result['values'] as $value) {
      $installmentdetail[$value['id']] = array(
        'financial_type' => CRM_Utils_Array::value($value['financial_type_id'], $financial_types),
        'count' => $value['api.contribution.get']['count'],
      );
    }

    // Assign variables to CRM.vars in JavaScript.
    $js_vars = array(
      'rowCount' => count($installmentdetail),
      'rows' => $installmentdetail,
    );
    CRM_Core_Resources::singleton()->addVars('installmentdetail', $js_vars);

    // Include extension JavaScript file.
    CRM_Core_Resources::singleton()->addScriptFile('com.jvillage.installmentdetail', 'js/installmentdetail.js');
  }
}

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function installmentdetail_civicrm_config(&$config) {
  _installmentdetail_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function installmentdetail_civicrm_xmlMenu(&$files) {
  _installmentdetail_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function installmentdetail_civicrm_install() {
  return _installmentdetail_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function installmentdetail_civicrm_uninstall() {
  return _installmentdetail_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function installmentdetail_civicrm_enable() {
  return _installmentdetail_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function installmentdetail_civicrm_disable() {
  return _installmentdetail_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function installmentdetail_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _installmentdetail_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function installmentdetail_civicrm_managed(&$entities) {
  return _installmentdetail_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function installmentdetail_civicrm_caseTypes(&$caseTypes) {
  _installmentdetail_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function installmentdetail_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _installmentdetail_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
