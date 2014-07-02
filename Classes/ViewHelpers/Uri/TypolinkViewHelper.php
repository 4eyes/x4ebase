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
		} else {
			return $linkHref;
		}
	}
}