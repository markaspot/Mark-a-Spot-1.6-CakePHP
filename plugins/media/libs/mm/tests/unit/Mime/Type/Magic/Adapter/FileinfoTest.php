<?php
/**
 * mm: the PHP media library
 *
 * Copyright (c) 2007-2010 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  2007-2010 David Persson <nperson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link       http://github.com/davidpersson/mm
 */

require_once 'PHPUnit/Framework.php';
require_once 'Mime/Type/Magic/Adapter/Fileinfo.php';

class Mime_Type_Magic_Adapter_FileinfoTest extends PHPUnit_Framework_TestCase {

	public $subject;

	protected $_files;
	protected $_data;

	protected function setUp() {
		if (extension_loaded('fileinfo')) {
			$this->subject = new Mime_Type_Magic_Adapter_Fileinfo();
		} else {
			$this->markTestSkipped('The `fileinfo` extension is not available.');
		}
		$this->_files = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . '/resources';
	}

	public function testToArray() {
		$this->setExpectedException('BadMethodCallException');
		$result = $this->subject->to('array');
	}

	public function testAnalyzeFail() {
		$handle = fopen('php://memory', 'rb');
		$result = $this->subject->analyze($handle);
		fclose($handle);
		$this->assertNull($result);
	}

	public function testAnalyze() {
		$files = array(
			'image_gif.gif' => 'image/gif; charset=binary',
			'application_pdf.pdf' => 'application/pdf; charset=binary',
			'text_html_snippet.html' => 'text/html; charset=us-ascii',
			'image_jpeg_snippet.jpg' => 'image/jpeg; charset=binary'
		);

		foreach ($files as $file => $mimeTypes) {
			$handle = fopen($this->_files . '/' . $file, 'rb');
			$this->assertContains($this->subject->analyze($handle), (array) $mimeTypes, "File `{$file}`.");
			fclose($handle);
		}
	}
}

?>