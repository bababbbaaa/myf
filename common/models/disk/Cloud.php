<?php


namespace common\models\disk;


use common\models\User;
use common\models\UsersBills;
use common\models\UsersCertificates;
use common\models\UsersProviderUploads;
use FilesystemIterator;
use PhpOffice\PhpWord\TemplateProcessor;

class Cloud
{

    const MAX_FILE_SIZE = 3097152;

    public static $mimes = [
        'pdf' => 'application/pdf',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
    ];

    public $userPath = "/home/master/web/myforce.ru/public_html/admin/web/uploads/cloud/users";
    public $path;
    public $user;
    public $downloadPath = "/uploads/cloud/users";

    private $default_validators = [
        'provider_report_signed' => ['jpg', 'jpeg', 'png', 'pdf'],
        'provider_outcome_signed' => ['jpg', 'jpeg', 'png', 'pdf'],
    ];

    const WEB_PATH = "/home/master/web/myforce.ru/public_html/admin/web";

    public function __construct($id)
    {
        $this->user = User::findOne($id);
        if (empty($this->user))
            throw new \Exception("Пользователь не найден", 404);
    }

    public function set__path($type) {
        $this->path = $this->userPath . "/{$this->user->id}/{$type}";
        $this->downloadPath = "/uploads/cloud/users" . "/{$this->user->id}/{$type}";
        if (is_dir($this->path))
            return true;
        else {
            return mkdir($this->path, 0755, true);
        }
    }

    public function move__file($fileName, $data) {
        if (file_exists($fileName)) {
            unlink($fileName);
        }
        return move_uploaded_file($data, $fileName);
    }

    public function new__file__name($type, $ext) {
        $fi = new FilesystemIterator($this->path, FilesystemIterator::SKIP_DOTS);
        $index = iterator_count($fi) + 1;
        return "{$type}_{$this->user->id}_" . date("d-m-Y-H-i-s") . "_{$index}.{$ext}";
    }

    public function validate__and__save($file, $type) {
        if ($file['size'] > self::MAX_FILE_SIZE)
            return ['status' => 'error', 'message' => 'Максимально допустимый размер файла - 3 МБ'];
        $path = pathinfo($file['name']);
        if (!$this->set__path($type))
            return ['status' => 'error', 'message' => 'Ошибка загрузки файла'];
        $ext = $path['extension'];
        $filename = $this->new__file__name($type, $ext);
        if (!in_array($path['extension'], $this->default_validators[$type]))
            return ['status' => 'error', 'message' => 'Недопустимый формат файла'];
        $temp_name = $file['tmp_name'];
        $path_filename_ext = "{$this->path}/{$filename}";
        $this->downloadPath = "{$this->downloadPath}/{$filename}";
        $this->move__file($path_filename_ext, $temp_name);
        if (file_exists($path_filename_ext))
            return ['download' => $this->downloadPath, 'real' => $path_filename_ext];
        else
            return ['status' => 'error', 'message' => 'Ошибка перемещения временного файла'];
    }

    public static function getMonthText($m) {
        switch ($m) {
            case '01':
                $response = 'января';
                break;
            case '02':
                $response = 'февраля';
                break;
            case '03':
                $response = 'марта';
                break;
            case '04':
                $response = 'апреля';
                break;
            case '05':
                $response = 'мая';
                break;
            case '06':
                $response = 'июня';
                break;
            case '07':
                $response = 'июля';
                break;
            case '08':
                $response = 'августа';
                break;
            case '09':
                $response = 'сентября';
                break;
            case '10':
                $response = 'октября';
                break;
            case '11':
                $response = 'ноября';
                break;
            case '12':
                $response = 'декабря';
                break;
        }
        return $response;
    }

    public static function morph($n, $f1, $f2, $f5) {
        $n = abs(intval($n)) % 100;
        if ($n>10 && $n<20) return $f5;
        $n = $n % 10;
        if ($n>1 && $n<5) return $f2;
        if ($n==1) return $f1;
        return $f5;
    }

    public static function getTextByPrice($num) {
        $nul='ноль';
        $ten=array(
            array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
            array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
        );
        $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
        $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
        $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',	 1),
            array('рубль'   ,'рубля'   ,'рублей'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
        //
        list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
        $out = array();
        if (intval($rub)>0) {
            foreach(str_split($rub,3) as $uk=>$v) {
                if (!intval($v)) continue;
                $uk = sizeof($unit)-$uk-1;
                $gender = $unit[$uk][3];
                list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
                $out[] = $hundred[$i1];
                if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3];
                else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3];
                if ($uk>1) $out[]= self::morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
            }
        }
        else $out[] = $nul;
        $out[] = self::morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]);
        $out[] = $kop.' '.self::morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]);
        return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
    }

    public function create__bill($reqs, $value) {
        $bills = UsersBills::find()
            ->orderBy('id desc')
            ->select('id')
            ->one();
        if (!empty($bills))
            $postfix = $bills->id + 1;
        else
            $postfix = 1;
        $template = new TemplateProcessor('/home/master/web/myforce.ru/public_html/user/web/templates/template_processor.docx');
        $default = "Пополнение баланса личного кабинета пользователя на сумму {$value} руб.";
        $arrayOfSet = [
            'price' => $value,
            'inn' => $reqs['inn'],
            'bik' => $reqs['bik'],
            'kpp' => $reqs['kpp'],
            'corr_sch' => $reqs['ks'],
            'org_name' => $reqs['organization'],
            'address' => $reqs['jur_address'],
            'corr_address' => $reqs['real_address'],
            'bank_name' => $reqs['bank'],
            'rs_sch' => $reqs['rs'],
            'id' => "{$this->user->id}-" . $postfix,
            'day' => date('d'),
            'month' => self::getMonthText(date('m')),
            'year' => date('Y'),
            'text_desc' => $default,
            'price_text' => self::getTextByPrice($value),
        ];
        $template->setValues($arrayOfSet);
        $arrayOfSet['director'] = $reqs['director'];
        $arrayOfSet['ogrn'] = $reqs['ogrn'];
        $fileName = "bill_".date("d-m-Y__H-i-s")."__{$arrayOfSet['id']}.docx";
        if ($this->set__path('bills') !== false) {
            $real = "{$this->path}/{$fileName}";
            $this->downloadPath = "{$this->downloadPath}/{$fileName}";
            $template->saveAs($real);
            return ['download' => $this->downloadPath, 'real' => $this->path, 'responseData' => $arrayOfSet];
        } else
            return ['error'];
    }

    public function create__bill__bot($reqs, $value) {
        $template = new TemplateProcessor('/home/master/web/myforce.ru/public_html/api/web/templates/' . $reqs['type']);
        $arrayOfSet = [
            'price' => $value,
            'inn' => $reqs['inn'],
            'kpp' => $reqs['kpp'],
            'org_name' => $reqs['org_name'],
            'address' => $reqs['address'],
            'id' => $reqs['id'],
            'day' => $reqs['day'],
            'month' => $reqs['month'],
            'year' => $reqs['year'],
            'text_desc' => $reqs['text_desc'],
            'price_text' => self::getTextByPrice($value),
        ];
        $template->setValues($arrayOfSet);
        $fileName = "1_{$reqs['type']}";
        if ($this->set__path('bills') !== false) {
            $real = "{$this->path}/{$fileName}";
            $this->downloadPath = "{$this->downloadPath}/{$fileName}";
            $template->saveAs($real);
            return ['download' => $this->downloadPath, 'real' => $this->path, 'responseData' => $arrayOfSet];
        } else
            return ['error'];
    }

    public function create__jur__act($data__set) {
        $acts = UsersCertificates::find()->orderBy('id desc')->select('id')->one();
        if (!empty($acts))
            $postfix = $acts->id + 1;
        else
            $postfix = 1;
        $template = new TemplateProcessor('/home/master/web/myforce.ru/public_html/admin/web/templates/template_act_jur.docx');
        $arrayOfSet = [
            'price' => number_format($data__set['price'], 2, ',', ' '),
            'company' => $data__set['org_name'],
            'boss' => $data__set['director'],
            'billdate' => "{$data__set['day']} {$data__set['month']} {$data__set['year']}",
            'price_text' => self::getTextByPrice($data__set['price']),
            'address' => $data__set['address'],
            'address2' => $data__set['corr_address'],
            'bank' => $data__set['bank_name'],
            'rs' => $data__set['rs_sch'],
            'ks' => $data__set['corr_sch'],
            'bik' => $data__set['bik'],
            'inn' => $data__set['inn'],
            'ogrn' => $data__set['ogrn'],
            'kpp' => $data__set['kpp'],
            'id' => "№{$data__set['id']}",
        ];
        $template->setValues($arrayOfSet);
        $fileName = "act_".date("d-m-Y__H-i-s")."__{$arrayOfSet['id']}__{$postfix}.docx";
        if ($this->set__path('acts') !== false) {
            $real = "{$this->path}/{$fileName}";
            $this->downloadPath = "{$this->downloadPath}/{$fileName}";
            $template->saveAs($real);
            return ['download' => $this->downloadPath, 'real' => $this->path];
        } else
            return ['error'];
    }

    public function create__fiz__act($data__set) {
        $acts = UsersCertificates::find()->orderBy('id desc')->select('id')->one();
        if (!empty($acts))
            $postfix = $acts->id + 1;
        else
            $postfix = 1;
        $template = new TemplateProcessor('/home/master/web/myforce.ru/public_html/api/web/templates/template_act_fiz.docx');
        $arrayOfSet = [
            'act_id' => "{$data__set['user_id']}-{$data__set['invoice']}AT",
            'invoice' => $data__set['invoice'],
            'fio' => $data__set['fio'],
            'address' => $data__set['address'],
            'email' => $data__set['email'],
            'phone' => $data__set['phone'],
            'date' => " " . date("d.m.Y"),
            'price' => $data__set['price']
        ];
        $template->setValues($arrayOfSet);
        $fileName = "act_".date("d-m-Y__H-i-s")."__№{$arrayOfSet['act_id']}__{$postfix}.docx";
        if ($this->set__path('acts') !== false) {
            $real = "{$this->path}/{$fileName}";
            $this->downloadPath = "{$this->downloadPath}/{$fileName}";
            $template->saveAs($real);
            return ['download' => $this->downloadPath, 'real' => $this->path];
        } else
            return ['error'];
    }

    public function create__provider__files($data__set) {
        $countFiles = UsersProviderUploads::find()
            ->where(['user_id' => $this->user->id])
            ->andWhere('CURDATE() < date + INTERVAL 1 MONTH')
            ->count();
        if ($countFiles >= 2)
            return ['status' => 'error', 'message' => 'Не более 2 выводов средств в месяц. Попробуйте совершить операцию позже.'];
        $files = UsersProviderUploads::find()->orderBy('id desc')->select('id')->one();
        if (!empty($files))
            $postfix = $files->id + 1;
        else
            $postfix = 1;
        $template = new TemplateProcessor('/home/master/web/myforce.ru/public_html/user/web/templates/template_provider_report.docx');
        $template->setValues([]);
        $fileName = "provider_report_".date("d-m-Y__H-i-s")."__{$postfix}.docx";
        if ($this->set__path('provider_reports') !== false) {
            $real = "{$this->path}/{$fileName}";
            $this->downloadPath = "{$this->downloadPath}/{$fileName}";
            $template->saveAs($real);
            $arrResult = ['download_report' => $this->downloadPath, 'real_report' => $this->path];
            if ($data__set['type'] === 'fiz')
                return array_merge($arrResult, ['status' => 'success']);
            else {
                $template = new TemplateProcessor('/home/master/web/myforce.ru/public_html/user/web/templates/template_provider_outcome.docx');
                $template->setValues([]);
                $fileName = "provider_outcome_".date("d-m-Y__H-i-s")."__{$postfix}.docx";
                if ($this->set__path('provider_outcomes') !== false) {
                    $real = "{$this->path}/{$fileName}";
                    $this->downloadPath = "{$this->downloadPath}/{$fileName}";
                    $template->saveAs($real);
                    $arrResult = array_merge($arrResult, ['status' => 'success', 'download_outcome' => $this->downloadPath, 'real_outcome' => $this->path]);
                    return $arrResult;
                } else
                    return ['error', 'message' => 'Ошибка сохранения файла счета'];
            }
        } else
            return ['error', 'message' => 'Ошибка сохранения файла отчета'];
    }

    public function create__new__provider__upload() {

    }


}