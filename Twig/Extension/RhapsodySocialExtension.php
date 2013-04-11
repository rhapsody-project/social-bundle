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
use Rhapsody\SocialBundle\Twig\ActivityTwigTemplateManager;
use Symfony\Bridge\Twig\TokenParser\FormThemeTokenParser;
use Symfony\Bridge\Twig\Form\TwigRendererInterface;
use Symfony\Component\Form\Extension\Core\View\ChoiceView;

/**
 * ActivityExtension extends Twig with activity rendering capabilities.
 */
class RhapsodySocialExtension extends \Twig_Extension
{
    /**
     * @var \Rhapsody\SocialBundle\Twig\ActivityTwigTemplateManager
     */
    public $activityTemplateManager;

    public function __construct(ActivityTwigTemplateManager $activityTemplateManager)
    {
        $this->activityTemplateManager = $activityTemplateManager;
    }

    public function doRenderSocialActivityWidget(ActivityInterface $activity)
    {
		return $this->activityTemplateManager->renderActivity($activity);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
    	$functions = array();

    	$functions['social_activity_widget'] = new \Twig_Function_Method($this, 'doRenderSocialActivityWidget', array('is_safe' => array('html')));
    	return $functions;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'rhapsody_social';
    }
}
