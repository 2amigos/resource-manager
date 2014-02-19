<?php
/**
 * @link http://github.com/2amigos/resource-manager
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group, LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

/**
 * Common resource manager interface defines a set of the methods
 * to be implemented by the particular implementations/backends.
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @author Timur Ruziev <resurtm@gmail.com>
 */
interface IResourceManager
{
	/**
	 * Saves the given file.
	 * @param CUploadedFile $file to be uploaded and persisted.
	 * @param string $name of the file.
	 * @param array $options additional options for the file save process.
	 * @return boolean whether file was successfully uploaded and saved.
	 */
	public function saveFile($file, $name, $options = array());

	/**
	 * Permanently removes a file from the storage.
	 * @param string $name of the file to be deleted.
	 * @return boolean status of the file removal.
	 */
	public function deleteFile($name);

	/**
	 * Returns URL to the file by the given name.
	 * @param string $name of the file to be used to generate a URL.
	 * @return string URL to the requested file.
	 */
	public function getFileUrl($name);

	/**
	 * Checks whether file with the specified name exists.
	 * @param string $name of the file to be checked.
	 * @return boolean status of the file existence.
	 */
	public function getIsFileExists($name);
}
