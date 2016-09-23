<?php
namespace X4e\X4ebase\ViewHelpers\Format;

class StrtolowerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Runs the given string through php-function 'strtolower'
     *
     * @return string The escaped string
     * @api
     */
    public function render()
    {
        $stringToFormat = $this->renderChildren();
        return strtolower($stringToFormat);
    }
}
