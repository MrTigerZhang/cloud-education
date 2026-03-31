<?php
/**
 * 
 * @license https://opensource.org/licenses/GPL-2.0
 * @link https://www.koogua.com
 */

namespace App\Providers;

use Phalcon\Di\InjectionAwareInterface;

interface ProviderInterface extends InjectionAwareInterface
{

    /**
     * Register application service.
     *
     * @return mixed
     */
    public function register();

    /**
     * Gets the Service name.
     *
     * @return string
     */
    public function getName();

}
