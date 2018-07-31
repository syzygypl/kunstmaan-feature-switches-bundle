<?php

namespace SZG\KunstmaanFeatureSwitchesBundle\Controller\AdminList;

use Doctrine\ORM\EntityManager;
use SZG\KunstmaanFeatureSwitchesBundle\Entity\FeatureSwitch;
use Kunstmaan\AdminListBundle\AdminList\Configurator\AdminListConfiguratorInterface;
use SZG\KunstmaanFeatureSwitchesBundle\AdminList\FeatureSwitchAdminListConfigurator;
use ArsThanea\KunstmaanExtraBundle\AdminList\AbstractAdminListController;
use Symfony\Component\HttpFoundation\Request;

class FeatureSwitchAdminListController extends AbstractAdminListController
{

    /**
     * @var AdminListConfiguratorInterface
     */
    private $configurator;

    /**
     * @return AdminListConfiguratorInterface
     */
    public function getAdminListConfigurator()
    {
        if (!isset($this->configurator)) {
            $this->configurator = new FeatureSwitchAdminListConfigurator($this->getEntityManager());
        }

        return $this->configurator;
    }

    public function bulkEnableAction(Request $request)
    {
        $em = $this->getEntityManager();
        $ids = $request->request->get('bulk_selection');
        if ($ids && $em instanceof EntityManager) {
            $result = $this->bulkSwitch($ids, true);
            $this->addFlash('info', sprintf('%d features have been enabled.', (int)$result));
        }

        return $this->redirectToRoute('kunstmaanfeatureswitchesbundle_admin_featureswitch');
    }

    public function bulkDisableAction(Request $request)
    {
        $em = $this->getEntityManager();
        $ids = $request->request->get('bulk_selection');
        if ($ids && $em instanceof EntityManager) {
            $result = $this->bulkSwitch($ids, false);
            $this->addFlash('info', sprintf('%d  features have been disabled.', (int)$result));
        }

        return $this->redirectToRoute('kunstmaanfeatureswitchesbundle_admin_featureswitch');
    }

    private function bulkSwitch($ids, $enable)
    {
        return $this->getEntityManager()
            ->createQueryBuilder()
            ->update(FeatureSwitch::class, 'f')
            ->set('f.enabled', ':enabled')
            ->where('f.id in (:ids)')
            ->setParameter('ids', $ids)
            ->setParameter('enabled', $enable)
            ->getQuery()
            ->execute();
    }


}
