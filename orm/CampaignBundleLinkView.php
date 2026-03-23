<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

use Tina4\ORM;

/**
 * Class CampaignBundleLinkView Used to generate the ORM for the dbo.CampaignBundleLinkView table in the database
 */
class CampaignBundleLinkView extends ORM
{
    public $tableName = "CampaignBundleLinkView";
    public $primaryKey = "id";

    public $id;
    public $campaignId;
    public $campaignName;
    public $couponBundleId;
    public $couponBundleName;
    public $maxUses;
    public $priceIncl;
    public $campaignHasLimit;
    public $stockLeft;

    public $dateCreated;
}