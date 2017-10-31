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
namespace Rhapsody\SocialBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 *
 * @author    Sean W. Quinn
 * @category  Rhapsody SocialBundle
 * @package   Rhapsody\SocialBundle\Form\Type
 * @copyright Copyright (c) Rhapsody Project
 * @license   http://opensource.org/licenses/MIT
 * @version   $Id$
 * @since     1.0
 */
class TopicType extends AbstractType
{
	private $class;

	/**
	 * @param string $class The User class name
	 */
	public function __construct($class)
	{
			$this->class = $class;
	}

	/**
	 * (non-PHPdoc)
	 * @see \Symfony\Component\Form\AbstractType::buildForm()
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('title', TextType::class);
		$builder->add('post', $options['post_form'], array(
			'data_class' => $options['post_class'],
			'label'  => false,
			'mapped' => false
		));
	}

	public function getName()
	{
		return 'rhapsody_forum_form_type_topic';
	}

	// BC for Symfony Framework < 2.7
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$this->configureOptions($resolver);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'csrf_protection'   => true,
			'csrf_token_id'     => 'topic',
			'data_class'        => $this->class,
			'post_form'         => null,
			'post_class'        => null,
			// BC for Symfony Framework < 2.8
			'intention'         => 'topic',
		));
	}
}
