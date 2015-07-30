<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/app')) {
            if (0 === strpos($pathinfo, '/app/t')) {
                // nothomepage
                if ($pathinfo === '/app/trol') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::wow',  '_route' => 'nothomepage',);
                }

                // test
                if ($pathinfo === '/app/test') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::test',  '_route' => 'test',);
                }

            }

            if (0 === strpos($pathinfo, '/app/upload')) {
                // upload
                if (rtrim($pathinfo, '/') === '/app/upload') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', 'upload');
                    }

                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::upload',  '_route' => 'upload',);
                }

                // deleteUpload
                if ($pathinfo === '/app/upload/upload') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::deleteUpload',  '_route' => 'deleteUpload',);
                }

            }

            // checkPath
            if ($pathinfo === '/app/checkPath') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getUrl',  '_route' => 'checkPath',);
            }

            if (0 === strpos($pathinfo, '/app/get')) {
                // getRegistrationForm
                if ($pathinfo === '/app/getRegistrationForm') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getRegistrationForm',  '_route' => 'getRegistrationForm',);
                }

                // getUploadForm
                if ($pathinfo === '/app/getUploadForm') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getUploadForm',  '_route' => 'getUploadForm',);
                }

            }

            // task_success
            if ($pathinfo === '/app/task_success') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::taskSuccess',  '_route' => 'task_success',);
            }

            if (0 === strpos($pathinfo, '/app/log')) {
                if (0 === strpos($pathinfo, '/app/login')) {
                    // loginAction
                    if ($pathinfo === '/app/login') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SecurityController::loginAction',  '_route' => 'loginAction',);
                    }

                    // loginCheckAction
                    if ($pathinfo === '/app/login_check') {
                        return array (  '_controller' => 'AppBundle\\Controller\\SecurityController::loginCheckAction',  '_route' => 'loginCheckAction',);
                    }

                }

                // logout
                if ($pathinfo === '/app/logout') {
                    return array('_route' => 'logout');
                }

            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
