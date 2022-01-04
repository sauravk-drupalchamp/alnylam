<?php

namespace Drupal\signup_for_updates\Plugin\Block;
use Drupal\Core\Block\BlockBase;


/**
 * Provides a block with simple text.
 *
 * @Block(
 * id="signup_for_updates",
 * admin_label=@Translation("Signup For Updates")
 * )
 */
class  SignupForUpdateBlock extends BlockBase{
   /**
   * {@inheritdoc}
   */  
  public function build(){     
        
        $output = [];        
        
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        $result  = array('country'=>'', 'city'=>'');
        if(filter_var($client, FILTER_VALIDATE_IP)){
            $ip = $client;
        }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
            $ip = $forward;
        }else{
            $ip = $remote;
        }
		$json     = file_get_contents("http://ipinfo.io/$ip/geo");
		$json     = json_decode($json, true);
		/*print"<pre>";
		print_r($json );    
		print"</pre>";*/
        if($json && $json['country'] != null){
            if( $json['country'] =="US"){
              $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('_us_residents');
              $webform = $webform->getSubmissionForm();
              return $webform;
            }else{
              $webform = \Drupal::entityTypeManager()->getStorage('webform')->load('signup_for_updates_international');
              $webform = $webform->getSubmissionForm();
              return $webform;
            }
        }   

        $build['signup_for_updates'] = [
        '#markup' => $output,
        '#cache' => ['max-age' => 0],

        ];

      return $build;
}


}