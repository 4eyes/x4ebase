<?php
namespace X4e\X4ebase\Template;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Philipp <philipp@4eyes.ch>, 4eyes GmbH
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

class FilterTemplate
{
    /**
     * All Filter keys and their selected filters in an associative array
     * Might be:
         $filterArray = array(
            'type'         => array(1,3);
            'languages'    => array(4,5,6);
            'tags'         => array(2);
         );
     *
     * @var array
     */
    protected $filterArray = [];

    /**
     * The Words a User searches for as an Array-List
     * Might be:
        $searchStrings = array('Hello','World');
     *
     * @var array
     */
    protected $searchStrings = [];

    /**
     * Associative Array: Key is the Parameter a user should be able to search in with $searchStrings, Value is the kind of search (like, contains, ...)
     * Possible Array:
         protected $searchableParameters = array(
             'name'             => 'like',
             'description'      => 'like',
             'authors.name'     => 'like',
             'languages.name'   => 'like',
             'tags'             => 'contains',
         );
     *
     * @var array
     */
    protected $searchableParameters = [];

    /**
     * Associative Array: Key is the Parameter of the object, Value is the kind of filter method (equals, contains, ...)
     * Possible Array:
         protected $filterMethods = array(
              'name'        => 'equals',
              'type'        => 'equals',
              'languages'   => 'contains',
              'description' => 'equals',
              'authors'     => 'contains',
              'tags'        => 'contains',
         );
     *
     * @var array
     */
    protected $filterMethods = [];

    /**
     * @return array
     */
    public function getFilterArray()
    {
        return $this->filterArray;
    }

    /**
     * @param array $filterArray
     */
    public function setFilterArray($filterArray)
    {
        $this->filterArray = $filterArray;
    }

    /**
     * @return array
     */
    public function getSearchStrings()
    {
        return $this->searchStrings;
    }

    /**
     * @param array $searchStrings
     */
    public function setSearchStrings($searchStrings)
    {
        $this->searchStrings = $searchStrings;
    }

    /**
     * @return array
     */
    public function getSearchableParameters()
    {
        return $this->searchableParameters;
    }

    /**
     * @param array $searchableParameters
     */
    public function setSearchableParameters($searchableParameters)
    {
        $this->searchableParameters = $searchableParameters;
    }

    /**
     * @param string $searchableParameter A parameter the user can search in
     */
    public function addSearchableParameter($searchableParameter)
    {
        if (!in_array($searchableParameter, $this->searchableParameters)) {
            $this->searchableParameters[] = $searchableParameter;
        }
    }

    /**
     * @param array $searchableParameters Multiple parameters a User can search in
     */
    public function addMultipleSearchableParameters($searchableParameters)
    {
        foreach ($searchableParameters as $searchableParameter) {
            $this->addSearchableParameter($searchableParameter);
        }
    }

    /**
     * @param string $searchableParameter A parameter the user should not be able to search in anymore
     */
    public function removeSearchableParameter($searchableParameter)
    {
        if (($key = array_search($searchableParameter, $this->searchableParameters)) !== false) {
            unset($this->searchableParameters[$key]);
            $this->searchableParameters = array_values($this->searchableParameters);
        }
    }

    /**
     * @param $parameterName
     * @param $parameterValue
     */
    public function addFilterToFilterArray($parameterName, $parameterValue)
    {
        if (!empty($parameterValue)) {
            $this->filterArray[$parameterName] = $parameterValue;
        }
    }

    /**
     * @param string $filterName The filter-key
     */
    public function removeFilterFromFilterArray($filterName)
    {
        unset($this->filterArray[$filterName]);
    }

    /**
     * @param string $search the Search String (normal Text, spaces are used as separators)
     */
    public function setSearchStringsFromSpaceSeparatedList($search)
    {
        $this->searchStrings = preg_split('/ /', $search, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * @param string $parameter The parameter of the object
     * @return string
     */
    public function getFilterMethodForParameter($parameter)
    {
        return $this->filterMethods[$parameter];
    }

    /**
     * @param array $filterMethods Sets the filter methods
     */
    public function setFilterMethods($filterMethods)
    {
        $this->filterMethods = $filterMethods;
    }

    /**
     * @return array
     */
    public function getFilterMethods()
    {
        return $this->filterMethods;
    }
}
