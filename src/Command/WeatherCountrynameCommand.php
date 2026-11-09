<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'weather:countryname',
    description: 'Add a short description for your command',
)]
class WeatherCountrynameCommand{
    public function __construct(
        private LocationRepository $locationRepository,
        private WeatherUtil $weatherUtil,
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Country')] string $country,
        #[Argument('Name')] string $name,
    ): int {

        $measurements = $this->weatherUtil->getWeatherForCountryAndCity($country, $name);
        $io->writeln(sprintf('Location: %s', $name));
        $io->table(['Date', 'Temperature','Humidity','Wind speed','Perceived temperature'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
            $m->getHumidity(),
            $m->getWind(),
            $m->getPerceivedTemperature(),
        ], $measurements));

        return Command::SUCCESS;
    }
}
