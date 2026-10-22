# Event / Observer Hooks

Our [Magento Custom Contact Forms extension](https://plugin.company/magento1-extensions/custom-contact-forms.html) comes with numerous event hooks, making it easy for developers to extend the functionality of this extension and of specific forms.

You'll find a detailed list of the available event / observer hooks below.

## Contact Form Submit Before

### Description

Client side form submit before processing hook.

To stop further processing and show an error message, set the `stop_processing` property of the ‘params’ object to true:

```php
$observer->getEvent()->getParams()->setStopProcessing(true);
```

### Event details

- **Event code:** `pc_contactforms_form_submit_before`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `params` (`Varien_Object`)

## Contact Form Submit After

### Description

Client side form submit after processing.

### Event details

- **Event code:** `pc_contactforms_form_submit_after`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `params` (`Varien_Object`)

## Customer Notification Send Before

### Description

Customer notification e-mail send before hook. E-mail parameters can be modified here if needed.

To prevent the e-mail from being sent, set the `can_send_mail` property of the `mail_data` object to ‘false’:

```php
$observer->getEvent()->getMailData()->setCanSendMail(false);
```

### Event details

- **Event code:** `pc_contactforms_customer_notify_before`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `mail_data` (`Varien_Object`)

## Customer Notification Send After

### Description

Customer notification e-mail send after hook.

### Event details

- **Event code:** `pc_contactforms_customer_notify_after`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `mail_data` (`Varien_Object`)

## Admin Notification Send Before

### Description

Admin notification e-mail send before hook. E-mail parameters can be modified here if needed.

To prevent the e-mail from being sent, set the `can_send_mail` property of the `mail_data` object to ‘false’:

```php
$observer->getEvent()->getMailData()->setCanSendMail(false);
```

### Event details

- **Event code:** `pc_contactforms_admin_notify_before`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `mail_data` (`Varien_Object`)

## Admin Notification Send After

### Description

Admin notification e-mail send after hook.

### Event details

- **Event code:** `pc_contactforms_admin_notify_after`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `mail_data` (`Varien_Object`)

## Comment Notification Send Before

### Description

Comment notification e-mail send before hook. Dispatched when a comment on a form submission is e-mailed to the customer from the admin area.

### Event details

- **Event code:** `pc_contactforms_comment_notify_before`
- **Parameters:** `entry` (`Plugincompany_Contactforms_Model_Entry`), `comment` (`Plugincompany_Contactforms_Model_Entry_Comment`)

## Comment Notification Send After

### Description

Comment notification e-mail send after hook. Dispatched when a comment on a form submission is e-mailed to the customer from the admin area.

### Event details

- **Event code:** `pc_contactforms_comment_notify_after`
- **Parameters:** `entry` (`Plugincompany_Contactforms_Model_Entry`), `comment` (`Plugincompany_Contactforms_Model_Entry_Comment`)

## Form Save Before Event

### Description

Custom Contact Form save before event. Takes place before saving a form in the admin area.

### Event details

- **Event code:** `plugincompany_contactforms_form_save_before`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `data_object` (`Plugincompany_Contactforms_Model_Form`)

## Form Save After Event

### Description

Custom Contact Form save after event. Takes place after saving a form in the admin area.

### Event details

- **Event code:** `plugincompany_contactforms_form_save_after`
- **Parameters:** `form` (`Plugincompany_Contactforms_Model_Form`), `data_object` (`Plugincompany_Contactforms_Model_Form`)

## Form Submission Save Before Event

### Description

Form submission save before event. Takes place before saving a form submission in the database.

### Event details

- **Event code:** `plugincompany_contactforms_entry_save_before`
- **Parameters:** `entry` (`Plugincompany_Contactforms_Model_Entry`), `data_object` (`Plugincompany_Contactforms_Model_Entry`)

## Form Submission Save After Event

### Description

Form submission save after event. Takes place after saving a form submission in the database.

### Event details

- **Event code:** `plugincompany_contactforms_entry_save_after`
- **Parameters:** `entry` (`Plugincompany_Contactforms_Model_Entry`), `data_object` (`Plugincompany_Contactforms_Model_Entry`)

---

[Documentation index](./README.md) · [README](../README.md) · [Online version](https://plugin.company/knowledge-base/docs/magento-custom-contact-forms/tutorials/event-observer-hooks/)
