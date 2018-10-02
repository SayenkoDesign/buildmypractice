<?php
// Single Business Card

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
                   'data' => array( 'data-tabs' => 'service-tabs', 'data-deep-link' => 'true' )
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
	
	function service_tab_links() {
        
        global $my_account, $client, $fa_tabs, $table;
                    
        $services = array( 
                         'domain' => 'Domains', 
                         'website_hosting' => 'Website Hosting', 
                         'office_365' => 'Office 365 / G Suite services', 
                         'voip_services' => 'VoIP services' );
                
        $fields = get_fields( $client );
                
        $count = 0;
        
        foreach( $services as $service => $label ) {
                      
            $href =  sprintf( '%s#%s', get_permalink( 346 ), sanitize_title_with_dashes( $label ) );   
                
            $args = array( 'title' => $label, 'href' => $href );
            $fa_tabs->add_tab_link( $args );
            
        }
        
        if( false != ( $link = $my_account->get_business_card_link() ) ) {
            $args = array( 'title' => 'Business Cards', 'href' => sprintf( '%s#%s', get_permalink( $link ), $fa_tabs->settings['id'] ), 'active' => true );
            $fa_tabs->add_tab_link( $args );
        }
        
        if( false != ( $link = $my_account->get_logo_link() ) ) {
            $args = array( 'title' => 'Logos', 'href' => sprintf( '%s#%s', get_permalink( $link ), $fa_tabs->settings['id'] ) );
            $fa_tabs->add_tab_link( $args );
        }
        
        echo $fa_tabs->get_tab_links();
		
	}
    
	?>
    
    
  <div class="row collapse">
      <div class="medium-4 columns">
      
        <?php
        // Lets add business cards and logos
        service_tab_links();
        ?>

      </div>
      <div class="medium-8 columns">
        <?php
        echo '<div class="tabs-content">';
            echo '<div class="tabs-panel show-panel">';
                $my_account->the_business_card();
            echo '</div>';
        echo '</div>';
        ?>
      </div>
  </div>
    
  
	</main>

</div>
<?php
get_footer();
