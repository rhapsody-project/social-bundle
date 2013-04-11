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
use Rhapsody\SocialBundle\Model\ActivityInterface;

class ActivityTwigTemplateManager extends TwigTemplateManager
{

	/**
	 *
	 * @param ActivityInterface $activity
	 */
	public function getActivityTemplate(ActivityInterface $activity)
	{
		$content = $activity->getContent();

		if ($content !== null) {
			$class = get_class($content);
			if (array_key_exists($class, $this->templateMap)) {
				return $this->getManagedTemplate($content);
			}
		}
		return $this->getManagedTemplate($activity);
	}

	/**
	 *
	 * @param ActivityInterface $activity
	 */
	public function getActivityView(ActivityInterface $activity)
	{
		$template = $this->getActivityTemplate($activity);
		return $template->getView();
	}

	public function renderActivity(ActivityInterface $activity, array $data = array())
	{
		$view = $this->getActivityView($activity);

		$data = array_merge(array('activity' => $activity), $data);
		return $this->twig->render($view, $data);
	}
}