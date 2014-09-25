<?php

class DefaultController extends Controller
{

    public $defaultAction = 'error';

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError($code = null)
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('error', $error);
            }
        } elseif (!is_null($code)) {
            $error['message'] = "Internal Server Error";
            $error['code'] = $code;
            $error['loggedEventIds'] = isset($_GET['loggedEventIds']) ? $_GET['loggedEventIds'] : array();
            $error['error'] = isset($_GET['error']) ? $_GET['error'] : array();
            $this->render('error', $error);
        } else {
            $error['message'] = "Precondition Failed";
            $error['code'] = 412;
            $this->render('error', $error);
        }
    }

    public function actionTriggerError()
    {

        /*
        if (!empty($_GET['theme'])) {
            Yii::app()->theme = $_GET['theme'];
        }
        */
        if (!empty($_GET['notice'])) {
            $bar = $foo;
        }
        if (!empty($_GET['warning'])) {
            $content = file_get_contents('foo.txt');
        }
        if (!empty($_GET['fatal'])) {
            $bar = foo();
        }

        echo "Current CONFIG_ENVIRONMENT is " . CONFIG_ENVIRONMENT;
        echo "</br>";
        echo "Current YII_DEBUG value is " . (int) YII_DEBUG;
        echo "</br>";
        echo "Current DEV value is " . (int) DEV;
        echo "</br>";
        echo CHtml::link("notice", array('site/triggerError', 'notice' => 1));
        echo "</br>";
        echo CHtml::link("warning", array('site/triggerError', 'warning' => 1));
        echo "</br>";
        echo CHtml::link("fatal", array('site/triggerError', 'fatal' => 1));

    }

}
