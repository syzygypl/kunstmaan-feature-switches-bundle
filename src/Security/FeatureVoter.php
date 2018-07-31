<?php

namespace SZG\KunstmaanFeatureSwitchesBundle\Security;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use SZG\KunstmaanFeatureSwitchesBundle\Entity\FeatureSwitch;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class FeatureVoter extends Voter
{

    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function supports($attribute, $subject)
    {
        return ($subject === 'feature');
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $featureSwitch = $this->repository->findOneBy(['code' => $attribute]);

        return $featureSwitch instanceof FeatureSwitch && $featureSwitch->isEnabled();
    }

}
