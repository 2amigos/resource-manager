<?php
/**
 * @link http://github.com/2amigos/resource-manager
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group, LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

/**
 * EAmazonS3ResourceManager class.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Timur Ruziev <resurtm@gmail.com>
 */
class EAmazonS3ResourceManager extends CApplicationComponent implements IResourceManager
{
	/**
	 * @param CUploadedFile $file
	 * @param string $name
	 * @param array $options
	 * @return boolean
	 */
	public function saveFile($file, $name, $options = array())
	{
		// implementation
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public function getFileUrl($name)
	{
		// implementation
	}

	/**
	 * @param string $name
	 * @return boolean
	 */
	public function getIsFileExist($name)
	{
		// implementation
	}
}
