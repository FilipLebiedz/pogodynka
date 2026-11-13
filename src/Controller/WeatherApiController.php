<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpFoundation\Response;
use App\Service\WeatherUtil;
use App\Entity\Forcast;

final class WeatherApiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api', methods: ['GET'])]
    public function index(        
        #[MapQueryParameter] string $country,
        #[MapQueryParameter] string $name,
        WeatherUtil $weatherUtil,
        #[MapQueryParameter] string $format,
        #[MapQueryParameter('twig')] bool $twig = false,
        ): Response {
        if (!in_array($format, ['json', 'csv'], true)) {
            return new Response('Invalid format', 400);
        }

        $forcasts = $weatherUtil->getWeatherForCountryAndCity($country, $name);

if ($twig) {
    $response = $this->render("weatherapi/index.$format.twig", [
        'city' => $name,
        'country' => $country,
        'forcasts' => $forcasts,
    ]);
    return $response;
}

        if ($format === 'csv') {
            $lines = ['name,country,date,temperature °C,temperature °F,humidity,perceived temperature,wind speed'];
            foreach ($forcasts as $f) {
                $lines[] = sprintf(
                    '%s,%s,%s,%s,%s,%s,%s',
                    $name,
                    $country,
                    $f->getDate()->format('Y-m-d'),
                    $f->getTemperature(),
                    $f->getFahrenheit(),
                    $f->getHumidity(),
                    $f->getPerceivedTemperature(),
                    $f->getWind()
                );
            }

    return new Response(implode("\n", $lines), 200, [
        'Content-Type' => 'text/plain; charset=UTF-8',
    ]);
        }

        $forcast = array_map(fn(Forcast $f) => [
            'date' => $f->getDate()->format('Y-m-d'),
            'temperature °C' => $f->getTemperature(),
            'temperature °F' => $f->getFahrenheit(),
            'humidity' => $f->getHumidity(),
            'perceived_temperature' => $f->getPerceivedTemperature(),
            'wind' => $f->getWind(),
        ], $forcasts);

        return $this->json([
            'name' => $name,
            'country' => $country,
            'forcast' => $forcast,
        ]);
    }
}
