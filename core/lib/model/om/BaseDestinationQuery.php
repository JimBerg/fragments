<?php


/**
 * Base class that represents a query for the 'Destination' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.3 on:
 *
 * Tue May 24 10:36:29 2011
 *
 * @method     DestinationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     DestinationQuery orderByLocationId($order = Criteria::ASC) Order by the location_id column
 * @method     DestinationQuery orderByLocationName($order = Criteria::ASC) Order by the location_name column
 * @method     DestinationQuery orderByRegion($order = Criteria::ASC) Order by the region column
 * @method     DestinationQuery orderByGeolocation($order = Criteria::ASC) Order by the geolocation column
 * @method     DestinationQuery orderByArea($order = Criteria::ASC) Order by the area column
 * @method     DestinationQuery orderByElevation($order = Criteria::ASC) Order by the elevation column
 * @method     DestinationQuery orderByPopulation($order = Criteria::ASC) Order by the population column
 * @method     DestinationQuery orderByInfotext($order = Criteria::ASC) Order by the infotext column
 * @method     DestinationQuery orderByPopulationDensity($order = Criteria::ASC) Order by the population_density column
 * @method     DestinationQuery orderByAirportName($order = Criteria::ASC) Order by the airport_name column
 * @method     DestinationQuery orderByAirportAbbr($order = Criteria::ASC) Order by the airport_abbr column
 * @method     DestinationQuery orderByAirportType($order = Criteria::ASC) Order by the airport_type column
 * @method     DestinationQuery orderByTimezone($order = Criteria::ASC) Order by the timezone column
 *
 * @method     DestinationQuery groupById() Group by the id column
 * @method     DestinationQuery groupByLocationId() Group by the location_id column
 * @method     DestinationQuery groupByLocationName() Group by the location_name column
 * @method     DestinationQuery groupByRegion() Group by the region column
 * @method     DestinationQuery groupByGeolocation() Group by the geolocation column
 * @method     DestinationQuery groupByArea() Group by the area column
 * @method     DestinationQuery groupByElevation() Group by the elevation column
 * @method     DestinationQuery groupByPopulation() Group by the population column
 * @method     DestinationQuery groupByInfotext() Group by the infotext column
 * @method     DestinationQuery groupByPopulationDensity() Group by the population_density column
 * @method     DestinationQuery groupByAirportName() Group by the airport_name column
 * @method     DestinationQuery groupByAirportAbbr() Group by the airport_abbr column
 * @method     DestinationQuery groupByAirportType() Group by the airport_type column
 * @method     DestinationQuery groupByTimezone() Group by the timezone column
 *
 * @method     DestinationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     DestinationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     DestinationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     DestinationQuery leftJoinPictures($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pictures relation
 * @method     DestinationQuery rightJoinPictures($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pictures relation
 * @method     DestinationQuery innerJoinPictures($relationAlias = null) Adds a INNER JOIN clause to the query using the Pictures relation
 *
 * @method     Destination findOne(PropelPDO $con = null) Return the first Destination matching the query
 * @method     Destination findOneOrCreate(PropelPDO $con = null) Return the first Destination matching the query, or a new Destination object populated from the query conditions when no match is found
 *
 * @method     Destination findOneById(int $id) Return the first Destination filtered by the id column
 * @method     Destination findOneByLocationId(int $location_id) Return the first Destination filtered by the location_id column
 * @method     Destination findOneByLocationName(string $location_name) Return the first Destination filtered by the location_name column
 * @method     Destination findOneByRegion(string $region) Return the first Destination filtered by the region column
 * @method     Destination findOneByGeolocation(string $geolocation) Return the first Destination filtered by the geolocation column
 * @method     Destination findOneByArea(string $area) Return the first Destination filtered by the area column
 * @method     Destination findOneByElevation(string $elevation) Return the first Destination filtered by the elevation column
 * @method     Destination findOneByPopulation(string $population) Return the first Destination filtered by the population column
 * @method     Destination findOneByInfotext(string $infotext) Return the first Destination filtered by the infotext column
 * @method     Destination findOneByPopulationDensity(string $population_density) Return the first Destination filtered by the population_density column
 * @method     Destination findOneByAirportName(string $airport_name) Return the first Destination filtered by the airport_name column
 * @method     Destination findOneByAirportAbbr(string $airport_abbr) Return the first Destination filtered by the airport_abbr column
 * @method     Destination findOneByAirportType(string $airport_type) Return the first Destination filtered by the airport_type column
 * @method     Destination findOneByTimezone(string $timezone) Return the first Destination filtered by the timezone column
 *
 * @method     array findById(int $id) Return Destination objects filtered by the id column
 * @method     array findByLocationId(int $location_id) Return Destination objects filtered by the location_id column
 * @method     array findByLocationName(string $location_name) Return Destination objects filtered by the location_name column
 * @method     array findByRegion(string $region) Return Destination objects filtered by the region column
 * @method     array findByGeolocation(string $geolocation) Return Destination objects filtered by the geolocation column
 * @method     array findByArea(string $area) Return Destination objects filtered by the area column
 * @method     array findByElevation(string $elevation) Return Destination objects filtered by the elevation column
 * @method     array findByPopulation(string $population) Return Destination objects filtered by the population column
 * @method     array findByInfotext(string $infotext) Return Destination objects filtered by the infotext column
 * @method     array findByPopulationDensity(string $population_density) Return Destination objects filtered by the population_density column
 * @method     array findByAirportName(string $airport_name) Return Destination objects filtered by the airport_name column
 * @method     array findByAirportAbbr(string $airport_abbr) Return Destination objects filtered by the airport_abbr column
 * @method     array findByAirportType(string $airport_type) Return Destination objects filtered by the airport_type column
 * @method     array findByTimezone(string $timezone) Return Destination objects filtered by the timezone column
 *
 * @package    propel.generator.lib.model.om
 */
abstract class BaseDestinationQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseDestinationQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Destination', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new DestinationQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    DestinationQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof DestinationQuery) {
			return $criteria;
		}
		$query = new DestinationQuery();
		if (null !== $modelAlias) {
			$query->setModelAlias($modelAlias);
		}
		if ($criteria instanceof Criteria) {
			$query->mergeWith($criteria);
		}
		return $query;
	}

	/**
	 * Find object by primary key
	 * Use instance pooling to avoid a database query if the object exists
	 * <code>
	 * $obj  = $c->findPk(12, $con);
	 * </code>
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    Destination|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = DestinationPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
			// the object is alredy in the instance pool
			return $obj;
		} else {
			// the object has not been requested yet, or the formatter is not an object formatter
			$criteria = $this->isKeepQuery() ? clone $this : $this;
			$stmt = $criteria
				->filterByPrimaryKey($key)
				->getSelectStatement($con);
			return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
		}
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{	
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		return $this
			->filterByPrimaryKeys($keys)
			->find($con);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(DestinationPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(DestinationPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(DestinationPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the location_id column
	 * 
	 * @param     int|array $locationId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByLocationId($locationId = null, $comparison = null)
	{
		if (is_array($locationId)) {
			$useMinMax = false;
			if (isset($locationId['min'])) {
				$this->addUsingAlias(DestinationPeer::LOCATION_ID, $locationId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($locationId['max'])) {
				$this->addUsingAlias(DestinationPeer::LOCATION_ID, $locationId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(DestinationPeer::LOCATION_ID, $locationId, $comparison);
	}

	/**
	 * Filter the query on the location_name column
	 * 
	 * @param     string $locationName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByLocationName($locationName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($locationName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $locationName)) {
				$locationName = str_replace('*', '%', $locationName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::LOCATION_NAME, $locationName, $comparison);
	}

	/**
	 * Filter the query on the region column
	 * 
	 * @param     string $region The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByRegion($region = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($region)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $region)) {
				$region = str_replace('*', '%', $region);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::REGION, $region, $comparison);
	}

	/**
	 * Filter the query on the geolocation column
	 * 
	 * @param     string $geolocation The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByGeolocation($geolocation = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($geolocation)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $geolocation)) {
				$geolocation = str_replace('*', '%', $geolocation);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::GEOLOCATION, $geolocation, $comparison);
	}

	/**
	 * Filter the query on the area column
	 * 
	 * @param     string $area The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByArea($area = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($area)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $area)) {
				$area = str_replace('*', '%', $area);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::AREA, $area, $comparison);
	}

	/**
	 * Filter the query on the elevation column
	 * 
	 * @param     string $elevation The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByElevation($elevation = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($elevation)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $elevation)) {
				$elevation = str_replace('*', '%', $elevation);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::ELEVATION, $elevation, $comparison);
	}

	/**
	 * Filter the query on the population column
	 * 
	 * @param     string $population The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByPopulation($population = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($population)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $population)) {
				$population = str_replace('*', '%', $population);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::POPULATION, $population, $comparison);
	}

	/**
	 * Filter the query on the infotext column
	 * 
	 * @param     string $infotext The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByInfotext($infotext = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($infotext)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $infotext)) {
				$infotext = str_replace('*', '%', $infotext);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::INFOTEXT, $infotext, $comparison);
	}

	/**
	 * Filter the query on the population_density column
	 * 
	 * @param     string $populationDensity The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByPopulationDensity($populationDensity = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($populationDensity)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $populationDensity)) {
				$populationDensity = str_replace('*', '%', $populationDensity);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::POPULATION_DENSITY, $populationDensity, $comparison);
	}

	/**
	 * Filter the query on the airport_name column
	 * 
	 * @param     string $airportName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByAirportName($airportName = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($airportName)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $airportName)) {
				$airportName = str_replace('*', '%', $airportName);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::AIRPORT_NAME, $airportName, $comparison);
	}

	/**
	 * Filter the query on the airport_abbr column
	 * 
	 * @param     string $airportAbbr The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByAirportAbbr($airportAbbr = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($airportAbbr)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $airportAbbr)) {
				$airportAbbr = str_replace('*', '%', $airportAbbr);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::AIRPORT_ABBR, $airportAbbr, $comparison);
	}

	/**
	 * Filter the query on the airport_type column
	 * 
	 * @param     string $airportType The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByAirportType($airportType = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($airportType)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $airportType)) {
				$airportType = str_replace('*', '%', $airportType);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::AIRPORT_TYPE, $airportType, $comparison);
	}

	/**
	 * Filter the query on the timezone column
	 * 
	 * @param     string $timezone The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByTimezone($timezone = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($timezone)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $timezone)) {
				$timezone = str_replace('*', '%', $timezone);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(DestinationPeer::TIMEZONE, $timezone, $comparison);
	}

	/**
	 * Filter the query by a related Pictures object
	 *
	 * @param     Pictures $pictures  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function filterByPictures($pictures, $comparison = null)
	{
		return $this
			->addUsingAlias(DestinationPeer::ID, $pictures->getDestinationId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Pictures relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function joinPictures($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Pictures');
		
		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}
		
		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'Pictures');
		}
		
		return $this;
	}

	/**
	 * Use the Pictures relation Pictures object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PicturesQuery A secondary query class using the current class as primary query
	 */
	public function usePicturesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPictures($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Pictures', 'PicturesQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Destination $destination Object to remove from the list of results
	 *
	 * @return    DestinationQuery The current query, for fluid interface
	 */
	public function prune($destination = null)
	{
		if ($destination) {
			$this->addUsingAlias(DestinationPeer::ID, $destination->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseDestinationQuery