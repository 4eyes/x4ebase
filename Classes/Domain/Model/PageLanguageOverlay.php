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
class PageLanguageOverlay extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * crdate
     *
     * @var int
     */
    protected $crdate;

    /**
     * cruserId
     *
     * @var int
     */
    protected $backendUser;

    /**
     * sysLanguageUid
     *
     * @var int
     */
    protected $sysLanguageUid;

    /**
     * title
     *
     * @var string
     */
    protected $title;

    /**
     * hidden
     *
     * @var int
     */
    protected $hidden;

    /**
     * starttime
     *
     * @var int
     */
    protected $starttime;

    /**
     * endtime
     *
     * @var int
     */
    protected $endtime;

    /**
     * deleted
     *
     * @var int
     */
    protected $deleted;

    /**
     * subtitle
     *
     * @var string
     */
    protected $subtitle;

    /**
     * navTitle
     *
     * @var string
     */
    protected $navTitle;

    /**
     * media
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $media;

    /**
     * keywords
     *
     * @var string
     */
    protected $keywords;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * abstract
     *
     * @var string
     */
    protected $abstract;

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
     * doktype
     *
     * @var int
     */
    protected $doktype;

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
     * Returns the creation date
     *
     * @return int $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Sets the creation date
     *
     * @param int $crdate
     * @return void
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * Returns the cruserId
     *
     * @return int $cruserId
     */
    public function getBackendUser()
    {
        return $this->backendUser;
    }

    /**
     * Sets the cruserId
     *
     * @param int $cruserId
     * @return void
     */
    public function setBackendUser($backendUser)
    {
        $this->backendUser = $backendUser;
    }

    /**
     * Returns the sysLanguageUid
     *
     * @return int $sysLanguageUid
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
     * Returns the title
     *
     * @return string $title
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
     * Returns the hidden
     *
     * @return int $hidden
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Sets the hidden
     *
     * @param int $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

    /**
     * Returns the starttime
     *
     * @return int $starttime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Sets the starttime
     *
     * @param int $starttime
     * @return void
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * Returns the endtime
     *
     * @return int $endtime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Sets the endtime
     *
     * @param int $endtime
     * @return void
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;
    }

    /**
     * Returns the deleted
     *
     * @return int $deleted
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Sets the deleted
     *
     * @param int $deleted
     * @return void
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * Returns the subtitle
     *
     * @return string $subtitle
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
     * Returns the navTitle
     *
     * @return string $navTitle
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
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaToRemove The FileReference to be removed
     * @return void
     */
    public function removeMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaToRemove)
    {
        $this->media->detach($mediaToRemove);
    }

    /**
     * Returns the media
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
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
     * Returns the keywords
     *
     * @return string $keywords
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
     * Returns the description
     *
     * @return string $description
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
     * Returns the abstract
     *
     * @return string $abstract
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
     * Returns the author
     *
     * @return string $author
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
     * @return string $authorEmail
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
     * Returns the doktype
     *
     * @return int $doktype
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
     * Returns the url
     *
     * @return string $url
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
     * @return int $urltype
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
     * @return int $shortcut
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
     * @return int $shortcutMode
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
}
