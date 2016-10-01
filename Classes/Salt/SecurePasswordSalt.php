<?php
namespace X4e\X4ebase\Salt;

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
 *
 *
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class SecurePasswordSalt implements \TYPO3\CMS\Saltedpasswords\Salt\SaltInterface
{

    /**
     * Keeps length of a salt.
     *
     * @var int
     */
    protected static $saltLength = 22;

    /**
     * The CPU cost factor of the current algorithm.
     *
     * @var int
     */
    protected $cost = 10;

    /**
     * Requires dependant function implementation
     */
    public function __construct()
    {
        $extConf = \X4e\X4ebase\Utility\GeneralUtility::getExtConf('x4ebase');
        if (isset($extConf['securePassword.']) && isset($extConf['securePassword.']['cost'])) {
            $cost = intval($extConf['securePassword.']['cost']);
            if ($cost > 3 && $cost < 32) {
                $this->cost = $cost;
            }
        }
    }

    /**
     * Returns the current cost factor
     *
     * @return int
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Sets the cost factor
     *
     * @param int $cost Cost factor
     */
    public function setCost($cost)
    {
        $this->cost = intval($cost);
    }

    /**
     * Method checks if a given plaintext password is correct by comparing it with
     * a given salted hashed password.
     *
     * @param string $plainPW plain-text password to compare with salted hash
     * @param string $saltedHashPW salted hash to compare plain-text password with
     * @return bool TRUE, if plain-text password matches the salted hash, otherwise FALSE
     */
    public function checkPassword($plainPW, $saltedHashPW)
    {
        return password_verify($plainPW, $saltedHashPW);
    }

    /**
     * Method creates a salted hash for a given plaintext password
     *
     * @param string $password plaintext password to create a salted hash from
     * @param string $salt Optional custom salt with setting to use
     * @return string Salted hashed password
     */
    public function getHashedPassword($password, $salt = null)
    {
        $saltedPW = null;
        if (!empty($password)) {
            $options = ['cost' => $this->cost];
            if (!empty($salt) && $this->isValidSalt($salt)) {
                $options['salt'] = $salt;
            }
            $saltedPW = password_hash($password, PASSWORD_DEFAULT, $options);
        }
        return $saltedPW;
    }

    /**
     * Returns length of a Blowfish salt in bytes.
     *
     * @return int Length of a Blowfish salt in bytes
     */
    public function getSaltLength()
    {
        return self::$saltLength;
    }

    /**
     * Returns whether all prerequisites for the hashing methods are matched
     *
     * @return bool Method available
     */
    public function isAvailable()
    {
        return PASSWORD_DEFAULT;
    }

    /**
     * Checks whether a user's hashed password needs to be replaced with a new hash.
     *
     * This is typically called during the login process when the plain text
     * password is available.  A new hash is needed when the desired iteration
     * count has changed through a change in the variable $hashCount or
     * HASH_COUNT.
     *
     * @param string $saltedPW Salted hash to check if it needs an update
     * @return bool TRUE if salted hash needs an update, otherwise FALSE
     */
    public function isHashUpdateNeeded($saltedPW)
    {
        return password_needs_rehash($saltedPW, PASSWORD_DEFAULT, ['cost' => $this->cost]);
    }

    /**
     * Method determines if a given string is a valid salt.
     *
     * @param string $salt String to check
     * @return bool TRUE if it's valid salt, otherwise FALSE
     */
    public function isValidSalt($salt)
    {
        return (strlen($salt) >= $this->getSaltLength() && preg_match('#^[a-zA-Z0-9./]+$#D', $salt));
    }

    /**
     * Method determines if a given string is a valid salted hashed password.
     *
     * @param string $saltedPW String to check
     * @return bool TRUE if it's valid salted hashed password, otherwise FALSE
     */
    public function isValidSaltedPW($saltedPW)
    {
        $info = password_get_info($saltedPW);
        return ($info['algo'] == PASSWORD_DEFAULT && isset($info['options']['cost']) && $info['options']['cost'] == $this->cost);
    }
}
