<?php
namespace NIMIUS\Workshops\Domain\Proxy;

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

/**
 * Abstract repository proxy class.
 *
 * Contains shared properties and methods.
 */
abstract class AbstractRepositoryProxy
{
    /**
     * @var \NIMIUS\Workshops\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * @var integer Storage page id.
     */
    protected $pid;

    /**
     * @var mixed A traversable object containing \NIMIUS\Workshops\Domain\Model\Category records.
     */
    protected $categories;

    /**
     * @var string Category operator (AND, OR, ...).
     */
    protected $categoryOperator;

    /**
     * @var string Sorting field.
     */
    protected $sortingField = 'sorting';

    /**
     * @var string Sorting type.
     */
    protected $sortingType = 'ASC';

    /**
     * @var integer Restrict dates to be within the following amount of days from now
     */
    protected $withinDaysFromNow;

    /**
     * @var bool Hide dates being in the past, regardless of time.
     */
    protected $hidePastDates;

    /**
     * @var bool Hide dates where workshops already started regarding time.
     */
    protected $hideAlreadyStartedDates;


    /**
     * Initialize proxy properties by given settings.
     *
     * Settings are coming from e.g. TypoScript or FlexForm.
     *
     * @param array $settings
     * @return void
     */
    public function initializeFromSettings($settings)
    {
        if (!empty($settings['categories'])) {
            $categoriesUids = explode(',', $settings['categories']);
            $this->setCategoriesUids($categoriesUids);
        }
        if (!empty($settings['categoryOperator'])) {
            $this->setCategoryOperator($settings['categoryOperator']);
        }
        if ((int)$settings['upcomingDays'] > 0) {
            $this->setWithinDaysFromNow((int)$settings['upcomingDays']);
        }
        if ((bool)$settings['hidePastDates']) {
            $this->setHidePastDates(TRUE);
        }
        if ((bool)$settings['hideAlreadyStartedDates']) {
            $this->setHideAlreadyStartedDates(TRUE);
        }
        // Unset already processed settings.
        unset(
            $settings['categories'], $settings['categoryOperator'], $settings['upcomingDays'],
            $settings['hidePastDates'], $settings['hideAlreadyStartedDates']
        );

        foreach($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param integer $pid
     * @return void
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     * @return void
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param \NIMIUS\Workshops\Domain\Model\Category $category
     * @return void
     */
    public function addCategory($category)
    {
        $this->categories[] = $category;
    }

    /**
     * @param array $uids Array of uid's
     * @return void
     */
    public function setCategoriesUids(array $uids)
    {
        $this->categories = [];
        foreach ($uids as $uid) {
            $this->categories[] = $this->categoryRepository->findByUid((int)$uid);
        }
    }

    /**
     * @return mixed
     */
    public function getCategoryOperator()
    {
        return $this->categoryOperator;
    }

    /**
     * @param string $categoryOperator
     * @return void
     */
    public function setCategoryOperator($categoryOperator)
    {
        $this->categoryOperator = $categoryOperator;
    }

    /**
     * @return string
     */
    public function getSortingField()
    {
        return $this->sortingField;
    }

    /**
     * @param string $sortingField
     * @return void
     */
    public function setSortingField($sortingField)
    {
        $this->sortingField = $sortingField;
    }

    /**
     * @return string
     */
    public function getSortingType()
    {
        return $this->sortingType;
    }

    /**
     * @param string $sortingType
     * @return void
     */
    public function setSortingType($sortingType)
    {
        $this->sortingType = $sortingType;
    }

    /**
     * @return mixed
     */
    public function getWithinDaysFromNow()
    {
        return $this->withinDaysFromNow;
    }

    /**
     * @param integer $withinDaysFromNow
     * @return void
     */
    public function setWithinDaysFromNow($withinDaysFromNow)
    {
        $this->withinDaysFromNow = (int)$withinDaysFromNow;
    }

    /**
     * @return bool
     */
    public function getHidePastDates()
    {
        return $this->hidePastDates;
    }

    /**
     * @param bool $hidePastDates
     * @return void
     */
    public function setHidePastDates($hidePastDates)
    {
        $this->hidePastDates = (bool)$hidePastDates;
    }

    /**
     * @return bool
     */
    public function getHideAlreadyStartedDates()
    {
        return $this->hideAlreadyStartedDates;
    }

    /**
     * @param bool $hideAlreadyStartedDates
     * @return void
     */
    public function setHideAlreadyStartedDates($hideAlreadyStartedDates)
    {
        $this->hideAlreadyStartedDates = (bool)$hideAlreadyStartedDates;
    }
}