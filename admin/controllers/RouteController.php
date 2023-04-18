<?php
namespace admin\controllers;

use Exception;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\Response;

/**
 * Description of RuleController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class RouteController extends \yii\web\Controller
{
    /**
     * Lists all Route models.
     *
     * @return mixed
     */
    /*public function actionIndex()
    {
        $result = [];
        $this->getRouteRecursive(Yii::$app, $result);
        $this->filterResult($result);
        $numeric = [];
        $text = [];
        foreach ($result as $key => $item) {
            if (is_numeric($key))
                $numeric[$key] = $item;
            else
                $text[$key] = $item;
        }
        return ['numeric' => $numeric, 'string' => $text];
    }*/

    /**
     * Get route(s) recrusive
     *
     * @param \yii\base\Module $module
     * @param array $result
     */
    private function getRouteRecursive($module, &$result)
    {
        try {
            foreach ($module->getModules() as $id => $child) {
                if (($child = $module->getModule($id)) !== null) {
                    $this->getRouteRecursive($child, $result);
                }
            }
            foreach ($module->controllerMap as $id => $type) {
                $this->getControllerActions($type, $id, $module, $result);
            }
            $namespace = trim($module->controllerNamespace, '\\') . '\\';
            $this->getControllerFiles($module, $namespace, '', $result);
            if (!empty($module->name))
                $result[$module->name] = ($module->uniqueId === '' ? '' : '/' . $module->uniqueId) . '/';
            else
                $result[] = ($module->uniqueId === '' ? '' : '/' . $module->uniqueId) . '/';
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }

    /**
     * Get list controller under module
     *
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     *
     * @return mixed
     */
    private function getControllerFiles($module, $namespace, $prefix, &$result)
    {
        $path = @Yii::getAlias('@' . str_replace('\\', '/', $namespace));
        try {
            if (!is_dir($path)) {
                return;
            }
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file)) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $id = Inflector::camel2id(substr(basename($file), 0, -14));
                    $className = $namespace . Inflector::id2camel($id) . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }

    /**
     * Get list action of controller
     *
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    private function getControllerActions($type, $id, $module, &$result)
    {
        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            $result[] = '/' . $controller->uniqueId . '/';
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }

    /**
     * Get route of action
     *
     * @param \yii\base\Controller $controller
     * @param array $result all controller action.
     */
    private function getActionRoutes($controller, &$result)
    {
        try {
            $prefix = '/' . $controller->uniqueId . '/';
            foreach ($controller->actions() as $id => $value) {
                $result[] = $prefix . $id;
            }
            $class = new \ReflectionClass($controller);
            foreach ($class->getMethods() as $method) {
                $name = $method->getName();
                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    $key = explode('::', $method->getDocComment())[1];
                    $result[$key] = $prefix . Inflector::camel2id(substr($name, 6));
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
    }

    private function filterResult(&$result) {
        $remove = ['/route/', '/gii/', '/debug/', '/access/', 'elfinder', '/site/error', '/site/login', '/site/logout'];
        foreach ($result as $key => $item) {
            foreach ($remove as $r)
                if (strripos($item, $r) !== false)
                    unset($result[$key]);
        }
    }
}