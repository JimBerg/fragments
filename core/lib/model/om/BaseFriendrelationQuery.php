<?php


/**
 * Base class that represents a query for the 'Friendrelation' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.5.3 on:
 *
 * Tue May 24 10:36:29 2011
 *
 * @method     FriendrelationQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     FriendrelationQuery orderByFriendId($order = Criteria::ASC) Order by the Friend_id column
 * @method     FriendrelationQuery orderByFriendlistId($order = Criteria::ASC) Order by the Friendlist_id column
 *
 * @method     FriendrelationQuery groupById() Group by the id column
 * @method     FriendrelationQuery groupByFriendId() Group by the Friend_id column
 * @method     FriendrelationQuery groupByFriendlistId() Group by the Friendlist_id column
 *
 * @method     FriendrelationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     FriendrelationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     FriendrelationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     FriendrelationQuery leftJoinFriend($relationAlias = null) Adds a LEFT JOIN clause to the query using the Friend relation
 * @method     FriendrelationQuery rightJoinFriend($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Friend relation
 * @method     FriendrelationQuery innerJoinFriend($relationAlias = null) Adds a INNER JOIN clause to the query using the Friend relation
 *
 * @method     FriendrelationQuery leftJoinFriendlist($relationAlias = null) Adds a LEFT JOIN clause to the query using the Friendlist relation
 * @method     FriendrelationQuery rightJoinFriendlist($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Friendlist relation
 * @method     FriendrelationQuery innerJoinFriendlist($relationAlias = null) Adds a INNER JOIN clause to the query using the Friendlist relation
 *
 * @method     Friendrelation findOne(PropelPDO $con = null) Return the first Friendrelation matching the query
 * @method     Friendrelation findOneOrCreate(PropelPDO $con = null) Return the first Friendrelation matching the query, or a new Friendrelation object populated from the query conditions when no match is found
 *
 * @method     Friendrelation findOneById(int $id) Return the first Friendrelation filtered by the id column
 * @method     Friendrelation findOneByFriendId(int $Friend_id) Return the first Friendrelation filtered by the Friend_id column
 * @method     Friendrelation findOneByFriendlistId(int $Friendlist_id) Return the first Friendrelation filtered by the Friendlist_id column
 *
 * @method     array findById(int $id) Return Friendrelation objects filtered by the id column
 * @method     array findByFriendId(int $Friend_id) Return Friendrelation objects filtered by the Friend_id column
 * @method     array findByFriendlistId(int $Friendlist_id) Return Friendrelation objects filtered by the Friendlist_id column
 *
 * @package    propel.generator.lib.model.om
 */
abstract class BaseFriendrelationQuery extends ModelCriteria
{

	/**
	 * Initializes internal state of BaseFriendrelationQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'propel', $modelName = 'Friendrelation', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new FriendrelationQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    FriendrelationQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof FriendrelationQuery) {
			return $criteria;
		}
		$query = new FriendrelationQuery();
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
	 * @return    Friendrelation|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ((null !== ($obj = FriendrelationPeer::getInstanceFromPool((string) $key))) && $this->getFormatter()->isObjectFormatter()) {
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
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(FriendrelationPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(FriendrelationPeer::ID, $keys, Criteria::IN);
	}

	/**
	 * Filter the query on the id column
	 * 
	 * @param     int|array $id The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(FriendrelationPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the Friend_id column
	 * 
	 * @param     int|array $friendId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterByFriendId($friendId = null, $comparison = null)
	{
		if (is_array($friendId)) {
			$useMinMax = false;
			if (isset($friendId['min'])) {
				$this->addUsingAlias(FriendrelationPeer::FRIEND_ID, $friendId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($friendId['max'])) {
				$this->addUsingAlias(FriendrelationPeer::FRIEND_ID, $friendId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(FriendrelationPeer::FRIEND_ID, $friendId, $comparison);
	}

	/**
	 * Filter the query on the Friendlist_id column
	 * 
	 * @param     int|array $friendlistId The value to use as filter.
	 *            Accepts an associative array('min' => $minValue, 'max' => $maxValue)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterByFriendlistId($friendlistId = null, $comparison = null)
	{
		if (is_array($friendlistId)) {
			$useMinMax = false;
			if (isset($friendlistId['min'])) {
				$this->addUsingAlias(FriendrelationPeer::FRIENDLIST_ID, $friendlistId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($friendlistId['max'])) {
				$this->addUsingAlias(FriendrelationPeer::FRIENDLIST_ID, $friendlistId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(FriendrelationPeer::FRIENDLIST_ID, $friendlistId, $comparison);
	}

	/**
	 * Filter the query by a related Friend object
	 *
	 * @param     Friend $friend  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterByFriend($friend, $comparison = null)
	{
		return $this
			->addUsingAlias(FriendrelationPeer::FRIEND_ID, $friend->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Friend relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
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
	 * Filter the query by a related Friendlist object
	 *
	 * @param     Friendlist $friendlist  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function filterByFriendlist($friendlist, $comparison = null)
	{
		return $this
			->addUsingAlias(FriendrelationPeer::FRIENDLIST_ID, $friendlist->getId(), $comparison);
	}

	/**
	 * Adds a JOIN clause to the query using the Friendlist relation
	 * 
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
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
	 * Exclude object from result
	 *
	 * @param     Friendrelation $friendrelation Object to remove from the list of results
	 *
	 * @return    FriendrelationQuery The current query, for fluid interface
	 */
	public function prune($friendrelation = null)
	{
		if ($friendrelation) {
			$this->addUsingAlias(FriendrelationPeer::ID, $friendrelation->getId(), Criteria::NOT_EQUAL);
	  }
	  
		return $this;
	}

} // BaseFriendrelationQuery