<?php

namespace user\modules\ads\controllers;

use yii\web\Controller;

/**
 * Default controller for the `ads` module
 */
class SpecController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionProfile()
    {
        return $this->render('profile');
    }

    public function actionBalance()
    {
        return $this->render('balance');
    }

    public function actionMyorders()
    {
        return $this->render('myorders');
    }

    public function actionChoose()
    {
        return $this->render('choose');
    }

    public function actionCreateorder()
    {
        return $this->render('createorder');
    }

    public function actionRatingspecialist()
    {
        return $this->render('ratingspecialist');
    }

    public function actionBase()
    {
        return $this->render('base');
    }

    public function actionMyrating()
    {
        return $this->render('myrating');
    }

    public function actionSpecialist()
    {
        return $this->render('specialist');
    }

    public function actionSpecialistorder()
    {
        return $this->render('specialistorder');
    }

    public function actionOrderpage()
    {
        return $this->render('orderpage');
    }

    public function actionBaseset()
    {
        return $this->render('baseset');
    }

    public function actionArticle()
    {
        return $this->render('article');
    }

    public function actionMessages()
    {
        return $this->render('messages');
    }

    public function actionManual()
    {
        return $this->render('manual');
    }

    public function actionManualmain()
    {
        return $this->render('manualmain');
    }

    public function actionManualprofile()
    {
        return $this->render('manualprofile');
    }

    public function actionManualbalance()
    {
        return $this->render('manualbalance');
    }

    public function actionManualorder()
    {
        return $this->render('manualorder');
    }

    public function actionManualchoose()
    {
        return $this->render('manualchoose');
    }

    public function actionManualstart()
    {
        return $this->render('manualstart');
    }

    public function actionManualrating()
    {
        return $this->render('manualrating');
    }

    public function actionManualmessage()
    {
        return $this->render('manualmessage');
    }

    public function actionManualbase()
    {
        return $this->render('manualbase');
    }

    public function actionManualmyrating()
    {
        return $this->render('manualmyrating');
    }
}
