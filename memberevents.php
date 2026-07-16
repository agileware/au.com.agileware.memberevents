<?php

/*
 * Implements hook_civicrm_alterContent().
 */
function memberevents_civicrm_alterContent( &$content, $context, $tplName, &$object) {
  // Check if this is an event Registation form
  if($tplName == 'CRM/Event/Form/Registration/Register.tpl' || $tplName == 'CRM/Event/Page/EventInfo.tpl') {
    if (CRM_Core_Permission::check('access CiviEvent')) {
      // Leave early if an event administrator
      return;
    }
    try {
      // SUP-72555 Fix attempt to access protected property _id
      $eventId = $object->getVar('_id'); // Will be deprecated, but currently in use

      // Check if the event ID is in the query string
      if (isset($_GET['id'])) {
        $eventId = $_GET['id'];
      }
      
      $is_public = (isset($object->_values['event']) ? $object->_values['event']['is_public'] : civicrm_api3('Event', 'getvalue', array('id' => $eventId, 'return' => 'is_public')));
    }
    catch(CRM_API3_Exception $e) {
      $is_public = 0;
    }
    // Check if is_public is set from Public Event? main events option, if not show only to members
    if (!$is_public) {
      // Get info about the current user
      $session =& CRM_Core_Session::singleton();
      $contact_id = $session->getLoggedInContactID();

      // Params to use to check if this user has a specific Membership Type
      $params = array(
        'sequential' => 1,
        'contact_id' => $contact_id,
        'active_only' => true,
      );

      try {
        // Get the count of active memberships
        $membership_count = civicrm_api3('Membership', 'getcount', $params);
      }
      catch(CRM_API3_Exception $e) {
        $membership_count = 0;
      }

      // If there are no memberships then redirect to purchase membership page.
      if(!$contact_id || $membership_count < 1) {
        $content = '<div class="messages error">ERROR: You must be a Member to access this page</div>';
        CRM_Utils_System::permissionDenied();
      }
    }
  }
}

/*
 * Implements hook_civicrm_buildForm();
 *
 * Deny registering for an event before the template is built.
 */
function memberevents_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Event_Form_Registration_Register') {
    try {
      $is_public = civicrm_api3('Event', 'getvalue', array('id' => $form->_eventId, 'return' => 'is_public'));
      if(!$is_public && !CRM_Core_Permission::check('access CiviEvent')) {
        // Get info about the current user
        $session =& CRM_Core_Session::singleton();
        $contact_id = $session->getLoggedInContactID();

        $params = array(
          'sequential' => 1,
          'contact_id' => $contact_id,
          'active_only' => true,
        );

        // If there are no memberships then redirect to purchase membership page.
        if(!$contact_id ||  civicrm_api3('Membership', 'getcount', $params) < 1) {
          CRM_Utils_System::permissionDenied();
        }
      }
    }
    catch(CRM_API3_Exception $e) {
    }
  }
}