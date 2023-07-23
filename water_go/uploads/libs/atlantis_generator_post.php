<?php 

function atlantis_generator_post( $num ){

   $title = [
      "How to Build a Custom WordPress Theme",
      "Best Practices for WordPress Site Security",
      "The Top 10 Plugins Every WordPress Site Needs",
      "Creating a Custom Plugin for Your WordPress Site",
      "WordPress SEO: Optimizing Your Site for Search Engines",
      "How to Use WordPress as a Headless CMS",
      "How to Create a Multilingual WordPress Site",
      "Building an E-commerce Site with WordPress",
      "How to Speed Up Your WordPress Site",
      "Best Practices for WordPress Site Performance",
      "Creating Custom Post Types in WordPress",
      "Building a Custom Gutenberg Block in WordPress",
      "Using Custom Fields in WordPress",
      "Integrating WooCommerce with Your WordPress Site",
      "How to Build a WordPress Membership Site",
      "The Ultimate Guide to WordPress Site Maintenance",
      "How to Build a WordPress Site for a Nonprofit",
      "Best Practices for WordPress Site Accessibility",
      "How to Integrate WordPress with Social Media",
      "Building a Portfolio Site with WordPress",
      "How to Build a WordPress Site for a Restaurant",
      "The Top 10 Free WordPress Themes of 2021",
      "The Top 10 Premium WordPress Themes of 2021",
      "How to Migrate Your Site to WordPress",
      "Building a Custom Page Template in WordPress",
      "Best Practices for WordPress Site Backup and Recovery",
      "Using Child Themes in WordPress",
      "How to Customize the WordPress Login Page",
      "Building a WordPress Site for a Small Business",
      "How to Build a WordPress Site for a Blog",
      "Best Practices for WordPress Site Content Creation",
      "Using WordPress Shortcodes to Enhance Your Site",
      "How to Build a WordPress Site for a Podcast",
      "How to Build a WordPress Site for an Online Course",
      "The Top 10 WordPress Security Plugins of 2021",
      "The Top 10 WordPress Performance Plugins of 2021",
      "How to Build a WordPress Site for a Photography Portfolio",
      "Best Practices for WordPress Site Navigation",
      "How to Build a WordPress Site for a Musician",
      "How to Build a WordPress Site for a Travel Blog",
      "Building a Landing Page in WordPress",
      "Using WordPress Plugins for Lead Generation",
      "How to Build a WordPress Site for a Freelancer",
      "Best Practices for WordPress Site Design",
      "How to Build a WordPress Site for a Personal Blog",
      "Building a Community Site with WordPress",
      "How to Build a WordPress Site for a Fitness Business",
      "Using WordPress to Build a Learning Management System (LMS)",
      "The Top 10 WordPress Contact Form Plugins of 2021",
      "How to Build a WordPress Site for a Wedding"
   ];

   $content = "
      Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
      Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.
      The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
   ";
   $excerpt = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";

   $_title = $title[ rand(0, count($title) - 1) ];

   $terms = get_terms([
      'taxonomy'		=> 'category',
      'hide_empty'	=> false,
      'parent'			=> 0, // => GET TOP TAXONOMY
      'exclude'      => [1]
   ]);

   $category = [];

   if( !empty($terms )){
      foreach( $terms as $k => $vl ){
         $category[$k] = $vl->term_id;
      }
   }

   $_id_cat = !empty($category) ? $category[ rand(0, count($category) - 1) ] : null;

   for($i = 0; $i < $num; $i++ ){
      $args = [
         'post_title'   => $_title,
         'post_content' => $content,
         'post_excerpt' => $excerpt,
         'post_status'  => 'publish',
         'post_type'    => 'post',
      ];
      if($_id_cat != null ){
         $args['post_category'] = [$_id_cat]; // pass id cat
      }
      wp_insert_post($args);
   }

}

// atlantis_generator_post(10);