# Extension FAQ

## I'm getting a 403 / permission error when trying to save forms in the back-end. What should I do?

Some customers encounter the following 403 error when trying to save a form in the Admin Panel:

*"You don't have permission to access /index.php/admin/contactforms_form/save/key/.../ on this server"*

This error is most likely caused by an Apache mod_security false positive.

You can solve this issue by whitelisting **/index.php/admin/contactforms_form/\*** and all sub-urls in mod_security, or you can ask your hoster to do this.

Whitelisting the URLs should solve the problem, allowing you to save the forms normally again.

## How do I insert a form into a CMS page or block?

Adding contact forms to CMS pages or block is very easy using our Custom Contact Forms widgets. You can read all about it in [Adding Forms to CMS Pages and Blocks](./17-adding-forms-to-cms-pages-and-blocks.md).

## How can I add a product questions form to my product pages?

If you'd like to add a form to a product page you can refer to [this tutorial](./18-adding-forms-to-layout-updates.md) about adding forms to a specific layout update using the Custom Contact Forms widget.

## Can I add a contact form to a specific phtml template?

Yes you can! Check out [this article](./19-adding-forms-to-phtml-templates.md) about adding custom contact forms to phtml templates.

## How can I add a pop-up form to my category pages for pre-ordering out of stock products?

You can refer to [this tutorial](./20-creating-a-pre-order-out-of-stock-pop-up-form.md) to learn how to replace the 'Out of Stock' button on category pages with a 'Pre-order' pop-up form button.

## I created a contact form widget but it doesn't appear on the front-end. What should I do?

When creating or making changes to Custom Contact Form widgets you'll need to refresh your cache (**System > Configuration > Cache Management**) to show the changes on the front-end.

If the widget still isn't visible after refreshing the cache, you might have to select a different Design Package / Theme or layout update when creating a widget using the **CMS > Widgets** interface.

## Some form submission data is missing in my admin notifications. How can I fix this?

If the form submission data of specific form fields is not included in admin e-mail notifications, then the form field ID / name is probably not configured correctly in the [Form Builder](./07-form-builder.md#configuring-components). To make sure all form data is submitted correctly, it’s important to assign a **unique ID** to each form component, without using any spaces. Best practice is to use short IDs that describe the content of the form component, such as *name, email, department, contact-method,* etc.

## How do I include specific form submission data in my customer and admin e-mail notifications?

You can automatically insert the submitted data of any form field in your customer and admin notifications using custom e-mail variables as further explained in [Adding Custom Variables to E-mail Notifications](./21-adding-custom-variables-to-email-notifications.md).

## Is it possible to automatically prefill forms with customer or product information?

As of Custom Contact Forms v1.11.0 you can automatically prefill forms with product, category, customer, shipping/billing address and store information by adding variables to the Default Value field. Using variables you can also prefill dropdown menus and list boxes with the customer invoice and order IDs. You can read all about configuring these variables in [Prefilling Forms Using Variables](./22-prefilling-forms-using-variables.md).

## Is it possible to duplicate forms?

Yes. After saving a form, you can use the 'Duplicate' button in the form view to create a copy of the contact form.

## Is it possible to add images to contact forms?

You won't find a form component in the Form Builder for inserting images, but it is possible to add images to your forms by inserting a paragraph using a HTML img tag as exemplified below:

```html
<img src="http://www.example.com/image.jpg" />
```

---

[Documentation index](./README.md) · [README](../README.md) · [Online version](https://plugin.company/knowledge-base/docs/magento-custom-contact-forms/faq/)
