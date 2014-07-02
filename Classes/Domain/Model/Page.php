<?php
namespace X4E\X4ebase\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * A TYPO3 page record model for extbase
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * sorting
	 *
	 * @var integer
	 */
	protected $sorting;
	
	/**
	 * sysLanguageUid
	 *
	 * @var integer
	 */
	protected $sysLanguageUid = 0;
	
	/**
	 * permsUserid
	 *
	 * @var integer
	 */
	protected $permsUserid;

	/**
	 * permsGroupid
	 *
	 * @var integer
	 */
	protected $permsGroupid;

	/**
	 * permsUser
	 *
	 * @var integer
	 */
	protected $permsUser;

	/**
	 * permsGroup
	 *
	 * @var integer
	 */
	protected $permsGroup;

	/**
	 * permsEverybody
	 *
	 * @var integer
	 */
	protected $permsEverybody;

	/**
	 * editlock
	 *
	 * @var integer
	 */
	protected $editlock;
	
	/**
	 * cruserId
	 *
	 * @var integer
	 */
	protected $cruserId;

	/**
	 * title
	 *
	 * @var string
	 */
	protected $title;

	/**
	 * doktype
	 *
	 * @var integer
	 */
	protected $doktype;

	/**
	 * tsconfig
	 *
	 * @var string
	 */
	protected $tsconfig;

	/**
	 * storagePid
	 *
	 * @var integer
	 */
	protected $storagePid;

	/**
	 * isSiteroot
	 *
	 * @var integer
	 */
	protected $isSiteroot;

	/**
	 * phpTreeStop
	 *
	 * @var integer
	 */
	protected $phpTreeStop;

	/**
	 * url
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * urltype
	 *
	 * @var integer
	 */
	protected $urltype;

	/**
	 * shortcut
	 *
	 * @var integer
	 */
	protected $shortcut;

	/**
	 * shortcutMode
	 *
	 * @var integer
	 */
	protected $shortcutMode;

	/**
	 * noCache
	 *
	 * @var integer
	 */
	protected $noCache;

	/**
	 * feGroup
	 *
	 * @var string
	 */
	protected $feGroup;

	/**
	 * subtitle
	 *
	 * @var string
	 */
	protected $subtitle;

	/**
	 * layout
	 *
	 * @var integer
	 */
	protected $layout;

	/**
	 * target
	 *
	 * @var string
	 */
	protected $target;

	/**
	 * media
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $media;

	/**
	 * lastupdated
	 *
	 * @var integer
	 */
	protected $lastupdated;

	/**
	 * keywords
	 *
	 * @var string
	 */
	protected $keywords;

	/**
	 * cacheTimeout
	 *
	 * @var integer
	 */
	protected $cacheTimeout;

	/**
	 * newuntil
	 *
	 * @var integer
	 */
	protected $newuntil;

	/**
	 * description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * noSearch
	 *
	 * @var integer
	 */
	protected $noSearch;

	/**
	 * sysLastchanged
	 *
	 * @var integer
	 */
	protected $sysLastchanged;

	/**
	 * abstract
	 *
	 * @var string
	 */
	protected $abstract;

	/**
	 * module
	 *
	 * @var string
	 */
	protected $module;

	/**
	 * extendtosubpages
	 *
	 * @var integer
	 */
	protected $extendtosubpages;

	/**
	 * author
	 *
	 * @var string
	 */
	protected $author;

	/**
	 * authorEmail
	 *
	 * @var string
	 */
	protected $authorEmail;

	/**
	 * navTitle
	 *
	 * @var string
	 */
	protected $navTitle;

	/**
	 * navHide
	 *
	 * @var integer
	 */
	protected $navHide;

	/**
	 * contentFromPid
	 *
	 * @var integer
	 */
	protected $contentFromPid;

	/**
	 * mountPid
	 *
	 * @var integer
	 */
	protected $mountPid;

	/**
	 * mountPidOl
	 *
	 * @var integer
	 */
	protected $mountPidOl;

	/**
	 * alias
	 *
	 * @var string
	 */
	protected $alias;

	/**
	 * l18nCfg
	 *
	 * @var integer
	 */
	protected $l18nCfg;

	/**
	 * feLoginMode
	 *
	 * @var integer
	 */
	protected $feLoginMode;

	/**
	 * urlScheme
	 *
	 * @var integer
	 */
	protected $urlScheme;

	/**
	 * backendLayout
	 *
	 * @var integer
	 */
	protected $backendLayout;

	/**
	 * backendLayoutNextLevel
	 *
	 * @var integer
	 */
	protected $backendLayoutNextLevel;

	/**
	 * cacheTags
	 *
	 * @var string
	 */
	protected $cacheTags;

	/**
	 *
	 * @var \DateTime
	 */
	protected $crdate;

	/**
	 *
	 * @var \DateTime
	 */
	protected $tstamp;

	/**
	 * __construct
	 *
	 * @return Pages
	 */
	public function __construct() {
		$this->initStorageObjects();
	}
	
	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		//$this->xyz = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}
	
	/**
	 * Returns the sorting
	 *
	 * @return integer $sorting
	 */
	public function getSorting() {
		return $this->permsUserid;
	}

	/**
	 * Sets the sorting
	 *
	 * @param integer $sorting
	 * @return void
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
	}
	
	/**
	 * Returns the sysLanguageUid
	 *
	 * @return integer $sysLanguageUid
	 */
	public function getSysLanguageUid() {
		return $this->sysLanguageUid;
	}

	/**
	 * Sets the sysLanguageUid
	 *
	 * @param integer $sysLanguageUid
	 * @return void
	 */
	public function setSysLanguageUid($sysLanguageUid) {
		$this->sysLanguageUid = $sysLanguageUid;
	}
	
	/**
	 * Returns the permsUserid
	 *
	 * @return integer $permsUserid
	 */
	public function getPermsUserid() {
		return $this->permsUserid;
	}

	/**
	 * Sets the permsUserid
	 *
	 * @param integer $permsUserid
	 * @return void
	 */
	public function setPermsUserid($permsUserid) {
		$this->permsUserid = $permsUserid;
	}

	/**
	 * Returns the permsGroupid
	 *
	 * @return integer $permsGroupid
	 */
	public function getPermsGroupid() {
		return $this->permsGroupid;
	}

	/**
	 * Sets the permsGroupid
	 *
	 * @param integer $permsGroupid
	 * @return void
	 */
	public function setPermsGroupid($permsGroupid) {
		$this->permsGroupid = $permsGroupid;
	}

	/**
	 * Returns the permsUser
	 *
	 * @return integer $permsUser
	 */
	public function getPermsUser() {
		return $this->permsUser;
	}

	/**
	 * Sets the permsUser
	 *
	 * @param integer $permsUser
	 * @return void
	 */
	public function setPermsUser($permsUser) {
		$this->permsUser = $permsUser;
	}

	/**
	 * Returns the permsGroup
	 *
	 * @return integer $permsGroup
	 */
	public function getPermsGroup() {
		return $this->permsGroup;
	}

	/**
	 * Sets the permsGroup
	 *
	 * @param integer $permsGroup
	 * @return void
	 */
	public function setPermsGroup($permsGroup) {
		$this->permsGroup = $permsGroup;
	}

	/**
	 * Returns the permsEverybody
	 *
	 * @return integer $permsEverybody
	 */
	public function getPermsEverybody() {
		return $this->permsEverybody;
	}

	/**
	 * Sets the permsEverybody
	 *
	 * @param integer $permsEverybody
	 * @return void
	 */
	public function setPermsEverybody($permsEverybody) {
		$this->permsEverybody = $permsEverybody;
	}

	/**
	 * Returns the editlock
	 *
	 * @return integer $editlock
	 */
	public function getEditlock() {
		return $this->editlock;
	}

	/**
	 * Sets the editlock
	 *
	 * @param integer $editlock
	 * @return void
	 */
	public function setEditlock($editlock) {
		$this->editlock = $editlock;
	}

	/**
	 * Returns the cruserId
	 *
	 * @return integer $cruserId
	 */
	public function getCruserId() {
		return $this->cruserId;
	}

	/**
	 * Sets the cruserId
	 *
	 * @param integer $cruserId
	 * @return void
	 */
	public function setCruserId($cruserId) {
		$this->cruserId = $cruserId;
	}

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the doktype
	 *
	 * @return integer $doktype
	 */
	public function getDoktype() {
		return $this->doktype;
	}

	/**
	 * Sets the doktype
	 *
	 * @param integer $doktype
	 * @return void
	 */
	public function setDoktype($doktype) {
		$this->doktype = $doktype;
	}

	/**
	 * Returns the tsconfig
	 *
	 * @return string $tsconfig
	 */
	public function getTsconfig() {
		return $this->tsconfig;
	}

	/**
	 * Sets the tsconfig
	 *
	 * @param string $tsconfig
	 * @return void
	 */
	public function setTsconfig($tsconfig) {
		$this->tsconfig = $tsconfig;
	}

	/**
	 * Returns the storagePid
	 *
	 * @return integer $storagePid
	 */
	public function getStoragePid() {
		return $this->storagePid;
	}

	/**
	 * Sets the storagePid
	 *
	 * @param integer $storagePid
	 * @return void
	 */
	public function setStoragePid($storagePid) {
		$this->storagePid = $storagePid;
	}

	/**
	 * Returns the isSiteroot
	 *
	 * @return integer $isSiteroot
	 */
	public function getIsSiteroot() {
		return $this->isSiteroot;
	}

	/**
	 * Sets the isSiteroot
	 *
	 * @param integer $isSiteroot
	 * @return void
	 */
	public function setIsSiteroot($isSiteroot) {
		$this->isSiteroot = $isSiteroot;
	}

	/**
	 * Returns the phpTreeStop
	 *
	 * @return integer $phpTreeStop
	 */
	public function getPhpTreeStop() {
		return $this->phpTreeStop;
	}

	/**
	 * Sets the phpTreeStop
	 *
	 * @param integer $phpTreeStop
	 * @return void
	 */
	public function setPhpTreeStop($phpTreeStop) {
		$this->phpTreeStop = $phpTreeStop;
	}

	/**
	 * Returns the url
	 *
	 * @return string $url
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * Sets the url
	 *
	 * @param string $url
	 * @return void
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * Returns the urltype
	 *
	 * @return integer $urltype
	 */
	public function getUrltype() {
		return $this->urltype;
	}

	/**
	 * Sets the urltype
	 *
	 * @param integer $urltype
	 * @return void
	 */
	public function setUrltype($urltype) {
		$this->urltype = $urltype;
	}

	/**
	 * Returns the shortcut
	 *
	 * @return integer $shortcut
	 */
	public function getShortcut() {
		return $this->shortcut;
	}

	/**
	 * Sets the shortcut
	 *
	 * @param integer $shortcut
	 * @return void
	 */
	public function setShortcut($shortcut) {
		$this->shortcut = $shortcut;
	}

	/**
	 * Returns the shortcutMode
	 *
	 * @return integer $shortcutMode
	 */
	public function getShortcutMode() {
		return $this->shortcutMode;
	}

	/**
	 * Sets the shortcutMode
	 *
	 * @param integer $shortcutMode
	 * @return void
	 */
	public function setShortcutMode($shortcutMode) {
		$this->shortcutMode = $shortcutMode;
	}

	/**
	 * Returns the noCache
	 *
	 * @return integer $noCache
	 */
	public function getNoCache() {
		return $this->noCache;
	}

	/**
	 * Sets the noCache
	 *
	 * @param integer $noCache
	 * @return void
	 */
	public function setNoCache($noCache) {
		$this->noCache = $noCache;
	}

	/**
	 * Returns the feGroup
	 *
	 * @return string $feGroup
	 */
	public function getFeGroup() {
		return $this->feGroup;
	}

	/**
	 * Sets the feGroup
	 *
	 * @param string $feGroup
	 * @return void
	 */
	public function setFeGroup($feGroup) {
		$this->feGroup = $feGroup;
	}

	/**
	 * Returns the subtitle
	 *
	 * @return string $subtitle
	 */
	public function getSubtitle() {
		return $this->subtitle;
	}

	/**
	 * Sets the subtitle
	 *
	 * @param string $subtitle
	 * @return void
	 */
	public function setSubtitle($subtitle) {
		$this->subtitle = $subtitle;
	}

	/**
	 * Returns the layout
	 *
	 * @return integer $layout
	 */
	public function getLayout() {
		return $this->layout;
	}

	/**
	 * Sets the layout
	 *
	 * @param integer $layout
	 * @return void
	 */
	public function setLayout($layout) {
		$this->layout = $layout;
	}

	/**
	 * Returns the target
	 *
	 * @return string $target
	 */
	public function getTarget() {
		return $this->target;
	}

	/**
	 * Sets the target
	 *
	 * @param string $target
	 * @return void
	 */
	public function setTarget($target) {
		$this->target = $target;
	}

	/**
	 * Adds a FileReference
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
	 * @return void
	 */
	public function addMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $media) {
		$this->media->attach($media);
	}

	/**
	 * Removes a FileReference
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaToRemove The FileReference to be removed
	 * @return void
	 */
	public function removeMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaToRemove) {
		$this->media->detach($mediaToRemove);
	}
	
	/**
	 * Returns the media
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
	 */
	public function getMedia() {
		return $this->media;
	}

	/**
	 * Sets the media
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
	 * @return void
	 */
	public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media) {
		$this->media = $media;
	}

	/**
	 * Returns the lastupdated
	 *
	 * @return integer $lastupdated
	 */
	public function getLastupdated() {
		return $this->lastupdated;
	}

	/**
	 * Sets the lastupdated
	 *
	 * @param integer $lastupdated
	 * @return void
	 */
	public function setLastupdated($lastupdated) {
		$this->lastupdated = $lastupdated;
	}

	/**
	 * Returns the keywords
	 *
	 * @return string $keywords
	 */
	public function getKeywords() {
		return $this->keywords;
	}

	/**
	 * Sets the keywords
	 *
	 * @param string $keywords
	 * @return void
	 */
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}

	/**
	 * Returns the cacheTimeout
	 *
	 * @return integer $cacheTimeout
	 */
	public function getCacheTimeout() {
		return $this->cacheTimeout;
	}

	/**
	 * Sets the cacheTimeout
	 *
	 * @param integer $cacheTimeout
	 * @return void
	 */
	public function setCacheTimeout($cacheTimeout) {
		$this->cacheTimeout = $cacheTimeout;
	}

	/**
	 * Returns the newuntil
	 *
	 * @return integer $newuntil
	 */
	public function getNewuntil() {
		return $this->newuntil;
	}

	/**
	 * Sets the newuntil
	 *
	 * @param integer $newuntil
	 * @return void
	 */
	public function setNewuntil($newuntil) {
		$this->newuntil = $newuntil;
	}

	/**
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the noSearch
	 *
	 * @return integer $noSearch
	 */
	public function getNoSearch() {
		return $this->noSearch;
	}

	/**
	 * Sets the noSearch
	 *
	 * @param integer $noSearch
	 * @return void
	 */
	public function setNoSearch($noSearch) {
		$this->noSearch = $noSearch;
	}

	/**
	 * Returns the abstract
	 *
	 * @return string $abstract
	 */
	public function getAbstract() {
		return $this->abstract;
	}

	/**
	 * Sets the abstract
	 *
	 * @param string $abstract
	 * @return void
	 */
	public function setAbstract($abstract) {
		$this->abstract = $abstract;
	}

	/**
	 * Returns the module
	 *
	 * @return string $module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * Sets the module
	 *
	 * @param string $module
	 * @return void
	 */
	public function setModule($module) {
		$this->module = $module;
	}

	/**
	 * Returns the extendtosubpages
	 *
	 * @return integer $extendtosubpages
	 */
	public function getExtendtosubpages() {
		return $this->extendtosubpages;
	}

	/**
	 * Sets the extendtosubpages
	 *
	 * @param integer $extendtosubpages
	 * @return void
	 */
	public function setExtendtosubpages($extendtosubpages) {
		$this->extendtosubpages = $extendtosubpages;
	}

	/**
	 * Returns the author
	 *
	 * @return string $author
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Sets the author
	 *
	 * @param string $author
	 * @return void
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Returns the authorEmail
	 *
	 * @return string $authorEmail
	 */
	public function getAuthorEmail() {
		return $this->authorEmail;
	}

	/**
	 * Sets the authorEmail
	 *
	 * @param string $authorEmail
	 * @return void
	 */
	public function setAuthorEmail($authorEmail) {
		$this->authorEmail = $authorEmail;
	}

	/**
	 * Returns the navTitle
	 *
	 * @return string $navTitle
	 */
	public function getNavTitle() {
		return $this->navTitle;
	}

	/**
	 * Sets the navTitle
	 *
	 * @param string $navTitle
	 * @return void
	 */
	public function setNavTitle($navTitle) {
		$this->navTitle = $navTitle;
	}

	/**
	 * Returns the navHide
	 *
	 * @return integer $navHide
	 */
	public function getNavHide() {
		return $this->navHide;
	}

	/**
	 * Sets the navHide
	 *
	 * @param integer $navHide
	 * @return void
	 */
	public function setNavHide($navHide) {
		$this->navHide = $navHide;
	}

	/**
	 * Returns the contentFromPid
	 *
	 * @return integer $contentFromPid
	 */
	public function getContentFromPid() {
		return $this->contentFromPid;
	}

	/**
	 * Sets the contentFromPid
	 *
	 * @param integer $contentFromPid
	 * @return void
	 */
	public function setContentFromPid($contentFromPid) {
		$this->contentFromPid = $contentFromPid;
	}

	/**
	 * Returns the mountPid
	 *
	 * @return integer $mountPid
	 */
	public function getMountPid() {
		return $this->mountPid;
	}

	/**
	 * Sets the mountPid
	 *
	 * @param integer $mountPid
	 * @return void
	 */
	public function setMountPid($mountPid) {
		$this->mountPid = $mountPid;
	}

	/**
	 * Returns the mountPidOl
	 *
	 * @return integer $mountPidOl
	 */
	public function getMountPidOl() {
		return $this->mountPidOl;
	}

	/**
	 * Sets the mountPidOl
	 *
	 * @param integer $mountPidOl
	 * @return void
	 */
	public function setMountPidOl($mountPidOl) {
		$this->mountPidOl = $mountPidOl;
	}

	/**
	 * Returns the alias
	 *
	 * @return string $alias
	 */
	public function getAlias() {
		return $this->alias;
	}

	/**
	 * Sets the alias
	 *
	 * @param string $alias
	 * @return void
	 */
	public function setAlias($alias) {
		$this->alias = $alias;
	}

	/**
	 * Returns the l18nCfg
	 *
	 * @return integer $l18nCfg
	 */
	public function getL18nCfg() {
		return $this->l18nCfg;
	}

	/**
	 * Sets the l18nCfg
	 *
	 * @param integer $l18nCfg
	 * @return void
	 */
	public function setL18nCfg($l18nCfg) {
		$this->l18nCfg = $l18nCfg;
	}

	/**
	 * Returns the feLoginMode
	 *
	 * @return integer $feLoginMode
	 */
	public function getFeLoginMode() {
		return $this->feLoginMode;
	}

	/**
	 * Sets the feLoginMode
	 *
	 * @param integer $feLoginMode
	 * @return void
	 */
	public function setFeLoginMode($feLoginMode) {
		$this->feLoginMode = $feLoginMode;
	}

	/**
	 * Returns the urlScheme
	 *
	 * @return integer $urlScheme
	 */
	public function getUrlScheme() {
		return $this->urlScheme;
	}

	/**
	 * Sets the urlScheme
	 *
	 * @param integer $urlScheme
	 * @return void
	 */
	public function setUrlScheme($urlScheme) {
		$this->urlScheme = $urlScheme;
	}

	/**
	 * Returns the backendLayout
	 *
	 * @return integer $backendLayout
	 */
	public function getBackendLayout() {
		return $this->backendLayout;
	}

	/**
	 * Sets the backendLayout
	 *
	 * @param integer $backendLayout
	 * @return void
	 */
	public function setBackendLayout($backendLayout) {
		$this->backendLayout = $backendLayout;
	}

	/**
	 * Returns the backendLayoutNextLevel
	 *
	 * @return integer $backendLayoutNextLevel
	 */
	public function getBackendLayoutNextLevel() {
		return $this->backendLayoutNextLevel;
	}

	/**
	 * Sets the backendLayoutNextLevel
	 *
	 * @param integer $backendLayoutNextLevel
	 * @return void
	 */
	public function setBackendLayoutNextLevel($backendLayoutNextLevel) {
		$this->backendLayoutNextLevel = $backendLayoutNextLevel;
	}

	/**
	 * Returns the cacheTags
	 *
	 * @return string $cacheTags
	 */
	public function getCacheTags() {
		return $this->cacheTags;
	}

	/**
	 * Sets the cacheTags
	 *
	 * @param string $cacheTags
	 * @return void
	 */
	public function setCacheTags($cacheTags) {
		$this->cacheTags = $cacheTags;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getCrdate() {
		return $this->crdate;
	}

	/**
	 *
	 * @param \DateTime $crdate
	 */
	public function setCrdate($crdate) {
		$this->crdate = $crdate;
	}

	/**
	 *
	 * @return \DateTime
	 */
	public function getTstamp() {
		return $this->tstamp;
	}

	/**
	 *
	 * @param \DateTime $tstamp
	 */
	public function setTstamp($tstamp) {
		$this->tstamp = $tstamp;
	}



}