<?php
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Error');
$this->breadcrumbs = array(
    Yii::t('app', 'Error'),
);
$loggedEventIds = !empty($loggedEventIds) ? $loggedEventIds : Yii::app()->errorHandler->getSentryClient()->getLoggedEventIds();
?>

<h2><?php echo Yii::t('app', 'Error'); ?> <?php echo $code; ?></h2>

<div class="error">
    <p><?php echo CHtml::encode($message); ?></p>
</div>

<?php if (!empty($loggedEventIds)): ?>
    <p>

        <?php echo Yii::t('app', 'An error report has been sent to our technicians. If you wish to manually report this error, please include the following information:'); ?>
    <pre><?php echo implode("\n", $loggedEventIds); ?></pre>

    </p>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <p>

        <?php echo Yii::t('app', 'Error details (shown since debug mode is activated):'); ?>
    <pre><?php echo print_r($error, true); ?></pre>

    </p>
<?php endif; ?>
