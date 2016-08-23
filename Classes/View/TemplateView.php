<?php
namespace X4e\X4ebase\View;
class TemplateView extends \TYPO3\CMS\Fluid\View\TemplateView {

	/**
	 * @return \TYPO3\CMS\Fluid\Core\Parser\Configuration
	 */
	protected function buildParserConfiguration() {
		$parserConfiguration = parent::buildParserConfiguration();
		$parserConfiguration->addInterceptor($this->objectManager->get('X4e\X4ebase\View\Interceptor\ReplaceTabs'));
		return $parserConfiguration;
	}
}