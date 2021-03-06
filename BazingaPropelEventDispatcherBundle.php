<?php

namespace Bazinga\Bundle\PropelEventDispatcherBundle;

use Bazinga\Bundle\PropelEventDispatcherBundle\DependencyInjection\CompilerPass\RegisterEventListenersPass;
use Bazinga\Bundle\PropelEventDispatcherBundle\EventDispatcher\LazyEventDispatcher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class BazingaPropelEventDispatcherBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterEventListenersPass());
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $classes = $this->container->getParameter('bazinga.propel_event_dispatcher.registered_classes');

        foreach ($classes as $id => $class) {
            $class::setEventDispatcher(new LazyEventDispatcher($this->container, $id));
        }
    }
}
