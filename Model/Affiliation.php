<?php
namespace Rhapsody\SocialBundle\Model;

/**
 * An Affiliation is a relationship between a <code>User</code> and another
 * entity, usually described in terms of membership to a group or friendship
 * with another user.
 *
 * @author Sean.Quinn
 * @since 1.0
 */
abstract class Affiliation implements AffiliationInterface
{

	/**
	 * The entity that the <tt>$user</tt> is affiliated with.
	 * @var mixed
	 * @access protected
	 */
	protected $affiliate;

	/**
	 * The date that this affiliation was formed.
	 * @var \DateTime
	 * @access protected
	 */
	protected $date;

	/**
	 * The group that this affiliation is classified in; may be null.
	 * @var string
	 * @access protected
	 */
	protected $group;

	/**
	 * The user for whom this affiliation is established.
	 * @var unknown
	 * @access protected
	 */
	protected $user;

}