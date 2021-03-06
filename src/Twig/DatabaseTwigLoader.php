<?php
// Copyright (C) 11 / 2019 | David annebicque | IUT de Troyes - All Rights Reserved
// @file /Users/davidannebicque/htdocs/intranetv3/src/Twig/DatabaseTwigLoader.php
// @author     David Annebicque
// @project intranetv3
// @date 25/11/2019 10:21
// @lastUpdate 23/11/2019 09:14

/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 07/08/2018
 * Time: 11:07
 */
namespace App\Twig;

use App\Repository\TwigTemplateRepository;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

class DatabaseTwigLoader implements LoaderInterface
{
    /** @var TwigTemplateRepository */
    private $twigTemplateRepository;

    /**
     * DatabaseTwigLoader constructor.
     *
     * @param TwigTemplateRepository $twigTemplateRepository
     */
    public function __construct(TwigTemplateRepository $twigTemplateRepository)
    {
        $this->twigTemplateRepository = $twigTemplateRepository;
    }


    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name
     *
     * @return Source
     *
     * @throws LoaderError When $name is not found
     */
    public function getSourceContext($name): Source
    {
        if (false === $source = $this->getValue($name)->getSource()) {
            throw new LoaderError(sprintf('Template "%s" does not exist.', $name));
        }

        return new Source($source, $name);
    }

    public function exists($name): bool
    {
        if ($this->getValue($name) !== null) {
            return $name === $this->getValue($name)->getName();
        }
        return false;
    }

    public function getCacheKey($name): string
    {
        return $name;
    }

    public function isFresh($name, $time): bool
    {
        if (false === $lastModified = $this->getValue($name)->getUpdated()) {
            return false;
        }

        return $lastModified <= $time;
    }

    protected function getValue($name): void
    {
        //return $this->twigTemplateRepository->findOneBy(['name' => $name]);
        //todo: SI je laisse cette ligne ca plante Travis et le composer install ???
    }
}
