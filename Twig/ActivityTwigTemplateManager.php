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
namespace Rhapsody\SocialBundle\Twig;

use Doctrine\Common\Util\Debug;

use Rhapsody\CommonsBundle\Twig\TwigTemplateManager;
use Rhapsody\SocialBundle\Model\ActivityContentInterface;
use Rhapsody\SocialBundle\Model\ActivityInterface;


class ActivityTwigTemplateManager extends TwigTemplateManager
{
	public function renderActivity(ActivityInterface $activity, array $data = array())
	{
		$view = $this->getView($activity);

		$data = array_merge(array('_widget' => $activity), $data);
		return $this->twig->render($view, $data);
	}

	public function renderActivityContent(ActivityContentInterface $activityContent, array $data = array())
	{
		$view = $this->getView($activityContent);

		$data = array_merge(array('_widget' => $activityContent), $data);
		return $this->twig->render($view, $data);
	}
}