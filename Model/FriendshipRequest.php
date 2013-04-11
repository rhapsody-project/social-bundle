<?php
namespace Rhapsody\SocialBundle\Model;

/**
 * @author Sean.Quinn
 *
 */
abstract class Friendship implements FriendshipInterface
{

	/**
	 * Friendships requests are not typically auto-confirmed (though they can
	 * be configured to be); this allows the user receiving the request to
	 * accept or deny it.
	 * @var unknown
	 */
	protected $confirmed = false;

	/**
	 *
	 * @var mixed
	 */
	protected $recipient;

	/**
	 *
	 * @var mixed
	 */
	protected $requestedBy;

}