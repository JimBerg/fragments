<?php



/**
 * Skeleton subclass for representing a row from the 'Destination' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.3 on:
 *
 * Fri Feb 25 22:48:35 2011
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class Destination extends BaseDestination {
	public function __toString() {
		return $this->getLocationName();
	}
} // Destination
