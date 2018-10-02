<?php
/*
Template Name: My Account -Services
*/

// Page is only available for clients
is_client_logged_in();

get_header(); 

get_template_part( 'template-parts/section', 'my-account-hero' );
    
get_template_part( 'template-parts/section', 'my-account-sub-menu' );

// My Account
$my_account = new My_Account;

$client = $my_account->get_client();
        
$tab_args = array( 'class' => 'vertical tabs', 
                   'id' => 'service-tabs', 
                   'data' => array( 'data-tabs' => 'true', 'data-deep-link' => 'true' )
                 );

$fa_tabs = new Foundation_Tabs( $tab_args );

$table = new CI_Table;
$template = array(
        'table_open' => '<table class="table">'
);
$table->set_template($template);
?>

<div id="primary" class="content-area">
                
    <main id="main" class="site-main" role="main">
    
    <?php
 	// Default
	section_tabs();
	function section_tabs() {
        
        global $my_account, $client, $fa_tabs, $table;
        
        // No Services
        
        if( ! is_object( $client ) ) {
            
            print( 'No services available' );
            return;
        }
                    
        $services = array( 
                         'support' => 'Support',
                         'domain' => 'Domains', 
                         'website_hosting' => 'Website Hosting', 
                         'office_365' => 'Office 365 / G Suite services', 
                         'voip_services' => 'VoIP services' );
                
        $fields = get_fields( $client );
        
        $content = '';
        
        $count = 0;
        
        foreach( $services as $service => $label ) {
            
            if( empty($fields[$service] ) ) {
                continue;
            }
            
            $data = $fields[$service];
            
            $editor = $data['editor']; 
            $list   = $data['list'];
            $button = $data['button'];
            
            if( empty( $editor ) ) {
                continue;   
            }
                      
            $args = array();
            
            $content = sprintf( '<h2>%s:</h2>', $label );
                            
            //var_dump( $data );
            
            $active = $count ? false : true;
            $count++;
                            
            
                            
            if( ! empty( $editor ) ) {
                $content .= $editor;
            }
            
            if( ! empty( $list ) ) {
                $table->set_heading( false );
                $content .= $table->generate( $list );
                $table->clear();
                
            }
            
            if( ! empty( $button ) ) {
                $content .= pb_get_cta_button( $button, array( 'class' => 'button light-blue' ) );
            }
            
            $args = array( 'title' => $label, 'content' => $content, 'active' => $active );
        
            $fa_tabs->add_tab( $args );
            
        }   
        		
	}
    

    
    
	?>
    
    
  <div class="row collapse">
      <div class="medium-4 columns">
      
        <?php
          
        echo $fa_tabs->get_tabs();
        
        // Lets add business cards and logos
        
        if( false != ( $link = $my_account->get_business_card_link() ) ) {
            $args = array( 'title' => 'Business Cards', 
            'href' => sprintf( '%s#%s', get_permalink( $link ), $fa_tabs->settings['id'] ) );
            $fa_tabs->add_tab_link( $args );
        }
        
        if( false != ( $link = $my_account->get_logo_link() ) ) {
            $args = array( 'title' => 'Logos', 
            'href' => sprintf( '%s#%s', get_permalink( $link ), $fa_tabs->settings['id'] ) );
            $fa_tabs->add_tab_link( $args );
        }
          
        echo $fa_tabs->get_tab_links();
        
        ?>

      </div>
      <div class="medium-8 columns">
        <?php
        echo $fa_tabs->get_panels();
        ?>
      </div>
  </div>
    
  
	</main>

</div>
<?php
get_footer();
