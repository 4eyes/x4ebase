<?php
namespace X4e\X4ebase\Domain\Model;

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
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Page extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * sorting
     *
     * @var int
     */
    protected $sorting;

    /**
     * sysLanguageUid
     *
     * @var int
     */
    protected $sysLanguageUid = 0;

    /**
     * permsUserid
     *
     * @var int
     */
    protected $permsUserid;

    /**
     * permsGroupid
     *
     * @var int
     */
    protected $permsGroupid;

    /**
     * permsUser
     *
     * @var int
     */
    protected $permsUser;

    /**
     * permsGroup
     *
     * @var int
     */
    protected $permsGroup;

    /**
     * permsEverybody
     *
     * @var int
     */
    protected $permsEverybody;

    /**
     * editlock
     *
     * @var int
     */
    protected $editlock;

    /**
     * cruserId
     *
     * @var int
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
     * @var int
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
     * @var int
     */
    protected $storagePid;

    /**
     * isSiteroot
     *
     * @var int
     */
    protected $isSiteroot;

    /**
     * phpTreeStop
     *
     * @var int
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
     * @var int
     */
    protected $urltype;

    /**
     * shortcut
     *
     * @var int
     */
    protected $shortcut;

    /**
     * shortcutMode
     *
     * @var int
     */
    protected $shortcutMode;

    /**
     * noCache
     *
     * @var int
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
     * @var int
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
     * @var int
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
     * @var int
     */
    protected $cacheTimeout;

    /**
     * newuntil
     *
     * @var int
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
     * @var int
     */
    protected $noSearch;

    /**
     * sysLastchanged
     *
     * @var int
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
     * @var int
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
     * @var int
     */
    protected $navHide;

    /**
     * contentFromPid
     *
     * @var int
     */
    protected $contentFromPid;

    /**
     * mountPid
     *
     * @var int
     */
    protected $mountPid;

    /**
     * mountPidOl
     *
     * @var int
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
     * @var int
     */
    protected $l18nCfg;

    /**
     * feLoginMode
     *
     * @var int
     */
    protected $feLoginMode;

    /**
     * urlScheme
     *
     * @var int
     */
    protected $urlScheme;

    /**
     * backendLayout
     *
     * @var int
     */
    protected $backendLayout;

    /**
     * backendLayoutNextLevel
     *
     * @var int
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
     * Returns the sorting
     *
     * @return int
     */
    public function getSorting()
    {
        return $this->sorting;
    }

    /**
     * Sets the sorting
     *
     * @param int $sorting
     * @return void
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

    /**
     * Returns the sysLanguageUid
     *
     * @return int
     */
    public function getSysLanguageUid()
    {
        return $this->sysLanguageUid;
    }

    /**
     * Sets the sysLanguageUid
     *
     * @param int $sysLanguageUid
     * @return void
     */
    public function setSysLanguageUid($sysLanguageUid)
    {
        $this->sysLanguageUid = $sysLanguageUid;
    }

    /**
     * Returns the permsUserid
     *
     * @return int
     */
    public function getPermsUserid()
    {
        return $this->permsUserid;
    }

    /**
     * Sets the permsUserid
     *
     * @param int $permsUserid
     * @return void
     */
    public function setPermsUserid($permsUserid)
    {
        $this->permsUserid = $permsUserid;
    }

    /**
     * Returns the permsGroupid
     *
     * @return int
     */
    public function getPermsGroupid()
    {
        return $this->permsGroupid;
    }

    /**
     * Sets the permsGroupid
     *
     * @param int $permsGroupid
     * @return void
     */
    public function setPermsGroupid($permsGroupid)
    {
        $this->permsGroupid = $permsGroupid;
    }

    /**
     * Returns the permsUser
     *
     * @return int
     */
    public function getPermsUser()
    {
        return $this->permsUser;
    }

    /**
     * Sets the permsUser
     *
     * @param int $permsUser
     * @return void
     */
    public function setPermsUser($permsUser)
    {
        $this->permsUser = $permsUser;
    }

    /**
     * Returns the permsGroup
     *
     * @return int
     */
    public function getPermsGroup()
    {
        return $this->permsGroup;
    }

    /**
     * Sets the permsGroup
     *
     * @param int $permsGroup
     * @return void
     */
    public function setPermsGroup($permsGroup)
    {
        $this->permsGroup = $permsGroup;
    }

    /**
     * Returns the permsEverybody
     *
     * @return int
     */
    public function getPermsEverybody()
    {
        return $this->permsEverybody;
    }

    /**
     * Sets the permsEverybody
     *
     * @param int $permsEverybody
     * @return void
     */
    public function setPermsEverybody($permsEverybody)
    {
        $this->permsEverybody = $permsEverybody;
    }

    /**
     * Returns the editlock
     *
     * @return int
     */
    public function getEditlock()
    {
        return $this->editlock;
    }

    /**
     * Sets the editlock
     *
     * @param int $editlock
     * @return void
     */
    public function setEditlock($editlock)
    {
        $this->editlock = $editlock;
    }

    /**
     * Returns the cruserId
     *
     * @return int
     */
    public function getCruserId()
    {
        return $this->cruserId;
    }

    /**
     * Sets the cruserId
     *
     * @param int $cruserId
     * @return void
     */
    public function setCruserId($cruserId)
    {
        $this->cruserId = $cruserId;
    }

    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the doktype
     *
     * @return int
     */
    public function getDoktype()
    {
        return $this->doktype;
    }

    /**
     * Sets the doktype
     *
     * @param int $doktype
     * @return void
     */
    public function setDoktype($doktype)
    {
        $this->doktype = $doktype;
    }

    /**
     * Returns the tsconfig
     *
     * @return string
     */
    public function getTsconfig()
    {
        return $this->tsconfig;
    }

    /**
     * Sets the tsconfig
     *
     * @param string $tsconfig
     * @return void
     */
    public function setTsconfig($tsconfig)
    {
        $this->tsconfig = $tsconfig;
    }

    /**
     * Returns the storagePid
     *
     * @return int
     */
    public function getStoragePid()
    {
        return $this->storagePid;
    }

    /**
     * Sets the storagePid
     *
     * @param int $storagePid
     * @return void
     */
    public function setStoragePid($storagePid)
    {
        $this->storagePid = $storagePid;
    }

    /**
     * Returns the isSiteroot
     *
     * @return int
     */
    public function getIsSiteroot()
    {
        return $this->isSiteroot;
    }

    /**
     * Sets the isSiteroot
     *
     * @param int $isSiteroot
     * @return void
     */
    public function setIsSiteroot($isSiteroot)
    {
        $this->isSiteroot = $isSiteroot;
    }

    /**
     * Returns the phpTreeStop
     *
     * @return int
     */
    public function getPhpTreeStop()
    {
        return $this->phpTreeStop;
    }

    /**
     * Sets the phpTreeStop
     *
     * @param int $phpTreeStop
     * @return void
     */
    public function setPhpTreeStop($phpTreeStop)
    {
        $this->phpTreeStop = $phpTreeStop;
    }

    /**
     * Returns the url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Returns the urltype
     *
     * @return int
     */
    public function getUrltype()
    {
        return $this->urltype;
    }

    /**
     * Sets the urltype
     *
     * @param int $urltype
     * @return void
     */
    public function setUrltype($urltype)
    {
        $this->urltype = $urltype;
    }

    /**
     * Returns the shortcut
     *
     * @return int
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * Sets the shortcut
     *
     * @param int $shortcut
     * @return void
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;
    }

    /**
     * Returns the shortcutMode
     *
     * @return int
     */
    public function getShortcutMode()
    {
        return $this->shortcutMode;
    }

    /**
     * Sets the shortcutMode
     *
     * @param int $shortcutMode
     * @return void
     */
    public function setShortcutMode($shortcutMode)
    {
        $this->shortcutMode = $shortcutMode;
    }

    /**
     * Returns the noCache
     *
     * @return int
     */
    public function getNoCache()
    {
        return $this->noCache;
    }

    /**
     * Sets the noCache
     *
     * @param int $noCache
     * @return void
     */
    public function setNoCache($noCache)
    {
        $this->noCache = $noCache;
    }

    /**
     * Returns the feGroup
     *
     * @return string
     */
    public function getFeGroup()
    {
        return $this->feGroup;
    }

    /**
     * Sets the feGroup
     *
     * @param string $feGroup
     * @return void
     */
    public function setFeGroup($feGroup)
    {
        $this->feGroup = $feGroup;
    }

    /**
     * Returns the subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Sets the subtitle
     *
     * @param string $subtitle
     * @return void
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Returns the layout
     *
     * @return int
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Sets the layout
     *
     * @param int $layout
     * @return void
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * Returns the target
     *
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Sets the target
     *
     * @param string $target
     * @return void
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Adds a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
     * @return void
     */
    public function addMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $media)
    {
        $this->media->attach($media);
    }

    /**
     * Removes a FileReference
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaToRemove
     * @return void
     */
    public function removeMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaToRemove)
    {
        $this->media->detach($mediaToRemove);
    }

    /**
     * Returns the media
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Sets the media
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     * @return void
     */
    public function setMedia(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $media)
    {
        $this->media = $media;
    }

    /**
     * Returns the lastupdated
     *
     * @return int
     */
    public function getLastupdated()
    {
        return $this->lastupdated;
    }

    /**
     * Sets the lastupdated
     *
     * @param int $lastupdated
     * @return void
     */
    public function setLastupdated($lastupdated)
    {
        $this->lastupdated = $lastupdated;
    }

    /**
     * Returns the keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Sets the keywords
     *
     * @param string $keywords
     * @return void
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Returns the cacheTimeout
     *
     * @return int
     */
    public function getCacheTimeout()
    {
        return $this->cacheTimeout;
    }

    /**
     * Sets the cacheTimeout
     *
     * @param int $cacheTimeout
     * @return void
     */
    public function setCacheTimeout($cacheTimeout)
    {
        $this->cacheTimeout = $cacheTimeout;
    }

    /**
     * Returns the newuntil
     *
     * @return int
     */
    public function getNewuntil()
    {
        return $this->newuntil;
    }

    /**
     * Sets the newuntil
     *
     * @param int $newuntil
     * @return void
     */
    public function setNewuntil($newuntil)
    {
        $this->newuntil = $newuntil;
    }

    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the noSearch
     *
     * @return int
     */
    public function getNoSearch()
    {
        return $this->noSearch;
    }

    /**
     * Sets the noSearch
     *
     * @param int $noSearch
     * @return void
     */
    public function setNoSearch($noSearch)
    {
        $this->noSearch = $noSearch;
    }

    /**
     * Returns the abstract
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Sets the abstract
     *
     * @param string $abstract
     * @return void
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Returns the module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Sets the module
     *
     * @param string $module
     * @return void
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Returns the extendtosubpages
     *
     * @return int
     */
    public function getExtendtosubpages()
    {
        return $this->extendtosubpages;
    }

    /**
     * Sets the extendtosubpages
     *
     * @param int $extendtosubpages
     * @return void
     */
    public function setExtendtosubpages($extendtosubpages)
    {
        $this->extendtosubpages = $extendtosubpages;
    }

    /**
     * Returns the author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Sets the author
     *
     * @param string $author
     * @return void
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Returns the authorEmail
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->authorEmail;
    }

    /**
     * Sets the authorEmail
     *
     * @param string $authorEmail
     * @return void
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->authorEmail = $authorEmail;
    }

    /**
     * Returns the navTitle
     *
     * @return string
     */
    public function getNavTitle()
    {
        return $this->navTitle;
    }

    /**
     * Sets the navTitle
     *
     * @param string $navTitle
     * @return void
     */
    public function setNavTitle($navTitle)
    {
        $this->navTitle = $navTitle;
    }

    /**
     * Returns the navHide
     *
     * @return int
     */
    public function getNavHide()
    {
        return $this->navHide;
    }

    /**
     * Sets the navHide
     *
     * @param int $navHide
     * @return void
     */
    public function setNavHide($navHide)
    {
        $this->navHide = $navHide;
    }

    /**
     * Returns the contentFromPid
     *
     * @return int
     */
    public function getContentFromPid()
    {
        return $this->contentFromPid;
    }

    /**
     * Sets the contentFromPid
     *
     * @param int $contentFromPid
     * @return void
     */
    public function setContentFromPid($contentFromPid)
    {
        $this->contentFromPid = $contentFromPid;
    }

    /**
     * Returns the mountPid
     *
     * @return int
     */
    public function getMountPid()
    {
        return $this->mountPid;
    }

    /**
     * Sets the mountPid
     *
     * @param int $mountPid
     * @return void
     */
    public function setMountPid($mountPid)
    {
        $this->mountPid = $mountPid;
    }

    /**
     * Returns the mountPidOl
     *
     * @return int
     */
    public function getMountPidOl()
    {
        return $this->mountPidOl;
    }

    /**
     * Sets the mountPidOl
     *
     * @param int $mountPidOl
     * @return void
     */
    public function setMountPidOl($mountPidOl)
    {
        $this->mountPidOl = $mountPidOl;
    }

    /**
     * Returns the alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Sets the alias
     *
     * @param string $alias
     * @return void
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Returns the l18nCfg
     *
     * @return int
     */
    public function getL18nCfg()
    {
        return $this->l18nCfg;
    }

    /**
     * Sets the l18nCfg
     *
     * @param int $l18nCfg
     * @return void
     */
    public function setL18nCfg($l18nCfg)
    {
        $this->l18nCfg = $l18nCfg;
    }

    /**
     * Returns the feLoginMode
     *
     * @return int
     */
    public function getFeLoginMode()
    {
        return $this->feLoginMode;
    }

    /**
     * Sets the feLoginMode
     *
     * @param int $feLoginMode
     * @return void
     */
    public function setFeLoginMode($feLoginMode)
    {
        $this->feLoginMode = $feLoginMode;
    }

    /**
     * Returns the urlScheme
     *
     * @return int
     */
    public function getUrlScheme()
    {
        return $this->urlScheme;
    }

    /**
     * Sets the urlScheme
     *
     * @param int $urlScheme
     * @return void
     */
    public function setUrlScheme($urlScheme)
    {
        $this->urlScheme = $urlScheme;
    }

    /**
     * Returns the backendLayout
     *
     * @return int
     */
    public function getBackendLayout()
    {
        return $this->backendLayout;
    }

    /**
     * Sets the backendLayout
     *
     * @param int $backendLayout
     * @return void
     */
    public function setBackendLayout($backendLayout)
    {
        $this->backendLayout = $backendLayout;
    }

    /**
     * Returns the backendLayoutNextLevel
     *
     * @return int
     */
    public function getBackendLayoutNextLevel()
    {
        return $this->backendLayoutNextLevel;
    }

    /**
     * Sets the backendLayoutNextLevel
     *
     * @param int $backendLayoutNextLevel
     * @return void
     */
    public function setBackendLayoutNextLevel($backendLayoutNextLevel)
    {
        $this->backendLayoutNextLevel = $backendLayoutNextLevel;
    }

    /**
     * Returns the cacheTags
     *
     * @return string
     */
    public function getCacheTags()
    {
        return $this->cacheTags;
    }

    /**
     * Sets the cacheTags
     *
     * @param string $cacheTags
     * @return void
     */
    public function setCacheTags($cacheTags)
    {
        $this->cacheTags = $cacheTags;
    }

    /**
     *
     * @return \DateTime
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     *
     * @param \DateTime $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     *
     * @return \DateTime
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     *
     * @param \DateTime $tstamp
     */
    public function setTstamp($tstamp)
    {
        $this->tstamp = $tstamp;
    }
}
