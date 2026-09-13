# Member-only non public events (au.com.agileware.memberevents)

This is a [CiviCRM](https://civicrm.org) extension which co-opts the standard CiviEvent
**"Public Event?"** (`is_public`) setting to restrict event registration and viewing to
active Members only.

CiviCRM does not natively provide a simple way to mark an Event as "members only" -
"Public Event?" only controls whether an Event is listed on public-facing event pages. This
extension repurposes that same field: when an Event is **not** marked as a Public Event, only
logged-in contacts with at least one active Membership may view the Event Info page or
register for it. Anyone else is shown a permission-denied error and prompted that they must
be a Member to access the page.

Contacts with the `access CiviEvent` permission (i.e. CiviEvent administrators/staff) are
never restricted, so they can always view and manage the Event regardless of its Public
Event or membership status.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Usage

There is no separate settings page, scheduled job, or CiviRule provided by this extension -
it works automatically, based entirely on the existing **"Public Event?"** field found on
every CiviEvent Event's Info tab:

1. Edit the Event and, on the **Event Info** tab, **untick "Public Event?"**.
2. Save the Event.

Once saved:

* The **Event Info** page (`CRM/Event/Page/EventInfo.tpl`) will show an error and deny access
  to any visitor who is not logged in, or who is logged in but has no active Membership.
* The **Event Registration** page and form (`CRM/Event/Form/Registration/Register.tpl` /
  `CRM_Event_Form_Registration_Register`) will likewise deny access to those same visitors,
  both when the page content is rendered and when the registration form itself is built -
  preventing registration even if the page were reached by another route.
* Contacts who are logged in and hold at least one active Membership (any Membership Type)
  are allowed through, as are any users with the `access CiviEvent` permission.

To make an Event visible/registerable to everyone as normal, simply tick "Public Event?" as
usual - this extension only changes behaviour for Events where that box is unticked.

## Special configuration requirements

None. There are no credentials, API keys, dependent extensions, or additional settings
pages to configure. The extension has no effect until an Event has "Public Event?" unticked,
and Membership status is determined using the standard CiviMember `Membership.getcount`
API with `active_only` - no configuration of Membership Types is required.

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
