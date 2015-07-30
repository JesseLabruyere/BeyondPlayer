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
            // nothomepage
            if ($pathinfo === '/app/trol') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::wow',  '_route' => 'nothomepage',);
            }

            // uploadForm
            if ($pathinfo === '/app/uploadForm') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::uploadForm',  '_route' => 'uploadForm',);
            }

            // test
            if ($pathinfo === '/app/test') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::test',  '_route' => 'test',);
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

            // getUploadForm
            if ($pathinfo === '/app/getUploadForm') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getUploadForm',  '_route' => 'getUploadForm',);
            }

            // task_success
            if ($pathinfo === '/app/task_success') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::taskSuccess',  '_route' => 'task_success',);
            }

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
