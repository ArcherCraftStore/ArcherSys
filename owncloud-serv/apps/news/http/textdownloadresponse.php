<?php
/**
 * ownCloud - News
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Alessandro Cosentino <cosenal@gmail.com>
 * @author Bernhard Posselt <dev@bernhard-posselt.com>
 * @copyright Alessandro Cosentino 2012
 * @copyright Bernhard Posselt 2012, 2014
 */

namespace OCA\News\Http;

use \OCP\AppFramework\Http\DownloadResponse;


/**
 * Prompts the user to download the a text file
 */
class TextDownloadResponse extends DownloadResponse {

	private $content;

	/**
	 * Creates a response that prompts the user to download a file which
	 * contains the passed string
	 * @param string $content the content that should be written into the file
	 * @param string $filename the name that the downloaded file should have
	 * @param string $contentType the mimetype that the downloaded file should have
	 */
	public function __construct($content, $filename, $contentType){
		parent::__construct($filename, $contentType);
		$this->content = $content;
	}


	/**
	 * Simply sets the headers and returns the file contents
	 * @return string the file contents
	 */
	public function render(){
		return $this->content;
	}


}
