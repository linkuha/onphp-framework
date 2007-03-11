<?php
/***************************************************************************
 *   Copyright (C) 2007 by Konstantin V. Arkhipov                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup Types
	**/
	final class InetType extends IntegerType
	{
		/**
		 * @throws WrongArgumentException
		 * @return InetType
		**/
		public function setDefault($default)
		{
			Assert::isTrue(
				long2ip(ip2long($default)) == $default,
				"strange default value given - '{$default}'"
			);
			
			return parent::setDefault($default);
		}
		
		public function toPrimitive()
		{
			return 'Primitive::inet';
		}
		
		public function toPrimitiveLimits()
		{
			return null;
		}
	}
?>