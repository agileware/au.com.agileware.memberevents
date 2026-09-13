# Member-only non public events (au.com.agileware.memberevents)

This is a [CiviCRM](https://civicrm.org) extension that co-opts the standard "Public Event?" setting
on CiviCRM Events to restrict registration and viewing of non-public events to current Members only.

Normally, a CiviCRM Event marked as *not public* is simply hidden from public event listings, but
can usually still be viewed and registered for directly if someone has the link. This extension
changes that behaviour so that any Event with **Public Event?** unchecked can only be viewed and
registered for by contacts who currently hold an active Membership. Anyone else attempting to view
the event info page or registration page — and who does not have `access CiviEvent` permission — is
shown an access-denied error and is not permitted to register.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Usage

No new menu items, settings pages, CiviRules actions, or Scheduled Jobs are added by this extension.
Its behaviour is automatic and applies as soon as it is installed:

1. When creating or editing an Event in CiviCRM, go to the **Event Info** tab and check or uncheck
   **Public Event?** as usual.
   * **Public Event?** checked — the event behaves normally, with no restriction added by this
     extension.
   * **Public Event?** unchecked — the event's info page and registration page are restricted to
     contacts with an active Membership (of any Membership Type).
2. When a contact without an active Membership attempts to view the Event Info page or the
   Registration page for a non-public event, they are shown the message "ERROR: You must be a
   Member to access this page" and access is denied.
3. Contacts with the `access CiviEvent` permission (typically CiviCRM staff/admin users) are never
   restricted by this extension and can always view and access non-public events, regardless of
   their Membership status.
4. If a contact is not logged in, or logged in but has no active Membership record, they are denied
   access to the non-public event in the same way.

Membership status is checked using an active-only count of `Membership` records for the logged-in
contact — any current, active Membership of any type is sufficient to gain access.

## Special configuration requirements

This extension requires no settings page, API keys, or one-time setup. It depends on the core
CiviCRM **CiviEvent** and **CiviMember** components being enabled, since it checks Event's
`is_public` field and the contact's `Membership` records. There is no way to configure which
Membership Types grant access — any active Membership qualifies.

## Requirements

* CiviCRM 5.0+
* CiviEvent and CiviMember components enabled

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin
Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this
extension and install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/agileware/au.com.agileware.memberevents.git
cv en memberevents
```

About the Authors
-----------------

This CiviCRM extension was developed by the team at [Agileware](https://agileware.com.au).

[Agileware](https://agileware.com.au) provide a range of CiviCRM services including:

  * CiviCRM migration
  * CiviCRM integration
  * CiviCRM extension development
  * CiviCRM support
  * CiviCRM hosting
  * CiviCRM remote training services

Support your Australian [CiviCRM](https://civicrm.org) developers, [contact Agileware](https://agileware.com.au/contact) today!

![Agileware](logo/agileware-logo.png)

Maintained by Agileware.
