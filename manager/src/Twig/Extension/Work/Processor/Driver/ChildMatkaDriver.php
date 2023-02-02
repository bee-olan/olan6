<?php

declare(strict_types=1);

namespace App\Twig\Extension\Work\Processor\Driver;

//use App\ReadModel\Work\Projects\ChildMatka\ChildMatkaFetcher;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;
use Twig\Environment;

class ChildMatkaDriver implements Driver
{
    private const PATTERN = '/\#\d+/';

    private $childmatkas;
    private $twig;

    public function __construct(ChildSideFetcher $childmatkas, Environment $twig)
    {
        $this->childmatkas = $childmatkas;
        $this->twig = $twig;
    }

    public function process(string $text): string
    {
        return preg_replace_callback(self::PATTERN, function (array $matches) {
            $id = ltrim($matches[0], '#');
            if (!$childmatka = $this->childmatkas->find($id)) {
                return $matches[0];
            }
            return $this->twig->render('processor/work/childmatka.html.twig', [
                'childmatka' => $childmatka,
            ]);
        }, $text);
    }
}
