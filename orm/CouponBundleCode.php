<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

use Tina4\ORM;

/**
 * Class CouponBundleCode Used to generate the ORM for the dbo.CouponBundleCode table in the database
 */
class CouponBundleCode extends ORM
{
    public $tableName = "CouponBundleCode";
    public $primaryKey = "id";

    public $id;
    public $couponId;
    public $couponBundleId;
    public $paymentIntentId;
    public $campaignId;

    public $dateCreated;
}