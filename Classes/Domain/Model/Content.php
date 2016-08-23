<?php
namespace X4e\X4ebase\Domain\Model;

    /***************************************************************
     *  Copyright notice
     *
     *  (c) 2015 Alessandro Bellafronte <alessandro@4eyes.ch>, 4eyes GmbH
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
 * A TYPO3 tt_content record model for extbase
 *
 * @package x4ebase
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Content extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * ctype
     *
     * @var string
     */
    protected $ctype;

    /**
     * header
     *
     * @var string
     */
    protected $header;

    /**
     * headerPosition
     *
     * @var string
     */
    protected $headerPosition;

    /**
     * bodytext
     *
     * @var string
     */
    protected $bodytext;

    /**
     * image
     *
     * @var string
     */
    protected $image;

    /**
     * imagewidth
     *
     * @var integer
     */
    protected $imagewidth;

    /**
     * imageorient
     *
     * @var integer
     */
    protected $imageorient;

    /**
     * imagecaption
     *
     * @var string
     */
    protected $imagecaption;

    /**
     * imagecols
     *
     * @var integer
     */
    protected $imagecols;

    /**
     * imageborder
     *
     * @var integer
     */
    protected $imageborder;

    /**
     * media
     *
     * @var string
     */
    protected $media;

    /**
     * layout
     *
     * @var integer
     */
    protected $layout;

    /**
     * cols
     *
     * @var integer
     */
    protected $cols;

    /**
     * records
     *
     * @var string
     */
    protected $records;

    /**
     * pages
     *
     * @var string
     */
    protected $pages;

    /**
     * colpos
     *
     * @var integer
     */
    protected $colpos;

    /**
     * subheader
     *
     * @var string
     */
    protected $subheader;

    /**
     * spacebefore
     *
     * @var string
     */
    protected $spacebefore;

    /**
     * spaceafter
     *
     * @var string
     */
    protected $spaceafter;

    /**
     * feGroup
     *
     * @var string
     */
    protected $feGroup;

    /**
     * headerLink
     *
     * @var string
     */
    protected $headerLink;

    /**
     * imagecaptionPosition
     *
     * @var string
     */
    protected $imagecaptionPosition;

    /**
     * imageLink
     *
     * @var string
     */
    protected $imageLink;

    /**
     * imageZoom
     *
     * @var integer
     */
    protected $imageZoom;

    /**
     * imageNorows
     *
     * @var integer
     */
    protected $imageNorows;

    /**
     * imageEffects
     *
     * @var integer
     */
    protected $imageEffects;

    /**
     * imageCompression
     *
     * @var integer
     */
    protected $imageCompression;

    /**
     * alttext
     *
     * @var string
     */
    protected $alttext;

    /**
     * titletext
     *
     * @var string
     */
    protected $titletext;

    /**
     * longdescurl
     *
     * @var string
     */
    protected $longdescurl;

    /**
     * headerLayout
     *
     * @var string
     */
    protected $headerLayout;

    /**
     * menuType
     *
     * @var string
     */
    protected $menuType;

    /**
     * listType
     *
     * @var string
     */
    protected $listType;

    /**
     * tableBorder
     *
     * @var integer
     */
    protected $tableBorder;

    /**
     * tableCellspacing
     *
     * @var integer
     */
    protected $tableCellspacing;

    /**
     * tableCellpadding
     *
     * @var integer
     */
    protected $tableCellpadding;

    /**
     * tableBgcolor
     *
     * @var integer
     */
    protected $tableBgcolor;

    /**
     * selectKey
     *
     * @var string
     */
    protected $selectKey;

    /**
     * sectionindex
     *
     * @var integer
     */
    protected $sectionindex;

    /**
     * linktotop
     *
     * @var integer
     */
    protected $linktotop;

    /**
     * filelinkSize
     *
     * @var integer
     */
    protected $filelinkSize;

    /**
     * sectionFrame
     *
     * @var integer
     */
    protected $sectionFrame;

    /**
     * date
     *
     * @var integer
     */
    protected $date;

    /**
     * multimedia
     *
     * @var string
     */
    protected $multimedia;

    /**
     * imageFrames
     *
     * @var integer
     */
    protected $imageFrames;

    /**
     * recursive
     *
     * @var integer
     */
    protected $recursive;

    /**
     * imageheight
     *
     * @var integer
     */
    protected $imageheight;

    /**
     * rteEnabled
     *
     * @var integer
     */
    protected $rteEnabled;

    /**
     * piFlexform
     *
     * @var string
     */
    protected $piFlexform;

    /**
     * fileCollections
     *
     * @var string
     */
    protected $fileCollections;

    /**
     * filelinkSorting
     *
     * @var string
     */
    protected $filelinkSorting;

    /**
     * target
     *
     * @var string
     */
    protected $target;

    /**
     * accessibilityTitle
     *
     * @var string
     */
    protected $accessibilityTitle;

    /**
     * accessibilityBypass
     *
     * @var integer
     */
    protected $accessibilityBypass;

    /**
     * accessibilityBypassText
     *
     * @var string
     */
    protected $accessibilityBypassText;

    /**
     * selectedCategories
     *
     * @var string
     */
    protected $selectedCategories;

    /**
     * categoryField
     *
     * @var string
     */
    protected $categoryField;

    /**
     * categories
     *
     * @var integer
     */
    protected $categories;

    /**
     * __construct
     *
     * @return TtContent
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
     * Returns the ctype
     *
     * @return string $ctype
     */
    public function getCtype() {
        return $this->ctype;
    }

    /**
     * Sets the ctype
     *
     * @param string $ctype
     * @return void
     */
    public function setCtype($ctype) {
        $this->ctype = $ctype;
    }

    /**
     * Returns the header
     *
     * @return string $header
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * Sets the header
     *
     * @param string $header
     * @return void
     */
    public function setHeader($header) {
        $this->header = $header;
    }

    /**
     * Returns the headerPosition
     *
     * @return string $headerPosition
     */
    public function getHeaderPosition() {
        return $this->headerPosition;
    }

    /**
     * Sets the headerPosition
     *
     * @param string $headerPosition
     * @return void
     */
    public function setHeaderPosition($headerPosition) {
        $this->headerPosition = $headerPosition;
    }

    /**
     * Returns the bodytext
     *
     * @return string $bodytext
     */
    public function getBodytext() {
        return $this->bodytext;
    }

    /**
     * Sets the bodytext
     *
     * @param string $bodytext
     * @return void
     */
    public function setBodytext($bodytext) {
        $this->bodytext = $bodytext;
    }

    /**
     * Returns the image
     *
     * @return string $image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param string $image
     * @return void
     */
    public function setImage($image) {
        $this->image = $image;
    }

    /**
     * Returns the imagewidth
     *
     * @return integer $imagewidth
     */
    public function getImagewidth() {
        return $this->imagewidth;
    }

    /**
     * Sets the imagewidth
     *
     * @param integer $imagewidth
     * @return void
     */
    public function setImagewidth($imagewidth) {
        $this->imagewidth = $imagewidth;
    }

    /**
     * Returns the imageorient
     *
     * @return integer $imageorient
     */
    public function getImageorient() {
        return $this->imageorient;
    }

    /**
     * Sets the imageorient
     *
     * @param integer $imageorient
     * @return void
     */
    public function setImageorient($imageorient) {
        $this->imageorient = $imageorient;
    }

    /**
     * Returns the imagecaption
     *
     * @return string $imagecaption
     */
    public function getImagecaption() {
        return $this->imagecaption;
    }

    /**
     * Sets the imagecaption
     *
     * @param string $imagecaption
     * @return void
     */
    public function setImagecaption($imagecaption) {
        $this->imagecaption = $imagecaption;
    }

    /**
     * Returns the imagecols
     *
     * @return integer $imagecols
     */
    public function getImagecols() {
        return $this->imagecols;
    }

    /**
     * Sets the imagecols
     *
     * @param integer $imagecols
     * @return void
     */
    public function setImagecols($imagecols) {
        $this->imagecols = $imagecols;
    }

    /**
     * Returns the imageborder
     *
     * @return integer $imageborder
     */
    public function getImageborder() {
        return $this->imageborder;
    }

    /**
     * Sets the imageborder
     *
     * @param integer $imageborder
     * @return void
     */
    public function setImageborder($imageborder) {
        $this->imageborder = $imageborder;
    }

    /**
     * Returns the media
     *
     * @return string $media
     */
    public function getMedia() {
        return $this->media;
    }

    /**
     * Sets the media
     *
     * @param string $media
     * @return void
     */
    public function setMedia($media) {
        $this->media = $media;
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
     * Returns the cols
     *
     * @return integer $cols
     */
    public function getCols() {
        return $this->cols;
    }

    /**
     * Sets the cols
     *
     * @param integer $cols
     * @return void
     */
    public function setCols($cols) {
        $this->cols = $cols;
    }

    /**
     * Returns the records
     *
     * @return string $records
     */
    public function getRecords() {
        return $this->records;
    }

    /**
     * Sets the records
     *
     * @param string $records
     * @return void
     */
    public function setRecords($records) {
        $this->records = $records;
    }

    /**
     * Returns the pages
     *
     * @return string $pages
     */
    public function getPages() {
        return $this->pages;
    }

    /**
     * Sets the pages
     *
     * @param string $pages
     * @return void
     */
    public function setPages($pages) {
        $this->pages = $pages;
    }

    /**
     * Returns the colpos
     *
     * @return integer $colpos
     */
    public function getColpos() {
        return $this->colpos;
    }

    /**
     * Sets the colpos
     *
     * @param integer $colpos
     * @return void
     */
    public function setColpos($colpos) {
        $this->colpos = $colpos;
    }

    /**
     * Returns the subheader
     *
     * @return string $subheader
     */
    public function getSubheader() {
        return $this->subheader;
    }

    /**
     * Sets the subheader
     *
     * @param string $subheader
     * @return void
     */
    public function setSubheader($subheader) {
        $this->subheader = $subheader;
    }

    /**
     * Returns the spacebefore
     *
     * @return string $spacebefore
     */
    public function getSpacebefore() {
        return $this->spacebefore;
    }

    /**
     * Sets the spacebefore
     *
     * @param string $spacebefore
     * @return void
     */
    public function setSpacebefore($spacebefore) {
        $this->spacebefore = $spacebefore;
    }

    /**
     * Returns the spaceafter
     *
     * @return string $spaceafter
     */
    public function getSpaceafter() {
        return $this->spaceafter;
    }

    /**
     * Sets the spaceafter
     *
     * @param string $spaceafter
     * @return void
     */
    public function setSpaceafter($spaceafter) {
        $this->spaceafter = $spaceafter;
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
     * Returns the headerLink
     *
     * @return string $headerLink
     */
    public function getHeaderLink() {
        return $this->headerLink;
    }

    /**
     * Sets the headerLink
     *
     * @param string $headerLink
     * @return void
     */
    public function setHeaderLink($headerLink) {
        $this->headerLink = $headerLink;
    }

    /**
     * Returns the imagecaptionPosition
     *
     * @return string $imagecaptionPosition
     */
    public function getImagecaptionPosition() {
        return $this->imagecaptionPosition;
    }

    /**
     * Sets the imagecaptionPosition
     *
     * @param string $imagecaptionPosition
     * @return void
     */
    public function setImagecaptionPosition($imagecaptionPosition) {
        $this->imagecaptionPosition = $imagecaptionPosition;
    }

    /**
     * Returns the imageLink
     *
     * @return string $imageLink
     */
    public function getImageLink() {
        return $this->imageLink;
    }

    /**
     * Sets the imageLink
     *
     * @param string $imageLink
     * @return void
     */
    public function setImageLink($imageLink) {
        $this->imageLink = $imageLink;
    }

    /**
     * Returns the imageZoom
     *
     * @return integer $imageZoom
     */
    public function getImageZoom() {
        return $this->imageZoom;
    }

    /**
     * Sets the imageZoom
     *
     * @param integer $imageZoom
     * @return void
     */
    public function setImageZoom($imageZoom) {
        $this->imageZoom = $imageZoom;
    }

    /**
     * Returns the imageNorows
     *
     * @return integer $imageNorows
     */
    public function getImageNorows() {
        return $this->imageNorows;
    }

    /**
     * Sets the imageNorows
     *
     * @param integer $imageNorows
     * @return void
     */
    public function setImageNorows($imageNorows) {
        $this->imageNorows = $imageNorows;
    }

    /**
     * Returns the imageEffects
     *
     * @return integer $imageEffects
     */
    public function getImageEffects() {
        return $this->imageEffects;
    }

    /**
     * Sets the imageEffects
     *
     * @param integer $imageEffects
     * @return void
     */
    public function setImageEffects($imageEffects) {
        $this->imageEffects = $imageEffects;
    }

    /**
     * Returns the imageCompression
     *
     * @return integer $imageCompression
     */
    public function getImageCompression() {
        return $this->imageCompression;
    }

    /**
     * Sets the imageCompression
     *
     * @param integer $imageCompression
     * @return void
     */
    public function setImageCompression($imageCompression) {
        $this->imageCompression = $imageCompression;
    }

    /**
     * Returns the alttext
     *
     * @return string $alttext
     */
    public function getAlttext() {
        return $this->alttext;
    }

    /**
     * Sets the alttext
     *
     * @param string $alttext
     * @return void
     */
    public function setAlttext($alttext) {
        $this->alttext = $alttext;
    }

    /**
     * Returns the titletext
     *
     * @return string $titletext
     */
    public function getTitletext() {
        return $this->titletext;
    }

    /**
     * Sets the titletext
     *
     * @param string $titletext
     * @return void
     */
    public function setTitletext($titletext) {
        $this->titletext = $titletext;
    }

    /**
     * Returns the longdescurl
     *
     * @return string $longdescurl
     */
    public function getLongdescurl() {
        return $this->longdescurl;
    }

    /**
     * Sets the longdescurl
     *
     * @param string $longdescurl
     * @return void
     */
    public function setLongdescurl($longdescurl) {
        $this->longdescurl = $longdescurl;
    }

    /**
     * Returns the headerLayout
     *
     * @return string $headerLayout
     */
    public function getHeaderLayout() {
        return $this->headerLayout;
    }

    /**
     * Sets the headerLayout
     *
     * @param string $headerLayout
     * @return void
     */
    public function setHeaderLayout($headerLayout) {
        $this->headerLayout = $headerLayout;
    }

    /**
     * Returns the menuType
     *
     * @return string $menuType
     */
    public function getMenuType() {
        return $this->menuType;
    }

    /**
     * Sets the menuType
     *
     * @param string $menuType
     * @return void
     */
    public function setMenuType($menuType) {
        $this->menuType = $menuType;
    }

    /**
     * Returns the listType
     *
     * @return string $listType
     */
    public function getListType() {
        return $this->listType;
    }

    /**
     * Sets the listType
     *
     * @param string $listType
     * @return void
     */
    public function setListType($listType) {
        $this->listType = $listType;
    }

    /**
     * Returns the tableBorder
     *
     * @return integer $tableBorder
     */
    public function getTableBorder() {
        return $this->tableBorder;
    }

    /**
     * Sets the tableBorder
     *
     * @param integer $tableBorder
     * @return void
     */
    public function setTableBorder($tableBorder) {
        $this->tableBorder = $tableBorder;
    }

    /**
     * Returns the tableCellspacing
     *
     * @return integer $tableCellspacing
     */
    public function getTableCellspacing() {
        return $this->tableCellspacing;
    }

    /**
     * Sets the tableCellspacing
     *
     * @param integer $tableCellspacing
     * @return void
     */
    public function setTableCellspacing($tableCellspacing) {
        $this->tableCellspacing = $tableCellspacing;
    }

    /**
     * Returns the tableCellpadding
     *
     * @return integer $tableCellpadding
     */
    public function getTableCellpadding() {
        return $this->tableCellpadding;
    }

    /**
     * Sets the tableCellpadding
     *
     * @param integer $tableCellpadding
     * @return void
     */
    public function setTableCellpadding($tableCellpadding) {
        $this->tableCellpadding = $tableCellpadding;
    }

    /**
     * Returns the tableBgcolor
     *
     * @return integer $tableBgcolor
     */
    public function getTableBgcolor() {
        return $this->tableBgcolor;
    }

    /**
     * Sets the tableBgcolor
     *
     * @param integer $tableBgcolor
     * @return void
     */
    public function setTableBgcolor($tableBgcolor) {
        $this->tableBgcolor = $tableBgcolor;
    }

    /**
     * Returns the selectKey
     *
     * @return string $selectKey
     */
    public function getSelectKey() {
        return $this->selectKey;
    }

    /**
     * Sets the selectKey
     *
     * @param string $selectKey
     * @return void
     */
    public function setSelectKey($selectKey) {
        $this->selectKey = $selectKey;
    }

    /**
     * Returns the sectionindex
     *
     * @return integer $sectionindex
     */
    public function getSectionindex() {
        return $this->sectionindex;
    }

    /**
     * Sets the sectionindex
     *
     * @param integer $sectionindex
     * @return void
     */
    public function setSectionindex($sectionindex) {
        $this->sectionindex = $sectionindex;
    }

    /**
     * Returns the linktotop
     *
     * @return integer $linktotop
     */
    public function getLinktotop() {
        return $this->linktotop;
    }

    /**
     * Sets the linktotop
     *
     * @param integer $linktotop
     * @return void
     */
    public function setLinktotop($linktotop) {
        $this->linktotop = $linktotop;
    }

    /**
     * Returns the filelinkSize
     *
     * @return integer $filelinkSize
     */
    public function getFilelinkSize() {
        return $this->filelinkSize;
    }

    /**
     * Sets the filelinkSize
     *
     * @param integer $filelinkSize
     * @return void
     */
    public function setFilelinkSize($filelinkSize) {
        $this->filelinkSize = $filelinkSize;
    }

    /**
     * Returns the sectionFrame
     *
     * @return integer $sectionFrame
     */
    public function getSectionFrame() {
        return $this->sectionFrame;
    }

    /**
     * Sets the sectionFrame
     *
     * @param integer $sectionFrame
     * @return void
     */
    public function setSectionFrame($sectionFrame) {
        $this->sectionFrame = $sectionFrame;
    }

    /**
     * Returns the date
     *
     * @return integer $date
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param integer $date
     * @return void
     */
    public function setDate($date) {
        $this->date = $date;
    }

    /**
     * Returns the multimedia
     *
     * @return string $multimedia
     */
    public function getMultimedia() {
        return $this->multimedia;
    }

    /**
     * Sets the multimedia
     *
     * @param string $multimedia
     * @return void
     */
    public function setMultimedia($multimedia) {
        $this->multimedia = $multimedia;
    }

    /**
     * Returns the imageFrames
     *
     * @return integer $imageFrames
     */
    public function getImageFrames() {
        return $this->imageFrames;
    }

    /**
     * Sets the imageFrames
     *
     * @param integer $imageFrames
     * @return void
     */
    public function setImageFrames($imageFrames) {
        $this->imageFrames = $imageFrames;
    }

    /**
     * Returns the recursive
     *
     * @return integer $recursive
     */
    public function getRecursive() {
        return $this->recursive;
    }

    /**
     * Sets the recursive
     *
     * @param integer $recursive
     * @return void
     */
    public function setRecursive($recursive) {
        $this->recursive = $recursive;
    }

    /**
     * Returns the imageheight
     *
     * @return integer $imageheight
     */
    public function getImageheight() {
        return $this->imageheight;
    }

    /**
     * Sets the imageheight
     *
     * @param integer $imageheight
     * @return void
     */
    public function setImageheight($imageheight) {
        $this->imageheight = $imageheight;
    }

    /**
     * Returns the rteEnabled
     *
     * @return integer $rteEnabled
     */
    public function getRteEnabled() {
        return $this->rteEnabled;
    }

    /**
     * Sets the rteEnabled
     *
     * @param integer $rteEnabled
     * @return void
     */
    public function setRteEnabled($rteEnabled) {
        $this->rteEnabled = $rteEnabled;
    }

    /**
     * Returns the piFlexform
     *
     * @return string $piFlexform
     */
    public function getPiFlexform() {
        return $this->piFlexform;
    }

    /**
     * Sets the piFlexform
     *
     * @param string $piFlexform
     * @return void
     */
    public function setPiFlexform($piFlexform) {
        $this->piFlexform = $piFlexform;
    }

    /**
     * Returns the fileCollections
     *
     * @return string $fileCollections
     */
    public function getFileCollections() {
        return $this->fileCollections;
    }

    /**
     * Sets the fileCollections
     *
     * @param string $fileCollections
     * @return void
     */
    public function setFileCollections($fileCollections) {
        $this->fileCollections = $fileCollections;
    }

    /**
     * Returns the filelinkSorting
     *
     * @return string $filelinkSorting
     */
    public function getFilelinkSorting() {
        return $this->filelinkSorting;
    }

    /**
     * Sets the filelinkSorting
     *
     * @param string $filelinkSorting
     * @return void
     */
    public function setFilelinkSorting($filelinkSorting) {
        $this->filelinkSorting = $filelinkSorting;
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
     * Returns the accessibilityTitle
     *
     * @return string $accessibilityTitle
     */
    public function getAccessibilityTitle() {
        return $this->accessibilityTitle;
    }

    /**
     * Sets the accessibilityTitle
     *
     * @param string $accessibilityTitle
     * @return void
     */
    public function setAccessibilityTitle($accessibilityTitle) {
        $this->accessibilityTitle = $accessibilityTitle;
    }

    /**
     * Returns the accessibilityBypass
     *
     * @return integer $accessibilityBypass
     */
    public function getAccessibilityBypass() {
        return $this->accessibilityBypass;
    }

    /**
     * Sets the accessibilityBypass
     *
     * @param integer $accessibilityBypass
     * @return void
     */
    public function setAccessibilityBypass($accessibilityBypass) {
        $this->accessibilityBypass = $accessibilityBypass;
    }

    /**
     * Returns the accessibilityBypassText
     *
     * @return string $accessibilityBypassText
     */
    public function getAccessibilityBypassText() {
        return $this->accessibilityBypassText;
    }

    /**
     * Sets the accessibilityBypassText
     *
     * @param string $accessibilityBypassText
     * @return void
     */
    public function setAccessibilityBypassText($accessibilityBypassText) {
        $this->accessibilityBypassText = $accessibilityBypassText;
    }

    /**
     * Returns the selectedCategories
     *
     * @return string $selectedCategories
     */
    public function getSelectedCategories() {
        return $this->selectedCategories;
    }

    /**
     * Sets the selectedCategories
     *
     * @param string $selectedCategories
     * @return void
     */
    public function setSelectedCategories($selectedCategories) {
        $this->selectedCategories = $selectedCategories;
    }

    /**
     * Returns the categoryField
     *
     * @return string $categoryField
     */
    public function getCategoryField() {
        return $this->categoryField;
    }

    /**
     * Sets the categoryField
     *
     * @param string $categoryField
     * @return void
     */
    public function setCategoryField($categoryField) {
        $this->categoryField = $categoryField;
    }

    /**
     * Returns the categories
     *
     * @return integer $categories
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Sets the categories
     *
     * @param integer $categories
     * @return void
     */
    public function setCategories($categories) {
        $this->categories = $categories;
    }
}