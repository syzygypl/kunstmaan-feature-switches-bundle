<?php

namespace SZG\KunstmaanFeatureSwitchesBundle\AdminList;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Kunstmaan\AdminBundle\Helper\Security\Acl\AclHelper;
use Kunstmaan\AdminListBundle\AdminList\BulkAction\SimpleBulkAction;
use Kunstmaan\AdminListBundle\AdminList\Configurator\AbstractDoctrineORMAdminListConfigurator;
use Kunstmaan\AdminListBundle\AdminList\FilterType\ORM;
use SZG\KunstmaanFeatureSwitchesBundle\Form\FeatureSwitchAdminType;

/**
 * The admin list configurator for FeatureSwitch
 */
class FeatureSwitchAdminListConfigurator extends AbstractDoctrineORMAdminListConfigurator
{
    /**
     * @param EntityManager|ObjectManager $em The entity manager
     * @param AclHelper $aclHelper The acl helper
     */
    public function __construct(EntityManager $em, AclHelper $aclHelper = null)
    {
        parent::__construct($em, $aclHelper);
        $this->setAdminType(FeatureSwitchAdminType::class);
        $bulkPath = ['path' => 'kunstmaanfeatureswitchesbundle_admin_featureswitch_bulk_enable', 'params' => []];
        $this->addBulkAction(new SimpleBulkAction($bulkPath, "Enable selected", "play"));

        $bulkPath = ['path' => 'kunstmaanfeatureswitchesbundle_admin_featureswitch_bulk_disable', 'params' => []];
        $this->addBulkAction(new SimpleBulkAction($bulkPath, "Disable selected", "pause"));
    }

    public function canAdd()
    {
        return false;
    }

    public function canEdit($item)
    {
        return false;
    }

    public function canDelete($item)
    {
        return false;
    }

    /**
     * Configure the visible columns
     */
    public function buildFields()
    {
        $this->addField('name', 'Feature', true);
        $this->addField('code', 'Feature code', true);
        $this->addField('enabled', 'Is enabled', true, 'KunstmaanFeatureSwitchesBundle:AdminList\fields:bool.html.twig');
    }

    /**
     * Build filters for admin list
     */
    public function buildFilters()
    {
        $this->addFilter('name', new ORM\StringFilterType('title'), 'Name');
        $this->addFilter('code', new ORM\StringFilterType('code'), 'Code');
        $this->addFilter('enabled', new ORM\StringFilterType('enabled'), 'Is enabled?');
    }

    /**
     * Get bundle name
     *
     * @return string
     */
    public function getBundleName()
    {
        return 'KunstmaanFeatureSwitchesBundle';
    }

    /**
     * Get entity name
     *
     * @return string
     */
    public function getEntityName()
    {
        return 'FeatureSwitch';
    }

}
