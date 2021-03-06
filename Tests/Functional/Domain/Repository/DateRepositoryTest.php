<?php
namespace NIMIUS\Workshops\Tests\Functional\Domain\Repository;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use NIMIUS\Workshops\Domain\Model\Date;
use NIMIUS\Workshops\Domain\Model\Workshop;
use NIMIUS\Workshops\Domain\Proxy\DateRepositoryProxy;
use NIMIUS\Workshops\Domain\Repository\DateRepository;
use NIMIUS\Workshops\Domain\Repository\WorkshopRepository;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Date repository tests.
 */
class DateRepositoryTest extends \TYPO3\CMS\Core\Tests\FunctionalTestCase
{

    /**
     * @var array Required extensions for this test suite
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/workshops'];

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persisteneManager;

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\WorkshopRepository
     */
    protected $workshopRepository;

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\DateRepository
     */
    protected $dateRepository;

    /**
     * @var \NIMIUS\Workshops\Domain\Model\Workshop
     */
    protected $workshop;


    /**
     * Test case constructor / initializer.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
        $this->workshopRepository = $this->objectManager->get(WorkshopRepository::class);
        $this->dateRepository = $this->objectManager->get(DateRepository::class);
    }

    /**
     * Test if findByProxy respects storage pid given.
     *
     * @test
     */
    public function findByProxyRespectsStoragePid()
    {
        $date = $this->createDate();
        $date->setPid(8);
        $this->dateRepository->add($date);
        $this->persistenceManager->persistAll();
        
        $proxy = $this->createProxy();
        $proxy->setPid(8);
        
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 1);
    }

    /**
     * Test if findByProxy() respects hidePastDates.
     *
     * @test
     */
    public function findByProxyRespectsHidePastDates()
    {
        $date = $this->createDate();
        $date->setEndAt(strtotime('-2 days'));
        $this->dateRepository->add($date);
        $this->persistenceManager->persistAll();
        
        $proxy = $this->createProxy();
        $proxy->setHidePastDates(TRUE);
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 0);
        
        $proxy->setHidePastDates(FALSE);
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 1);
    }

    /**
     * Test if findByProxy() respects hideAlreadyStartedDates.
     *
     * @test
     */
    public function findByProxyRespectsHideAlreadyStartedDates()
    {
        $date = $this->createDate();
        $date->setBeginAt(strtotime('-2 days'));
        $this->dateRepository->add($date);
        $this->persistenceManager->persistAll();
        
        $proxy = $this->createProxy();
        $proxy->setHideAlreadyStartedDates(TRUE);
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 0);
        
        $proxy->setHideAlreadyStartedDates(FALSE);
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 1);
    }

    /**
     * Test if findByProxy() respects withinDaysFromNow.
     *
     * @test
     */
    public function findByProxyRespectsWithinDaysFromNow()
    {
        $date = $this->createDate();
        $date->setBeginAt(strtotime('+2 days'));
        $this->dateRepository->add($date);
        
        $date = $this->createDate();
        $date->setBeginAt(strtotime('+8 days'));
        $this->dateRepository->add($date);

        $date = $this->createDate();
        $date->setBeginAt(strtotime('+1 year'));
        $this->dateRepository->add($date);

        $this->persistenceManager->persistAll();
        
        $proxy = $this->createProxy();
        $proxy->setWithinDaysFromNow(4);
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 1);
        
        $proxy->setWithinDaysFromNow(NULL);
        $dates = $this->dateRepository->findByProxy($proxy);
        $this->assertTrue(count($dates) == 3);
    }

    /**
     * Helper to create a proxy object.
     *
     * @return DateRepositoryProxy
     */
    protected function createProxy() {
        return $this->objectManager->get(DateRepositoryProxy::class);
    }

    /**
     * Helper to create a workshop object.
     *
     * @return Workshop
     */
    protected function createWorkshop() {
        return $this->objectManager->get(Workshop::class);
    }

    /**
     * Helper to create a date object.
     *
     * @return Category
     */
    protected function createDate() {
        return $this->objectManager->get(Date::class);
    }

}