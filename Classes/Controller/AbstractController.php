<?php
namespace NIMIUS\Workshops\Controller;

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

/**
 * Abstract extension controller.
 *
 * This extension's base for all controllers. Contains shared
 * objects and functionality.
 */
abstract class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\DateRepository
     * @inject
     */
    protected $dateRepository;

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\RegistrationRepository
     * @inject
     */
    protected $registrationRepository;

    /**
     * @var \NIMIUS\Workshops\Domain\Repository\WorkshopRepository
     * @inject
     */
    protected $workshopRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher
     * @inject
     */
    protected $signalSlotDispatcher;


    /**
     * Enforces presence of a logged in fe_user.
     *
     * If plugin.tx_workshops.settings.loginPid is given,
     * a redirect to the given login page is made. Otherwise,
     * a core "page not found" is yielded.
     */
    public function requireFrontendUser() 
    {
        if (!$this->currentFrontendUser()) {
            $loginPid = (int)$this->settings['loginPid'];
            if ($loginPid > 0) {
                $this->redirect(NULL, NULL, NULL, NULL, $loginPid);
                exit;
            } else {
                $GLOBALS['TSFE']->pageNotFoundAndExit('Frontend user required to proceed.');
            }
        }
    }
    
    /**
     * Get the currently logged in frontend user.
     *
     * @return mixed A FrontendUser object or FALSE.
     */
    public function currentFrontendUser()
    {
        if (isset($this->currentFrontendUser)) {
            return $this->currentFrontendUser;
        }
        
        if ($GLOBALS['TSFE']->fe_user->user) {
            $this->currentFrontendUser = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
            return $this->currentFrontendUser;
        } else {
            return FALSE;
        }
    }

}