<?php
/* Copyright (c) 2013 Rhapsody Project
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
namespace Rhapsody\SocialBundle\Twig\Extension;

use Rhapsody\SocialBundle\Model\ActivityInterface;
use Rhapsody\SocialBundle\Model\CommentInterface;
use Rhapsody\SocialBundle\Twig\ActivityTwigTemplateManager;
use Rhapsody\SocialBundle\Model\ShareableInterface;
use Rhapsody\SocialBundle\Model\ActivitySourceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ActivityExtension extends Twig with activity rendering capabilities.
 *
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Twig\Extension
 * @copyright Copyright (c) 2015 Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class RhapsodySocialExtension extends \Twig_Extension
{
	/**
	 * @var \Rhapsody\SocialBundle\Twig\ActivityTwigTemplateManager
	 */
	public $activityTemplateManager;

	/**
	 * The service container.
	 * @var \Symfony\Component\DependencyInjection\ContainerInterface
	 */
	private $container;

	public function __construct(ContainerInterface $container, ActivityTwigTemplateManager $activityTemplateManager)
	{
		$this->container = $container;
		$this->activityTemplateManager = $activityTemplateManager;
	}

	public function attributeActivitySource($object)
	{
		return $this->activityTemplateManager->renderAttribution($object);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('rhapsody_social_activity_source_attribution',
				array($this, 'attributeActivitySource'),
				array('is_safe' => array('html'))
			),
			new \Twig_SimpleFunction('render_shared_media',
				array($this, 'renderSharedMedia'),
				array('is_safe' => array('html'))
			),
			new \Twig_SimpleFunction('rhapsody_social_config',
				array($this, 'getRhapsodySocialConfig')
			),
			new \Twig_SimpleFunction('rhapsody_social_get_share_type',
				array($this, 'getShareType'),
				array('is_safe' => array('html'))
			),
			new \Twig_SimpleFunction('rhapsody_social_is_activity_interactive',
				array($this, 'isActivityInteractive')
			),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return 'rhapsody_social';
	}

	/**
	 *
	 * @param unknown $parameter
	 */
	public function getRhapsodySocialConfig($parameter)
	{
		return $this->container->getParameter($parameter);
	}

	public function getShareType($object)
	{
		$class = get_class($object);
		return $class;
	}

	public function isActivityInteractive()
	{
		$canComment = $this->container->getParameter('rhapsody_social.activity.allow_comment');
		$canEndorse = $this->container->getParameter('rhapsody_social.activity.allow_endorsement');
		$canShare   = $this->container->getParameter('rhapsody_social.activity.allow_share');

		return $canComment || $canEndorse || $canShare;
	}

	/**
	 * Renders the shared media.
	 *
	 * @param ShareableInterface $object
	 */
	public function renderSharedMedia(ShareableInterface $object)
	{
		return $this->activityTemplateManager->renderShareable($object);
	}

}
