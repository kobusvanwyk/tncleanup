<?php
/**
 * Copyright © 2022 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

use Tina4\ORM;

/**
 * Class CouponCode Used to generate the ORM for the dbo.CouponCode table in the database
 */
class CouponCode extends ORM
{
    public $tableName = "CouponCode";
    public $primaryKey = "id";

    public $fieldMapping = [
        "id" => "Id",
        "initiative" => "Initiative",
        "code" => "Code",
        "maxUses" => "MaxUses",
        "discount" => "Discount",
        "duration" => "Duration",
        "subscriptionLevel" => "SubscriptionLevel",
        "dateCreated" => "DateCreated"
    ];

    public $id;
    public $initiative;
    public $code;
    public $maxUses;
    public $discount;
    public $duration;
    public $subscriptionLevel;

    public $dateCreated;

    public $virtualFields = ["Id"];
}