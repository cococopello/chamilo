<?php
/* For licensing terms, see /license.txt */

namespace Chamilo\CoreBundle\Settings;

use Sylius\Bundle\SettingsBundle\Schema\SchemaInterface;
use Sylius\Bundle\SettingsBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class GroupSettingsSchema
 * @package Chamilo\CoreBundle\Settings
 */
class GroupSettingsSchema extends AbstractSettingsSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            ->setDefaults(
                array(
                    'allow_group_categories' => 'false',
                    'hide_course_group_if_no_tools_available' => 'false',
                )
            )
        ;
        $allowedTypes = array(
            'allow_group_categories' => array('string'),
        );
        $this->setMultipleAllowedTypes($allowedTypes, $builder);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('allow_group_categories', 'yes_no')
            ->add('hide_course_group_if_no_tools_available', 'yes_no');
    }
}
