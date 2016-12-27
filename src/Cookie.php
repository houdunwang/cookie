<?php
/** .-------------------------------------------------------------------
 * |  Software: [HDCMS framework]
 * |      Site: www.hdcms.com
 * |-------------------------------------------------------------------
 * |    Author: 向军 <2300071698@qq.com>
 * |    WeChat: aihoudun
 * | Copyright (c) 2012-2019, www.houdunwang.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/
namespace houdunwang\cookie;

use houdunwang\arr\Arr;
use houdunwang\config\Config;
use houdunwang\cookie\build\Base;

/**
 * Cookie 管理组件
 * Class Cookie
 * @package hdphp\cookie
 */
class Cookie {
	protected $link;
	protected $config;

	public function __construct() {
		$this->config( Config::get( 'cookie' ) );
	}

	//设置配置项
	public function config( $config, $value = null ) {
		if ( is_array( $config ) ) {
			$this->config = $config;

			return $this;
		} else if ( is_null( $value ) ) {
			return Arr::get( $this->config, $config );
		} else {
			$this->config = Arr::set( $this->config, $config, $value );

			return $this;
		}
	}

	//获取实例
	protected function driver() {
		$this->link = new Base($this);

		return $this;
	}

	public function __call( $method, $params ) {
		if ( is_null( $this->link ) ) {
			$this->driver();
		}

		return call_user_func_array( [ $this->link, $method ], $params );
	}

	public static function __callStatic( $name, $arguments ) {
		static $link;
		if ( is_null( $link ) ) {
			$link = new static();
		}

		return call_user_func_array( [ $link, $name ], $arguments );
	}
}