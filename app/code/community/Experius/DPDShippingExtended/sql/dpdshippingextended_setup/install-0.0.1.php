<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection()->addColumn($this->getTable('sales_flat_quote_item'), 'exclude_dpdpickup', 'varchar(255) NOT NULL');
$installer->endSetup();
