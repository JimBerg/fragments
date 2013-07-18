<?php


/**
 * Base class that represents a query for the 'User' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.3 on:
 *
 * Tue May 24 10:36:30 2011
 *
 * @method     UserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     UserQuery orderByFbId($order = Criteria::ASC) Order by the fb_id column
 * @method     UserQuery orderByAccessToken($order = Criteria::ASC) Order by the access_token column
 * @method     UserQuery orderByIsFan($order = Criteria::ASC) Order by the is_fan column
 * @method     UserQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     UserQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     UserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     UserQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     UserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     UserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     UserQuery orderByInactiveNotification($order = Criteria::ASC) Order by the inactive_notification column
 * @method     UserQuery orderByWeeklyNotification($order = Criteria::ASC) Order by the weekly_notification column
 * @method     UserQuery orderByLocationId($order = Criteria::ASC) Order by the Location_id column
 *
 * @method     UserQuery groupById() Group by the id column
 * @method     UserQuery groupByFbId() Group by the fb_id column
 * @method     UserQuery groupByAccessToken() Group by the access_token column
 * @method     UserQuery groupByIsFan() Group by the is_fan column
 * @method     UserQuery groupByFirstname() Group by the firstname column
 * @method     UserQuery groupByLastname() Group by the lastname column
 * @method     UserQuery groupByEmail() Group by the email column
 * @method     UserQuery groupByLocale() Group by the locale column
 * @method     UserQuery groupByCreatedAt() Group by the created_at column
 * @method     UserQuery groupByUpdatedAt() Group by the updated_at column
 * @method     UserQuery groupByInactiveNotification() Group by the inactive_notification column
 * @method     UserQuery groupByWeeklyNotification() Group by the weekly_notification column
 * @method     UserQuery groupByLocationId() Group by the Location_id column
 *
 * @method     UserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     UserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     UserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     UserQuery leftJoinLocation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Location relation
 * @method     UserQuery rightJoinLocation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Location relation
 * @method     UserQuery innerJoinLocation($relationAlias = null) Adds a INNER JOIN clause to the query using the Location relation
 *
 * @method     UserQuery leftJoinFlight($relationAlias = null) Adds a LEFT JOIN clause to the query using the Flight relation
 * @method     UserQuery rightJoinFlight($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Flight relation
 * @method     UserQuery innerJoinFlight($relationAlias = null) Adds a INNER JOIN clause to the query using the Flight relation
 *
 * @method     UserQuery leftJoinFriendlist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Friendlist relation
 * @method     UserQuery rightJoinFriendlist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Friendlist relation
 * @method     UserQuery innerJoinFriendlist($relationAlias = null) Adds a INNER JOIN clause to the query using the Friendlist relation
 *
 * @method     UserQuery leftJoinPlayerstatus($relationAlias = null) Adds a LEFT JOIN clause to the query using the Playerstatus relation
 * @method     UserQuery rightJoinPlayerstatus($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Playerstatus relation
 * @method     UserQuery innerJoinPlayerstatus($relationAlias = null) Adds a INNER JOIN clause to the query using the Playerstatus relation
 *
 * @method     User findOne(PropelPDO $con = null) Return the first User matching the query
 * @method     User findOneOrCreate(PropelPDO $con = null) Return the first User matching the query, or a new User object populated from the query conditions when no match is found
 *
 * @method     User findOneById(int $id) Return the first User filtered by the id column
 * @method     User findOneByFbId(string $fb_id) Return the first User filtered by the fb_id column
 * @method     User findOneByAccessToken(string $access_token) Return the first User filtered by the access_token column
 * @method     User findOneByIsFan(boolean $is_fan) Return the first User filtered by the is_fan column
 * @method     User findOneByFirstname(string $firstname) Return the first User filtered by the firstname column
 * @method     User findOneByLastname(string $lastname) Return the first User filtered by the lastname column
 * @method     User findOneByEmail(string $email) Return the first User filtered by the email column
 * @method     User findOneByLocale(string $locale) Return the first User filtered by the locale column
 * @method     User findOneByCreatedAt(string $created_at) Return the first User filtered by the created_at column
 * @method     User findOneByUpdatedAt(string $updated_at) Return the first User filtered by the updated_at column
 * @method     User findOneByInactiveNotification(boolean $inactive_notification) Return the first User filtered by the inactive_notification column
 * @method     User findOneByWeeklyNotification(boolean $weekly_notification) Return the first User filtered by the weekly_notification column
 * @method     User findOneByLocationId(int $Location_id) Return the first User filtered by the Location_id column
 *
 * @method     array findById(int $id) Return User objects filtered by the id column
 * @method     array findByFbId(string $fb_id) Return User objects filtered by the fb_id column
 * @method     array findByAccessToken(string $access_token) Return User objects filtered by the access_token column
 * @method     array findByIsFan(boolean $is_fan) Return User objects filtered by the is_fan column
 * @method     array findByFirstname(string $firstname) Return User objects filtered by the firstname column
 * @method     array findByLastname(string $lastname) Return User objects filtered by the lastname column
 * @method     array findByEmail(string $email) Return User objects filtered by the email column
 * @method     array findByLocale(string $locale) Return User objects filtered by the locale column
 * @method     array findByCreatedAt(string $created_at) Return User objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return User objects filtered by the updated_at column
 * @method     array findByInactiveNotification(boolean $inactive_notification) Return User objects filtered by the inactive_notification column
 * @method     array findByWeeklyNotification(boolean $weekly_notification) Return User objects filtered by the weekly_notification column
 * @method     array findByLocationId(int $Location_id) Return User objects filtered by the Location_id column
 *
 * @package    propel.generator.lib.model.om
 */
abstract class BaseUserQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseUserQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'User', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new UserQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    UserQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof UserQuery) {
			return $criteria;
		}
		$query = new UserQuery();
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
	 * @return    User|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = UserPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(UserPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(UserPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(UserPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the fb_id column
	 * 
	 * @param     string $fbId The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFbId($fbId = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($fbId)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $fbId)) {
				$fbId = str_replace('*', '%', $fbId);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::FB_ID, $fbId, $comparison);
	}

	/**
	 * Filter the query on the access_token column
	 * 
	 * @param     string $accessToken The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByAccessToken($accessToken = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($accessToken)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $accessToken)) {
				$accessToken = str_replace('*', '%', $accessToken);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::ACCESS_TOKEN, $accessToken, $comparison);
	}

	/**
	 * Filter the query on the is_fan column
	 * 
	 * @param     boolean|string $isFan The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByIsFan($isFan = null, $comparison = null)
	{
		if (is_string($isFan)) {
			$is_fan = in_array(strtolower($isFan), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(UserPeer::IS_FAN, $isFan, $comparison);
	}

	/**
	 * Filter the query on the firstname column
	 * 
	 * @param     string $firstname The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFirstname($firstname = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($firstname)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $firstname)) {
				$firstname = str_replace('*', '%', $firstname);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::FIRSTNAME, $firstname, $comparison);
	}

	/**
	 * Filter the query on the lastname column
	 * 
	 * @param     string $lastname The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLastname($lastname = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($lastname)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $lastname)) {
				$lastname = str_replace('*', '%', $lastname);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::LASTNAME, $lastname, $comparison);
	}

	/**
	 * Filter the query on the email column
	 * 
	 * @param     string $email The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByEmail($email = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($email)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $email)) {
				$email = str_replace('*', '%', $email);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::EMAIL, $email, $comparison);
	}

	/**
	 * Filter the query on the locale column
	 * 
	 * @param     string $locale The value to use as filter.
	 *            Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLocale($locale = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($locale)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $locale)) {
				$locale = str_replace('*', '%', $locale);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(UserPeer::LOCALE, $locale, $comparison);
	}

	/**
	 * Filter the query on the created_at column
	 * 
	 * @param     string|array $createdAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(UserPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(UserPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::CREATED_AT, $createdAt, $comparison);
	}

	/**
	 * Filter the query on the updated_at column
	 * 
	 * @param     string|array $updatedAt The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query on the inactive_notification column
	 * 
	 * @param     boolean|string $inactiveNotification The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByInactiveNotification($inactiveNotification = null, $comparison = null)
	{
		if (is_string($inactiveNotification)) {
			$inactive_notification = in_array(strtolower($inactiveNotification), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(UserPeer::INACTIVE_NOTIFICATION, $inactiveNotification, $comparison);
	}

	/**
	 * Filter the query on the weekly_notification column
	 * 
	 * @param     boolean|string $weeklyNotification The value to use as filter.
	 *            Accepts strings ('false', 'off', '-', 'no', 'n', and '0' are false, the rest is true)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByWeeklyNotification($weeklyNotification = null, $comparison = null)
	{
		if (is_string($weeklyNotification)) {
			$weekly_notification = in_array(strtolower($weeklyNotification), array('false', 'off', '-', 'no', 'n', '0')) ? false : true;
		}
		return $this->addUsingAlias(UserPeer::WEEKLY_NOTIFICATION, $weeklyNotification, $comparison);
	}

	/**
	 * Filter the query on the Location_id column
	 * 
	 * @param     int|array $locationId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLocationId($locationId = null, $comparison = null)
	{
		if (is_array($locationId)) {
			$useMinMax = false;
			if (isset($locationId['min'])) {
				$this->addUsingAlias(UserPeer::LOCATION_ID, $locationId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($locationId['max'])) {
				$this->addUsingAlias(UserPeer::LOCATION_ID, $locationId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(UserPeer::LOCATION_ID, $locationId, $comparison);
	}

	/**
	 * Filter the query by a related Location object
	 *
	 * @param     Location $location  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByLocation($location, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::LOCATION_ID, $location->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Location relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinLocation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Location');
		
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
			$this->addJoinObject($join, 'Location');
		}
		
		return $this;
	}

	/**
	 * Use the Location relation Location object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    LocationQuery A secondary query class using the current class as primary query
	 */
	public function useLocationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinLocation($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Location', 'LocationQuery');
	}

	/**
	 * Filter the query by a related Flight object
	 *
	 * @param     Flight $flight  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFlight($flight, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $flight->getUserId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Flight relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinFlight($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Flight');
		
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
			$this->addJoinObject($join, 'Flight');
		}
		
		return $this;
	}

	/**
	 * Use the Flight relation Flight object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FlightQuery A secondary query class using the current class as primary query
	 */
	public function useFlightQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFlight($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Flight', 'FlightQuery');
	}

	/**
	 * Filter the query by a related Friendlist object
	 *
	 * @param     Friendlist $friendlist  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByFriendlist($friendlist, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $friendlist->getUserId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Friendlist relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinFriendlist($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Friendlist');
		
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
			$this->addJoinObject($join, 'Friendlist');
		}
		
		return $this;
	}

	/**
	 * Use the Friendlist relation Friendlist object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FriendlistQuery A secondary query class using the current class as primary query
	 */
	public function useFriendlistQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinFriendlist($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Friendlist', 'FriendlistQuery');
	}

	/**
	 * Filter the query by a related Playerstatus object
	 *
	 * @param     Playerstatus $playerstatus  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function filterByPlayerstatus($playerstatus, $comparison = null)
	{
		return $this
			->addUsingAlias(UserPeer::ID, $playerstatus->getUserId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Playerstatus relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function joinPlayerstatus($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('Playerstatus');
		
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
			$this->addJoinObject($join, 'Playerstatus');
		}
		
		return $this;
	}

	/**
	 * Use the Playerstatus relation Playerstatus object
	 *
	 * @see       useQuery()
	 * 
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    PlayerstatusQuery A secondary query class using the current class as primary query
	 */
	public function usePlayerstatusQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinPlayerstatus($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'Playerstatus', 'PlayerstatusQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     User $user Object to remove from the list of results
	 *
	 * @return    UserQuery The current query, for fluid interface
	 */
	public function prune($user = null)
	{
		if ($user) {
			$this->addUsingAlias(UserPeer::ID, $user->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseUserQuery
