<?php
/**
 * Copyright © 2024 - Code Infinity. All right reserved.
 *
 * @author Justin Bruce <justin@codeinfinity.co.za>
 */

use Tina4\ORM;

/**
 * Class CampaignView Used to generate the ORM for the dbo.CampaignView table in the database
 */
class CampaignView extends ORM
{
    public $tableName = "CampaignView";
    public $primaryKey = "id";

    public $id;

    public $name;
    public $startDate;
    public $endDate;
    public $saleLimit;
    public $stockLeft;

    public $dateCreated;
    public $isActive;
}