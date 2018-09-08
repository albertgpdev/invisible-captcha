Invisible CAPTCHA
==========


## Installation

```
composer require albertgpdev/invisible_captcha --dev
```

## Laravel 5

### Setup

Add ServiceProvider to the providers array in `app/config/app.php`.

```
Albertgpdev\InvisibleCaptcha\InvisibleCaptchaServiceProvider::class,
```

> It also supports package discovery for Laravel 5.5.

### Configuration
Add `INVISIBLE_RECAPTCHA_PUBLIC_KEY`, `INVISIBLE_RECAPTCHA_PRIVATE_KEY` to **.env** file.

```
// required
INVISIBLE_RECAPTCHA_PUBLIC_KEY=your_public_key
INVISIBLE_RECAPTCHA_PRIVATE_KEY=your_private_key

```

### Usage

Before you render the captcha, please keep those notices in mind:

* `getCaptcha()` function needs to be called within a form element.
* You have to ensure the `type` attribute of your submit button has to be `submit`.
* There can only be one submit button in your form.

##### Display reCAPTCHA in Your View

```php
{!! app('captcha')->getCaptcha(); !!}
```

With custom language support:

```php
{!! app('captcha')->getCaptcha('en'); !!}
```

With custom position:

```php
{!! app('captcha')->getCaptcha('inline'); !!}
{!! app('captcha')->getCaptcha('bottomright'); !!}
{!! app('captcha')->getCaptcha('bottomleft'); !!}
```

##### Validation

Add `'g-recaptcha-response' => 'required|captcha'` to rules array.

```