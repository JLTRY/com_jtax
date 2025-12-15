<?php

/***[JCBGUI.power.licensing_template.11.$$$$]***/
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
/***[/JCBGUI$$$$]***/

namespace JCB\Joomla\Jtax;


use JCB\Joomla\Interfaces\TableInterface;
use JCB\Joomla\Abstraction\BaseTable;


/**
 * Jtax Tables
 * 
 * @since 3.2.0
 */
final class Table extends BaseTable implements TableInterface
{

/***[JCBGUI.power.main_class_code.11.$$$$]***/
    /**
     * All areas/views/tables with their field details
     *
     * @var     array
     * @since 3.2.0
     **/
    protected array $tables = [
        'impot' => [
            'name' => [
                'name' => 'name',
                'guid' => '2707db98-28f2-485b-9344-8287427c00ab',
                'label' => 'COM_JTAX_IMPOT_NAME_LABEL',
                'type' => 'text',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'VARCHAR(255)',
                    'default' => '',
                    'GUID' => '2707db98-28f2-485b-9344-8287427c00ab',
                    'null_switch' => 'NULL',
                    'unique_key' => false,
                    'key' => true,
                ],
                'link' => NULL,
            ],
            'year' => [
                'name' => 'year',
                'guid' => 'a91a83e1-2e9c-4ca0-b80c-adc35101e59c',
                'label' => 'COM_JTAX_IMPOT_YEAR_LABEL',
                'type' => 'sql',
                'title' => true,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => 'a91a83e1-2e9c-4ca0-b80c-adc35101e59c',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => true,
                ],
                'link' => NULL,
            ],
            'revenu' => [
                'name' => 'revenu',
                'guid' => 'ca0ca028-a879-4278-bed9-a02e4d48be46',
                'label' => 'Revenu net imposable',
                'type' => 'number',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => 'ca0ca028-a879-4278-bed9-a02e4d48be46',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'nbparts' => [
                'name' => 'nbparts',
                'guid' => '88b3581b-8a86-4173-a960-75e361ba2d0b',
                'label' => 'COM_JTAX_IMPOT_NBPARTS_LABEL',
                'type' => 'number',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'FLOAT(7)',
                    'default' => '1',
                    'GUID' => '88b3581b-8a86-4173-a960-75e361ba2d0b',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'deduction' => [
                'name' => 'deduction',
                'guid' => '8b808acd-c478-4b09-9f8a-83c6657761ec',
                'label' => 'COM_JTAX_IMPOT_DEDUCTION_LABEL',
                'type' => 'radio',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'TINYINT(1)',
                    'default' => '1',
                    'GUID' => '8b808acd-c478-4b09-9f8a-83c6657761ec',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'impot' => [
                'name' => 'impot',
                'guid' => '73a8bea3-8316-4b61-a3ab-54f499b41736',
                'label' => 'COM_JTAX_IMPOT_IMPOT_LABEL',
                'type' => 'textarea',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'VARCHAR(255)',
                    'default' => '',
                    'GUID' => '73a8bea3-8316-4b61-a3ab-54f499b41736',
                    'null_switch' => 'NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'dons' => [
                'name' => 'dons',
                'guid' => '536bf2df-cc9f-4d44-9c5a-9055cfae9cf0',
                'label' => 'dons aux associations',
                'type' => 'number',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => '536bf2df-cc9f-4d44-9c5a-9055cfae9cf0',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'pel' => [
                'name' => 'pel',
                'guid' => '2e0a6181-caff-4194-8ad7-eac18db38b13',
                'label' => 'placements déductibles',
                'type' => 'number',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => '2e0a6181-caff-4194-8ad7-eac18db38b13',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'fraisreels' => [
                'name' => 'fraisreels',
                'guid' => 'bed3e003-e6c7-4988-b76a-c144c77a709d',
                'label' => 'Frais Réels',
                'type' => 'number',
                'title' => false,
                'list' => 'impots',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => 'bed3e003-e6c7-4988-b76a-c144c77a709d',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'access' => [
                'name' => 'access',
                'label' => 'Access',
                'type' => 'accesslevel',
                'title' => false,
                'store' => NULL,
                'tab_name' => NULL,
                'db' => [
                    'type' => 'INT(10) unsigned',
                    'default' => '0',
                    'key' => true,
                    'null_switch' => 'NULL',
                ],
            ],
        ],
        'year' => [
            'name' => [
                'name' => 'name',
                'guid' => '5d3d34dd-4876-4c6a-86ab-b4e162f22c08',
                'label' => 'COM_JTAX_YEAR_NAME_LABEL',
                'type' => 'text',
                'title' => true,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'VARCHAR(255)',
                    'default' => '',
                    'GUID' => '5d3d34dd-4876-4c6a-86ab-b4e162f22c08',
                    'null_switch' => 'NULL',
                    'unique_key' => false,
                    'key' => true,
                ],
                'link' => NULL,
            ],
            'taux4' => [
                'name' => 'taux4',
                'guid' => '1e2a59a7-a5dd-493c-8a01-825317bed058',
                'label' => 'Taux tranche 4',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'FLOAT(7)',
                    'default' => '0',
                    'GUID' => '1e2a59a7-a5dd-493c-8a01-825317bed058',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'taux3' => [
                'name' => 'taux3',
                'guid' => '6109e4e2-5fbc-4b15-a14d-7b7aaad5a756',
                'label' => 'Taux tranche 3',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'FLOAT(7)',
                    'default' => '0',
                    'GUID' => '6109e4e2-5fbc-4b15-a14d-7b7aaad5a756',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'taux2' => [
                'name' => 'taux2',
                'guid' => '186fce64-2103-4f16-b9e3-4ad89f273942',
                'label' => 'Taux tranche 2',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'FLOAT(7)',
                    'default' => '0',
                    'GUID' => '186fce64-2103-4f16-b9e3-4ad89f273942',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'taux1' => [
                'name' => 'taux1',
                'guid' => '7957d870-0cc4-4619-b20a-ca71fd9ec132',
                'label' => 'Taux tranche 1',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'FLOAT(7)',
                    'default' => '0',
                    'GUID' => '7957d870-0cc4-4619-b20a-ca71fd9ec132',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'tranche4' => [
                'name' => 'tranche4',
                'guid' => '9ab99502-31ea-4e25-9510-7a7148fb8959',
                'label' => 'Tranche 4',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => '9ab99502-31ea-4e25-9510-7a7148fb8959',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'tranche3' => [
                'name' => 'tranche3',
                'guid' => '8b489ad0-832a-4306-8cf7-2e8538504054',
                'label' => 'Tranche 3',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => '8b489ad0-832a-4306-8cf7-2e8538504054',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'tranche2' => [
                'name' => 'tranche2',
                'guid' => '22bc4a79-b8cb-46fb-8907-0cb3f086efdd',
                'label' => 'Tranche 2',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => '22bc4a79-b8cb-46fb-8907-0cb3f086efdd',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'tranche1' => [
                'name' => 'tranche1',
                'guid' => 'c316104b-f31c-4e79-96c1-6b859f46afb9',
                'label' => 'Tranche 1',
                'type' => 'number',
                'title' => false,
                'list' => 'years',
                'store' => NULL,
                'tab_name' => 'Details',
                'db' => [
                    'type' => 'INT(64)',
                    'default' => '0',
                    'GUID' => 'c316104b-f31c-4e79-96c1-6b859f46afb9',
                    'null_switch' => 'NOT NULL',
                    'unique_key' => false,
                    'key' => false,
                ],
                'link' => NULL,
            ],
            'access' => [
                'name' => 'access',
                'label' => 'Access',
                'type' => 'accesslevel',
                'title' => false,
                'store' => NULL,
                'tab_name' => NULL,
                'db' => [
                    'type' => 'INT(10) unsigned',
                    'default' => '0',
                    'key' => true,
                    'null_switch' => 'NULL',
                ],
            ],
        ],
    ];/***[/JCBGUI$$$$]***/

}

