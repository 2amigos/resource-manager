<?php
/**
 * @link http://github.com/2amigos/resource-manager
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group, LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

/**
 * File system resource manager implementation.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Timur Ruziev <resurtm@gmail.com>
 * @link http://2amigos.us/
 *
 * @property string $basePath of the resource storage.
 * @property string $baseUrl of the resource storage.
 */
class EFsResourceManager extends CApplicationComponent implements IResourceManager
{
	/**
	 * @const string default directory name where files will be uploaded.
	 */
	const DEFAULT_DIRECTORY = 'uploads';

	/**
	 * @var string base path of the resource storage.
	 */
	private $_basePath;
	/**
	 * @var string base URL of the resource storage.
	 */
	private $_baseUrl;

	/**
	 * @inheritdoc
	 */
	public function saveFile($file, $name, $options = array())
	{
		$filePath = $this->getBasePath() . DIRECTORY_SEPARATOR . $name;
		@mkdir(dirname($filePath), 0777, true);

		return $file instanceof CUploadedFile ? $file->saveAs($filePath) : file_put_contents($filePath, $file, LOCK_EX);
	}

	/**
	 * @inheritdoc
	 */
	public function deleteFile($name)
	{
		return unlink($this->getFilePath($name));
	}

	/**
	 * @inheritdoc
	 */
	public function copyFile($sourceName, $targetName)
	{
		if (!$this->getIsFileExists($sourceName)) {
			return false;
		}

		$sourceName = $this->getFilePath($sourceName);
		$targetName = $this->getFilePath($targetName);
		return copy($sourceName, $targetName);
	}

	/**
	 * @inheritdoc
	 */
	public function getFileUrl($name)
	{
		return $this->getBaseUrl() . '/' . $name;
	}

	/**
	 * @inheritdoc
	 */
	public function getIsFileExists($name)
	{
		return file_exists($this->getFilePath($name));
	}

	/**
	 * Returns path to the file by the given name.
	 * @param string $name of the file to return its path.
	 * @return string path to the requested file.
	 */
	public function getFilePath($name)
	{
		return $this->getBasePath() . DIRECTORY_SEPARATOR . $name;
	}

	/**
	 * Returns the base path value.
	 * @return string the base path value.
	 */
	public function getBasePath()
	{
		if ($this->_basePath === null) {
			$this->setBasePath(
				dirname(Yii::app()->getRequest()->getScriptFile()) . DIRECTORY_SEPARATOR . self::DEFAULT_DIRECTORY
			);
		}

		return $this->_basePath;
	}

	/**
	 * Changes the base path value.
	 * @param string $basePath value to be set.
	 */
	public function setBasePath($basePath)
	{
		$this->_basePath = rtrim($basePath, '/\\');
	}

	/**
	 * Returns the base URL value.
	 * @return string the base URL value.
	 */
	public function getBaseUrl()
	{
		if ($this->_baseUrl === null) {
			$this->setBaseUrl(Yii::app()->getRequest()->getBaseUrl() . '/' . self::DEFAULT_DIRECTORY);
		}

		return $this->_baseUrl;
	}

	/**
	 * Changes the base URL value.
	 * @param string $baseUrl value to be set.
	 */
	public function setBaseUrl($baseUrl)
	{
		$this->_baseUrl = rtrim($baseUrl, '/');
	}
}
