<?php
namespace Rhapsody\SocialBundle\Model;

/**
 *
 * @author Sean.Quinn
 */
interface ActivityInterface
{

	/**
	 *
	 */
	function getComments();

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
	function getId();

	/**
	 *
	 */
	function getText();

	/**
	 *
	 */
	function getType();

	/**
	 *
	 * @return \Rhapsody\SocialBundle\Model\mixed
	 */
	function getUser();
}