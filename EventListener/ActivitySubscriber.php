<?php
/* Copyright (c) Rhapsody Project
 *
 * Licensed under the MIT License (http://opensource.org/licenses/MIT)
 *
 * Permission is hereby granted, free of charge, to any
 * person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the
 * Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software,
 * and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice
 * shall be included in all copies or substantial portions of
 * the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY
 * KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR
 * OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT
 * OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Rhapsody\SocialBundle\EventListener;

use Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface;
use Rhapsody\SocialBundle\Event\ActivityEventInterface;
use Rhapsody\SocialBundle\Factory\TemplateFactoryInterface;
use Rhapsody\SocialBundle\Mailer\MailerInterface;
use Rhapsody\SocialBundle\RhapsodySocialEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 *
 * @author    Sean.Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\EventListener
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class ActivitySubscriber implements EventSubscriberInterface
{

	private $mailer;
	private $router;
	private $session;

	/**
	 * The {@link ActivityManager}.
	 * @var \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface
	 */
	private $activityManager;

	/**
	 * The {@link TemplateFactory}.
	 * @var \Rhapsody\SocialBundle\Factory\TemplateFactoryInterface
	 */
	private $templateFactory;

	protected $senderEmail = 'noreply@lorecall.com';
	protected $senderName = 'Lorecall';

	/**
	 *
	 * @param MailerInterface $mailer
	 * @param UrlGeneratorInterface $router
	 * @param SessionInterface $session
	 */
	public function __construct(MailerInterface $mailer, UrlGeneratorInterface $router, SessionInterface $session, ActivityManagerInterface $activityManager, TemplateFactoryInterface $templateFactory)
	{
		$this->mailer = $mailer;
		$this->router = $router;
		$this->session = $session;
		$this->activityManager = $activityManager;
		$this->templateFactory = $templateFactory;
	}

	public static function getSubscribedEvents()
	{
		return array(
			RhapsodySocialEvents::NEW_ACTIVITY => array('onActivity', 0),
		);
	}

	public function onActivity(ActivityEventInterface $event)
	{
	}

}
