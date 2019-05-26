<?php
get_header();
?>

<?php 
$slides=new WP_Query(array(
        'post_type' => 'rt_slider',
        'order' => 'ASC'
    ));
?>



<div class="container-fluid" style="background:#eee;">
<div class="slideshow-container container">

<!-- <div class="mySlides fade">
  <img src="<?php //echo get_template_directory_uri(); ?>/img_nature_wide.jpg" style="width:100%">
  <div class="text"><h3>Caption One</h3><p>Lorem ipsum fjewf fiewjifojw fiewjfijejwfijwe eiofjew</p></div>
</div>

<div class="mySlides fade">
  <img src="<?php //echo get_template_directory_uri(); ?>/img_snow_wide.jpg" style="width:100%">
  <div class="text"><h3>Caption Two</h3><p>Lorem ipsum fjewf fiewjifojw fiewjfijejwfijwe eiofjew</p></div>
</div> -->
 <?php while($slides->have_posts()):$slides->the_post(); ?>
    <div class="mySlides fade">
      <img src="<?php echo get_the_post_thumbnail_url(); ?>" style="width:100%">
      <div class="text"><h3 class="cust_title"><?php the_title(); ?></h3><p class="cust_content"><?php $the_exerpt = get_the_excerpt();  
                        if($the_exerpt != "")  {
                            the_excerpt();
                        }else {
                            the_content();
                        } ?></p></div>
    </div>

<?php endwhile; ?>

<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

<div style="text-align:center" class="indicators">
  <?php $temp =1; while($slides->have_posts()):$slides->the_post(); ?>
  <span class="dot" onclick="currentSlide(<?php echo $temp; ?>)"></span> 
  <!-- <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span>  -->

  <?php $temp++; endwhile; ?>
</div>

</div>
<br>


</div>
<div class="row">
    <div class="col-md-3 child_page" style="display:block;">
        <?php 
        $child_page=new WP_Query(array(
                'post_type' => 'page',
                'order' => 'ASC',
                'post_parent' => 10
            ));
        
        while($child_page->have_posts()):$child_page->the_post(); 
            $child_ids=get_the_ID();  
            $args = array(
                'post_parent' => get_the_ID()
            );
            $children = get_children( $args );
            if($children) {
                ?> <a class="has_children"><?php the_title(); ?></a> <?php
            }else {
                ?> <a><?php the_title(); ?></a> <?php    
            } 
              ?>
        <?php endwhile; ?>
    </div>
    <?php
    while($child_page->have_posts()):$child_page->the_post(); 
            $args = array(
                'post_parent' => get_the_ID()
            );
            $children = get_children( $args );
            if(!empty($children)) 
            $child_of_child=new WP_Query(array(
                'post_type' => 'page',
                'order' => 'ASC',
                'post_parent' => get_the_ID()
            ));
    ?>
    <?php endwhile; ?>
    <?php  while($child_of_child->have_posts()):$child_of_child->the_post(); ?>
            <div class="col-md-3 hover_show" style="display: none;">
                <?php the_post_thumbnail(); ?>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php the_content(); ?>
            </div>    
    <?php endwhile; ?>
</div>
<div class="container-fluid">
    <div class="container general_widgets">
        <div class="row">
            <div class="col-md-3">
                <?php dynamic_sidebar('sidebar-4'); ?>
            </div>
            <div class="col-md-3">
                <?php dynamic_sidebar('sidebar-1'); ?>   
            </div>
            <div class="col-md-3">  
                <?php dynamic_sidebar('sidebar-2'); ?>
            </div>
            <div class="col-md-3">
                <?php dynamic_sidebar('sidebar-3'); ?>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();