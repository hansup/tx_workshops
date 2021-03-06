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

/**
 * Location model.
 */
class Location extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $address;

    /**
     * @var string
     */
    protected $zip;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var float
     */
    protected $latitude = 0.000000;

    /**
     * @var float
     */
    protected $longitude = 0.000000;


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
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }
    
    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
    
    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

}