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
	 * @ingroup OSQL
	**/
	final class Joiner implements DialectString
	{
		private $from	= array();
		private $tables	= array();
		
		/**
		 * @return Joiner
		**/
		public function from(FromTable $from)
		{
			$this->from[] = $from;
			
			return $this;
		}
		
		public function hasJoinedTable($table)
		{
			return isset($this->tables[$table]);
		}
		
		public function getTablesCount()
		{
			return count($this->from);
		}
		
		/**
		 * @return Joiner
		**/
		public function join(SQLJoin $join)
		{
			$this->from[] = $join;
			$this->tables[$join->getTable()] = true;
			
			return $this;
		}
		
		/**
		 * @return Joiner
		**/
		public function leftJoin(SQLLeftJoin $join)
		{
			$this->from[] = $join;
			$this->tables[$join->getTable()] = true;
			
			return $this;
		}
		
		public function getLastTable()
		{
			if ($this->from)
				return $this->from[count($this->from) - 1]->getTable();
			
			return null;
		}
		
		public function toDialectString(Dialect $dialect)
		{
			$fromString = null;
			
			for ($i = 0, $size = count($this->from); $i < $size; ++$i) {
				if ($i == 0)
					$separator = null;
				elseif (
					$this->from[$i] instanceof FromTable &&
					!$this->from[$i]->getTable() instanceof SelectQuery
				)
					$separator = ', ';
				else
					$separator = ' ';

				$fromString .=
					$separator
					.$this->from[$i]->toDialectString($dialect);
			}

			if ($fromString)
				return ' FROM '.$fromString;
			
			return null;
		}
	}
?>