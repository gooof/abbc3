<?php
/**
*
* Advanced BBCode Box
*
* @copyright (c) 2014 Matt Friedman
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace vse\abbc3\tests\event;

class listener_base extends \phpbb_test_case
{
	/** @var \vse\abbc3\core\bbcodes_display|\PHPUnit_Framework_MockObject_MockObject */
	protected $bbcodes;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\controller\helper|\PHPUnit_Framework_MockObject_MockObject */
	protected $controller_helper;

	/** @var \vse\abbc3\event\listener */
	protected $listener;

	/** @var \vse\abbc3\core\bbcodes_parser|\PHPUnit_Framework_MockObject_MockObject */
	protected $parser;

	/** @var \phpbb\template\template|\PHPUnit_Framework_MockObject_MockObject */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $ext_root_path;

	/** @var string */
	protected $bbvideo_width;

	/** @var string */
	protected $bbvideo_height;

	public function setUp()
	{
		parent::setUp();

		global $phpbb_root_path, $phpEx;

		$this->parser = $this->createMock('\vse\abbc3\core\bbcodes_parser');
		$this->bbcodes = $this->createMock('\vse\abbc3\core\bbcodes_display');
		$this->config = new \phpbb\config\config(array('enable_mod_rewrite' => '0'));

		$this->template = $this->createMock('\phpbb\template\template');
		$this->user = $this->createMock('\phpbb\user', array(), array(
			new \phpbb\language\language(new \phpbb\language\language_file_loader($phpbb_root_path, $phpEx)),
			'\phpbb\datetime'
		));
		$this->user->data['username'] = 'admin';

		$this->controller_helper = $this->createMock('\phpbb\controller\helper');
		$this->controller_helper->expects($this->any())
			->method('route')
			->willReturnCallback(function ($route, array $params = array()) {
				return $route . '#' . serialize($params);
			});

		$this->ext_root_path = 'ext/vse/abbc3/';
		$this->bbvideo_width = 560;
		$this->bbvideo_height = 315;
	}

	/**
	 * Set up an instance of the event listener
	 */
	protected function set_listener()
	{
		$this->listener = new \vse\abbc3\event\listener(
			$this->parser,
			$this->bbcodes,
			$this->controller_helper,
			$this->template,
			$this->user,
			$this->ext_root_path
		);
	}
}
