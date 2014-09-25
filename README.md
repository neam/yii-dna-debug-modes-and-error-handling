Yii DNA Debug Modes and Error Handling
======================================

Provides easy debug of redirects and general application flow through logs as well as user and developer friendly error handling in production.

## Error Handling

Features:
* Sentry integration
* Friendly errors, including proper catching of fatal errors. Users are informed that an error report has been sent to our technicians and reported sentry event ids are displayed for the end user to include in support requests
* Overrides the insecure default displayError and displayException that could be exploited for Cross-Site Scripting attacks.
* The SaveException class for getting useful exception messages when $model->save() return false

Requires that the `SENTRY_DSN` constant is set containing the Sentry dsn to use when reporting errors.

## Debug Modes

The modes are activated when the corresponding PHP constants are defined and `true`.

### DEBUG_REDIRECTS

Will pause and let you manually click the new url that. This way logs can be inspected before the redirect is performed.

### DEBUG_LOGS

Will enable the web log route on non-ajax requests together with some $_GET options that let's the developer fine tune what logs are displayed.

## Installation

### Error Handling

In your main configuration file, make sure that the current configuration is available in a variable called `$config`, then include this extension's config include:

    include('vendor/neam/yii-dna-debug-modes-and-error-handling/config/error-handling.php');

This will configure the error handler and ensure that your Yii::app() uses the included trait (necessary for proper error handling).

To use a custom class for Yii::app(), adjust your frontend entry script from the default:

    Yii::createWebApplication($config)->run();

To something that looks like this:

    require_once("$approot/vendor/neam/yii-dna-debug-modes-and-error-handling/components/YiiDnaWebApplication.php");
    Yii::createApplication('YiiDnaWebApplication', $config)->run();

If you already have your own custom class, make sure that it uses the included YiiDnaWebApplicationTrait.

To use the SaveException, make a habit of throwing it whenever $model->save() returns false, like so:

    if (!$model->save()) {
        throw new SaveException($model);
    }

The exception message will contain useful information about validation errors, making it easy to spot what went wrong.

### Debug Modes

In your main configuration file, make sure that the current configuration is available in a variable called `$config`, then include this extension's config include:

    include('vendor/neam/yii-dna-debug-modes-and-error-handling/config/debug-modes.php');

This will make the debug modes available.
