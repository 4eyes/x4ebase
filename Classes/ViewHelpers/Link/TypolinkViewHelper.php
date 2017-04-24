<?php
namespace X4e\X4ebase\ViewHelpers\Link;

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
        $this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
        $this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
        $this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
    }

    /**
     * @param string $parameter The typolink parameter to be turned into a link.
     * @param bool $keepContent Set TRUE to render the tag content even if no typolink parameter was given or the link generation failed.
     * @return string
     */
    public function render($parameter, $keepContent = false)
    {
        if (TYPO3_MODE === 'FE') {
            $cObj = $GLOBALS['TSFE']->cObj;
        } else {
            $cObj = $this->objectManager->get('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
        }
        $linkHref = $cObj->getTypoLink_URL($parameter);
        if (!$linkHref) {
            if ($keepContent) {
                return  $this->renderChildren();
            }
            return '';
        }
        $tagContent = $this->renderChildren();
        $linkText = ($tagContent ?: '');
        $this->tag->setContent($linkText);
        $this->tag->addAttribute('href', $linkHref);
        if (strstr($parameter, 'http') || strstr($parameter, ' _blank')) {
            $this->tag->addAttribute('target', '_blank');
        }
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }
}
