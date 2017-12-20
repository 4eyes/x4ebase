<?php
namespace X4e\X4ebase\ViewHelpers\Format;

class TrimViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Runs the given string through php-function 'trim'
     *
     * @return string The escaped string
     * @api
     */
    public function render()
    {
        $stringToFormat = $this->renderChildren();
        return trim($stringToFormat);
    }
}
