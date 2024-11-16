<?php

namespace App\Service;

use Random\RandomException;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PasswordService
{

    public function __construct()
    {
    }

    /**
     * @param int $length
     * @return string|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function generatePassword(int $length = 8): ?string
    {
        // 1. Faire une requête HTTP pour récupérer le contenu HTML
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://password.markei.nl/human?removeLO=true&numberLength=8');

        // Vérifiez si la réponse est valide
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Erreur lors de la récupération de la page HTML.');
        }

        // Récupérer le contenu HTML
        $html = $response->getContent();

        // 2. Utiliser le Crawler pour analyser le contenu HTML
        $crawler = new Crawler($html);

        // 3. Sélectionner le premier élément <li>
        $firstLi = $crawler->filter('ul > li')->first();

        // 4. Retourner le contenu texte du premier <li> s'il existe
        return $firstLi->count() > 0 ? $firstLi->text() : null;
    }

}