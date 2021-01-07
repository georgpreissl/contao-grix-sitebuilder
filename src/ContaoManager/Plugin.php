<?php



declare(strict_types=1);

namespace GeorgPreissl\ContaoGrixBundle\ContaoManager;


use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use GeorgPreissl\ContaoGrixBundle\GeorgPreisslContaoGrixBundle;

/**
 * Class Plugin
 *
 * @package GeorgPreissl\ContaoGrixBundle\ContaoManager
 */
class Plugin implements BundlePluginInterface, RoutingPluginInterface
{
    /**
     * @param ParserInterface $parser
     * @return array
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(GeorgPreisslContaoGrixBundle::class)
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle']),
        ];
    }

    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__.'/../Resources/config/routing.yml')
            ->load(__DIR__.'/../Resources/config/routing.yml')
        ;
    }


}

