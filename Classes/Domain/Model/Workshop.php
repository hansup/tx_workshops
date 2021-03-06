<?php
namespace NIMIUS\Workshops\Domain\Model;

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

use NIMIUS\Workshops\Domain\Model\Category;
use NIMIUS\Workshops\Domain\Model\Date;

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Workshop model.
 */
class Workshop extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var integer Default workshop
     */
    const TYPE_DEFAULT = 0;

    /**
     * @var integer Workshop with link to external page
     */
    const TYPE_EXTERNAL = 2;

    /**
     * @var boolean
     */
    protected $hidden;
    
    /**
     * @var integer
     */
    protected $type;

    /**
     * @var string
     */
    protected $identifier;
    
    /**
     * @var string
     */
    protected $internalUrl;
    
    /**
     * @var string
     */
    protected $externalUrl;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $abstract;

    /**
     * @var string
     */
    protected $description;
    
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NIMIUS\Workshops\Domain\Model\Date>
     * @lazy
     */
    protected $dates;
    
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NIMIUS\Workshops\Domain\Model\Category>
     * @lazy
     */
    protected $categories;
    
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NIMIUS\Workshops\Domain\Model\Workshop>
     * @lazy
     */
    protected $relatedWorkshops;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $images;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $files;



    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->categories = new ObjectStorage;
        $this->dates = new ObjectStorage;
        $this->relatedWorkshops = new ObjectStorage;
        $this->images = new ObjectStorage;
        $this->files = new ObjectStorage;
    }
    
    /**
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }
    
    /**
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->type == self::TYPE_DEFAULT;
    }

    /**
     * @return boolean
     */
    public function getIsExternal()
    {
        return $this->type == self::TYPE_EXTERNAL;
    }
    
    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
    
    /**
     * @return string
     */
    public function getInternalUrl()
    {
        return $this->internalUrl;
    }
    
    /**
     * @return string
     */
    public function getExternalUrl()
    {
        return $this->externalUrl;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Get all dates.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NIMIUS\Workshops\Domain\Model\Date>
     */
    public function getDates()
    {
        return $this->dates;
    }
    
    /**
     * Adds a date.
     *
     * @param $date \NIMIUS\Workshops\Domain\Model\Date
     */
    public function addDate(Date $date)
    {
        $this->dates->attach($date);
    }
    
    /**
     * Get all categories.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NIMIUS\Workshops\Domain\Model\Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }
    
    /**
     * Adds a category.
     *
     * @param $category \NIMIUS\Workshops\Domain\Model\Category
     */
    public function addCategory(Category $category)
    {
        $this->categories->attach($category);
    }
    
    /**
     * Get all related workshops.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\NIMIUS\Workshops\Domain\Model\Workshop>
     */
    public function getRelatedWorkshops()
    {
        return $this->relatedWorkshops;
    }

    /**
     * Get all images.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get all files.
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Get the first category.
     *
     * @return \NIMIUS\Workshops\Domain\Model\Category
     */
    public function getFirstCategory()
    {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
            $categories->rewind();
            return $categories->current();
        } else {
            return NULL;
        }
    }

}