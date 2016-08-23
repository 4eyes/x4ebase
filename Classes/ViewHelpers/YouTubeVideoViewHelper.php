<?php
namespace X4e\X4ebase\ViewHelpers;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Embeds a YouTube Video
 * 
 * @author Christoph Dörfel <christoph@4eyes.ch>
 */
class YouTubeVideoViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * Helps render video
	 *
	 * @param string $value The YouTube video url or video hash
	 * 
	 * @param string $videoHash The name of the video hash variable
	 * @param string $thumbnail The name of the thumbnail image variable
	 * @param string|integer $thumbnailType The video thumbnail type (one of 0,1,2,3,default,hqdefault,mqdefault,sddefault,maxresdefault)
	 * @return string Rendered string
	 */
	public function render($value, $videoHash = 'videoHash', $thumbnail = 'thumbnail', $thumbnailType = 'sddefault') {
		$output = '';
		$hash = $this->retrieveYoutubeHash($value);
		if ($hash) {
			$this->templateVariableContainer->add($videoHash, $hash);
			$this->templateVariableContainer->add($thumbnail, $this->getThumbnail($hash, $thumbnailType));
			$output = $this->renderChildren();
			$this->templateVariableContainer->remove($thumbnail);
			$this->templateVariableContainer->remove($videoHash);
		}
		return $output;
	}
	
	/**
	 * Rendering the cObject, MEDIA
	 *
	 * @param $videoHash string The YouTube video hash
	 * @param $thumbnailType string|integer The video thumbnail type
	 * @return string Output
	 */
	public function getThumbnail($videoHash, $thumbnailType = 0) {
		$thumbType = 0;
		if (in_array($thumbnailType, array('0','1','2','3','default','hqdefault','mqdefault','sddefault','maxresdefault'))) {
			$thumbType = $thumbnailType;
		}
		
//		$thumbnail = 'https://img.youtube.com/vi/' . $videoHash . '/' . $thumbType . '.jpg';
		$thumbnail = 'https://i3.ytimg.com/vi/' . $videoHash . '/' . $thumbType . '.jpg';
		
		return $thumbnail;
	}

	/**
	 * Extracts the video hash of a YouTube video URL
	 *
	 * @param string $url
	 * @return string|NULL
	 */
	protected function retrieveYoutubeHash($url) {
		$returnValue = NULL;
		if (preg_match('~
			# Match non-linked youtube URL in the wild. (Rev:20111012)
			(?:https?://)?    # Optional scheme. Either http or https. (edited: $file sometimes has no scheme)
			(?:[0-9A-Z-]+\.)? # Optional subdomain.
			(?:               # Group host alternatives.
			  youtu\.be/      # Either youtu.be,
			| youtube\.com    # or youtube.com followed by
			  \S*             # Allow anything up to VIDEO_ID,
			  [^\w\-\s]       # but char before ID is non-ID char.
			)                 # End host alternatives.
			([\w\-]{11})      # $1: VIDEO_ID is exactly 11 chars.
			(?=[^\w\-]|$)     # Assert next char is non-ID or EOS.
			(?!               # Assert URL is not pre-linked.
			  [?=&+%\w]*      # Allow URL (query) remainder.
			  (?:             # Group pre-linked alternatives.
				[\'"][^<>]*>  # Either inside a start tag,
			  | </a>          # or inside <a> element text contents.
			  )               # End recognized pre-linked alts.
			)                 # End negative lookahead assertion.
			[?=&+%\w-]*        # Consume any URL (query) remainder.
			~ix', $url, $matches) && isset($matches[1])) {
			$returnValue = $matches[1];
		} else {
			$returnValue = $url;
		}
		return $returnValue;
	}

}