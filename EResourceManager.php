<?php
/**
 * @link http://github.com/2amigos/resource-manager
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group, LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

/**
 * EResourceManager class.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Timur Ruziev <resurtm@gmail.com>
 */
abstract class EResourceManager extends CApplicationComponent
{
	/**
	 * @param CUploadedFile $file
	 * @param string $name
	 * @param array $options
	 * @return boolean
	 */
	abstract public function saveFile($file, $name, $options = array());

	/**
	 * @param string $name
	 * @return string
	 */
	abstract public function getFileUrl($name);

	/**
	 * @param string $name
	 * @return boolean
	 */
	abstract public function getIsFileExist($name);
}
