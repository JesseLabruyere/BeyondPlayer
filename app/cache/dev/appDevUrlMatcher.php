<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher.
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
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

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if (rtrim($pathinfo, '/') === '/_profiler') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ($pathinfo === '/_profiler/search') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ($pathinfo === '/_profiler/search_bar') {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ($pathinfo === '/_profiler/purge') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ($pathinfo === '/_profiler/phpinfo') {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if (rtrim($pathinfo, '/') === '/_configurator') {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ($pathinfo === '/_configurator/final') {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

            // _twig_error_test
            if (0 === strpos($pathinfo, '/_error') && preg_match('#^/_error/(?P<code>\\d+)(?:\\.(?P<_format>[^/]++))?$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_twig_error_test')), array (  '_controller' => 'twig.controller.preview_error:previewErrorPageAction',  '_format' => 'html',));
            }

        }

        // homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'homepage');
            }

            return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::indexAction',  '_route' => 'homepage',);
        }

        if (0 === strpos($pathinfo, '/app')) {
            // removeAudio
            if (0 === strpos($pathinfo, '/app/removeAudio') && preg_match('#^/app/removeAudio/(?P<audioId>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'removeAudio')), array (  '_controller' => 'AppBundle\\Controller\\DefaultController::removeAudio',));
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

            if (0 === strpos($pathinfo, '/app/getPlaylist')) {
                // getPlaylist
                if (preg_match('#^/app/getPlaylist/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => 'getPlaylist')), array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getPlaylist',));
                }

                // getPlaylists
                if ($pathinfo === '/app/getPlaylists') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getPlaylists',  '_route' => 'getPlaylists',);
                }

            }

            // addToPlaylist
            if (0 === strpos($pathinfo, '/app/addToPlaylist') && preg_match('#^/app/addToPlaylist/(?P<listId>[^/]++)/(?P<audioId>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'addToPlaylist')), array (  '_controller' => 'AppBundle\\Controller\\DefaultController::addToPlaylist',));
            }

            if (0 === strpos($pathinfo, '/app/get')) {
                if (0 === strpos($pathinfo, '/app/getAlbum')) {
                    // getAlbum
                    if (preg_match('#^/app/getAlbum/(?P<name>[^/]++)$#s', $pathinfo, $matches)) {
                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'getAlbum')), array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getAlbum',));
                    }

                    // getAlbums
                    if ($pathinfo === '/app/getAlbums') {
                        return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getAlbums',  '_route' => 'getAlbums',);
                    }

                }

                // getUploads
                if ($pathinfo === '/app/getUploads') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getUploads',  '_route' => 'getUploads',);
                }

                if (0 === strpos($pathinfo, '/app/getPlaylist')) {
                    // getPlaylistsView
                    if ($pathinfo === '/app/getPlaylistsView') {
                        return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getPlaylistsView',  '_route' => 'getPlaylistsView',);
                    }

                    // getPlaylistView
                    if ($pathinfo === '/app/getPlaylistView') {
                        return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getPlaylistView',  '_route' => 'getPlaylistView',);
                    }

                }

                if (0 === strpos($pathinfo, '/app/getAlbum')) {
                    // getAlbumsView
                    if ($pathinfo === '/app/getAlbumsView') {
                        return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getAlbumsView',  '_route' => 'getAlbumsView',);
                    }

                    // getAlbumView
                    if ($pathinfo === '/app/getAlbumView') {
                        return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getAlbumView',  '_route' => 'getAlbumView',);
                    }

                }

                // getUploadsView
                if ($pathinfo === '/app/getUploadsView') {
                    return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getUploadsView',  '_route' => 'getUploadsView',);
                }

            }

            // getEmpty
            if ($pathinfo === '/app/empty') {
                return array (  '_controller' => 'AppBundle\\Controller\\DefaultController::getEmpty',  '_route' => 'getEmpty',);
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
