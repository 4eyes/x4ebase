<?php
namespace X4e\X4ebase\ViewHelpers\Uri;

class TypolinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Arguments initialization
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();

        $this->registerTagAttribute('parameter', 'string', 'Specifies the typolink parameter');
    }

    /**
     *
     * @return string Rendered email link
     */
    public function render()
    {
        $parameter = $this->arguments['parameter'];

        if (TYPO3_MODE === 'FE') {
            $cObj = $GLOBALS['TSFE']->cObj;
        } else {
            $cObj = $this->objectManager->get('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
        }
        $linkHref = $cObj->getTypoLink_URL($parameter);
        if (!$linkHref) {
            return '';
        } else {
            return $linkHref;
        }
    }
}
