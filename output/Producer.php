<?php
namespace App\Struct;

/**
 * @property integer $id
 * @property string $prefix
 * @property App\Struct\Contract $contract
 * @property string $name
 * @property App\Struct\Details $details
 * @property string $website
 * @property boolean $fixed
 * @property boolean $hasCancelledContract
 * @property string $iconPath
 * @property boolean $iconIsSet
 * @property string $shopwareId
 * @property integer $userId
 * @property integer $companyId
 * @property string $companyName
 * @property string $saleMail
 * @property string $supportMail
 * @property string $ratingMail
 * @property string $iconUrl
 * @property NULL $cancelledContract
 */
class Producer extends Struct
{

    public $id = null;

    public $prefix = null;

    public $contract = null;

    public $name = null;

    public $details = null;

    public $website = null;

    public $fixed = null;

    public $hasCancelledContract = null;

    public $iconPath = null;

    public $iconIsSet = null;

    public $shopwareId = null;

    public $userId = null;

    public $companyId = null;

    public $companyName = null;

    public $saleMail = null;

    public $supportMail = null;

    public $ratingMail = null;

    public $iconUrl = null;

    public $cancelledContract = null;

    public static $mappedFields = [
        'contract' => 'App\\Struct\\Contract',
        'details' => 'App\\Struct\\Details',
    ];


}
