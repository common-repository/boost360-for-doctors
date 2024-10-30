<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.nowfloats.com
 * @since      1.0.0
 *
 * @package    Boost360_For_Doctors
 * @subpackage Boost360_For_Doctors/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Boost360_For_Doctors
 * @subpackage Boost360_For_Doctors/public
 * @author     NowFloats Technologies Pvt Ltd <developers@nowfloats.com>
 */
class Boost360_For_Doctors_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Boost360_For_Doctors_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boost360_For_Doctors_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boost360-for-doctors-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Boost360_For_Doctors_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boost360_For_Doctors_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/boost360-for-doctors-public.js', array( 'jquery' ), $this->version, false );

	}

	private function callDataAPI($method, $url, $data){
		try {
			$response = wp_remote_get( $url,array(
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
				'method' => 'PUT',
                'blocking'    => true,
                'headers'     => array(
                    'Content-type' => 'application/json'
                ),
				'filename'    => null, 
                'body' => $data,
            ));
			$result = wp_remote_retrieve_body( $response );
			return $result;
		} catch(Exception $e){
			error_log("Exception in callDataAPI");
			error_log($e);
			return "FAILED";
		}
	 }

	
	private function callFileAPI($method, $url, $fileName, $fileUrl) {
		try {
			
			$data = file_get_contents($fileName);
			$response = wp_remote_get( $url,array(
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
				'method' => 'PUT',
                'blocking'    => true,
                'headers'     => array(
                    'Content-type' => 'binary/octect-stream',
                    'cache-control' => 'no-cache'
                ),
				'filename'    => $fileName, 
                'body' => $data,
            ));
			$result = wp_remote_retrieve_body( $response );
			return $result;
		} catch(Exception $e){
			error_log("Exception in callFileAPI");
			error_log($e);
			return "FAILED";
		}
	}

	 private function post_boost_sync_notification($ID, $post, $status) {
		 try{
			$author = $post->post_author; /* Post author ID. */
			$name = get_the_author_meta( 'display_name', $author );
			$email = get_the_author_meta( 'user_email', $author );
			$title = $post->post_title;
			$permalink = get_permalink( $ID );
			$edit = get_edit_post_link( $ID, '' );
			$to[] = sprintf( '%s <%s>', $name, $email );
			$subject = sprintf( 'Boost360 sync %s for: %s', ($status == 1?'complete' : 'failed'), $title );
			$message = sprintf ('%s, %s! Your article "%s" %s' . "\n\n", 
										($status === 1?'Congratulations' : 'Sorry'), 
										$name, 
										$title, 
										($status === 1?'failed to sync with Boost360. Please check your account settings in the Boost360 app, or you can get in touch with Boost Care team.' : 
														'has been published to all your digital channels via Boost360.' )
								);
			$message .= sprintf( 'View: %s', $permalink );
			$headers[] = '';
			wp_mail( $to, $subject, $message, $headers );
		} catch(Exception $e){
			error_log("Exception in post_boost_sync_notification");
			error_log($e);
		}
	}

	/**
	 * Fire a callback when page footer is rendered.
	 * Adds the Boost360 bar to the website.
	 */
	public function set_boostx_script(){
		try{
			$options = get_option($this->plugin_name);
			$boostxscript = $options['boostxscript'];
			
			echo $boostxscript;
		} catch(Exception $e){
			error_log("Exception in set_boostx_script");
			error_log($e);
		}
	}

	/**
	 * Fire a callback only when post status is changed.
	 *
	 * @param string  $new_status New post status.
	 * @param string  $old_status Old post status.
	 * @param WP_Post $post       Post object.
	 */
	public function process_post_update( $new_status, $old_status, $post ){
		try{
			$options = get_option($this->plugin_name);
			$sync_post = $options['sync_post'];
			$fp_id = $options['int_id'];
			//echo $fp_id;die();
			if(1 === $sync_post && !empty($fp_id)){
				if('publish' === $new_status && 'publish' !== $old_status) {
					// Do something - new post
					if (!isset($request)) {
						$request = new stdClass();
					}
					$request->clientId = "8DB87D953727422DA36B4977BD12E37A92EEB23119DC4152AAEB6B22BDB578EF";
					$request->sendToSubscribers = true;
					$request->isPictureMessage = false;
					$request->message = $post->post_title . " " . $post->post_content;
					$request->IsHtmlString = true;
					$request->merchantId = $fp_id;
					$request->externalSourceName = $post->ID;
					
					$boost_post_id = $this->callDataAPI("PUT", "https://api.withfloats.com/discover/v2/FloatingPoint/createBizMessage", json_encode($request));
					if("FAILED" === $boost_post_id){
						$this->post_boost_sync_notification($post->ID, $post, 0);
					} else if(!empty($boost_post_id)){
						update_post_meta($post->ID, "boost_update_id", $boost_post_id);
						$this->post_boost_sync_notification($post->ID, $post, 1);
					}
				}

				if ( 'trash' === $old_status  &&  'trash'  !== $new_status) {				
					$fp_post_id = get_post_meta($post->ID, "boost_update_id", true);
					//TODO: archive $fp_post_id in Boost
				}
			}
		} catch(Exception $e){
			error_log("Exception in process_post_update");
			error_log($e);
		}
	}

	/**
	 * Fire a callback only when media is uploaded.
	 *
	 * @param string  $resource file details.
	 * @param string  $context 
	 */
	public function process_image_update($resource, $context){
		try{
			$options = get_option($this->plugin_name);
			$sync_image = $options['sync_image'];
			$fp_id = $options['int_id'];
			//echo $fp_id;die();
			if(1 === $sync_image && !empty($fp_id)){
				if( 'image' == substr( $resource['type'], 0, 5 ) ){
					$url = "https://api.withfloats.com/discover/v1/FloatingPoint/createSecondaryImage?";
					$url = $url . "clientId=8DB87D953727422DA36B4977BD12E37A92EEB23119DC4152AAEB6B22BDB578EF";
					$url = $url . "&reqType=sequential";
					$url = $url . "&reqtId=".uniqid();
					$url = $url . "&totalChunks=1";
					$url = $url . "&currentChunkNumber=1";
					$url = $url . "&fpId=".$fp_id;
					$url = $url . "&identifierType=SINGLE";
					$url = $url . "&fileName=" . $resource['file'];
					
					$boost_post_id = $this->callFileAPI("PUT", $url, $resource['file'], $resource['url']);
				}
			}

			return $resource;
		} catch(Exception $e){
			error_log("Exception in process_image_update");
			error_log($e);
		}
	}

}
