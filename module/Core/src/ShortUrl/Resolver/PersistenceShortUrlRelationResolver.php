<?php

declare(strict_types=1);

namespace Shlinkio\Shlink\Core\ShortUrl\Resolver;

use Doctrine\ORM\EntityManagerInterface;
use Shlinkio\Shlink\Core\Entity\Domain;
use Shlinkio\Shlink\Rest\Entity\ApiKey;

class PersistenceShortUrlRelationResolver implements ShortUrlRelationResolverInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function resolveDomain(?string $domain): ?Domain
    {
        if ($domain === null) {
            return null;
        }

        /** @var Domain|null $existingDomain */
        $existingDomain = $this->em->getRepository(Domain::class)->findOneBy(['authority' => $domain]);
        return $existingDomain ?? new Domain($domain);
    }

    public function resolveApiKey(?string $key): ?ApiKey
    {
        if ($key === null) {
            return null;
        }

        /** @var ApiKey|null $existingApiKey */
        $existingApiKey = $this->em->getRepository(ApiKey::class)->findOneBy(['key' => $key]);
        return $existingApiKey;
    }
}
