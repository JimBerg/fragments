<?php


/**
 * Base class that represents a query for the 'Location' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.3 on:
 *
 * Tue May 24 10:36:30 2011
 *
 * @method     LocationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     LocationQuery orderByLocationName($order = Criteria::ASC) Order by the location_name column
 * @method     LocationQuery orderByLat($order = Criteria::ASC) Order by the lat column
 * @method     LocationQuery orderByLng($order = Criteria::ASC) Order by the lng column
 * @method     LocationQuery orderByCountry($order = Criteria::ASC) Order by the country column
 * @method     LocationQuery orderByTimezone($order = Criteria::ASC) Order by the timezone column
 * @method     LocationQuery orderBySwissDestination($order = Criteria::ASC) Order by the swiss_destination column
 * @method     LocationQuery orderByForeignDestination($order = Criteria::ASC) Order by the foreign_destination column
 * @method     LocationQuery orderByNearestDestination($order = Criteria::ASC) Order by the nearest_destination column
 *
 * @method     LocationQuery groupById() Group by the id column
 * @method     LocationQuery groupByLocationName() Group by the location_name column
 * @method     LocationQuery groupByLat() Group by the lat column
 * @method     LocationQuery groupByLng() Group by the lng column
 * @method     LocationQuery groupByCountry() Group by the country column
 * @method     LocationQuery groupByTimezone() Group by the timezone column
 * @method     LocationQuery groupBySwissDestination() Group by the swiss_destination column
 * @method     LocationQuery groupByForeignDestination() Group by the foreign_destination column
 * @method     LocationQuery groupByNearestDestination() Group by the nearest_destination column
 *
 * @method     LocationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     LocationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     LocationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     LocationQuery leftJoinFlightRelatedByStartLocationId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FlightRelatedByStartLocationId relation
 * @method     LocationQuery rightJoinFlightRelatedByStartLocationId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FlightRelatedByStartLocationId relation
 * @method     LocationQuery innerJoinFlightRelatedByStartLocationId($relationAlias = null) Adds a INNER JOIN clause to the query using the FlightRelatedByStartLocationId relation
 *
 * @method     LocationQuery leftJoinFlightRelatedByTargetLocationId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FlightRelatedByTargetLocationId relation
 * @method     LocationQuery rightJoinFlightRelatedByTargetLocationId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FlightRelatedByTargetLocationId relation
 * @method     LocationQuery innerJoinFlightRelatedByTargetLocationId($relationAlias = null) Adds a INNER JOIN clause to the query using the FlightRelatedByTargetLocationId relation
 *
 * @method     LocationQuery leftJoinFriend($relationAlias = null) Adds a LEFT JOIN clause to the query using the Friend relation
 * @method     LocationQuery rightJoinFriend($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Friend relation
 * @method     LocationQuery innerJoinFriend($relationAlias = null) Adds a INNER JOIN clause to the query using the Friend relation
 *
 * @method     LocationQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     LocationQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     LocationQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     Location findOne(PropelPDO $con = null) Return the first Location matching the query
 * @method     Location findOneOrCreate(PropelPDO $con = null) Return the first Location matching the query, or a new Location object populated from the query conditions when no match is found
 *
 * @method     Location findOneById(int $id) Return the first Location filtered by the id column
 * @method     Location findOneByLocationName(string $location_name) Return the first Location filtered by the location_name column
 * @method     Location findOneByLat(double $lat) Return the first Location filtered by the lat column
 * @method     Location findOneByLng(double $lng) Return the first Location filtered by the lng column
 * @method     Location findOneByCountry(string $country) Return the first Location filtered by the country column
 * @method     Location findOneByTimezone(string $timezone) Return the first Location filtered by the timezone column
 * @method     Location findOneBySwissDestination(boolean $swiss_destination) Return the first Location filtered by the swiss_destination column
 * @method     Location findOneByForeignDestination(boolean $foreign_destination) Return the first Location filtered by the foreign_destination column
 * @method     Location findOneByNearestDestination(string $nearest_destination) Return the first Location filtered by the nearest_destination column
 *
 * @method     array findById(int $id) Return Location objects filtered by the id column
 * @method     array findByLocationName(string $location_name) Return Location objects filtered by the location_name column
 * @method     array findByLat(double $lat) Return Location objects filtered by the lat column
 * @method     array findByLng(double $lng) Return Location objects filtered by the lng column
 * @method     array findByCountry(string $country) Return Location objects filtered by the country column
 * @method     array findByTimezone(string $timezone) Return Location objects filtered by the timezone column
 * @method     array findBySwissDestination(boolean $swiss_destination) Return Location objects filtered by the swiss_destination column
 * @method     array findByForeignDestination(boolean $foreign_destination) Return Location objects filtered by the foreign_destination column
 * @method     array findByNearestDestination(string $nearest_destination) Return Location objects filtered by the nearest_destination column
 *
 * @package    propel.generator.lib.model.om
 */
abstract class BaseLocationQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseLocationQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Location', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new LocationQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    LocationQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof LocationQuery) {
			return $criteria;
		}
		$query = new LocationQuery();
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
	 * @return    Location|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = LocationPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(LocationPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(LocationPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(LocationPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the location_name column
	 * 
	 * @param     string $locationName The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
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
		return $this->addUsingAlias(LocationPeer::LOCATION_NAME, $locationName, $comparison);
	}

	/**
	 * Filter the query on the lat column
	 * 
	 * @param     double|array $lat The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByLat($lat = null, $comparison = null)
	{
		if (is_array($lat)) {
			$useMinMax = false;
			if (isset($lat['min'])) {
				$this->addUsingAlias(LocationPeer::LAT, $lat['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($lat['max'])) {
				$this->addUsingAlias(LocationPeer::LAT, $lat['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LocationPeer::LAT, $lat, $comparison);
	}

	/**
	 * Filter the query on the lng column
	 * 
	 * @param     double|array $lng The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByLng($lng = null, $comparison = null)
	{
		if (is_array($lng)) {
			$useMinMax = false;
			if (isset($lng['min'])) {
				$this->addUsingAlias(LocationPeer::LNG, $lng['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($lng['max'])) {
				$this->addUsingAlias(LocationPeer::LNG, $lng['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(LocationPeer::LNG, $lng, $comparison);
	}

	/**
	 * Filter the query on the country column
	 * 
	 * @param     string $country The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByCountry($country = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($country)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $country)) {
				$country = str_replace('*', '%', $country);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(LocationPeer::COUNTRY, $country, $comparison);
	}

	/**
	 * Filter the query on the timezone column
	 * 
	 * @param     string $timezone The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
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
		return $this->addUsingAlias(LocationPeer::TIMEZONE, $timezone, $comparison);
	}

	/**
	 * Filter the query on the swiss_destination column
	 * 
	 * @param     boolean|string $swissDestination The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterBySwissDestination($swissDestination = null, $comparison = null)
	{
		if (is_string($swissDestination)) {
			$swiss_destination = in_array(strtolower($swissDestination), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(LocationPeer::SWISS_DESTINATION, $swissDestination, $comparison);
	}

	/**
	 * Filter the query on the foreign_destination column
	 * 
	 * @param     boolean|string $foreignDestination The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByForeignDestination($foreignDestination = null, $comparison = null)
	{
		if (is_string($foreignDestination)) {
			$foreign_destination = in_array(strtolower($foreignDestination), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(LocationPeer::FOREIGN_DESTINATION, $foreignDestination, $comparison);
	}

	/**
	 * Filter the query on the nearest_destination column
	 * 
	 * @param     string $nearestDestination The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByNearestDestination($nearestDestination = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($nearestDestination)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $nearestDestination)) {
				$nearestDestination = str_replace('*', '%', $nearestDestination);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(LocationPeer::NEAREST_DESTINATION, $nearestDestination, $comparison);
	}

	/**
	 * Filter the query by a related Flight object
	 *
	 * @param     Flight $flight  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByFlightRelatedByStartLocationId($flight, $comparison = null)
	{
		return $this
			->addUsingAlias(LocationPeer::ID, $flight->getStartLocationId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the FlightRelatedByStartLocationId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function joinFlightRelatedByStartLocationId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('FlightRelatedByStartLocationId');
		
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
			$this->addJoinObject($join, 'FlightRelatedByStartLocationId');
		}
		
		return $this;
	}

	/**
	 * Use the FlightRelatedByStartLocationId relation Flight object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FlightQuery A secondary query class using the current class as primary query
	 */
	public function useFlightRelatedByStartLocationIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFlightRelatedByStartLocationId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'FlightRelatedByStartLocationId', 'FlightQuery');
	}

	/**
	 * Filter the query by a related Flight object
	 *
	 * @param     Flight $flight  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByFlightRelatedByTargetLocationId($flight, $comparison = null)
	{
		return $this
			->addUsingAlias(LocationPeer::ID, $flight->getTargetLocationId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the FlightRelatedByTargetLocationId relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function joinFlightRelatedByTargetLocationId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('FlightRelatedByTargetLocationId');
		
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
			$this->addJoinObject($join, 'FlightRelatedByTargetLocationId');
		}
		
		return $this;
	}

	/**
	 * Use the FlightRelatedByTargetLocationId relation Flight object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FlightQuery A secondary query class using the current class as primary query
	 */
	public function useFlightRelatedByTargetLocationIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFlightRelatedByTargetLocationId($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'FlightRelatedByTargetLocationId', 'FlightQuery');
	}

	/**
	 * Filter the query by a related Friend object
	 *
	 * @param     Friend $friend  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByFriend($friend, $comparison = null)
	{
		return $this
			->addUsingAlias(LocationPeer::ID, $friend->getLocationId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Friend relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function joinFriend($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Friend');
		
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
			$this->addJoinObject($join, 'Friend');
		}
		
		return $this;
	}

	/**
	 * Use the Friend relation Friend object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FriendQuery A secondary query class using the current class as primary query
	 */
	public function useFriendQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFriend($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Friend', 'FriendQuery');
	}

	/**
	 * Filter the query by a related User object
	 *
	 * @param     User $user  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function filterByUser($user, $comparison = null)
	{
		return $this
			->addUsingAlias(LocationPeer::ID, $user->getLocationId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the User relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('User');
		
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
			$this->addJoinObject($join, 'User');
		}
		
		return $this;
	}

	/**
	 * Use the User relation User object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery A secondary query class using the current class as primary query
	 */
	public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinUser($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'User', 'UserQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     Location $location Object to remove from the list of results
	 *
	 * @return    LocationQuery The current query, for fluid interface
	 */
	public function prune($location = null)
	{
		if ($location) {
			$this->addUsingAlias(LocationPeer::ID, $location->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseLocationQuery
