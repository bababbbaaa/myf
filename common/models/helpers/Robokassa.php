<?php


namespace common\models\helpers;


/**
 * Class Robokassa
 * @package common\models\helpers
 * @property float $price
 * @property string $description
 * @property string $crc
 * @property integer $test
 * @property string $url
 * @property integer $invoice
 * @property array $shp
 * @property array $receipt
 */
class Robokassa
{

    const
        /*SHOP_ID = 'myforce',
        PASSWORD_MAIN_1 = "n8HAjEK3P7aA1gpH9GDS",
        PASSWORD_MAIN_2 = "NZVh9hizjnf6B83AxK3g",
        PASSWORD_TEST_1 = "WjDv6NYaDBW2i5J8zMP7",
        PASSWORD_TEST_2 = "K7m46S5WsHF9kyQweFKD",*/
        SHOP_ID = 'LawBusinessShop',
        PASSWORD_MAIN_1 = "Osm6fNLDwEfFJSvw2585",
        PASSWORD_MAIN_2 = "JL89uorzJd4Lg7G9hIGA",
        PASSWORD_TEST_1 = "poZj8Np1e57DHqt0zpoq",
        PASSWORD_TEST_2 = "WL8ThT442x2CXulVmIHh",
        DEFAULT_INVOICE = 0;

    public
        $price,
        $description,
        $crc,
        $test,
        $url,
        $invoice = self::DEFAULT_INVOICE,
        $shp,
        $receipt;

    public function __construct(Array $data)
    {
        if (!empty($data['price']))
            $this->price = $data['price'];
        if (!empty($data['description']))
            $this->description = $data['description'];
        if (!empty($data['test']))
            $this->test = $data['test'];
        if (!empty($data['shp'])) {
            ksort($data['shp']);
            $this->shp = $data['shp'];
        }
        $this->receipt = [
            'sno' => 'osn',
            'items' => [
                [
                    'name' => "Покупка доступа к информационной базе MYFORCE",
                    'quantity' => 1,
                    'sum' => $this->price,
                    "payment_method" => "full_payment",
                    "payment_object" => "payment",
                    "tax" => "none",
                ],
            ]
        ];
    }

    public function create__pay__link() {
        if (!empty($this->shp)) {
            $additional = http_build_query($this->shp);
        } else {
            $additional = null;
        }
        if ($this->test === 1)
            $pass = self::PASSWORD_TEST_1;
        else
            $pass = self::PASSWORD_MAIN_1;
        $jsonReceipt = json_encode($this->receipt, JSON_UNESCAPED_UNICODE);
        $receiptUrl = urlencode($jsonReceipt);
        $defaultCRC = self::SHOP_ID . ":{$this->price}:{$this->invoice}:{$jsonReceipt}:{$pass}";
        if (!empty($this->shp)) {
            foreach ($this->shp as $key => $item)
                $defaultCRC .= ":{$key}={$item}";
        }
        $this->crc = md5($defaultCRC);
        if($this->test === 1) {
            if (!empty($additional))
                $this->url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=". self::SHOP_ID ."&OutSum={$this->price}&InvId={$this->invoice}&Description={$this->description}&Receipt={$receiptUrl}&SignatureValue={$this->crc}&IsTest={$this->test}&{$additional}";
            else
                $this->url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=". self::SHOP_ID ."&OutSum={$this->price}&InvId={$this->invoice}&Description={$this->description}&Receipt={$receiptUrl}&SignatureValue={$this->crc}&IsTest={$this->test}";
        }
        else {
            if (!empty($additional))
                $this->url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=". self::SHOP_ID ."&OutSum={$this->price}&InvId={$this->invoice}&Description={$this->description}&Receipt={$receiptUrl}&SignatureValue={$this->crc}&{$additional}";
            else
                $this->url = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=". self::SHOP_ID ."&OutSum={$this->price}&InvId={$this->invoice}&Description={$this->description}&Receipt={$receiptUrl}&SignatureValue={$this->crc}";
        }
    }

}