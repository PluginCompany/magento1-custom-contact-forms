# Changelog: Custom Contact Forms for Magento 1 / OpenMage

All releases of this extension, newest first. This repository contains the latest release, tagged [`1.21.2`](https://github.com/PluginCompany/magento1-custom-contact-forms/releases/tag/1.21.2); earlier versions are listed for reference and have no tag.

*Unreleased* changes are commits on `main` after the `1.21.2` tag; they are not part of a tagged release.

## Unreleased — 2026-10-23

- Security hardening: the admin download of form submission uploads now only serves files from the media/pccf_uploads/ folder. Before, any logged-in admin user could download any file the web server can read.

## 1.21.2 — 2020-04-06

- Fixed "Invalid method isCustomerLoggedIn" error which occurred when viewing a contact form CMS widget instance. (Issue was introduced in version 1.21.0)

## 1.21.1 — 2020-03-01

- Fixed issue causing all form submission comment timestamps to be off several hours when not using GMT locale

## 1.21.0 — 2019-12-16

- Added customer_logged_in condition to conditional fields section, which allows showing / hiding fields based on customer login status.
- Improved conditional fields conditions logic and descriptions.
- Added ``{{var xxx}}`` notation support to notification e-mail content. (Both ``{xxx}`` and ``{{var xxx}}`` are now supported.)
- Added support to ``{{include ..}}`` shortcode in notification e-mail. Allowing e-mail templates to be used.

## 1.20.4 — 2019-02-17

- Fixed captcha not being loaded issue which occurred when multiple forms with different captcha settings were placed on a single page

## 1.20.3 — 2018-10-20

- Fixed issue where inline pop-up form link would split the paragraph text it's placed in

## 1.20.2 — 2018-10-04

- Removed logging statement

## 1.20.1 — 2018-09-29

- Fixed conditional field checkbox 'does not contain' issue

## 1.20.0 — 2018-09-25

- Added option to include or exclude the visitor IP address in form submissions

## 1.19.4 — 2018-09-20

- Additional fix for Infortis theme

## 1.19.3 — 2018-09-18

- Popup form compatibility fix for Infortis theme

## 1.19.2 — 2018-09-14

- Forms on dedicated form page are now automatically centered
- Added custom CSS class to popup form buttons and links, allowing custom styling

## 1.19.1 — 2018-08-20

- Fixed issue related to conditional form fields staying disabled after being shown

## 1.19.0 — 2018-08-17

- Form components are now 'sticking' in the users screen when scrolling down, making them more easily accessible
- Added help text for some fields in form builder, including ID fields and multi-select option fields
- Added support for email template directives (header, footer etc) in e-mail notifications

## 1.18.1 — 2018-08-16

- Fixed nested conditional form fields issue
- Fixed required conditional checkbox validation issue
- Fixed issue where conditional form field value was lost when disabled / hidden

## 1.18.0 — 2018-05-23

- E-mail notification submission overview table now uses field labels instead of IDs
- Fixed issue where form wouldn't submit if reCaptcha wasn't checked on first try

## 1.17.6 — 2018-05-04

- Fixed ReCaptcha related issue which was caused by changes in external library

## 1.17.5 — 2018-04-17

- Fixed file upload issue introduced in version 1.17.4

## 1.17.4 — 2018-03-23

- Fixed file upload issue on IOS Safari
- Improved file upload error reporting

## 1.17.3 — 2018-03-21

- Removed some debugging code

## 1.17.2 — 2018-03-06

- Fixed nested conditional form field issue. Conditional form fields which are disabled are now automatically reset to their default value

## 1.17.1 — 2018-02-23

- Required form field red star position fix for small screens < 990px

## 1.17.0 — 2018-02-23

- Added option to enable focus on first field per form
- Fixed issue where focussing on first field didn't work in some cases
- Responsive fix for bottom left / right slideout forms

## 1.16.10 — 2018-01-24

- Ultimo theme pop-up style improvement

## 1.16.9 — 2017-12-02

- Fixed issue which allowed to submit a form multiple times when clicking the submit button repeatedly
- Added alt text for gears loading image

## 1.16.8 — 2017-11-15

- Bug fix for issue regarding saving of forms introduced in version 1.16.6

## 1.16.7 — 2017-11-02

- Added option to allow all extension types in upload field by leaving allowed extensions blank

## 1.16.6 — 2017-11-02

- Magento 1.4.x compatibility fixes
- Code improvements

## 1.16.5 — 2017-10-28

- Submissions CSV export special characters bug fix

## 1.16.4 — 2017-09-22

- un-minified codemirror library for compatibility with Fooman Speedster

## 1.16.3 — 2017-08-24

- Bug fix for special characters while exporting form submissions

## 1.16.2 — 2017-08-14

- Fixed conditional form fields bug
- Fixed get request empty form submissions bug

## 1.16.1 — 2017-07-27

- Added css classes field for appended textfield

## 1.16.0 — 2017-06-30

- Small admin area improvements
- Improved 2 column form design
- Added translation CSV file

## 1.15.0 — 2017-04-29

- Added custom CSS field for each form
- Added option to add custom CSS class to form wrapper
- Added on page load custom JS field
- Added before form submit custom JS field

## 1.14.4 — 2017-04-13

- Added custom methods to prefill form with formatted product price variables

## 1.14.3 — 2017-04-07

- Fixed small bug regarding utf8mb4 characters being used in form submissions

## 1.14.2 — 2017-04-05

- Excess white space is now trimmed from input fields before submitting a form

## 1.14.1 — 2017-03-22

- Fixed colorbox issue with newest Google Chrome browser version
- Renamed head.js library global variable for compatibility with some third party scripts

## 1.14.0 — 2017-03-14

- Added possibility to notify customers when form submission comment has been added
- Added auto hide form on submission option for widgets
- Added scroll to top of form after submission functionality
- Added copy / duplicate form functionality

## 1.13.3 — 2017-03-11

- Added support for CMS widget shortcodes inside form

## 1.13.2 — 2017-01-28

- Fixed various bugs
- Fixed php7 compatibility

## 1.13.1 — 2017-01-10

- Fixed some minor bugs

## 1.13.0 — 2017-01-03

- Added option to prefill dropdown menus and list boxes with customer's invoice and order IDs

## 1.12.1 — 2016-12-08

- Fixed issue regarding slide-out form bottom left/right margin

## 1.12.0 — 2016-10-19

- Added visitor IP variable ``{visitor_IP}`` to form submissions

## 1.11.4 — 2016-09-25

- Fixed some notice and warning level errors

## 1.11.3 — 2016-09-21

- Fixed mobile file upload issue
- Fixed multiple upload fields validation display issue

## 1.11.2 — 2016-09-21

- Fixed issue regarding Bootstrap JS and Visual Captcha in conjunction with RequireJS

## 1.11.1 — 2016-09-07

- Fixed bug regarding form not being submitted when embedded in a product page (introduced in v1.11.0)
- Added form URL to default form submission entry parameters list
- Disabled loading of reCaptcha library if it isn't used

## 1.11.0 — 2016-08-11

- Added option to create multi-column contact forms and form sections
- Added option to automatically prefill input fields using default values and variables
- Added option to preselect default value of radios, checkboxes, dropdown menu and list box
- Added custom CSS class option to form component settings
- Added file upload component to conditional form fields
- Added 24 hour notation to time selection field
- Empty conditional form field data is now hidden from admin notification emails
- Fixed 'header already sent' warning error
- Fixed spam assassin issue

## 1.10.1 — 2016-05-22

- Fixed required file upload field bug

## 1.10.0 — 2016-05-17

- Fixed empty form submission issue
- Fixed required checkboxes selection bug
- Fixed multi-page form height issue related to conditional form fields
- Fixed installer compatibility with Magento Community editions up to 1.6
- Enabled CMS widget / variable processing in front-end success messages

## 1.9.1 — 2016-03-29

- Fixed issue regarding widget chooser permissions

## 1.9.0 — 2016-03-08

- Added exit intent pop-up form functionality

## 1.8.3 — 2016-02-22

- Fixed pop-up resizing issue regarding forms with conditional fields and input validation

## 1.8.2 — 2015-12-30

- Fixed form submission comment saving issue

## 1.8.1 — 2015-12-21

- Fixed form saving bug introduced in v1.8.0

## 1.8.0 — 2015-12-18

- Added comment functionality for form submissions
- Added option to change the status of form submissions
- Added configurable form submission ID prefix option in Form Settings tab

## 1.7.0 — 2015-12-12

- Added match type selection to conditional admin recipient settings
- Added form URL variable for configuring conditional admin recipients

## 1.6.1 — 2015-11-25

- Fixed small issue regarding compatibility with old jQuery versions
- Reply to e-mail address of admin notification e-mail now defaults to the customer address
- Fixed a bug in the drag & drop form builder

## 1.6.0 — 2015-11-19

- Added conditional recipient to admin notifications
- Added configurable reply to e-mail address to admin notifications
- Improved multi-page form design for mobile
- Improved slide-out form design for mobile
- Fixed pop-up form min width issue
- Added conditional paragraph text and headers
- Added maximum days limit to date range field
- From date in date range field is grayed out by default
- Added newsletter subscription check-box
- Changed the upload field color for completed file uploads
- Fixed reCaptcha issues
- Added Visual Captcha translation support
- Fixed form loading issue when custom Bootstrap theme is selected

## 1.5.2 — 2015-10-24

- Fixed form builder display bug for 1200px screen resolution

## 1.5.1 — 2015-10-14

- Small bug fix
- Increased vertical margin of multi-page form pagination

## 1.5.0 — 2015-10-14

- Fixed pop-up multi-page form resizing bug
- Added option to define minimum width for pop-up form

## 1.4.7 — 2015-10-06

- Fixed small notice error

## 1.4.6 — 2015-09-24

- Fixed multiple select and checkbox bug during form submission
- Fixed compatibility issue with Syntax Highlighter extension

## 1.4.5 — 2015-09-22

- Fixed secure URL issue: extension checks if current URL is secure now before using secure URL

## 1.4.4 — 2015-09-22

- Fixed conditional field issue with older jQuery versions

## 1.4.3 — 2015-09-21

- Fixed issue when notice level error reporting is enabled

## 1.4.2 — 2015-09-19

- Improved IE8 compatibility on front-end

## 1.4.1 — 2015-09-19

- Fixed form page creation bug in form builder

## 1.4.0 — 2015-09-07

- Added conditional form fields functionality
- Improved placeholder text display
- Added required option to radios and drop-down component
- Added customizable upload field text and required option
- Added option to delete uploaded files
- Added arbitrary Javascript field for form submissions
- Fixed compatibility issue with custom mailing / SMTP extensions
- Fixed back-end resizing bug

## 1.3.4 — 2015-08-19

- Small bug fix regarding upload field in combination with old jQuery version

## 1.3.3 — 2015-08-13

- Added support for secure URL (https)

## 1.3.2 — 2015-08-07

- Fixed BCC notification issue
- Fixed colorbox issue

## 1.3.1 — 2015-07-27

- Fixed date picker positioning issue
- Fixed minor display bugs

## 1.3.0 — 2015-07-19

- Added multi-page form functionality
- Re-sized multi-page colorbox and multi-page slide-out form
- Added multiple event hooks for developers
- Small bug fix

## 1.2.6 — 2015-07-13

- Fixed bug regarding customer e-mail and customer name variable

## 1.2.5 — 2015-07-11

- Fixed backwards compatibility Captcha

## 1.2.4 — 2015-07-09

- Fixed Magento 1.4 compatibility

## 1.2.3 — 2015-06-20

- Security update .htaccess uploads

## 1.2.2 — 2015-06-19

- Fixed slide-out form text rotation for safari

## 1.2.1 — 2015-06-16

- Added back-end form submissions save & export functionality

## 1.1.3 — 2015-06-03

- Added RTL, special character and UTF-8 e-mail support
- Added Form URL variable for e-mail notifications

## 1.1.2 — 2015-06-02

- Fixed shoplift bug compatibility
- Fixed slide-out resize issue

## 1.1.1 — 2015-06-01

- Improved slide-out widgets and pop-up widget
- Improved file upload and visual captcha CSS
- Updated to new Google ReCaptcha 2.0
- Fixed issue with multiple captchas
- Updated jQuery & Bootstrap libraries
- Improved some minor front-end theme features

## 1.1.0 — 2015-05-29

- Added slide-out contact form widget
- Added Visual Captcha integration
- Updated Google ReCaptcha integration
- Added file upload form component
- Added date, time and date range selection components
- Improved form builder layout

## 1.0.5 — 2015-05-11

- Minor bug fix for multiple forms on the same page

## 1.0.4 — 2015-04-30

- Form title now used for page title
- Fixed installer table prefix bug

## 1.0.3 — 2015-03-10

- Improved widget functionality
- Fixed FireFox bug in admin area

## 1.0.2 — 2015-02-24

- Changed widget functionality
- Fixed front-end IE8 compatibility

## 1.0.1 — 2015-02-12

- Updated grid view and changed column names to fit low resolution screen
- Changed height of default success alert
- Added store config values
- Moved jQuery library
- Improved widget support
- Fixed ACL issue
- Fixed text area and pop-up form width issue

## 1.0.0 — 2014-10-30

- First release of Magento Custom Contact Forms extension by Plugin Company.
