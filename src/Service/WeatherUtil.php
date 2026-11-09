<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Forcast;
use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;

class WeatherUtil
{

    public function __construct(private EntityManagerInterface $a)
    {
    }
    public function getWeatherForLocation(Location $location): array
    {
        $qb = $this-> a -> createQueryBuilder()
            ->select('f')
            ->from(Forcast::class, 'f')
            ->where('f.location = :location')
            ->setParameter('location', $location->getId())
            ->andWhere('f.date > :now')
            ->setParameter('now', date('Y-m-d'));

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $qb = $this-> a -> createQueryBuilder()
            ->select('l')
            ->from(Location::class, 'l')
            ->where('l.name = :city')
            ->andWhere('l.country = :countryCode')
            ->setParameter('city', $city)
            ->setParameter('countryCode', $countryCode);

        $query = $qb->getQuery();
        return $this->getWeatherForLocation($query->getOneOrNullResult());
    }
}
