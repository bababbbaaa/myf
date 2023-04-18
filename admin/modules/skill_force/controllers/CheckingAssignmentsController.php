<?php

namespace admin\modules\skill_force\controllers;

use admin\controllers\AccessController;

class CheckingAssignmentsController extends AccessController
{

  public function actionIndex()
  {
    return $this->render('index');
  }
}
