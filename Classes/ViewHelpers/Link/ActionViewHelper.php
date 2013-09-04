<?php
namespace X4E\X4ebase\ViewHelpers\Link;

class ActionViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\ActionViewHelper {

	/**
	 * @param string $action Target action
	 * @param array $arguments Arguments
	 * @param string $controller Target controller. If NULL current controllerName is used
	 * @param string $extensionName Target Extension Name (without "tx_" prefix and no underscores). If NULL the current extension name is used
	 * @param string $pluginName Target plugin. If empty, the current plugin name is used
	 * @param integer $pageUid target page. See TypoLink destination
	 * @param integer $pageType type of the target page. See typolink.parameter
	 * @param boolean $noCache set this to disable caching for the target page. You should not need this.
	 * @param boolean $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
	 * @param string $section the anchor to be added to the URI
	 * @param string $format The requested format, e.g. ".html
	 * @param boolean $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
	 * @param array $additionalParams additional query parameters that won't be prefixed like $arguments (overrule $arguments)
	 * @param boolean $absolute If set, the URI of the rendered link is absolute
	 * @param boolean $addQueryString If set, the current query parameters will be kept in the URI
	 * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
	 * @return string Rendered link
	 */
	public function render($action = NULL, array $arguments = array(), $controller = NULL, $extensionName = NULL, $pluginName = NULL, $pageUid = NULL, $pageType = 0, $noCache = FALSE, $noCacheHash = FALSE, $section = '', $format = '', $linkAccessRestrictedPages = FALSE, array $additionalParams = array(), $absolute = FALSE, $addQueryString = FALSE, array $argumentsToBeExcludedFromQueryString = array()) {
		\X4E\X4ebase\Utility\BackendUtility::initTSFE($pageUid);
		
		$uriBuilder = $this->controllerContext->getUriBuilder();
		$uri = $uriBuilder->reset()->setTargetPageUid($pageUid)->setTargetPageType($pageType)->setNoCache($noCache)->setUseCacheHash(!$noCacheHash)->setSection($section)->setFormat($format)->setLinkAccessRestrictedPages($linkAccessRestrictedPages)->setArguments($additionalParams)->setCreateAbsoluteUri($absolute)->setAddQueryString($addQueryString)->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString)->uriFor($action, $arguments, $controller, $extensionName, $pluginName);
		$uri = $uriBuilder->buildFrontendUri();
		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($this->renderChildren());
		$this->tag->forceClosingTag(TRUE);
		return $this->tag->render();
	}
}

?>