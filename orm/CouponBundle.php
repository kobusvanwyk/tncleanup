<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

use Tina4\ORM;

/**
 * Class Product Used to generate the ORM for the dbo.Product table in the database
 */
class CouponBundle extends ORM
{
    public $tableName = "CouponBundle";
    public $primaryKey = "id";

    public $id;

    public $name;
    public $priceIncl;
    public $currency;
    public $subscriptionLevelId;
    public $amount;
    public $initiative;
    public $maxUses;
    public $discountId;
    public $duration;
    public $prefix;
    public $characterLength;

    public $stripeId;
    public $priceStripeId;

    public $dateCreated;
    public $isActive;
}