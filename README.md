# breakdance-password-protected-shortcode-wrapper

Add this to your site using a plugin like code snippets, Scripts Organizer, etc. 
Protected content should be wrapped in a "ShortcodeWrapper" Breakdance element.
Use the shortcode [custom_protected]

The password form will use a custom field on your post for the password. If blank, the content will load (no password). If password set, the form will show instead of the wrapped content. If the form is submitted correctly, the page reloads and shows the content in the wrapper.

I am using Metabox.io for my custom field password with a text field called "password-protected" but you can modify this code to work with default wordpress custom fields, ACF, etc.
