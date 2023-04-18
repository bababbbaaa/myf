<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "au_client".
 *
 * @property int $id
 * @property string|null $FIO
 * @property int $user_id
 * @property string|null $Nkad
 * @property string|null $au_name_text
 * @property int $RaspCheck
 * @property string|null $RaspDate
 * @property float|null $PMzp
 * @property float|null $PMch
 * @property float|null $PMsc
 * @property float|null $PMpr
 * @property float $PMall
 * @property float $sumZP
 * @property string|null $BflDate
 * @property float $Pmreg
 * @property string|null $FinDate
 * @property string|null $RealDate
 * @property float $ZPSUM
 * @property string|null $ZPDateD
 * @property float $PNSUM
 * @property string|null $PNDateD
 * @property float $SCSUM
 * @property string|null $SCDateD
 * @property float $PRSUM
 * @property string|null $PRDateD
 * @property float $DHALL
 * @property int|null $ZPMet
 * @property int|null $PNMet
 * @property int|null $SCMet
 * @property int|null $PRMet
 * @property string|null $DayW
 * @property float $SumW
 * @property string|null $DayPM
 * @property float $SumPM
 * @property float|null $DutPM
 * @property float $DutMe
 * @property float $CosAY
 * @property float $SaleKM
 * @property float $RemAY
 * @property float $SobKM
 * @property float $RasPM
 * @property string|null $Kom
 * @property string|null $month
 * @property float $SumGlobal
 * @property float $PMGlobal
 * @property float $KMGlobal
 * @property float $DutGlobal
 * @property float $CosGlobal
 * @property float $SaleGlobal
 * @property float $RemGlobal
 * @property float $RasGlobal
 * @property string|null $month_status
 * @property float $pubSUM
 * @property string|null $pubDATE
 * @property string|null $depDATE
 * @property string|null $part
 * @property string|null $recface
 * @property string|null $bankall
 * @property string|null $global_status
 */
class AuClient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'au_client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'RaspCheck', 'ZPMet', 'PNMet', 'SCMet', 'PRMet'], 'integer'],
            [['RaspDate', 'BflDate', 'FinDate', 'RealDate', 'ZPDateD', 'PNDateD', 'SCDateD', 'PRDateD', 'DayW', 'DayPM', 'pubDATE', 'depDATE'], 'safe'],
            [['PMzp', 'PMch', 'PMsc', 'PMpr', 'PMall', 'sumZP', 'Pmreg', 'ZPSUM', 'PNSUM', 'SCSUM', 'PRSUM', 'DHALL', 'SumW', 'SumPM', 'DutPM', 'DutMe', 'CosAY', 'SaleKM', 'RemAY', 'SobKM', 'RasPM', 'SumGlobal', 'PMGlobal', 'KMGlobal', 'DutGlobal', 'CosGlobal', 'SaleGlobal', 'RemGlobal', 'RasGlobal', 'pubSUM'], 'number'],
            [['Kom', 'month', 'part', 'recface', 'bankall'], 'string'],
            [['FIO', 'Nkad', 'month_status', 'global_status', 'au_name_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'FIO' => 'Fio',
            'user_id' => 'User ID',
            'Nkad' => 'Nkad',
            'RaspCheck' => 'Rasp Check',
            'RaspDate' => 'Rasp Date',
            'PMzp' => 'P Mzp',
            'PMch' => 'P Mch',
            'PMsc' => 'P Msc',
            'PMpr' => 'P Mpr',
            'PMall' => 'P Mall',
            'sumZP' => 'Sum Zp',
            'BflDate' => 'Bfl Date',
            'Pmreg' => 'Pmreg',
            'FinDate' => 'Fin Date',
            'RealDate' => 'Real Date',
            'ZPSUM' => 'Zpsum',
            'ZPDateD' => 'Zp Date D',
            'PNSUM' => 'Pnsum',
            'PNDateD' => 'Pn Date D',
            'SCSUM' => 'Scsum',
            'SCDateD' => 'Sc Date D',
            'PRSUM' => 'Prsum',
            'PRDateD' => 'Pr Date D',
            'DHALL' => 'Dhall',
            'ZPMet' => 'Zp Met',
            'PNMet' => 'Pn Met',
            'SCMet' => 'Sc Met',
            'PRMet' => 'Pr Met',
            'DayW' => 'Day W',
            'SumW' => 'Sum W',
            'DayPM' => 'Day Pm',
            'SumPM' => 'Sum Pm',
            'DutPM' => 'Dut Pm',
            'DutMe' => 'Dut Me',
            'CosAY' => 'Cos Ay',
            'SaleKM' => 'Sale Km',
            'RemAY' => 'Rem Ay',
            'SobKM' => 'Sob Km',
            'RasPM' => 'Ras Pm',
            'Kom' => 'Kom',
            'month' => 'Month',
            'SumGlobal' => 'Sum Global',
            'PMGlobal' => 'Pm Global',
            'KMGlobal' => 'Km Global',
            'DutGlobal' => 'Dut Global',
            'CosGlobal' => 'Cos Global',
            'SaleGlobal' => 'Sale Global',
            'RemGlobal' => 'Rem Global',
            'RasGlobal' => 'Ras Global',
            'month_status' => 'Month Status',
            'pubSUM' => 'Pub Sum',
            'pubDATE' => 'Pub Date',
            'depDATE' => 'Dep Date',
            'part' => 'Part',
            'recface' => 'Recface',
            'bankall' => 'Bankall',
            'global_status' => 'Global Status',
        ];
    }
}
