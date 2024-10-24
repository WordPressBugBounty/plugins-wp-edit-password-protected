<?php

/**
 * @link              http://wpthemespace.com
 * @since             1.0.0
 * @package           wp edit password protected
 *
 * @author noor alam
 */
/*
if(!class_exists('WpSpaceNtClass')){
class WpSpaceNtClass{

    function __construct()
   {
    add_action( 'init', [ $this, 'wpspace_admin_notice_option' ] );;
    add_action( 'admin_notices', [ $this, 'clicktop_new_optins_texts' ] );
      
   }

    function clicktop_new_optins_texts() {
        $api_url = 'https://ms.wpthemespace.com/msadd.php';  
        $api_response = wp_remote_get( $api_url );
    
        $click_message = '';
        $click_id = '1';
        $click_link1 = '';
        $click_linktext1 = '';
        $click_link2 = '';
        $click_linktext2 = '';
        if( !is_wp_error($api_response) ){
            $click_api_body = wp_remote_retrieve_body($api_response);
            $click_notice_outer = json_decode($click_api_body);
        
            $click_message = !empty($click_notice_outer->massage)? $click_notice_outer->massage: '';
            $click_id = !empty($click_notice_outer->id)? $click_notice_outer->id: '';
            $click_linktext1 = !empty($click_notice_outer->linktext1)? $click_notice_outer->linktext1: '';
            $click_link1 = !empty($click_notice_outer->link1)? $click_notice_outer->link1: '';
            $click_linktext2 = !empty($click_notice_outer->linktext2)? $click_notice_outer->linktext2: '';
            $click_link2 = !empty($click_notice_outer->link2)? $click_notice_outer->link2: '';
    
        }
    
        $click_addid = 'clickdissmiss'.$click_id;
        global $pagenow;
        if( get_option( $click_addid ) || $pagenow == 'plugins.php' ){
            return;
        }
    ?>
    <div class="eye-notice notice notice-success is-dismissible" style="padding:10px 15px 20px;">
    <?php if( $click_message ): ?>
        <p><?php echo wp_kses_post( $click_message ); ?></p>
    <?php endif; ?>
    <?php if( $click_link1 ): ?>
        <a target="_blank" class="button button-primary" href="<?php echo esc_url( $click_link1 ); ?>" style="margin-right:10px"><?php echo esc_html( $click_linktext1  ); ?></a>
    <?php endif; ?>
    <?php if( $click_link2 ): ?>
        <a target="_blank" class="button button-primary" href="<?php echo esc_url( $click_link2 ); ?>" style="margin-right:10px"><?php echo esc_html( $click_linktext2 ); ?></a>
    <?php endif; ?>
    <a href="#" class="clickto-dismiss"><?php echo esc_html('Dismiss this notice','click-to-top'); ?></a>
        
    </div>
    
    <?php
    
    
    }

        function wpspace_admin_notice_option(){
            global $pagenow;
            $api_url = 'https://ms.wpthemespace.com/msadd.php';  
            $api_response = wp_remote_get( $api_url );
          
            $click_id = '1';
            $click_oldid = '2';
            if( !is_wp_error($api_response) ){
                $click_api_body = wp_remote_retrieve_body($api_response);
                $click_notice_outer = json_decode($click_api_body);
        
                $click_id = !empty($click_notice_outer->id)? $click_notice_outer->id: '';
                $click_oldid = !empty($click_notice_outer->old_id)? $click_notice_outer->old_id: '';
        
              
            }
        
            $click_removeid = 'clickdissmiss'.$click_oldid;
            $click_addid = 'clickdissmiss'.$click_id;
        
            if(isset($_GET['clickdissmiss']) && $_GET['clickdissmiss'] == 1 ){
                delete_option( $click_removeid );
                update_option( $click_addid, 1 );
            }

            if( !(get_option( $click_addid ) || $pagenow == 'plugins.php') ){
                add_action( 'admin_footer', [ $this, 'add_scripts' ],999 );
            }
            
        }

        function add_scripts(){
            ?>
            <script>
            ;(function($){
                $(document).ready(function(){
                    $('.notic-click-dissmiss').on('click',function(){
                        var url = new URL(location.href);
                        url.searchParams.append('cdismissed',1);
                        location.href= url;
                    });
                    $('.clickto-dismiss').on('click',function(e){
                        e.preventDefault();
                        var url = new URL(location.href);
                        url.searchParams.append('clickdissmiss',1);
                        location.href= url;
                    });
                });
            })(jQuery);
            </script>
            <?php
        }




}

new WpSpaceNtClass();

  
}// if condition check 

*/

//Admin notice 
if (!function_exists('spacehide_go_me')) :
    function spacehide_go_me()
    {
        // Check if we're on the themes.php page
        global $pagenow;
        if ($pagenow !== 'themes.php') {
            return;
        }

        // Define variables
        $class = 'notice notice-success is-dismissible';
        $url = 'https://wpthemespace.com/product-category/pro-theme/';

        // Prepare the message
        $message = sprintf(
            /* translators: 1: Opening strong and span tags, 2: Closing strong tag */
            __('%1$sRecommended WordPress Theme for you: <span style="color:green">If you find a Secure, SEO friendly, full functional premium WordPress theme for your site then</span>%2$s', 'wp-edit-password-protected'),
            '<strong><span style="color:red;">',
            '</strong>'
        );

        // Prepare the link text
        $see_here = __('see here', 'wp-edit-password-protected');
        $view_theme = __('View WordPress Theme', 'wp-edit-password-protected');

        // Output the notice
?>
        <div class="<?php echo esc_attr($class); ?>" style="padding:10px 15px 20px;">
            <p>
                <?php echo wp_kses_post($message); ?>
                <a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_html($see_here); ?></a>.
            </p>
            <a target="_blank"
                class="button button-danger"
                href="<?php echo esc_url($url); ?>"
                style="margin-right:10px">
                <?php echo esc_html($view_theme); ?>
            </a>
        </div>
<?php
    }
    add_action('admin_notices', 'spacehide_go_me');
endif;


function wpepop_admin_notice()
{
    $service_url = 'https://wpthemespace.com/custom-wordpress-services';
    $notices = array(

        sprintf(
            '<div class="notice solution-notice">
                <h2>%s</h2>
                <div class="tagline">%s</div>
                <p>%s</p>
                <p>%s</p>
                <p><span class="highlight">%s</span></p>
                <a target="_blank" href="%s" class="solution-button">%s</a>
                <button class="button button-info wpepop-dismiss">%s</button>
            </div>',
            esc_html__('Need WordPress Expertise? We\'re Here to Help!', 'text-domain'),
            esc_html__('Custom Development • Elementor Specialists • Technical Support • Customization', 'text-domain'),
            esc_html__('Whether you need a complete website built from scratch, custom Elementor widgets, or technical issues resolved, our team is ready to assist with proven WordPress solutions.', 'text-domain'),
            esc_html__('Choose what works best for you: Project-based development, monthly maintenance, or yearly partnership - we\'re flexible to your needs.', 'text-domain'),
            esc_html__('Try our services risk-free with a complimentary test project!', 'text-domain'),
            esc_url($service_url),
            esc_html__('Let\'s Discuss Your Project →', 'text-domain'),
            esc_html__('No Thanks', 'wp-edit-password-protected')

        ),

        // Notice 2 - Technical Solutions
        sprintf(
            '<div class="notice solution-notice ">
                <h2>%s</h2>
                <div class="tagline">%s</div>
                <p>%s</p>
                <p>%s</p>
                <p><span class="highlight">%s</span></p>
                <a target="_blank" href="%s" class="solution-button">%s</a>
                <button class="button button-info wpepop-dismiss">%s</button>
            </div>',
            esc_html__('Looking for WordPress Solutions? We\'ve Got You Covered!', 'text-domain'),
            esc_html__('Expert Development • Custom Features • Quick Problem Solving • $10 or $1000', 'text-domain'),
            esc_html__('From turning designs into pixel-perfect WordPress websites to developing custom Elementor widgets, we deliver solutions that make your website stand out.', 'text-domain'),
            esc_html__('Our experienced team is ready to tackle any WordPress challenge with proven expertise and dedication to quality.', 'text-domain'),
            esc_html__('Start with a free test project and see the difference we can make!', 'text-domain'),
            esc_url($service_url),
            esc_html__('Get Started Today →', 'text-domain'),
            esc_html__('No Thanks', 'wp-edit-password-protected')
        ),

        // Notice 3 - Partnership Approach
        sprintf(
            '<div class="notice solution-notice">
                <h2>%s</h2>
                <div class="tagline">%s</div>
                <p>%s</p>
                <p>%s</p>
                <p><span class="highlight">%s</span></p>
                <a target="_blank" href="%s" class="solution-button">%s</a>
                <button class="button button-info wpepop-dismiss">%s</button>
            </div>',
            esc_html__('Want a Reliable WordPress Partner? Let\'s Connect!', 'text-domain'),
            esc_html__('Custom Development • Ongoing Support • Long-term Partnership', 'text-domain'),
            esc_html__('Partner with a team that understands your WordPress needs. We specialize in custom development, Elementor solutions, and technical support that helps your business grow.', 'text-domain'),
            esc_html__('Flexible engagement options available: Work with us on a per-project basis, monthly retainer, or long-term partnership.', 'text-domain'),
            esc_html__('Special offer: Test our capabilities with a free trial project!', 'text-domain'),
            esc_url($service_url),
            esc_html__('Start the Conversation →', 'text-domain'),
            esc_html__('No Thanks', 'wp-edit-password-protected')

        )
    );

    return $notices[array_rand($notices)];
}
add_action('admin_notices', 'wpepop_admin_notice');



//Admin notice 
function wp_edit_pass_new_optins_texts()
{
    global $pagenow;

    $hide_date = get_option('wpeditpass_info_randtext');
    if (!empty($hide_date)) {
        $clickhide = round((time() - strtotime($hide_date)) / 24 / 60 / 60);
        if ($clickhide < 25) {
            return;
        }
    }
    echo wp_kses_post(wpepop_admin_notice());
}
add_action('admin_notices', 'wp_edit_pass_new_optins_texts');

function wp_edit_pass_new_optins_texts_init()
{
    if (isset($_GET['dismissed']) && $_GET['dismissed'] == 1) {
        update_option('wpeditpass_info_randtext', current_time('mysql'));
    }
    if (isset($_GET['revadded']) && $_GET['revadded'] == 1) {
        update_option('wpeditpass_offadded', 1);
    }
}
add_action('init', 'wp_edit_pass_new_optins_texts_init');
