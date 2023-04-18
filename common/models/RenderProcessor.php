<?php

namespace common\models;

use yii\base\Module;
use yii\helpers\UnsetArrayValue;
use yii\helpers\Url;
use admin\controllers\RouteController;


class RenderProcessor
{

    public static $modules = [
        '/rbac/',
        '/cms/',
        '/cms/femida',
        '/cms/lead',
        '/dev-force/',
        '/lead-force/',
        '/contact-center/',
        '/logs/',
        '/support/',
        '/femida/',
    ];

    /**
     * @param $sidebar
     * @param $user \yii\web\User
     * @return bool
     */
    public static function check__if__can($sidebar, $user) {
        if (empty($sidebar['access']))
            return true;
        if (is_array($sidebar['access'])) {
            $can = false;
            foreach ($sidebar['access'] as $item) {
                if ($user->can($item)) {
                    $can = true;
                    break;
                }
            }
            return $can;
        } else
            return $user->can($sidebar['access']);
    }

    public static function getSidebarInfo() {
        return [
            Url::to(['/']) => [
                'title' => 'Главная',
                'access' => null,
                'glyph' => 'dashboard'
            ],
            Url::to(['/rbac/']) => [
                'title' => 'RBAC',
                'access' => 'rbac',
                'glyph' => 'log-in'
            ],
            Url::to(['/cms/']) => [
                'title' => 'CMS',
                'access' => 'cms',
                'glyph' => 'pencil'
            ],
            Url::to(['/lead-force/']) => [
                'title' => 'Lead.Force',
                'access' => 'global-lead-force',
                'glyph' => 'send'
            ],
            Url::to(['/skill-force/']) => [
                'title' => 'Skill.Force',
                'access' => 'skill-force',
                'glyph' => 'education'
            ],
            Url::to(['/dev-force/']) => [
                'title' => 'Dev.Force',
                'access' => 'dev-force',
                'glyph' => 'th'
            ],
            Url::to(['/contact-center/']) => [
                'title' => 'Контакт-центр',
                'access' => ['ccOperations', 'qualityControl'],
                'glyph' => 'headphones'
            ],
            Url::to(['/logs/']) => [
                'title' => 'Логгирование',
                'access' => 'logs',
                'glyph' => 'file'
            ],
            Url::to(['/support/']) => [
                'title' => 'Поддержка',
                'access' => 'supportAccess',
                'glyph' => 'comment'
            ],
            Url::to(['/reports/']) => [
                'title' => 'Статистика',
                'access' => 'reports',
                'glyph' => 'stats'
            ],
            Url::to(['/api-docs/']) => [
                'title' => 'API',
                'access' => 'apiAccess',
                'glyph' => 'list-alt'
            ],
            Url::to(['/settings/']) => [
                'title' => 'Настройки',
                'access' => 'settingsAccess',
                'glyph' => 'cog'
            ],
        ];
    }

    public static function renderDynamicObjectInput ($label, $section, $param, $type, $placeholder, $additionalParam = '', $value = '', $length = false, $append = false) {
        if ($append) {
            $class = "append append-{$section}";
        } else
            $class = '';
        $html = "<div class='{$class}'>";
            $html .= "<div style='padding-bottom: 5px'>";
                $html .= "<b>{$label}</b>";
            $html .= "</div>";
            if (!$length) {
                $html .= "<div>";
                if ($type === 'input')
                    $html .= "<input class='object-admin-input' type='text' name='{$section}[{$param}]{$additionalParam}' value='{$value}' placeholder='{$placeholder}' />";
                else
                    $html .= "<textarea class='object-admin-input' style='resize: none' rows='6' name='{$section}[{$param}]' placeholder='{$placeholder}'>{$value}</textarea>";
                $html .= "</div>";
            } else {
                for ($i = 0; $i < $length; $i++) {
                    $html .= "<div>";
                    if ($type === 'input')
                        $html .= "<input class='object-admin-input' type='text' name='{$section}[{$param}]{$additionalParam}' value='{$value[$i]}' placeholder='{$placeholder}' />";
                    else
                        $html .= "<textarea class='object-admin-input' style='resize: none' rows='6' name='{$section}[{$param}]' placeholder='{$placeholder}'>{$value[$i]}</textarea>";
                    $html .= "</div>";
                }
            }
        $html .= "</div>";
        return $html;
    }

    public static function renderTopMini() {
        return [
            'app-admin' => [
                Url::to(['/users/index']) => ['name' => 'Пользователи', 'access' => 'mainPageModeration'],
            ],
            'rbac' => [
                Url::to(['/rbac/roles/index']) => ['name' => 'Роли', 'access' => 'rbac'],
                Url::to(['/rbac/assignments/index']) => ['name' => 'Связи', 'access' => 'rbac'],
                Url::to(['/rbac/legacy/index']) => ['name' => 'Наследования', 'access' => 'rbac'],
                Url::to(['/rbac/rules/index']) => ['name' => 'Правила', 'access' => 'rbac'],
            ],
            'cms' => [
                Url::to(['/cms/femida']) => ['name' => 'Femida.Force', 'access' => 'cms'],
                Url::to(['/cms/skill']) => ['name' => 'Skill.Force', 'access' => 'cms'],
                Url::to(['/cms/general']) => ['name' => 'Главная', 'access' => 'cms'],
                Url::to(['/cms/femida/news/index']) => ['name' => 'Новости', 'access' => 'cms'],
            ],
            'lead-force' => [
                Url::to(['/lead-force/leads/index']) => ['name' => 'Лиды', 'access' => 'lead-force'],
                Url::to(['/lead-force/clients/index']) => ['name' => 'Клиенты', 'access' => 'lead-force'],
                Url::to(['/lead-force/main/offers']) => ['name' => 'Офферы', 'access' => 'global-lead-force'],
                Url::to(['/lead-force/integrations/index']) => ['name' => 'Интеграции', 'access' => 'lead-force'],
                Url::to(['/lead-force/lead-templates/index']) => ['name' => 'Шаблоны', 'access' => 'global-lead-force'],
                Url::to(['/lead-force/sources/index']) => ['name' => 'Источники', 'access' => 'lead-force'],
            ],
            'skill-force' => [
                Url::to(['/skill-force/main/constructor']) => ['name' => 'Конструктор курсов', 'access' => 'skill-force'],
            ],
            'dev-force' => [
                Url::to(['/dev-force/main/constructor']) => ['name' => 'Конструктор курсов', 'access' => 'dev-force'],
            ],
            'contact-center' => [
                Url::to(['/contact-center/main/leads?type=dolgi']) => ['name' => 'Лиды КЦ', 'access' => 'ccOperations'],
                Url::to(['/contact-center/fields/index']) => ['name' => 'Поля лидов', 'access' => 'contactCenter'],
                Url::to(['/contact-center/statistics/index']) => ['name' => 'Статистика', 'access' => 'contactCenter'],
                Url::to(['/contact-center/settings/index']) => ['name' => 'Настройки', 'access' => 'contactCenter'],
            ],
            'logs' => [
                Url::to(['/logs/main/cron']) => ['name' => 'Лог CRON', 'access' => 'logs'],
                Url::to(['/logs/main/sent']) => ['name' => 'Лог отправки', 'access' => 'logs'],
                Url::to(['/logs/main/input']) => ['name' => 'Лог входящих', 'access' => 'logs'],
                Url::to(['/logs/budget/index']) => ['name' => 'Лог баланса', 'access' => 'logs'],
            ],
            'femida' => [
                Url::to(['/cms/femida/map/index']) => ['name' => 'Партнеры', 'access' => 'cms'],
                Url::to(['/cms/femida/franchise/main/index']) => ['name' => 'Франшизы', 'access' => 'cms'],
            ],
            'franchise' => [
                Url::to(['/cms/femida/franchise/add/index']) => ['name' => 'Франшизы', 'access' => 'cms'],
                Url::to(['/cms/femida/franchise/package/index']) => ['name' => 'Пакеты', 'access' => 'cms'],
                Url::to(['/cms/femida/franchise/technologies/index']) => ['name' => 'Технологии', 'access' => 'cms'],
                Url::to(['/cms/femida/franchise/reviews/index']) => ['name' => 'Отзывы', 'access' => 'cms'],
                Url::to(['/cms/femida/franchise/cases/index']) => ['name' => 'Кейсы', 'access' => 'cms'],
            ],
            'support' => [
                Url::to(['/support/dialogues/index']) => ['name' => 'Тикеты', 'access' => 'supportAccess'],
                Url::to(['/support/notices/index']) => ['name' => 'Уведомления', 'access' => 'supportAccess'],
            ],
            'settings' => [
                Url::to(['/settings/systemd/index']) => ['name' => 'Фоновые процессы', 'access' => 'settingsAccess'],
            ],
        ];
    }


}