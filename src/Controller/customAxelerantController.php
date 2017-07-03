<?php

namespace Drupal\custom_axelerant\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception;

/**
 * Controller routines for Custom Axelerant route.
 */
class customAxelerantController extends ControllerBase {

  /**
   * Page callback to retrieve nodes of type page.
   *
   *  @param int $nid
   *    Nid of a node object defaults to FALSE.
   *  @return $output
   *    JSON output of the node.
   */
  public function axelerant_page_json_output($node = NULL) {
    $axelerant_site_api_key = \Drupal::state()->get('siteapikey', 'No API Key yet');
    $node_data = $output = $element = '';
    if ($axelerant_site_api_key && $node) {
      $nodes = Node::load($node);
      if (!empty($nodes)) {
        $node_data = $nodes->toArray();
        if (!empty($node_data) && $nodes->getType() === 'page' && !empty($axelerant_site_api_key) && ($axelerant_site_api_key != 'No API Key yet')) {
          $output = new JsonResponse($node_data);
          $out = json_encode($node_data);
        }
      }
    }
    if (empty($output)) {
      throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
    } else {
      $element = array(
        '#markup' => '<h3><b>OUTPUT 1:  json_encode()</b></h3><p>' . $out . '</p></br></br><h3><b>OUTPUT 2:  JsonResponse()</b></h3><p>' . $output . '</p>',
      );

      return $element;
    }
  }

}
