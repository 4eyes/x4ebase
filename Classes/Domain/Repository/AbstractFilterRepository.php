<?php
namespace X4E\X4ebase\Domain\Repository;

    /***************************************************************
     *
     *  Copyright notice
     *
     *  (c) 2015 Harry <harry@4eyes.ch>, 4eyes GmbH
     *           Michel <michel@4eyes.ch>, 4eyes GmbH
     *
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 3 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * This abstract repository holds the generic filter and search methods.
 * It requires a X4E\X4ebase\Template\FilterTemplate and the query to create the matching
 */
class AbstractFilterRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * @var array e.g.: array('firstName' => 'like', ... )
     */
    protected $searchableParameters;

    /**
     * @var array e.g.: array('firstName' => 'like', ... )
     */
    protected $filterMethods;


    /**
     * @var array
     */
    public $additionalConstraints;

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param String $filterMethod
     * @param string $parameterName
     * @param array $parameterValues
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface
     */
    protected function filterByParameter(&$query, $filterMethod, $parameterName, $parameterValues) {
        if(!empty($parameterValues) && !empty($filterMethod)) {
            $constraints = array();
            foreach($parameterValues as $parameterValue) {
                $constraints[] = $query->$filterMethod($parameterName,$parameterValue);
            }
            if(!empty($constraints))
                return $query->logicalOr($constraints);
        }
        return NULL;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param array $searchableParameters Associative Array: Key is the Parameter a user should be able to search in with $searchStrings, Value is the kind of search (like, contains, ...)
     * @param array $searchString The Words a User searches for as an Array-List
     * @return \TYPO3\CMS\Extbase\Persistence\Generic\Qom\OrInterface
     */
    public function searchByParameter(&$query, $searchableParameters, $searchString) {
        $constraints = array();
        foreach($searchableParameters as $searchParameter=>$searchMethod) {
            $constraints[] = $query->$searchMethod($searchParameter,"%".$searchString."%");
        }
        if(!empty($constraints))
            return $query->logicalOr($constraints);
        else
            return NULL;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param \X4E\X4ebase\Template\FilterTemplate $filterTemplate
     * @return \TYPO3\CMS\Extbase\Persistence\QueryInterface
     */
    public function createMatching(&$query, $filterTemplate) {
        $constraints = array();

        foreach($filterTemplate->getFilterArray() as $filterKey=>$filterValues) {
            $constraintMayBeNull = $this->filterByParameter($query, $filterTemplate->getFilterMethodForParameter($filterKey), $filterKey, $filterValues);
            if(!empty($constraintMayBeNull))
                $constraints[] = $constraintMayBeNull;
        }
        foreach($filterTemplate->getSearchStrings() as $searchString) {
            $constraintMayBeNull = $this->searchByParameter($query, $filterTemplate->getSearchableParameters(), $searchString);
            if(!empty($constraintMayBeNull))
                $constraints[] = $constraintMayBeNull;
        }

        $constraints = $this->addAdditionalConstraints($query, $filterTemplate, $constraints);

        if(!empty($constraints))
            return $query->matching(
                $query->logicalAnd($constraints)
            );
        else
            return $query;
    }

    /**
     * @param \X4E\X4ebase\Template\FilterTemplate $filterTemplate
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function performSearch($filterTemplate) {
        $filterTemplate->setSearchableParameters($this->searchableParameters);
        $filterTemplate->setFilterMethods($this->filterMethods);

        $query = $this->createQuery();
        $query = $this->createMatching($query, $filterTemplate);
        $documents = $query->execute();

        return $documents;
    }

    /**
     * This method can be used to add additional constraints to the $query object
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @param \X4E\X4ebase\Template\FilterTemplate $filterTemplate
     * @param array() $constraints
     * @return array()
     */
    public function addAdditionalConstraints ($query, $filterTemplate, $constraints) {
        return $constraints;
    }
}