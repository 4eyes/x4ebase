<?php
namespace X4e\X4ebase\ViewHelpers\Form;

/***************************************************************
*  Copyright notice
*
*  (c) 2012 Christoph Dörfel <christoph@4eyes.ch>
*
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Extends CheckboxViewHelper
 *
 * Xml format a string
 *
 * @author Christoph Dörfel <christoph@4eyes.ch>
 */
class CheckboxViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\CheckboxViewHelper
{

    /**
     * Initialize the arguments.
     *
     * @return void
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('defaultHiddenValue', 'string', 'Default value of hidden field, which defines the value of the checkbox when unchecked', false, '');
        $this->registerArgument('renderHiddenField', 'string', 'Defines if a hidden field has to be rendered for this element', false, true);
    }

    /**
     * Reimplements this method of AbstractViewHelper, to set the hidden field value to a given argument instead of hardcoding it to empty string
     *
     * @return string the hidden field.
     */
    protected function renderHiddenFieldForEmptyValue()
    {
        if ($this->arguments['renderHiddenField'] === true) {
            $hiddenFieldNames = [];
            if ($this->viewHelperVariableContainer->exists('TYPO3\\CMS\\Fluid\\ViewHelpers\\FormViewHelper', 'renderedHiddenFields')) {
                $hiddenFieldNames = $this->viewHelperVariableContainer->get('TYPO3\\CMS\\Fluid\\ViewHelpers\\FormViewHelper', 'renderedHiddenFields');
            }
            $fieldName = $this->getName();
            if (substr($fieldName, -2) === '[]') {
                $fieldName = substr($fieldName, 0, -2);
            }
            if (!in_array($fieldName, $hiddenFieldNames)) {
                $hiddenFieldNames[] = $fieldName;
                $this->viewHelperVariableContainer->addOrUpdate('TYPO3\\CMS\\Fluid\\ViewHelpers\\FormViewHelper', 'renderedHiddenFields', $hiddenFieldNames);
                $defaultHiddenValue = isset($this->arguments['defaultHiddenValue']) ? $this->arguments['defaultHiddenValue'] : '';
                return '<input type="hidden" name="' . htmlspecialchars($fieldName) . '" value="' . $defaultHiddenValue . '" />';
            }
        }
        return '';
    }
}
