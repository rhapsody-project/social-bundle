<?php
namespace Rhapsody\SocialBundle\Model;

/**
 *
 * @author Sean.Quinn
 */
interface CommentInterface
{
	/**
	 *
	 */
	function getDate();

	/**
	 *
	 */
	function getEndorsements();

	/**
	 *
	 */
	function getText();

	/**
	 *
	 * @return mixed
	 */
	function getUser();
}