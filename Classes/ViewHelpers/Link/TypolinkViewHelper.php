<?php
namespace X4E\X4ebase\ViewHelpers\Link;

class TypolinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * Arguments initialization
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
		$this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
		$this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
		$this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');
	}

	/**
	 * @param string $parameter The typolink parameter to be turned into a link.
	 * @return string Rendered email link
	 */
	public function render($parameter) {
		if (TYPO3_MODE === 'FE') {
			$cObj = $GLOBALS['TSFE']->cObj;
		} else {
			$cObj = $this->objectManager->get('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');
		}
		$linkHref = $cObj->getTypoLink_URL($parameter);
		if (!$linkHref) {
			return '';
		}
		$tagContent = $this->renderChildren();
		$linkText = ($tagContent ?: '');
		$this->tag->setContent($linkText);
		$this->tag->addAttribute('href', $linkHref);
		if(strstr($parameter, 'http') || strstr($parameter, ' _blank')){
			$this->tag->addAttribute('target', '_blank');
		}
		$this->tag->forceClosingTag(TRUE);
		return $this->tag->render();
	}
}