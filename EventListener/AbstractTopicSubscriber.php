<?php
/* Copyright (c) 2015 Rhapsody Project
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
use Rhapsody\SocialBundle\Doctrine\TopicManagerInterface;
use Rhapsody\SocialBundle\Event\TopicEventInterface;
use Rhapsody\SocialBundle\Factory\TemplateFactoryInterface;
use Rhapsody\SocialBundle\Mailer\EmailTemplate;
use Rhapsody\SocialBundle\Mailer\MailerInterface;
use Rhapsody\SocialBundle\Model\TopicInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Rhapsody\SocialBundle\Model\ActivitySourceInterface;

/**
 *
 * @author    Sean.Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\EventListener
 * @copyright Copyright (c) 2013 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
abstract class AbstractTopicSubscriber implements EventSubscriberInterface
{

	protected $mailer;
	protected $router;
	protected $session;

	/**
	 * The {@link ActivityManager}
	 * @var \Rhapsody\SocialBundle\Doctrine\ActivityManagerInterface
	 */
	protected $activityManager;

	/**
	 * The sender's email address.
	 * @var string
	 */
	protected $senderEmail = null;

	/**
	 * The sender's name.
	 * @var string
	 */
	protected $senderName = null;

	/**
	 * The {@link TemplateFactory}.
	 * @var \Rhapsody\SocialBundle\Factory\TemplateFactoryInterface
	 */
	protected $templateFactory;

	/**
	 * The {@link TopicManager}.
	 * @var \Rhapsody\SocialBundle\Doctrine\TopicManagerInterface
	 */
	protected $topicManager;

	/**
	 *
	 * @param MailerInterface $mailer
	 * @param UrlGeneratorInterface $router
	 * @param SessionInterface $session
	 */
	public function __construct(
			MailerInterface $mailer,
			UrlGeneratorInterface $router,
			SessionInterface $session,
			TemplateFactoryInterface $templateFactory,
			ActivityManagerInterface $activityManager,
			TopicManagerInterface $topicManager)
	{
		$this->mailer = $mailer;
		$this->router = $router;
		$this->session = $session;
		$this->templateFactory = $templateFactory;
		$this->activityManager = $activityManager;
		$this->topicManager = $topicManager;
	}

	/**
	 * Excludes users in the <code>$exclude</code> list from the final filtered
	 * list of users.
	 *
	 * @param array $users the complete users list.
	 * @param array $exclude the collection of users to exclude.
	 * @return array the collection of users, filtered to not include those
	 *     users who were excluded.
	 */
	public function exclude($users = array(), $exclude = array())
	{
		array_walk($exclude, function(&$value, $key) {
			$value = $value->getId();
		});

		$filtered = array();
		foreach ($users as $user) {
			if (array_search($user->getId(), $exclude) === false) {
				$filtered[] = $user;
			}
		}
		return $filtered;
	}

	/**
	 * Generates a system level activity.
	 *
	 */
	public function generateActivity(ActivitySourceInterface $source, $content, $user = null)
	{
		$activity= $this->activityManager->newActivity(array(
			'content' => $content,
			'source' => $source,
			'author' => $user,
			'user' => null,
		));
		$this->activityManager->updateActivity($activity);
	}

	/**
	 * Notify the collection of <code>$users</code> of something that has
	 * happened on the platform. The email that is sent is composed from the
	 * <code>$data</code> and rendered into the <code>$template</code> before
	 * the mail is sent.
	 *
	 * @param string $template the email template.
	 * @param array $data the data to pass into the construction of the email
	 *     message.
	 * @param array $users the filtered collection of users to notify.
	 */
	public function notify($template, $data = array(), $users = array())
	{
		foreach ($users as $user) {
			$email = $user->email;
			if (!empty($email)) {
				$data['user'] = $user;

				/** @var $message \Rhapsody\SocialBundle\Mailer\MessageTemplate */
				$message = EmailTemplate::newInstance()
					->setTemplate($template)
					->setTo($email)
					->setFrom($this->mailer->getSenderEmail(), $this->mailer->getSenderName());
				$this->mailer->sendMessage($message, $data);
			}
		}
	}

}
