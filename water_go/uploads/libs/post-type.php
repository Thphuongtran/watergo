<?php 
defined( 'ABSPATH' ) || exit;

/**
*	@access CREATE POST TYPE 
*	@author CJ88
*	@version 2.0
*/


if( !class_exists( 'PostTypeBuiler' ) ){
	class PostTypeBuiler{
		
		private $tax;

		private $slug;

		private $icon;
		//
		// NAME POSTTYPE
		private $posttypeName;

		// REWRITE POSTTYPE
		private $rewrite; 


		private $tag;

		/**
		*	@access OBJECT
		*/
		private $tags;

		private $args;
		
		/**
		*	@access OBJECT
		*/
		private $taxonomy;

		private $support;

		/**
		*	@access REGISTER POSTTYPE
		*/
		public function register_posttype(){
			$name = $this->posttypeName;

			if($this->icon == '' || empty($this->icon)){
				$this->icon = 'dashicons-id-alt';
			}
			// IF EMPTY -> GET ALL
			$supportDefault = [ 'title', 'editor', 'author', 'thumbnail', 'excerpt','comments', 'custom-fields'];

			if( empty( $this->support ) ) $this->support = $supportDefault;

			$slugTaxonomies	= [];
			// GET RELASHIP WITH TAXONOMIES
			if( is_array( $this->taxonomy) && count( $this->taxonomy ) > 0 ){
				foreach( $this->taxonomy as $tK => $tV ){
					array_push( $slugTaxonomies, $tV['slug'] ); 
				}
			}

			// GET REWRITE
			if( empty( $this->rewrite ) ){
				$this->rewrite = array( 'slug' => $this->slug );
			}

			// print_r( $slugTaxonomies);

			$labels = array(
				'name'                  => _x( $name, 'Post type general name' ),
				'singular_name'         => _x( $name, 'Post type singular name' ),
				'menu_name'             => _x( $name, 'Admin Menu text'),
				'name_admin_bar'        => _x( $name, 'Add New on Toolbar'),
				'add_new'               => __( "Add New $name" , TEXTDOMAIN ),
				'add_new_item'          => __( "Add New $name", TEXTDOMAIN ),
				'new_item'              => __( "New $name", TEXTDOMAIN ),
				'edit_item'             => __( "Edit $name", TEXTDOMAIN ),
				'view_item'             => __( "View $name", TEXTDOMAIN ),
				'all_items'             => __( "All $name", TEXTDOMAIN ),
				'search_items'          => __( "Search $name", TEXTDOMAIN ),
				'parent_item_colon'     => __( "Parent : $name", TEXTDOMAIN ),
				'not_found'             => __( "No $name found.", TEXTDOMAIN ),
				'not_found_in_trash'    => __( "No $name found in Trash.", TEXTDOMAIN ),
				'featured_image'        => _x( "$name Cover Image", 'Overrides the “Featured Image” phrase for this post type. Added in 4.3' ),
				'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3' ),
				'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3' ),
				'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3' ),
				'archives'              => _x( "$name archives", 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4' ),
				'insert_into_item'      => _x( "Insert into $name", 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4' ),
				'uploaded_to_this_item' => _x( "Uploaded to this $name", 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4' ),
				'filter_items_list'     => _x( "Filter $name list", 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4' ),
				'items_list_navigation' => _x( "$name list navigation", 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4'),
				'items_list'            => _x( "$name list", 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4'),
			);

			$args = array(
			   'labels'             		=> $labels,
			   'public'             		=> true,
			   'publicly_queryable' 		=> true,
			   'show_ui'            		=> true,
			   'show_in_menu'       		=> true,
			   'menu_icon'          		=> $this->icon,
			   'capability_type'    		=> 'page',
			   'has_archive'        		=> true,
			   'can_export'         		=> true,
			   'exclude_from_search'		=> false,
			   'hierarchical'       		=> false,
			   'menu_position'      		=> null,
			   'query_var'          		=> true,
			   /**
				*	@access BREAK CHANGE FROM 1.0 
			   */
			   'taxonomies'         		=> $slugTaxonomies,
			   'supports'           		=> $this->support,
			   'cptp_permalink_structure'	=> '/%postname%/',
            'query_var'          		=> true,
			   'rewrite'            		=> $this->rewrite,
			);

			register_post_type( $this->slug, $args );
		}

		/**
		*	@access REGISTER TAXONOMY ( slug , posttype slug , args )
		*/
		public function register_taxonomy(){

			if( !empty ( $this->taxonomy ) ){

				$count 	= count( $this->taxonomy );

				if( $count == 0 ) return;

				foreach( $this->taxonomy as $tKey => $tVal ){

					$name = $tVal['name'];
					$slug = $tVal['slug'];
               // access write
               $rewrite = isset( $tVal['rewrite'] ) ?  $tVal['rewrite'] : $slug;

					$args = array(
						'labels'            => [
							'name'              => __( "$name Category", 	TEXTDOMAIN ),
							'singular_name'     => __( "$name Category", 	TEXTDOMAIN ),
							'search_items'      => __( "Search $name", 		TEXTDOMAIN ),
							'all_items'         => __( "All $name", 		TEXTDOMAIN ),
							'parent_item'       => __( "Parent $name", 		TEXTDOMAIN ),
							'parent_item_colon' => __( "Parent $name :", 	TEXTDOMAIN ),
							'edit_item'         => __( "Edit $name", 		TEXTDOMAIN ),
							'update_item'       => __( "Update $name", 		TEXTDOMAIN ),
							'add_new_item'      => __( "Add New $name", 	TEXTDOMAIN ),
							'new_item_name'     => __( "New $name Name", 	TEXTDOMAIN ),
							'menu_name'         => __( "$name Category", 	TEXTDOMAIN ),
						],
						'hierarchical'      => true,
						'show_ui'           => true,
						'show_admin_column' => true,
						'query_var'         => $rewrite,
						'public'            => true,
						'rewrite'           => [ 'slug' => $rewrite ],
					);
					/**
					*	@access register_taxonomy( $slug-taxonomy , $slug-posttype , $arguments )
					*/
					register_taxonomy( $slug, $this->slug, $args );

				}

			}

		}	

		/**
		* 	@access REGISTER TAGS ( slug , posttype slug , args )
		*/
		public function register_tag_taxonomies(){
			$name 	= $this->posttypeName;
			$slug	= $this->tag;

			if( !empty( $this->tags ) ) {
				$name 	= $this->tags['name'];
				$slug	   = isset( $this->tags['slug'] ) ? $this->tags['slug'] : null;
			}

			$args = [
				'labels' 							=> [
					'name' 							=> _x("$name Tags", 'taxonomy general name' ),
					'singular_name' 				=> _x( "$name Tag", 'taxonomy singular name' ),
					'search_items' 					=>  __( 'Search '. "$name Tags" ),
					'popular_items' 				=> __( 'Popular '. "$name Tags" ),
					'all_items' 					=> __( 'All Tags ' . $name ),
					'parent_item' 					=> null,
					'parent_item_colon' 			=> null,
					'edit_item' 					=> __( 'Edit Tag ' . $name ), 
					'update_item' 					=> __( 'Update Tag ' . $name ),
					'add_new_item' 					=> __( 'Add New Tag ' . $name ),
					'new_item_name' 				=> __( 'New Tag Name ' . $name ),
					'separate_items_with_commas' 	=> __( 'Separate tags with commas' ),
					'add_or_remove_items' 			=> __( 'Add or remove tags' ),
					'choose_from_most_used' 		=> __( 'Choose from the most used tags' ),
					'menu_name' 					=> __( 'Tags ' . $name ),
				],
				'hierarchical' 			=> false,
				'show_ui' 				=> true,
				'update_count_callback' => '_update_post_term_count',
				'query_var' 			=> true,
				'rewrite' 				=> [ 'slug' => $slug ],
			];

			register_taxonomy( $slug , $this->slug , $args );
		}

		/**
		*	@access GET NAME PREFIX BY ITSELF 
		*/
		public function auto_fill_slug( $slug ){ return 'posttype-' . strtolower( $slug ); }

		/**
		*	@access GET NAME PREFIX BY ITSELF 
		*/
		public function auto_fill_taxonomy( $tax ){ return 'taxonomy-' . strtolower( $tax ); }
		

		/**
		*	@access INIT FUNCTION 
		*/

		private function init( $args = array() ){

			add_action( 'init', array( $this, 'register_posttype'), 10);

        	add_action( 'init', array( $this, 'register_taxonomy'), 10);

        	if( ! empty( $this->tags ) ){
        	   add_action( 'init', [ $this, 'register_tag_taxonomies' ], 10);
         }
		}

		/**
		*	@access CONSTRUCTION WITH ARGS
		*/
		public function __construct( $args = [] ){
			if( ! is_array( $args ) ) return;

			$this->posttypeName 	= isset($args['name']) ? $args['name'] : 0;
			// AUTO GET SLUG WHEN SLUG MISSING
			$this->slug 			= isset($args['slug']) ? $args['slug'] : $this->auto_fill_slug($this->posttypeName);
			// AUTO GET TAX WHEN SLUG MISSING
			$this->tax 				= 'category-' . strtolower( $this->posttypeName );
			// AUTO GET TAG WHEN SLUG MISSING
			$this->tag 				= 'tag-' . strtolower( $this->posttypeName );
			// AUTO GET ICON WHEN SLUG MISSING
			$this->icon 			= isset($args['icon']) ? $args['icon'] : 'dashicons-id-alt';
			// GET TAXONOMY INPUT
			$this->taxonomy 		= isset( $args['taxonomy'] ) ? $args['taxonomy'] : [];
			// GET TAGS INPUT
			$this->tags				= isset( $args['tags'] ) ? $args['tags'] : [];

			$this->init();
		}


	}
}

/**
*	@access EXAMPLE

	new PostTypeBuiler( [
		'name' => 'Project',
		'slug' => 'project',
		'support'	=> [],
		'rewrite'	=> [],
		// THIS IS OVERRIDE ARGS FOR SOME REASON
		'args'		=> [],

		// ADD CATEGORY
		'taxonomy'	=> [
			[
				'name'	=> 'Category Project',
				'slug'	=> 'category-project',
            'rewrite' => 'category/project'
			],
			[
				'name'	=> 'Category Project 2',
				'slug'	=> 'category-project2'
			]
		],

		// ADD TAGS
		'tags'	=> [
			'name'	=> 'Tag Project'
			'slug' 	=> 'tag-project'
		]

	]);
*/


new PostTypeBuiler( [
		'name' => 'Project',
		'slug' => 'project',
		'support'	=> [],
		'rewrite'	=> [],
		// THIS IS OVERRIDE ARGS FOR SOME REASON
		'args'		=> [],

		// ADD CATEGORY
		'taxonomy'	=> [
			[
				'name'	=> 'Category Project',
				'slug'	=> 'category-project',
			],
		],

		// ADD TAGS
		'tags'	=> [
			'name'	=> 'Tag Project'
		]

	]);