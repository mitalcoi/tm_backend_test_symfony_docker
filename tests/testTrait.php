<?php
namespace App\Tests;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;

trait testTrait
{


    /**
     * @param null|(callable(Loader): void) $postProcessClb
     */
    function withFixtures(KernelInterface $kernel)
    {
        $fixturesLoader = new Loader();
        $em = $kernel->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($em);
        $purger->setPurgeMode($purger::PURGE_MODE_DELETE);
        $executor = new ORMExecutor($em, $purger);
        $fixturesLoader->loadFromDirectory(__DIR__.'/../src/DataFixtures');


        $executor->execute($fixturesLoader->getFixtures());

        return $executor->getReferenceRepository();
    }
}