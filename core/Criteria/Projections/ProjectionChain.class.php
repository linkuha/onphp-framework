<?php
/***************************************************************************
 *   Copyright (C) 2006 by Konstantin V. Arkhipov                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup Projections
	**/
	final class ProjectionChain
	{
		private $list = array();
		
		/**
		 * @return ProjectionChain
		**/
		public function add(BaseProjection $projection, $name = null)
		{
			if ($name) {
				Assert::isFalse(isset($this->list[$name]));
				
				$this->list[$name] = $projection;
			} else {
				$this->list[] = $projection;
			}
			
			return $this;
		}
		
		/**
		 * @return FieldGroup
		**/
		public function toField(Criteria $criteria, JoinCapableQuery $query)
		{
			$group = new FieldGroup();
			
			foreach ($this->list as $projection)
				$group->add($projection->toField($criteria, $query));
			
			return $group;
		}
	}
?>