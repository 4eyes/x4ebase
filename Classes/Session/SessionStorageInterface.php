<?php
namespace X4e\X4ebase\Session;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Christoph Dörfel <christoph@4eyes.ch>, 4eyes GmbH
 *           Michel Georgy <michel@4eyes.ch>, 4eyes GmbH
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
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
interface SessionStorageInterface extends \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * Read session data
     *
     * @param string $key
     * @param string $type
     * @return mixed
     */
    public function get($key, $type = '');

    /**
     * Write data to the session
     *
     * @param string $key
     * @param mixed $data
     * @param string $type
     * @return void
     */
    public function set($key, $data, $type = '');

    /**
     * Returns TRUE if $key exists in the session, otherwise FALSE
     *
     * @param string $key
     * @param string $type
     * @return bool
     */
    public function has($key, $type = '');

    /**
     * Remove data from the session
     *
     * @param string $key
     * @param string $type
     * @return void
     */
    public function remove($key, $type = '');
}
