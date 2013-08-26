<?php
namespace X4E\X4ebase\View;
class TemplateView extends \TYPO3\CMS\Fluid\View\TemplateView {

	/**
	 * @return Tx_Fluid_Core_Parser_Configuration
	 */
	protected function buildParserConfiguration() {
		$parserConfiguration = parent::buildParserConfiguration();
		$parserConfiguration->addInterceptor($this->objectManager->get('X4E\X4ebase\View\Interceptor\ReplaceTabs'));
		return $parserConfiguration;
	}

}
?>